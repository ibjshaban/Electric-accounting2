@extends('admin.index')
@section('content')

@push('css')
    <style>
        .createTable{
            max-width: 100%;
        }
        .createTable div:not(:last-child){
            border: 1px solid black;
        }

    </style>
@endpush
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
                <a href="{{aurl('revenue-expenses/'.request()->route('id'))}}" class="dropdown-item" style="color:#343a40">
                    <i class="fas fa-list"></i> {{trans('admin.show_all')}} </a>
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
{!! Form::open(['url'=>aurl('/revenue-expenses/create/'.$expenses->id),'id'=>'expenses','files'=>true,'class'=>'form-horizontal form-row-seperated','method' => 'post','enctype'=>'multipart/form-data']) !!}
<div class="row">

<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('name','البيان',['class'=>' control-label']) !!}
            {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=> 'البيان','required']) !!}
    </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('discount','الخصم',['class'=>' control-label']) !!}
        {!! Form::number('discount',old('discount')?? 0,['step'=>'0.0000001','min'=>0,'class'=>'form-control','placeholder'=> 'الخصم','required','oninput'=> 'refreshDiscount()','id'=>'discount_amount']) !!}
    </div>
</div>
{{--<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('price',trans('admin.price'),['class'=>' control-label']) !!}
            {!! Form::text('price',old('price'),['class'=>'form-control','placeholder'=>trans('admin.price')]) !!}
    </div>
</div>--}}
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <!-- Date range -->
    <div class="form-group">
        {!! Form::label('date',trans('admin.date')) !!}
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            {!! Form::text('date',old('date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.date'),'readonly'=>'readonly','required']) !!}
        </div>
        <!-- /.input group -->
    </div>
    <!-- /.form group -->
</div>

</div>
		<!-- /.row -->
        <hr>
        <div class="row col-12">
            <div class="row row-cols-5 col-12 mb-5 element font-weight-bold createTable">
                <div class="col">الصنف</div>
                <div class="col">رقم الصنف</div>
                <div class="col">الكمية</div>
                <div class="col">سعر الوحدة</div>
                <div class="col">سعر الكمية</div>
                <div class="col"></div>
            </div>
            <div class="row row-cols-5 col-12 mb-5 detail element">
                <div class="col">
                    <input required type="text" class="form-control " name="item[]" placeholder="الصنف">
                </div>
                <div class="col">
                    <input required type="text" class="form-control " name="item_number[]" placeholder="رقم الصنف">
                </div>
                <div class="col">
                    <input required type="number" step="0.001" min="0" class="form-control " name="amount[]" placeholder="الكمية" oninput="changeAllPrice(this)">
                </div>
                <div class="col">
                    <input required type="number" step="0.001" min="0" class="form-control " name="price[]" placeholder="سعر الوحدة" oninput="changeAllPrice(this)">
                </div>
                <div class="col all_price font-weight-bolder" data-price="0">0.00 ₪</div>
                <div class="col">
                    <button type="button" name="add" class="btn btn-danger btn-flat" onclick="removeDetail(this)">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="row row-cols-5 col-12 mb-5" >
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col">
                </div>
                <div class="col bg-success p-3" >
                    <span id="all_amount">المبلغ: {{ShekelFormat(0)}}</span>
                    <span id="discount">الخصم: {{ShekelFormat(0)}}</span>
                    <span id="all_total">المجموع: {{ShekelFormat(0)}}</span>
                </div>
                <div class="col"></div>
            </div>
            <div class="d-flex flex-row-reverse  mx-3">
                <button type="button" name="add" class="btn btn-success btn-flat" onclick="addNewDetails()">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
	</div>
	<!-- /.card-body -->
<div class="card-footer"><button type="submit" name="add" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
<button type="submit" name="add_back" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add_back') }}</button>
{!! Form::close() !!}	</div>
</div>
@endsection

@push('js')
    <script>
        function refreshDiscount(){
            var sum = 0;
            $('.all_price').each(function()
            {
                sum += parseFloat($(this).data('price'));
            });
            var discount= $('#discount_amount').val();

            $('#all_amount').text('المبلغ: ₪ '+parseFloat(sum).toFixed(2))
            $('#discount').text('الخصم: ₪ '+parseFloat(discount).toFixed(2))
            $('#all_total').text('المجموع: ₪ '+parseFloat(sum-discount).toFixed(2))
        }
        function changeAllPrice(e){
            var parent= $(e).parent().parent();
            var amount=  parent.find('input[name="amount[]"]').val() ?? 0;
            var price=  parent.find('input[name="price[]"]').val() ?? 0;

            parent.find(".all_price").text('₪ '+(amount* price).toFixed(2));
            parent.find(".all_price").data('price',(amount* price).toFixed(2));

            var sum = 0;
            $('.all_price').each(function()
            {
                sum += parseFloat($(this).data('price'));
            });
            $('#all_amount').text('المبلغ: ₪ '+parseFloat(sum).toFixed(2))
            var discount= $('#discount_amount').val();
            $('#all_total').text('المجموع: ₪ '+parseFloat(sum-discount).toFixed(2))
        }
        function addNewDetails(){
            $('.element').last().after(
                '<div class="row row-cols-5 col-12 mb-5 detail element"  > '+
                '<div class="col"> <input required type="text" class="form-control " name="item[]" placeholder="الصنف">' +
                ' </div> <div class="col"> <input required type="text" class="form-control " name="item_number[]" placeholder="رقم الصنف">' +
                ' </div> <div class="col"> ' +
                '<input required type="number" step="0.001" min="0" class="form-control " name="amount[]" placeholder="الكمية" oninput="changeAllPrice(this)"> ' +
                '</div> <div class="col"> ' +
                '<input required type="number" step="0.001" min="0" class="form-control " name="price[]" placeholder="سعر الوحدة" oninput="changeAllPrice(this)"> ' +
                '</div> <div class="col all_price" data-price="0">0.00 ₪</div> ' +
                '<div class="col"> ' +
                '<button type="button" name="add" class="btn btn-danger btn-flat" onclick="removeDetail(this)">' +
                ' <i class="fa fa-minus"></i> </button> </div> </div>');
        }
        function removeDetail(e){
            $(e).parent().parent().remove();
        }
    </script>
@endpush
