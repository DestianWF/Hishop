<!-- product area start -->
@if ($products)
	<div class="popular-product-area wrapper-padding-3 white-bg pt-55 pb-115">
		<div class="container-fluid">
			<div class="section-title-6 text-center mb-50">
				<h3>Produk Populer</h3>
				<p>Rekomendasi produk-produk terpopuler dan banyak dibeli untuk memberi pelayanan terbaik bagi Anda.</p>
			</div>
			<div class="product-style">
				<div class="popular-product-active owl-carousel">
					@foreach ($products as $product)
						@php
							$product = $product->parent ?: $product;	
						@endphp
						<div class="product-wrapper">
							<div class="product-img">
								<a href="{{ url('product/'. $product->slug) }}">
									@if ($product->productImages->first())
										<img src="{{ asset('storage/'.$product->productImages->first()->medium) }}" alt="{{ $product->name }}">
									@else
										<img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->name }}">
									@endif
								</a>
								<span>hot</span>
								<div class="product-action">
									<a class="animate-left add-to-fav" title="Wishlist" product-slug="{{ $product->slug }}" href="">
										<i class="pe-7s-like"></i>
									</a>
									<a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $product->id }}" product-type="{{ $product->type }}" product-slug="{{ $product->slug }}">
										<i class="pe-7s-cart"></i>
									</a>
									<a class="animate-right quick-view" title="Quick View" product-slug="{{ $product->slug }}" href="">
										<i class="pe-7s-look"></i>
									</a>
								</div>
							</div>
							<div class="funiture-product-content text-center">
								<h4><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></h4>
								<span>{{ number_format($product->priceLabel()) }}</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endif
<!-- product area end -->