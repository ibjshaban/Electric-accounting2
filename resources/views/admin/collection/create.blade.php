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
				<a href="{{ aurl('collection') }}"  style="color:#343a40"  class="dropdown-item">
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

{!! Form::open(['url'=>aurl('/collection'),'id'=>'collection','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
<div class="row">

<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('employee_id',trans('admin.employee_id')) !!}
		{!! Form::select('employee_id',App\Models\Employee::where('type_id',1)->pluck('name','id'),old('employee_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('amount',trans('admin.amount'),['class'=>' control-label']) !!}
            {!! Form::number('amount',old('amount'),['class'=>'form-control','placeholder'=>trans('admin.amount')]) !!}
        </div>
    </div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('revenue_id',trans('admin.revenue_id')) !!}
		{!! Form::select('revenue_id',App\Models\Revenue::pluck('name','id'),old('revenue_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <!-- Date range -->
    <div class="form-group">
        {!! Form::label('collection_date',trans('admin.collection_date')) !!}
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            {!! Form::text('collection_date',old('collection_date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.collection_date'),'readonly'=>'readonly']) !!}
        </div>
        <!-- /.input group -->
    </div>
    <!-- /.form group -->
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('source',trans('admin.source'),['class'=>' control-label']) !!}
            {!! Form::text('source',old('source'),['class'=>'form-control','placeholder'=>trans('admin.source')]) !!}
    </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('note',trans('admin.note'),['class'=>'control-label']) !!}
            {!! Form::textarea('note',old('note'),['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
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
