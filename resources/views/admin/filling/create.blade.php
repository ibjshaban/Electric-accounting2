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
				<a href="{{ aurl('filling') }}"  style="color:#343a40"  class="dropdown-item">
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

{!! Form::open(['url'=>aurl('/filling'),'id'=>'filling','files'=>true,'id'=>'MainForm','class'=>'form-horizontal form-row-seperated','method' => 'post','enctype'=>'multipart/form-data']) !!}
<div class="row">

    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('name',trans('admin.name'),['class'=>' control-label']) !!}
            {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>trans('admin.name'),'required'=>'required']) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('quantity',trans('admin.quantity'),['class'=>' control-label']) !!}
            {!! Form::number('quantity',old('quantity'),['class'=>'form-control','placeholder'=>trans('admin.quantity'),'required'=>'required','id'=> 'filling_amount']) !!}
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
        <div class="form-group">
            {!! Form::label('price','سعر(لتر)',['class'=>' control-label']) !!}
            {!! Form::number('price',old('price'),['class'=>'form-control','placeholder'=>'سعر(لتر)','step'=>"0.001",'min'=>"0",'id'=> 'filling_price','required'=>'required','oninput'=>'changeAllPrice(this)']) !!}
        </div>
    </div>
{{--<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('supplier_id',trans('admin.supplier_id')) !!}
		{!! Form::select('supplier_id',App\Models\Supplier::pluck('name','id'),old('supplier_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>--}}
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <!-- Date range -->
    <div class="form-group">
        {!! Form::label('filling_date',trans('admin.filling_date')) !!}
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
            {!! Form::text('filling_date',old('filling_date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.filling_date'),'readonly'=>'readonly']) !!}
        </div>
        <!-- /.input group -->
    </div>
    <!-- /.form group -->
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('filling_note',trans('admin.note'),['class'=>'control-label']) !!}
            {!! Form::textarea('filling_note',old('filling_note'),['class'=>'form-control','placeholder'=>trans('admin.note'),'rows'=> 3]) !!}
    </div>
</div>

</div>
		<!-- /.row -->
        <hr>
        <div class="row col-12">
            <div class="row row-cols-5 col-12 mb-5 element">
                <div class="col">المخزن</div>
                <div class="col">الايرادة</div>
                <div class="col">الكمية</div>
                <div class="col">ملاحظات</div>
                <div class="col"></div>
            </div>
            <div class="row row-cols-5 col-12 mb-5 detail element" >
                <div class="col">
                    <div class="form-group">
                        <select name="stock[]" class="form-control" required onchange="refreshRevenue(this)">
                            <option disabled>المخزن</option>
                            @foreach($stocks as $stock)
                            <option value="{{$stock->id}}" {{$loop->first? 'selected' :''}} data-city_id="{{$stock->city_id}}">{{$stock->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select name="revenue[]"  class="form-control" required>
                            <option class="revenue_first_item" disabled>الإيرادة</option>
                            @foreach(\App\Models\revenue::where('city_id',$stocks->first()->city_id)->where('status',1)->orderByDesc('created_at')->get() as $revenue)
                                <option class="revenue_item" value="{{$revenue->id}}" {{$loop->first? 'selected' :''}} >{{$revenue->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <input required type="number" step="0.001" min="0" class="form-control " name="amount[]" placeholder="الكمية (لتر)" oninput="changeAllPrice(this)">
                </div>
                <div class="col">
                    <input type="text" class="form-control " name="note[]" placeholder="ملاحظات">
                </div>
                <div class="col">
                    <button type="button" class="btn btn-primary btn-flat" onclick="removeDetail(this)">
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
                <div class="col bg-success" id="all_total">المجموع: {{ShekelFormat(0)}}</div>
                <div class="col">
                </div>
            </div>
            <div class="d-flex flex-row-reverse  mx-3">
                <button type="button" class="btn btn-primary btn-flat" onclick="addNewDetails()">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

	</div>
	<!-- /.card-body -->
	<div class="card-footer">
        <button type="submit" name="add" class="btn btn-primary btn-flat" ><i class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
        <button type="submit" name="add_back" class="btn btn-success btn-flat" ><i class="fa fa-plus"></i> {{ trans('admin.add_back') }}</button>
{!! Form::close() !!}	</div>
</div>
@endsection

@push('js')
    <script>
        $('#MainForm').on('submit', function(){
            var amount = 0;
            $('input[name="amount[]"]').each(function()
            {
                var am= $(this).val()? $(this).val(): 0
                amount += parseFloat(am);
            });
            var filling_amount= $('#filling_amount').val() ?? 0
            console.log(amount,filling_amount)
            if (amount == filling_amount){
                //$('#MainForm').submit();
                return true;
            }
            else {
                alert('الكمية الكلية لا تساوي مجموع كميات المخازن');
                return false;
            }
        });
        function refreshRevenue(e){
            //$(e).parent().
            var val= $(e).find(':selected').data('city_id');
            $(e).parent().parent().parent().find('option[class="revenue_item"]').remove();
            $.post( "{{route("getRevenueByCity")}}", {id: val, _token: "{{csrf_token()}}"})
                .done(function(Alldata) {
                    var html= '';
                    var data= Alldata.revenues;
                    data.forEach(e=> {
                        html += '<option class="revenue_item" value="'+e.id+'" '+(e == data[0] ? 'selected' : '')+'>'+e.name+'</option>'
                    })
                    $(e).parent().parent().parent().find('option[class="revenue_first_item"]').after(html);
                })
                .fail(function() {

                })
        }
        function changeAllPrice(e){
            var sum = 0;
            var filling_price= $('#filling_price').val() ?? 0
            $('input[name="amount[]"]').each(function()
            {
                var amount= $(this).val()? $(this).val(): 0
                sum += parseFloat(amount*filling_price);
            });
            $('#all_total').text('المجموع: ₪ '+parseFloat(sum).toFixed(2))
        }
        function addNewDetails(){
            $('.element').last().after('<div class="row row-cols-5 col-12 mb-5 detail element" > ' +
                '<div class="col">' +
                ' <div class="form-group">' +
                ' <select name="stock[]" class="form-control" required onchange="refreshRevenue(this)">' +
                ' <option disabled>المخزن</option>'+
                @foreach($stocks as $stock)
                '<option value="{{$stock->id}}" {{$loop->first? 'selected' :''}} data-city_id="{{$stock->city_id}}">{{$stock->name}}</option>'+
                @endforeach
                '</select>' +
                ' </div>' +
                ' </div> ' +
                '<div class="col"> ' +
                '<div class="form-group"> ' +
                '<select name="revenue[]" class="form-control" required> ' +
                '<option class="revenue_first_item" disabled>الإيرادة</option>'+
                @foreach(\App\Models\revenue::where('city_id',$stocks->first()->city_id)->where('status',1)->orderByDesc('created_at')->get() as $revenue)
                '<option class="revenue_item" value="{{$revenue->id}}" {{$loop->first? 'selected' :''}} >{{$revenue->name}}</option>'+
                @endforeach
                '</select> ' +
                '</div> </div> ' +
                '<div class="col"> ' +
                '<input required type="number" step="0.001" min="0" class="form-control " name="amount[]" placeholder="الكمية (لتر)" oninput="changeAllPrice(this)">' +
                ' </div> ' +
                '<div class="col"> <input type="text" class="form-control " name="note[]" placeholder="ملاحظات"> </div> <div class="col">' +
                ' <button type="button" class="btn btn-primary btn-flat" onclick="removeDetail(this)"> <i class="fa fa-minus"></i> </button> </div> </div>');
        }
        function removeDetail(e){
            $(e).parent().parent().remove();
        }
    </script>
@endpush
