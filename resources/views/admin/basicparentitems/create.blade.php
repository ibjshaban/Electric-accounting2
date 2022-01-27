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
                        {!! Form::text('name',old('name'),['class'=>'form-control name parentName','placeholder'=>trans('admin.name')]) !!}
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('discount',trans('admin.discount'),['class'=>' control-label']) !!}
                        {!! Form::number('discount',old('discount'),['class'=>'form-control parentDiscount','step'=>'0.00000001','placeholder'=>trans('admin.discount')])!!}
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
                            {!! Form::text('date',old('date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.date'),'readonly'=>'readonly']) !!}
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                </div>
            </div>
            {{--
                        <div class="row">

                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    {!! Form::label('name',trans('admin.name'),['class'=>' control-label']) !!}
                                    {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>trans('admin.name')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    {!! Form::label('price',trans('admin.price'),['class'=>' control-label']) !!}
                                    {!! Form::number('price',old('price'),['class'=>'form-control','step'=>'0.00000001','placeholder'=>trans('admin.price')])!!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    {!! Form::label('discount',trans('admin.discount'),['class'=>' control-label']) !!}
                                    {!! Form::number('discount',old('discount'),['class'=>'form-control','step'=>'0.00000001','placeholder'=>trans('admin.discount')])!!}
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    {!! Form::label('amount',trans('admin.amount'),['class'=>' control-label']) !!}
                                    {!! Form::number('amount',old('amount'),['class'=>'form-control','step'=>'0.00000001','placeholder'=>trans('admin.amount')])!!}
                                </div>
                            </div>
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
                                        {!! Form::text('date',old('date'),['class'=>'form-control float-right datepicker','placeholder'=>trans('admin.date'),'readonly'=>'readonly']) !!}
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    {!! Form::label('note',trans('admin.note'),['class'=>' control-label']) !!}
                                    {!! Form::text('note',old('note'),['class'=>'form-control','placeholder'=>trans('admin.note')]) !!}
                                </div>
                            </div>

                        </div>
            --}}
            <div class="row">

                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr class="element">
                        {{--                        <th>البيان</th>--}}
                        <th>السعر</th>
                        @if($basicparent->item != '2')
                            {{--                            <th>الخصم</th>--}}
                            <th>الكمية</th>
                        @endif
                        {{--                        <th>التاريخ</th>--}}
                        <th>الملاحظات</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="element">
                        <td hidden>
                            <input type="text" class="name" name="name[]" placeholder="البيان">
                        </td>
                        <td>
                            <input type="number" class="price" name="price[]" min="0" step="0.0000001"
                                   placeholder="السعر" oninput="changeAllPrice(this)">
                        </td>
                        @if($basicparent->item != '2')

                            <td hidden>
                                <input type="number" class="discount" name="discount[]" step="0.0000001" min="0"
                                       placeholder="المبلغ" required>
                            </td>
                            <td>
                                <input type="number" class="amount" name="amount[]" step="0.0000001" min="0"
                                       placeholder="الكمية" oninput="changeAllPrice(this)" required>
                            </td>
                        @endif
                        <td hidden>
                            <input type="date" class="date" name="date[]" placeholder="التاريخ" required>
                        </td>

                        <td>
                            <input type="text" name="note[]" placeholder="الملاحظات">
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

                <div class="col p-3">
                    <button type="button" name="add" class="btn btn-success btn-flat" onclick="addNewDetails()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <div class="col">
                    <div class="bg-gradient-info p-3 float-right" id="all_total">المجموع: {{ShekelFormat(00)}}</div>
                </div>


            </div>

            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        {{--
                <div class="card-footer">
                    <button type="submit" name="add" class="btn btn-primary btn-flat"><i
                            class="fa fa-plus"></i> {{ trans('admin.add') }}
                    </button>
                    <button type="submit" name="add_back" class="btn btn-success btn-flat"><i
                            class="fa fa-plus"></i> {{ trans('admin.add_back') }}
                    </button>
                    {!! Form::close() !!}
                </div>
        --}}
        <div class="card-footer">
            <button type="submit" name="add" class="btn btn-primary btn-flat"><i
                    class="fa fa-plus"></i> {{ trans('admin.save') }}</button>

        </div>
    </div>
@endsection

@push('js')
    <script>

        function changeAllPrice(e) {

            var sum = 0;
            var amount = 0;
            $('.element .price').each(function () {
                amount = $('.element .amount').val();
                sum += parseFloat($(this).val());
            });
            $('#all_total').text('المجموع: ₪ ' + parseFloat(sum).toFixed(2))
        }

        function addNewDetails() {
            $('.element').last().after(
                '<tr class="element"> ' +
                '<td hidden><input type="text" class="name" name="name[]" placeholder="البيان"></td>' +
                '<td> <input type="number" class="price" name="price[]" min="0" step="0.0000001" placeholder="السعر" oninput="changeAllPrice(this)"> </td>' +
                @if($basicparent->item != '2')
                    '<td hidden> <input type="number" class="discount" name="discount[]" step="0.0000001" min="0" placeholder="المبلغ" required> </td>' +
                '<td> <input type="number" class="amount" name="amount[]" step="0.0000001" min="0" placeholder="الكمية" oninput="changeAllPrice(this)" required> </td>' +
                @endif
                    '<td hidden> <input type="date" value="' + $(".datepicker").val() + '" name="date[]" class="date" placeholder="التاريخ" required> </td>' +
                '<td> <input type="text" name="note[]" placeholder="الملاحظات"> </td>' +
                '<td>  <button type="button" name="add" class="btn btn-danger btn-flat" onclick="removeDetail(this)"> <i class="fa fa-minus"></i> </button></td>' +
                '</tr>'
            )

        }

        function removeDetail(e) {
            $(e).parent().parent().remove();
        }


        /*$(".source").last().focus(function (event) {
            if ($('tr td .employeeSel').last().val()) {
                event.preventDefault();
                $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');

            }
        });*/

        /*$(".employeeSel").last().focus(function (event) {
            if ($('tr td .source').last().val()) {
                event.preventDefault();
                $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');

            }
        });*/

        /*$('body').on('DOMNodeInserted', 'tr', function (event) {
            $(".source").last().focus(function () {
                if ($('.employeeSel').last().val()) {
                    event.preventDefault();
                    $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');

                }
            });
            $(".employeeSel").last().focus(function (event) {
                if ($('tr td .source').last().val()) {
                    event.preventDefault();
                    $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');

                }
            });
        });*/



        /*$(".test").click(function (event) {

            if ($('.employeeSel').val()) {
                event.preventDefault();
                $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');
            }


        });
        $(".ok").click(function () {
            $('.card-body').removeAttr('data-target', '.modal').attr('data-toggle', 'modal');
        });*/

        $(".parentName").on("keyup", function () {
            var value = $(this).val();
            $(".name").val(value);
        });
        $(".parentDiscount").on("keyup", function () {
            var value = $(this).val();
            $(".discount").val(value);
        });
        $(".datepicker").on("change", function () {
            var value = $(this).val();
            $(".date").val(value);
        });
    </script>
@endpush
