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
                        <a href="{{ aurl('collection') }}" style="color:#343a40" class="dropdown-item">
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

            {!! Form::open(['url'=>aurl('/revenue-collection/create/'.$collection->id),'id'=>'collection','files'=>true,'class'=>'form-horizontal form-row-seperated', 'method' => 'post']) !!}
            <div class="row">

                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr class="element">
                        <th>الموظف</th>
                        <th>جهةاخرى</th>
                        <th>المبلغ</th>
                        <th>تاريخ التحصيل</th>
                        <th>الملاحظات</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="element">
                        <td>
                            {!! Form::select('employee_id[]',App\Models\Employee::where('type_id',1)->where('city_id',\App\Models\revenue::whereId(request()->route('id'))->first()->city_id)->pluck('name','id'),old('employee_id'),['class'=>'form-control employeeSel','placeholder'=>trans('admin.choose')]) !!}
                        </td>
                        <td>
                            <input type="text" class="source" name="source[]" placeholder="جهة اخرى">
                        </td>
                        <td>
                            <input type="number" class="amount" name="amount[]" step="0.001" min="0"
                                   placeholder="المبلغ" oninput="changeAllPrice(this)" required>
                        </td>
                        <td>
                            <input type="date" name="collection_date[]" placeholder="التاريخ" required>
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
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" name="add" class="btn btn-primary btn-flat"><i
                        class="fa fa-plus"></i> {{ trans('admin.save') }}</button>

            </div>
            {!! Form::close() !!}

            <div class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                            <button class="close" data-dismiss="modal">x</button>
                        </div>
                        <div class="modal-body">
                            <i class="fa fa-exclamation-triangle"></i> لايمكن ادخال قيمة <strong>موظف و جهة
                                اخرى</strong> معاً
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default btn-warning ok" data-dismiss="modal">إغلاق</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        @endsection

        @push('js')
            <script>

                function changeAllPrice(e) {

                    var sum = 0;
                    $('.amount').each(function () {
                        sum += parseFloat($(this).val());
                    });
                    $('#all_total').text('المجموع: ₪ ' + parseFloat(sum).toFixed(2))
                }

                function addNewDetails() {
                    $('.element').last().after(
                        '<tr class="element"> ' +
                        '<td> {!! Form::select('employee_id[]',App\Models\Employee::where('type_id',1)->where('city_id',\App\Models\revenue::whereId(request()->route('id'))->first()->city_id)->pluck('name','id'),old('employee_id'),['class'=>'form-control employeeSel','id'=>'employee_id','placeholder'=>trans('admin.choose')]) !!} </td>' +
                        '<td> <input type="text" class="source" name="source[]" placeholder="جهة اخرى"> </td>' +
                        '<td> <input type="number" class="amount" name="amount[]" step="0.001" min="0" placeholder="المبلغ" oninput="changeAllPrice(this)" required> </td>' +
                        '<td> <input type="date" name="collection_date[]" placeholder="التاريخ" required> </td>' +
                        '<td> <input type="text" name="note[]" placeholder="الملاحظات"> </td>' +
                        '<td>  <button type="button" name="add" class="btn btn-danger btn-flat" onclick="removeDetail(this)"> <i class="fa fa-minus"></i> </button></td>' +
                        '</tr>'
                    )

                }

                function removeDetail(e) {
                    $(e).parent().parent().remove();
                }


                $(".source").last().focus(function (event) {
                    if ($('tr td .employeeSel').last().val()) {
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

                $('body').on('DOMNodeInserted', 'tr', function (event) {
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
                });



                $(".test").click(function (event) {
                    //alert('sadf');
                    /* $('#source').function()
                     {*/
                    if ($('.employeeSel').val()) {
                        event.preventDefault();
                        $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');
                        //alert('dsad');
                        //$('.modal').show();
                    }

                    //}

                });
                $(".ok").click(function () {
                    $('.card-body').removeAttr('data-target', '.modal').attr('data-toggle', 'modal');
                });


            </script>
    @endpush




