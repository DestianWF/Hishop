@extends('admin.layout')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Pesanan</h2>
					</div>
					<div class="card-body">
						@include('admin.partials.flash')
						@include('admin.orders.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>ID Pesanan</th>
								<th>Total Pembayaran</th>
								<th>Nama</th>
								<th>Status</th>
								<th>Pembayaran</th>
								<th>Tindakan</th>
							</thead>
							<tbody>
								@forelse ($orders as $order)
									<tr>    
										<td>
											{{ $order->code }}<br>
											<span style="font-size: 12px; font-weight: normal"> {{\General::datetimeFormat($order->order_date) }}</span>
										</td>
										<td>{{\General::priceFormat($order->grand_total) }}</td>
										<td>
											{{ $order->customer_full_name }}<br>
											<span style="font-size: 12px; font-weight: normal"> {{ $order->customer_email }}</span>
										</td>
										<td>{{ $order->status }}</td>
										<td>{{ $order->payment_status }}</td>
										<td>
											@can('edit_orders')
												<a href="{{ url('admin/orders/'. $order->id) }}" class="btn btn-info btn-sm">Lihat</a>
											@endcan
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="5">Tidak ditemukan data.</td>
									</tr>
								@endforelse
							</tbody>
						</table>
						{{ $orders->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection