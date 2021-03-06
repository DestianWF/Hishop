@extends('admin.layout')

@section('content')


@php
    $formTitle = !empty($shop)? 'Kelola' : 'Toko'
@endphp

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>{{$formTitle}} Toko</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash',['$errors'=>$errors])
                        @if (!empty ($shop))
                            {!!Form::model($shop,['url'=>['admin/shops', $shop->id], 'method'=>'PUT'])!!}
                            {!!Form::hidden('id')!!}
                        @else
                            {!!Form::open(['url'=>'admin/shops'])!!}
                        @endif
                            <div class="form-group">
                                {!!Form::label('name','Nama Toko')!!}
                                {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Nama toko'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::label('description','Deskripsi')!!}
                                {!!Form::text('description',null,['class'=>'form-control','placeholder'=>'Deskripsi', 'disabled' => !empty($shop)])!!}
                            </div>
                            <!-- <div class="form-group">
                                {!! Form::label('province_id', 'Provinsi') !!}
                                {!! Form::select('province_id', $provinces, Auth::user()->province_id, ['id' => 'shop-province-id', 'placeholder' => '- Pilih Provinsi - ', 'required' => true]) !!}
                            </div>             
                            <div class="form-group">
                                {!! Form::label('city_id', 'Kota') !!}
                                {!! Form::select('city_id', $cities, null, ['id' => 'shop-city-id', 'placeholder' => '- Pilih Kota -', 'required' => true])!!}
                            </div> -->
                            <div class="form-group">
                                {!!Form::label('created_at','Tanggal Dibuat')!!}
                                {!!Form::text('created_at',null,['class'=>'form-control','placeholder'=>'Tanggal Dibuat', 'disabled' => !empty($shop)])!!}
                            </div>
                            <!-- Roles Form Input -->
                            <div class="form-group @if ($errors->has('roles')) has-error @endif">
                                {!! Form::label('roles[]', 'Peran') !!}
                                {!! Form::select('roles[]', $roles, isset($user) ? $user->roles->pluck('id')->toArray() : null,  ['class' => 'form-control', 'multiple']) !!}
                                @if ($errors->has('roles')) <p class="help-block">{{ $errors->first('roles') }}</p> @endif
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', 'Status') !!}
                                {!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Pilih Status --']) !!}
                            </div>
                            <div class="form-footer pt-5 border-top">
                                <button type="submit" class="btn btn-primary btn-default">Simpan</button>
                                <a href="{{url('admin/shops')}}" class="btn btn-secondary btn-default">Kembali</a>
                            </div>
                                {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection