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
				<a href="{{aurl('collection')}}" class="dropdown-item" style="color:#343a40">
				<i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
				<a href="{{aurl('collection/'.$collection->id)}}" class="dropdown-item" style="color:#343a40">
				<i class="fa fa-eye"></i> {{trans('admin.show')}} </a>
				<a class="dropdown-item" style="color:#343a40" href="{{aurl('collection/create')}}">
					<i class="fa fa-plus"></i> {{trans('admin.create')}}
				</a>
				<div class="dropdown-divider"></div>
				<a data-toggle="modal" data-target="#deleteRecord{{$collection->id}}" class="dropdown-item" style="color:#343a40" href="#">
					<i class="fa fa-trash"></i> {{trans('admin.delete')}}
				</a>
			</div>
		</div>
		</h3>
		@push('js')
		<div class="modal fade" id="deleteRecord{{$collection->id}}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{trans('admin.delete')}}</h4>
						<button class="close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<i class="fa fa-exclamation-triangle"></i>   {{trans('admin.ask_del')}} {{trans('admin.id')}}  ({{$collection->id}})
					</div>
					<div class="modal-footer">
						{!! Form::open([
						'method' => 'DELETE',
						'route' => ['collection.destroy', $collection->id]
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

{!! Form::open(['url'=>aurl('/collection/'.$collection->id),'method'=>'put','id'=>'collection','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
<div class="row">
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <div class="form-group clearfix">
                <label for="radioPrimary3">
                    نوع المحصل
                </label>
                <br>
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary1" value="0" onchange="change_collect()" name="collect_type" {{$collection->employee_id ? 'checked=""':''}}>
                    <label for="radioPrimary1">
                        موظف
                    </label>
                </div>
                <div class="icheck-primary d-inline">
                    <input type="radio" id="radioPrimary2" value="1" onchange="change_collect()" name="collect_type" {{$collection->employee_id ? '':'checked=""'}}>
                    <label for="radioPrimary2">
                        جهة أخرى
                    </label>
                </div>
            </div>
        </div>
    </div>
<div id="employeebox" class="col-md-6 col-lg-6 col-sm-6 col-xs-12" style="display: {{$collection->employee_id ? '':'none'}}">
		<div class="form-group">
				{!! Form::label('employee_id',trans('admin.employee_id'),['class'=>'control-label']) !!}
{!! Form::select('employee_id',App\Models\Employee::where('type_id',1)->pluck('name','id'), $collection->employee_id ,['class'=>'form-control select2','placeholder'=>trans('admin.employee_id')]) !!}
		</div>
</div>
    <div id="sourcebox" class="col-md-6 col-lg-6 col-sm-6 col-xs-12" style="display: {{$collection->employee_id ? 'none':''}}">
        <div class="form-group">
            {!! Form::label('source',trans('admin.source'),['class'=>'control-label']) !!}
            {!! Form::text('source', $collection->source ,['class'=>'form-control','placeholder'=>trans('admin.source')]) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('amount',trans('admin.amount'),['class'=>' control-label']) !!}
            {!! Form::number('amount',$collection->amount,['class'=>'form-control','placeholder'=>trans('admin.amount')]) !!}
        </div>
    </div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
		<div class="form-group">
				{!! Form::label('revenue_id',trans('admin.revenue_id'),['class'=>'control-label']) !!}
{!! Form::select('revenue_id',App\Models\Revenue::pluck('name','id'), $collection->revenue_id ,['class'=>'form-control select2','placeholder'=>trans('admin.revenue_id')]) !!}
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
            {!! Form::text('collection_date', $collection->collection_date ,['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.collection_date'),'readonly'=>'readonly']) !!}
        </div>
        <!-- /.input group -->
    </div>
    <!-- /.form group -->
</div>

<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('note',trans('admin.note'),['class'=>'control-label']) !!}
        {!! Form::textarea('note', $collection->note ,['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
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

@push('js')
    <script>
        function change_collect(){
            var value = $('input[name="collect_type"]:checked').val();
            if (value == '0'){
                $('#sourcebox').css('display', 'none');
                $('#employeebox').css('display', '');
            }
            else if(value == '1'){
                $('#employeebox').css('display', 'none');
                $('#sourcebox').css('display', '');
            }
        }
    </script>
@endpush
