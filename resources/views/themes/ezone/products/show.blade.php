@extends('themes.ezone.layout')

@section('content')
	<!-- <div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/penjual.jpg') }})">
		<div class="container">
			<div class="breadcrumb-content text-center">
				<h2>Rincian Produk</h2>
				<ul>
					<li><a href="/">beranda</a></li>
					<li> rincian produk </li>
				</ul>
			</div>
		</div>
	</div> -->
	<div class="product-details ptb-50 pb-90">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-7 col-12">
					<div class="product-details-img-content">
						<div class="product-details-tab mr-70">
							<div class="product-details-large tab-content">
								@php
									$i = 1
								@endphp
								@forelse ($product->productImages as $image)
									<div class="tab-pane fade {{ ($i == 1) ? 'active show' : '' }}" id="pro-details{{ $i}}" role="tabpanel">
										<div class="easyzoom easyzoom--overlay">
											@if ($image->large && $image->extra_large)
												<a href="{{ asset('storage/'.$image->extra_large) }}">
													<img src="{{ asset('storage/'.$image->large) }}" alt="{{ $product->name }}">
												</a>
											@else
												<a href="{{ asset('themes/ezone/assets/img/product-details/bl1.jpg') }}">
													<img src="{{ asset('themes/ezone/assets/img/product-details/l1.jpg') }}" alt="{{ $product->name }}">
												</a>
											@endif
                                        </div>
									</div>
									@php
										$i++
									@endphp
								@empty
									Gambar tidak ditemukan!
								@endforelse
							</div>
							<div class="product-details-small nav mt-12" role=tablist>
								@php
									$i = 1
								@endphp
								@forelse ($product->productImages as $image)
									<a class="{{ ($i == 1) ? 'active' : '' }} mr-12" href="#pro-details{{ $i }}" data-toggle="tab" role="tab" aria-selected="true">
										@if ($image->small)
											<img src="{{ asset('storage/'.$image->small) }}" alt="{{ $product->name }}">
										@else
											<img src="{{ asset('themes/ezone/assets/img/product-details/s1.jpg') }}" alt="{{ $product->name }}">
										@endif
									</a>
									@php
										$i++
									@endphp
								@empty
									Gambar tidak ditemukan!
								@endforelse
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-lg-5 col-12">
					<div class="product-details-content">
						<h3>{{ $product->name }}</h3>
						<div class="details-price">
							<span>{{ number_format($product->priceLabel()) }}</span>
						</div>
						<p>{{ $product->description }}</p>
						{!! Form::open(['url' => 'carts']) !!}
							{{ Form::hidden('product_id', $product->id) }}
							@if ($product->type == 'configurable')
								<div class="quick-view-select">
									<div class="select ">
										<label>Ukuran*</label>
										{!! Form::select('ukuran', $ukuran , null, ['class' => 'select', 'placeholder' => '- Pilihan -', 'required' => true]) !!}
									</div>
								</div>
							@endif

							<div class="quickview-plus-minus">
								<div class="cart-plus-minus">
									{!! Form::text('stock', 1, ['class' => 'cart-plus-minus-box', 'placeholder' => 'stock', 'min' => 1]) !!}
								</div>
								<div class="quickview-btn-cart">
									<button type="submit" class="submit contact-btn btn-hover">tambah ke keranjang</button>
								</div>
								<div class="quickview-btn-wishlist">
									<a class="btn-hover add-to-fav" product-slug="{{ $product->slug }}" href="#">
									<i class="pe-7s-like"></i></a>
								</div>
							</div>
						{!! Form::close() !!}
						<div class="product-details-cati-tag mt-35">
							<ul>
							<h4>{{ $product->user->first_name }}</h4><h4>{{ $product->user->last_name }}</h4>
							<div class="mtb-10">
							
							</div>
								<li class="categories-title">Kategori :</li>
								@foreach ($product->categories as $category)
									<li><a href="{{ url('products/category/'. $category->slug ) }}">{{ $category->name }}</a></li>
								@endforeach
							</ul>
							<div class="mtb-10">
							
							</div>
							<ul>
								<li class="categories-title">Asal :</li>
								
									<li><a>{{ $product->origin }}</a></li>
								
							</ul>
							<div class="mtb-10">

							</div>
							<ul>
								<li class="categories-title">Berat :</li>
								
									<li><a>{{ $product->weight /1000}}</a> Kilogram / Pack</li>
								
							</ul>

							<div class="mtb-10">

							</div>
							<ul>
								<li class="categories-title">Stok :</li>
								
									<li><a>{{ $product->productInventory->stock }}</a></li>
								
							</ul>
						
						</div>
						<div class="mtb-10">
							
						<!-- </div>
						<div class="product-share">
							<ul>
								<li class="categories-title">Bagikan :</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-facebook"></i>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-twitter"></i>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-pinterest"></i>
									</a>
								</li>
								
							</ul>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="product-description-review-area pb-90">
		<div class="container">
			<div class="product-description-review text-center">
				<div class="description-review-title nav" role=tablist>
					<!-- <a class="active" href="#pro-dec" data-toggle="tab" role="tab" aria-selected="true">
						Description
					</a> -->
					<a href="#pro-review" data-toggle="tab" role="tab" aria-selected="false">
						Reviews 
					</a>
				</div>
				<div class="description-review-text tab-content">
					<!-- <div class="tab-pane active show fade" id="pro-dec" role="tabpanel">
						<p>{{ $product->description }} </p>
					</div> -->
					<div class="tab-pane fade" id="pro-review" role="tabpanel">
						<a href="#">Be the first to write your review!</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection