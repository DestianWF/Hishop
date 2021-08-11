<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\AttributeOption;
use App\Models\Category;

use Str;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['q'] = null;

        $this->data['categories'] = Category::parentCategories()
                                    ->orderBy('name', 'asc')
                                    ->get();

        $this->data['minPrice'] = Product::min('price');
        $this->data['maxPrice'] = Product::max('price');

        $this->data['ukurans'] = AttributeOption::whereHas('attribute', function ($query) {
                                $query->where('code', 'ukuran')
                                ->where('is_filterable', 1);
                                })->orderBy('name', 'asc')->get();

        $this->data['sorts'] = [
            url('products') => 'Standar',
            url('products?sort=price-asc') => 'Harga - Rendah ke Tinggi',
            url('products?sort=price-desc') => 'Harga - Tinggi ke Rendah',
            url('products?sort=created_at-desc') => 'Terbaru ke Terdahulu',
            url('products?sort=created_at-asc') => 'Terdahulu ke Terbaru',
        ];

        $this->data['selectedSort'] = url('products');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::active();

        $products = $this->searchProducts($products, $request);
        $products = $this->filterProductsByPriceRange($products, $request);
        $products = $this->filterProductsByAttribute($products, $request);
        $products = $this->sortProducts($products, $request);

        $this->data['products'] = $products->paginate(9);
        return $this->loadTheme('products.index', $this->data);
    }

    private function searchProducts($products, $request){
        if ($q = $request->query('q')){
            $q = str_replace('-' , ' ', Str::slug($q));

            $products = $products->whereRaw('MATCH(name, slug, description) AGAINST(? IN NATURAL LANGUAGE MODE)', [$q]);

            $this->data['q'] = $q;
        }

        if ($categorySlug = $request->query('category')) {
            $category = Category::where('slug', $categorySlug)->firstOrFail();

            $childIds = Category::childIds($category->id);
            $categoryIds = array_merge([$category->id], $childIds);

            $products = $products->whereHas('categories', function ($query) use ($categoryIds) {
                            $query->whereIn('categories.id', $categoryIds);
            });
        }

        return $products;
    }

    private function filterProductsByPriceRange($products, $request){
        $lowPrice = null;
        $highPrice = null;

        if ($priceSlider = $request->query('price')) {
            $prices = explode('-', $priceSlider);

            $lowPrice = !empty($prices[0]) ? (float)$prices[0] : $this->data['minPrice'];
            $highPrice = !empty($prices[1]) ? (float)$prices[1] : $this->data['maxPrice'];

            if ($lowPrice && $highPrice) {
                $products = $products->where('price', '>=', $lowPrice)
                                ->where('price', '<=', $highPrice)
                                ->orWhereHas('variants', function ($query) use ($lowPrice, $highPrice) {
                                    $query->where('price', '>=', $lowPrice)
                                        ->where('price', '<=', $highPrice);
                                });

                $this->data['minPrice'] = $lowPrice;
                $this->data['maxPrice'] = $highPrice;
            }
        }

        return $products;
    }

    private function filterProductsByAttribute($products, $request){
        if ($attributeOptionID = $request->query('option')) {
            $attributeOption = AttributeOption::findOrFail($attributeOptionID);

            $products = $products->whereHas('ProductAttributeValues', function ($query) use ($attributeOption) {
                                    $query->where('attribute_id', $attributeOption->attribute_id)
                                        ->where('text_value', $attributeOption->name);
            });
        }

        return $products;
    }

    private function sortProducts($products, $request){
        if ($sort = preg_replace('/\s+/', '',$request->query('sort'))) {
            $availableSorts = ['price', 'created_at'];
            $availableOrder = ['asc', 'desc'];
            $sortAndOrder = explode('-', $sort);

            $sortBy = strtolower($sortAndOrder[0]);
            $orderBy = strtolower($sortAndOrder[1]);

            if (in_array($sortBy, $availableSorts) && in_array($orderBy, $availableOrder)) {
                $products = $products->orderBy($sortBy, $orderBy);
            }

            $this->data['selectedSort'] = url('products?sort='. $sort);
        }

        return $products;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::active()->where('slug', $slug)->first();

        if (!$product) {
            return redirect('products');
        }

        if ($product->configurable()) {
            $this->data['ukuran'] = ProductAttributeValue::getAttributeOptions($product, 'ukuran')->pluck('text_value', 'text_value');
        }

        $this->data['product'] = $product;

        return $this->loadTheme('products.show', $this->data);
    }

    /**
	 * Quick view product.
	 *
	 * @param string $slug product slug
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function quickView($slug)
	{
		$product = Product::active()->where('slug', $slug)->firstOrFail();
		if ($product->configurable()) {
			$this->data['ukuran'] = ProductAttributeValue::getAttributeOptions($product, 'ukuran')->pluck('text_value', 'text_value');
		}

		$this->data['product'] = $product;

		return $this->loadTheme('products.quick_view', $this->data);
	}

}
