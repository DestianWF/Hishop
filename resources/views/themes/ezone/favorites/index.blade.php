@extends('themes.ezone.layout')

@section('content')
	<!-- <div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container-fluid">
			<div class="breadcrumb-content text-center">
				<h2>My Favorites</h2>
				<ul>
					<li><a href="{{ url('/') }}">home</a></li>
					<li>my favorites</li>
				</ul>
			</div>
		</div>
	</div> -->
	<div class="shop-page-wrapper shop-page-padding ptb-50">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3">
					@include('themes.ezone.partials.user_menu')
				</div>
				<div class="col-lg-9">
					@include('admin.partials.flash')
					<div class="shop-product-wrapper res-xl">
						<div class="table-content table-responsive">
							<table>
								<thead>
									<tr>
										<th>Hapus</th>
										<th>Gambar</th>
										<th>Produk</th>
										<th>Harga</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($favorites as $favorite)
										@php
											$product = $favorite->product;
											$product = isset($product->parent) ?: $product;
											$image = !empty($product->productImages->first()) ? asset('storage/'.$product->productImages->first()->small) : asset('themes/ezone/assets/img/cart/3.jpg')
										@endphp
										<tr>
											<td class="product-remove">
												{!! Form::open(['url' => 'favorites/'. $favorite->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                <button type="submit" style="background-color: transparent; border-color: #FFF;">X</button>
                                                {!! Form::close() !!}
											</td>
											<td class="product-thumbnail">
												<a href="{{ url('product/'. $product->slug) }}"><img src="{{ $image }}" alt="{{ $product->name }}" style="width:100px"></a>
											</td>
											<td class="product-name"><a href="{{ url('product/'. $product->slug) }}">{{ $product->name }}</a></td>
											<td class="product-price-cart"><span class="amount">{{ number_format($product->priceLabel()) }}</span></td>
										</tr>
									@empty
										<tr>
											<td colspan="4">Anda tidak memiliki produk favorit.</td>
										</tr>
									@endforelse
                                </tbody>
                            </table>
							</table>
							{{ $favorites->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection