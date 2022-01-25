@extends('admin.index')
@section('content')
<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
		<div class="">
			<a>{{!empty($title)?$title:''}}</a>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only"></span>
			</a>
			<div class="dropdown-menu" role="menu">
				<a href="{{aurl('basicparents')}}" class="dropdown-item"  style="color:#343a40">
				<i class="fas fa-list"></i> {{trans('admin.show_all')}}</a>
				<a class="dropdown-item"  style="color:#343a40" href="{{aurl('basicparents/'.$basicparents->id.'/edit')}}">
					<i class="fas fa-edit"></i> {{trans('admin.edit')}}
				</a>
				<a class="dropdown-item"  style="color:#343a40" href="{{aurl('basicparents/create')}}">
					<i class="fas fa-plus"></i> {{trans('admin.create')}}
				</a>
				<div class="dropdown-divider"></div>
				<a data-toggle="modal" data-target="#deleteRecord{{$basicparents->id}}" class="dropdown-item"  style="color:#343a40" href="#">
					<i class="fas fa-trash"></i> {{trans('admin.delete')}}
				</a>
			</div>
		</div>
		</h3>
		@push('js')
		<div class="modal fade" id="deleteRecord{{$basicparents->id}}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{trans('admin.delete')}}</h4>
						<button class="close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<i class="fa fa-exclamation-triangle"></i>  {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$basicparents->id}})
					</div>
					<div class="modal-footer">
						{!! Form::open([
               'method' => 'DELETE',
               'route' => ['basicparents.destroy', $basicparents->id]
               ]) !!}
                {!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
						 <a class="btn btn-default" data-dismiss="modal">{{trans('admin.cancel')}}</a>
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
        <h2 class="pb-2 alert alert-heading">{{ $basicparents->name }}</h2>
        <hr>
		<div class="row">
			{{--<div class="col-md-12 col-lg-12 col-xs-12">
				<b>{{trans('admin.id')}} :</b> {{$basicparents->id}}
			</div>--}}
			<div class="clearfix"></div>
			<hr />

		{{--	@if(!empty($basicparents->admin_id()->first()))
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<b>{{trans('admin.admin_id')}} :</b>
				{{ $basicparents->admin_id()->first()->name }}
			</div>
			@endif--}}

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.name')}} :</b>
				{!! $basicparents->name !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.description')}} :</b>
				{!! $basicparents->description !!}
			</div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<a class="btn btn-info" href="{{ aurl('startup-items/'.$basicparents->id.'/create') }}">
                    <span><i class="fa fa-plus"></i>  إضافة عناصر</span>
                </a>
			</div>

		{{--	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.startup')}} :</b>
				{{ trans("admin.".$basicparents->startup) }}
			</div>--}}

			<!-- /.row -->
		</div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
</div>

{!! Form::open(["method" => "post","url" => [aurl('/basicparentitems/multi_delete')]]) !!}
<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">{{!empty($title)?$title:''}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                {!! $dataTable->table(["class"=> "table table-striped table-bordered table-hover table-checkable dataTable no-footer"],true) !!}
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
    </div>
</div>
<div class="modal fade" id="multi_delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{trans("admin.delete")}} </h4>
                <button class="close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <div class="delete_done"><i class="fa fa-exclamation-triangle"></i> {{trans("admin.ask-delete")}} <span id="count"></span> {{trans("admin.record")}} </div>
                <div class="check_delete">{{trans("admin.check-delete")}}</div>
            </div>
            <div class="modal-footer">
                {!! Form::submit(trans("admin.approval"), ["class" => "btn btn-danger btn-flat delete_done"]) !!}
                <a class="btn btn-default" data-dismiss="modal">{{trans("admin.cancel")}}</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@push('js')
    {!! $dataTable->scripts() !!}
@endpush
@endsection
