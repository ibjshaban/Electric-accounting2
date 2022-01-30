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
                        <a href="{{ aurl('basicparentitems') }}" style="color:#343a40" class="dropdown-item">
                            <i class="fas fa-list"></i> {{ trans('admin.show_all') }}</a>
                    </div>
                </div>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            {!! Form::open(['url'=>aurl('/startup-items/store/'.$id),'id'=>'basicparentitems','method'=>'post','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
            <div class="row pb-4">
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('name',trans('admin.name'),['class'=>' control-label']) !!}
                        {!! Form::text('name',old('name'),['class'=>'form-control name','placeholder'=>trans('admin.name'), 'required']) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('discount',trans('admin.discount'),['class'=>' control-label']) !!}
                        {!! Form::number('discount',old('discount'),['class'=>'form-control parentDiscount','step'=>'0.00000001','placeholder'=>trans('admin.discount'), 'oninput'=> 'refreshDiscount()','id'=>'discount_amount', 'required'])!!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <!-- Date range -->
                    <div class="form-group">
                        {!! Form::label('date',trans('admin.date')) !!}
                        <div class="input-group">
                            <div class="input-group-prepend parentDate">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                            </div>
                            {!! Form::text('date',old('date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.date'),'readonly'=>'readonly', 'required']) !!}
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>
            <div class="row">

                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr class="element">
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الملاحظات</th>
                        <th>سعر الكمية</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="element">
                        <td>
                            <input type="number" class="price" name="price[]" min="0" step="0.001"
                                   placeholder="السعر" oninput="changeAllPrice(this)">
                        </td>
                        <td>
                            <input type="number" class="amount" name="amount[]" step="0.001" min="0"
                                   placeholder="الكمية" oninput="changeAllPrice(this)">
                        </td>
                        <td>
                            <input type="text" name="note[]" placeholder="الملاحظات">
                        </td>
                        <td>
                            <label class="all_price font-weight-bolder" data-price="0">0.00 ₪</label>
                        </td>
                        <td>
                            <button type="button" name="add" class="btn btn-danger btn-flat"
                                    onclick="removeDetail(this)">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="col-md-2 p-3">
                    <button type="button" name="add" class="btn btn-success btn-flat" onclick="addNewDetails()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2"></div>
                <div class="col-md-2 bg-gradient-success">
                    <span id="all_amount">المبلغ: {{ShekelFormat(0)}}</span>
                    <span id="discount">الخصم: {{ShekelFormat(0)}}</span>
                    <span id="all_total">المجموع: {{ShekelFormat(0)}}</span>
                    {{--                    <div class="bg-gradient-info p-3 float-right" id="all_total">المجموع: {{ShekelFormat(00)}}</div>--}}
                </div>
                <div class="col-md-2"></div>


            </div>

            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" name="add" class="btn btn-primary btn-flat"><i
                    class="fa fa-plus"></i> {{ trans('admin.save') }}</button>

        </div>
    </div>
@endsection

@push('js')
    <script>
        function refreshDiscount() {
            var sum = 0;
            $('.all_price').each(function () {
                sum += parseFloat($(this).data('price'));
            });
            var discount = $('#discount_amount').val();

            $('#all_amount').text('المبلغ: ₪ ' + parseFloat(sum).toFixed(2))
            $('#discount').text('الخصم: ₪ ' + parseFloat(discount).toFixed(2))
            $('#all_total').text('المجموع: ₪ ' + parseFloat(sum - discount).toFixed(2))
        }

        /*function changeAllPrice(e) {

            var sum = 0;
            var amount = 0;
            $('.element .price').each(function () {
                amount = $('.element .amount').val();
                sum += parseFloat($(this).val());
            });
            $('#all_total').text('المجموع: ₪ ' + parseFloat(sum).toFixed(2))
        }*/
        function changeAllPrice(e) {
            var parent = $(e).parent().parent();
            var amount = parent.find('input[name="amount[]"]').val() ?? 0;
            var price = parent.find('input[name="price[]"]').val() ?? 0;

            parent.find(".all_price").text('₪ ' + (amount * price).toFixed(2));
            parent.find(".all_price").data('price', (amount * price).toFixed(2));

            var sum = 0;
            $('.all_price').each(function () {
                sum += parseFloat($(this).data('price'));
            });
            $('#all_amount').text('المبلغ: ₪ ' + parseFloat(sum).toFixed(2))
            var discount = $('#discount_amount').val();
            $('#all_total').text('المجموع: ₪ ' + parseFloat(sum - discount).toFixed(2))
        }


        function addNewDetails() {
            $('.element').last().after(
                '<tr class="element"> ' +
                '<td> <input type="number" class="price" name="price[]" min="0" step="0.0000001" placeholder="السعر" oninput="changeAllPrice(this)"> </td>' +
                '<td> <input type="number" class="amount" name="amount[]" step="0.0000001" min="0" placeholder="الكمية" oninput="changeAllPrice(this)"> </td>' +
                '<td> <input type="text" name="note[]" placeholder="الملاحظات"> </td>' +
                '<td> <label class="all_price font-weight-bolder" data-price="0">0.00 ₪</label></td>' +
                '<td>  <button type="button" name="add" class="btn btn-danger btn-flat" onclick="removeDetail(this)"> <i class="fa fa-minus"></i> </button></td>' +
                '</tr>'
            )

        }

        function removeDetail(e) {
            $(e).parent().parent().remove();
        }


    </script>
@endpush
