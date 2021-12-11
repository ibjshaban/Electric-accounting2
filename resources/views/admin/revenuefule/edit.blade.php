@extends('admin.index')
@section('content')


<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
		<div class="">
			<span>{{!empty($title)?$title:''}}</span>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only"></span>
			</a>
			<div class="dropdown-menu" role="menu">
				<a href="{{aurl('revenuefule')}}" class="dropdown-item" style="color:#343a40">
				<i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
				<a href="{{aurl('revenuefule/'.$revenuefule->id)}}" class="dropdown-item" style="color:#343a40">
				<i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
				<a class="dropdown-item" style="color:#343a40" href="{{aurl('revenuefule/create')}}">
					<i class="fa fa-plus"></i> {{trans('admin.create')}}
				</a>
				<div class="dropdown-divider"></div>
				<a data-toggle="modal" data-target="#deleteRecord{{$revenuefule->id}}" class="dropdown-item" style="color:#343a40" href="#">
					<i class="fa fa-trash"></i> {{trans('admin.delete')}}
				</a>
			</div>
		</div>
		</h3>
		@push('js')
		<div class="modal fade" id="deleteRecord{{$revenuefule->id}}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{trans('admin.delete')}}</h4>
						<button class="close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<i class="fa fa-exclamation-triangle"></i>   {{trans('admin.ask_del')}} {{trans('admin.id')}}  ({{$revenuefule->id}})
					</div>
					<div class="modal-footer">
						{!! Form::open([
						'method' => 'DELETE',
						'route' => ['revenuefule.destroy', $revenuefule->id]
						]) !!}
						{!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
						<a class="btn btn-default btn-flat" data-dismiss="modal">{{trans('admin.cancel')}}</a>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
		@endpush
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
			<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
		</div>
	</div>
	<!-- /.card-header -->
	<div class="card-body">

{!! Form::open(['url'=>aurl('/revenuefule/'.$revenuefule->id),'method'=>'put','id'=>'revenuefule','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
<div class="row">
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('quantity',trans('admin.quantity'),['class'=>' control-label']) !!}
            {!! Form::number('quantity',$revenuefule->quantity,['class'=>'form-control','placeholder'=>trans('admin.quantity')]) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('price',trans('admin.price'),['class'=>' control-label']) !!}
            {!! Form::number('price',$revenuefule->price,['class'=>'form-control','placeholder'=>trans('admin.price')]) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('paid_amount',trans('admin.paid_amount'),['class'=>' control-label']) !!}
            {!! Form::number('paid_amount',$revenuefule->paid_amount,['class'=>'form-control','placeholder'=>trans('admin.paid_amount')]) !!}
        </div>
    </div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
		<div class="form-group">
				{!! Form::label('filling_id',trans('admin.filling_id'),['class'=>'control-label']) !!}
{!! Form::select('filling_id',App\Models\Filling::pluck('name','id'), $revenuefule->filling_id ,['class'=>'form-control select2','placeholder'=>trans('admin.filling_id')]) !!}
		</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
		<div class="form-group">
				{!! Form::label('stock_id',trans('admin.stock_id'),['class'=>'control-label']) !!}
{!! Form::select('stock_id',App\Models\Stock::pluck('name','id'), $revenuefule->stock_id ,['class'=>'form-control select2','placeholder'=>trans('admin.stock_id')]) !!}
		</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
		<div class="form-group">
				{!! Form::label('revenue_id',trans('admin.revenue_id'),['class'=>'control-label']) !!}
{!! Form::select('revenue_id',App\Models\Revenue::pluck('name','id'), $revenuefule->revenue_id ,['class'=>'form-control select2','placeholder'=>trans('admin.revenue_id')]) !!}
		</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
		<div class="form-group">
				{!! Form::label('city_id',trans('admin.city_id'),['class'=>'control-label']) !!}
{!! Form::select('city_id',App\Models\City::pluck('name','id'), $revenuefule->city_id ,['class'=>'form-control select2','placeholder'=>trans('admin.city_id')]) !!}
		</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('note',trans('admin.note'),['class'=>'control-label']) !!}
        {!! Form::text('note', $revenuefule->note ,['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
    </div>
</div>

</div>
		<!-- /.row -->
		</div>
	<!-- /.card-body -->
	<div class="card-footer"><button type="submit" name="save" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> {{ trans('admin.save') }}</button>
<button type="submit" name="save_back" class="btn btn-success btn-flat"><i class="fa fa-save"></i> {{ trans('admin.save_back') }}</button>
{!! Form::close() !!}
</div>
</div>
@endsection
