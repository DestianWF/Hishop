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
					<div class="d-flex justify-content-between">
						<h2 class="text-dark font-weight-medium">ID Pesanan #{{ $order->code }}</h2>
					</div>
					<div class="row pt-5">
						<div class="col-xl-4 col-lg-4">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Alamat Tagihan</p>
							<address>
								{{ $order->customer_first_name }} {{ $order->customer_last_name }}
								<br> {{ $order->customer_address1 }}
								<br> {{ $order->customer_address2 }}
								<br> Email: {{ $order->customer_email }}
								<br> Telepon: {{ $order->customer_phone }}
								<br> Kode Pos: {{ $order->customer_postcode }}
							</address>
						</div>
						@if ($order->shipment)
							<div class="col-xl-4 col-lg-4">
								<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Alamat Pengiriman</p>
								<address>
									{{ $order->shipment->first_name }} {{ $order->shipment->last_name }}
									<br> {{ $order->shipment->address1 }}
									<br> {{ $order->shipment->address2 }}
									<br> Email: {{ $order->shipment->email }}
									<br> Telepon: {{ $order->shipment->phone }}
									<br> Kode Pos: {{ $order->shipment->postcode }}
								</address>
							</div>
						@endif
						<div class="col-xl-4 col-lg-4">
							<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Rincian</p>
							<address>
								ID: <span class="text-dark">#{{ $order->code }}</span>
								<br> {{ \General::datetimeFormat($order->order_date) }}
								<br> Status: {{ $order->status }} {{ $order->isCancelled() ? '('. \General::datetimeFormat($order->cancelled_at) .')' : null}}
								@if ($order->isCancelled())
									<br> Catatan Pembatalan : {{ $order->cancellation_note}}
								@endif
								<br> Status Pembayaran: {{ $order->payment_status }}
								<br> Dikirim Oleh: {{ $order->shipping_service_name }}
							</address>
						</div>
					</div>
					<div class="table-content table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama Produk</th>
									<th>Tipe</th>
									<th>Jumlah</th>
									<th>Harga Produk</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($order->orderItems as $item)
									<tr>
										<td>{{ $item->sku }}</td>
										<td>{{ $item->name }}</td>
										<td>{!! \General::showAttributes($item->attributes) !!}</td>
										<td>{{ $item->stock }}</td>
										<td>{{ \General::priceFormat($item->base_price) }}</td>
										<td>{{ \General::priceFormat($order->grand_total) }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="6">Pesanan tidak ditemukan.</td>
									</tr>
								@endforelse
							</tbody>
						</table>
						<div class="col-md-2 ml-auto">
							<div class="cart-page-total">
						@if (!$order->isPaid())
							<a href="{{ $order->payment_url }}">Lanjutkan Ke Pembayaran</a>
						@endif
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection