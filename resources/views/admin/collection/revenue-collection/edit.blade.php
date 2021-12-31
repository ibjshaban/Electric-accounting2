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
                        <a data-toggle="modal" data-target="#deleteRecord{{$collection->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fa fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
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
            @endpush
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


            {!! Form::open(['url'=>aurl('/revenue-collection/edit/'.$collection->id),'method'=>'put','id'=>'collection','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
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
                    <?php $employees = App\Models\Employee::where('type_id',1)->where('city_id',\App\Models\revenue::whereId(\App\Models\Collection::find(request()->route('id'))->revenue_id)->first()->city_id)->pluck('name','id') ?>
{{--                    @foreach($collection as $item)--}}
                    <tr class="element">
                        <td>
                            {!! Form::select('employee_id',$employees, $collection->employee_id,['class'=>'form-control employeeSel','placeholder'=>trans('admin.choose')]) !!}
                        </td>
                        <td>
                            <input type="text" value="{{ $collection->source }}" class="source" name="source" placeholder="جهة اخرى">
                        </td>
                        <td>
                            <input type="number" class="amount" value="{{ $collection->amount }}" name="amount" step="0.001" min="0"
                                   placeholder="المبلغ" oninput="changeAllPrice(this)" required>
                        </td>
                        <td>
                            <input type="date" name="collection_date" value="{{ $collection->collection_date }}" placeholder="التاريخ" required>
                        </td>
                        <td>
                            <input type="text" name="note" value="{{ $collection->note }}" placeholder="الملاحظات" required>
                        </td>
                        <td>
                            <button type="button" name="add" class="btn btn-danger btn-flat"
                                    onclick="removeDetail(this)">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
{{--                    @endforeach--}}
                    </tbody>
                </table>

                {{--<div class="col p-3">
                    <button type="button" name="add" class="btn btn-success btn-flat" onclick="addNewDetails()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>--}}
                <div class="col">
                    <div class="bg-gradient-info p-3 float-right" id="all_total">المجموع: {{ShekelFormat(00)}}</div>
                </div>


            </div>
            <!-- /.row -->
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" name="save" class="btn btn-primary btn-flat"><i
                    class="fa fa-save"></i> {{ trans('admin.save') }}</button>
            <button type="submit" name="save_back" class="btn btn-success btn-flat"><i
                    class="fa fa-save"></i> {{ trans('admin.save_back') }}</button>
            {!! Form::close() !!}
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
                '<td> {!! Form::select('employee_id[]',$employees, $collection->employee_id,['class'=>'form-control employeeSel','placeholder'=>trans('admin.choose')]) !!} </td>' +
                '<td> <input type="text" class="source" name="source[]" placeholder="جهة اخرى"> </td>' +
                '<td> <input type="number" class="amount" name="amount[]" step="0.001" min="0" placeholder="المبلغ" oninput="changeAllPrice(this)" required> </td>' +
                '<td> <input type="date" name="collection_date[]" placeholder="التاريخ" required> </td>' +
                '<td> <input type="text" name="note[]" placeholder="الملاحظات" required> </td>' +
                '<td>  <button type="button" name="add" class="btn btn-danger btn-flat" onclick="removeDetail(this)"> <i class="fa fa-minus"></i> </button></td>' +
                '</tr>'
            )

        }

        function removeDetail(e) {
            $(e).parent().parent().remove();
        }


        $(".source").focus(function (event) {
            if ($('tr td .employeeSel').last().val()) {
                event.preventDefault();
                $('.card-body').attr('data-target', '.modal').attr('data-toggle', 'modal');

            }
        });

        $(".employeeSel").focus(function (event) {
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
