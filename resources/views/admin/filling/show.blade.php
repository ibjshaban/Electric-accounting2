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
				<a href="{{aurl('filling')}}" class="dropdown-item"  style="color:#343a40">
				<i class="fas fa-list"></i> {{trans('admin.show_all')}}</a>
				<a class="dropdown-item"  style="color:#343a40" href="{{aurl('filling/'.$filling->id.'/edit')}}">
					<i class="fas fa-edit"></i> {{trans('admin.edit')}}
				</a>
				<a class="dropdown-item"  style="color:#343a40" href="{{aurl('filling/create')}}">
					<i class="fas fa-plus"></i> {{trans('admin.create')}}
				</a>
				<div class="dropdown-divider"></div>
				<a data-toggle="modal" data-target="#deleteRecord{{$filling->id}}" class="dropdown-item"  style="color:#343a40" href="#">
					<i class="fas fa-trash"></i> {{trans('admin.delete')}}
				</a>
			</div>
		</div>
		</h3>
		@push('js')
		<div class="modal fade" id="deleteRecord{{$filling->id}}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{trans('admin.delete')}}</h4>
						<button class="close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<i class="fa fa-exclamation-triangle"></i>  {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$filling->id}})
					</div>
					<div class="modal-footer">
						{!! Form::open([
               'method' => 'DELETE',
               'route' => ['filling.destroy', $filling->id]
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
				<b>{{trans('admin.id')}} :</b> {{$filling->id}}
			</div>
			<div class="clearfix"></div>
			<hr />

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.quantity')}} :</b>
				{!! $filling->quantity !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.price')}} :</b>
				{!! $filling->price !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.filling_date')}} :</b>
				{!! $filling->filling_date !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.note')}} :</b>
				{!! $filling->note !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.name')}} :</b>
				{!! $filling->name !!}
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<b>{{trans('admin.supplier_id')}} :</b>
				@if(!empty($filling->supplier_id()->first()))
			{{ $filling->supplier_id()->first()->name }}
			@endif
			</div>

			<!-- /.row -->
		</div>
        <hr>
        <div class="row col-12">
            <div class="mb-3"><b>التفاصيل</b></div>

            <div class="row row-cols-5 col-12 mb-5 element">
                <div class="col">المنطقة</div>
                <div class="col">المخزن</div>
                <div class="col">الايرادة</div>
                <div class="col">الكمية</div>
                <div class="col">السعر الكلي</div>
                <div class="col">السعر المدفوع</div>
                <div class="col">ملاحظات</div>
            </div>
            @foreach($filling->fule() as $it)
                <?php $city= \App\Models\City::whereId($it->city_id)->first();
                 $stock= \App\Models\Stock::whereId($it->stock_id)->first();
                $revenue= \App\Models\revenue::whereId($it->revenue_id)->first();?>

                <div class="row row-cols-5 col-12 mb-5 element" >
                    <div class="col">
                        {{$city? $city->name : ''}}
                    </div>
                    <div class="col">
                        {{$stock? $stock->name : ''}}
                    </div>
                    <div class="col">
                        {{$revenue? $revenue->name : ''}}
                    </div>
                    <div class="col">
                        {{$it->quantity}}
                    </div>
                    <div class="col">
                        {{ShekelFormat($it->price*$it->quantity)}}
                    </div>
                    <div class="col">
                        {{ShekelFormat($it->paid_price)}}
                    </div>
                    <div class="col">
                        {{$it->note}}
                    </div>

                </div>
            @endforeach
            <div class="row row-cols-5 col-12 mb-5" >
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col bg-success" id="all_total">المجموع: {{ShekelFormat($filling->price * $filling->quantity)}}</div>
                <div class="col"></div>
            </div>
        </div>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
</div>
@endsection
