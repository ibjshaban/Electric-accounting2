@extends('admin.index')
@section('content')


<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
		<div class="">
			<span>
			{{ !empty($title)?$title:'' }}
			</span>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only"></span>
			</a>
			<div class="dropdown-menu" role="menu">
				<a href="{{ aurl('revenuefule') }}"  style="color:#343a40"  class="dropdown-item">
				<i class="fas fa-list"></i> {{ trans('admin.show_all') }}</a>
			</div>
		</div>
		</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
			<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
		</div>
	</div>
	<!-- /.card-header -->
	<div class="card-body">

{!! Form::open(['url'=>aurl('/revenuefule'),'id'=>'revenuefule','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
<div class="row">
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('quantity',trans('admin.quantity'),['class'=>' control-label']) !!}
            {!! Form::number('quantity',old('quantity'),['class'=>'form-control','placeholder'=>trans('admin.quantity')]) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('price',trans('admin.price'),['class'=>' control-label']) !!}
            {!! Form::number('price',old('price'),['class'=>'form-control','placeholder'=>trans('admin.price')]) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('paid_amount',trans('admin.paid_amount'),['class'=>' control-label']) !!}
            {!! Form::number('paid_amount',old('paid_amount'),['class'=>'form-control','placeholder'=>trans('admin.paid_amount')]) !!}
        </div>
    </div>

<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('filling_id',trans('admin.filling_id')) !!}
		{!! Form::select('filling_id',App\Models\Filling::pluck('name','id'),old('filling_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('stock_id',trans('admin.stock_id')) !!}
		{!! Form::select('stock_id',App\Models\Stock::pluck('name','id'),old('stock_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('revenue_id',trans('admin.revenue_id')) !!}
		{!! Form::select('revenue_id',App\Models\Revenue::pluck('name','id'),old('revenue_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('city_id',trans('admin.city_id')) !!}
		{!! Form::select('city_id',App\Models\City::pluck('name','id'),old('city_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('note',trans('admin.note'),['class'=>' control-label']) !!}
            {!! Form::text('note',old('note'),['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
    </div>
</div>

</div>
		<!-- /.row -->
	</div>
	<!-- /.card-body -->
	<div class="card-footer"><button type="submit" name="add" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
<button type="submit" name="add_back" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add_back') }}</button>
{!! Form::close() !!}	</div>
</div>
@endsection
