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
                <a href="{{aurl('revenue-expenses/'.$expenses->revenue_id)}}" class="dropdown-item" style="color:#343a40">
                    <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
                <a class="dropdown-item"  style="color:#343a40" href="{{aurl('revenue-expenses/'.$expenses->id.'/edit')}}">
                    <i class="fas fa-edit"></i> {{trans('admin.edit')}}
                </a>
                <a class="dropdown-item" style="color:#343a40" href="{{aurl('revenue-expenses/'.$expenses->revenue_id.'/create')}}">
                    <i class="fa fa-plus"></i> {{trans('admin.create')}}
                </a>
                <div class="dropdown-divider"></div>
                <a data-toggle="modal" data-target="#deleteRecord{{$expenses->id}}" class="dropdown-item"
                   style="color:#343a40" href="#">
                    <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                </a>
            </div>
		</div>
		</h3>
		@push('js')
		<div class="modal fade" id="deleteRecord{{$expenses->id}}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{trans('admin.delete')}}</h4>
						<button class="close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<i class="fa fa-exclamation-triangle"></i>  {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$expenses->id}})
					</div>
					<div class="modal-footer">
						{!! Form::open([
               'method' => 'DELETE',
               'route' => ['expenses.destroy', $expenses->id]
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
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xs-12">
				<b>{{trans('admin.id')}} :</b> {{$expenses->id}}
			</div>
			<div class="clearfix"></div>
			<hr />

			@if(!empty($expenses->admin_id()->first()))
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<b>{{trans('admin.admin_id')}} :</b>
				{{ $expenses->admin_id()->first()->name }}
			</div>
			@endif

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>البيان :</b>
				{!! $expenses->name !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.price')}} :</b>
				{!! ShekelFormat($expenses->price) !!}
			</div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.discount')}} :</b>
				{!! ShekelFormat($expenses->discount) !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.date')}} :</b>
				{!! $expenses->date !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.revenue_id')}} :</b>
				@if(!empty($expenses->revenue_id()->first()))
			{{ $expenses->revenue_id()->first()->name }}
			@endif
			</div>
			<!-- /.row -->
		</div>
        <hr>
        <div class="row col-12">
            <div class="mb-3"><b>التفاصيل</b></div>

            <div class="row row-cols-5 col-12 mb-5 element">
                <div class="col">الصنف</div>
                <div class="col">رقم الصنف</div>
                <div class="col">الكمية</div>
                <div class="col">سعر الوحدة</div>
                <div class="col">سعر الكمية</div>
            </div>
            @foreach($expenses->item() as $it)
            <div class="row row-cols-5 col-12 mb-5 detail element" >
                <div class="col">
                    {{$it->item}}
                </div>
                <div class="col">
                    {{$it->item_number}}
                </div>
                <div class="col">
                    {{$it->amount}}
                </div>
                <div class="col">
                    {{ShekelFormat($it->price)}}
                </div>
                <div class="col all_price">{{ShekelFormat($it->price* $it->amount)}}</div>
            </div>
            @endforeach
            <div class="row row-cols-5 col-12 mb-5" >
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col bg-success" id="all_total">المجموع: {{ShekelFormat($expenses->price)}}</div>
                <div class="col"></div>
            </div>
        </div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
</div>
@endsection
