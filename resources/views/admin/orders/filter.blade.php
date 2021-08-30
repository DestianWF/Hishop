{!! Form::open(['url'=> Request::path(),'method'=>'GET','class' => 'input-daterange form-inline']) !!}
<div class="form-group mb-2"> 
	<div class="col-md-3 col-sm-3">
		<input type="text" class="form-control input-block" name="q" value="{{ !empty(request()->input('q')) ? request()->input('q') : '' }}" placeholder="Ketik kode atau nama"> 
	</div>
	<div class="form-group mx-sm-3 mb-2">
	<input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}" name="start" placeholder="dari"/>
		
	</div>
	<div class="form-group mx-sm-3 mb-2">
		<input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}" name="end" placeholder="ke">
	</div>
	<div class="form-group mx-sm-3 mb-2">
		{{ Form::select('status', $statuses, !empty(request()->input('status')) ? request()->input('status') : null, ['placeholder' => 'Semua Status', 'class' => 'form-control input-block']) }}
	</div>
	<div class="form-group mx-sm-3 mb-2">
		<button type="submit" class="btn btn-primary btn-default">Tampilkan</button>
	</div>
</div>
{!! Form::close() !!}