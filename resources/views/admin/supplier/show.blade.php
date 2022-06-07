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
                        <a href="{{aurl('supplier')}}" class="dropdown-item" style="color:#343a40">
                            <i class="fas fa-list"></i> {{trans('admin.show_all')}}</a>
                        <a class="dropdown-item" style="color:#343a40"
                           href="{{aurl('supplier/'.$supplier->id.'/edit')}}">
                            <i class="fas fa-edit"></i> {{trans('admin.edit')}}
                        </a>
                        <a class="dropdown-item" style="color:#343a40" href="{{aurl('supplier/create')}}">
                            <i class="fas fa-plus"></i> {{trans('admin.create')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a data-toggle="modal" data-target="#deleteRecord{{$supplier->id}}" class="dropdown-item"
                           style="color:#343a40" href="#">
                            <i class="fas fa-trash"></i> {{trans('admin.delete')}}
                        </a>
                    </div>
                </div>
            </h3>
            @push('js')
                <div class="modal fade" id="deleteRecord{{$supplier->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                <button class="close" data-dismiss="modal">x</button>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}}
                                ({{$supplier->id}})
                            </div>
                            <div class="modal-footer">
                                {!! Form::open([
                                   'method' => 'DELETE',
                                   'route' => ['supplier.destroy', $supplier->id]
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
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12">
                    <b>{{trans('admin.id')}} :</b> {{$supplier->id}}
                </div>
                <div class="clearfix"></div>
                <hr/>

                @if(!empty($supplier->admin_id()->first()))
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <b>{{trans('admin.admin_id')}} :</b>
                        {{ $supplier->admin_id()->first()->name }}
                    </div>
                @endif

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.name')}} :</b>
                    {!! $supplier->name !!}
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>{{trans('admin.phone')}} :</b>
                    {!! $supplier->phone !!}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <b>الفرق المالي بين الدفعات و التعبئات للمورد :</b>
                    @if($supplier->balance > 0)
                        لك : {{ShekelFormat($supplier->balance)}}
                    @else
                        له : {{ShekelFormat(abs($supplier->balance))}}
                    @endif
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6">
                    <b>{{trans('admin.photo_profile')}} :</b>
                    @include("admin.show_image",["image"=>$supplier->photo_profile])
                </div>
                <div class="col-12"><hr></div>
                <div class="col-12">
                    <b>جدول التعبئات :</b>
                    <p>  مجموع كميات السولار : {{ShekelFormat($filling_quantity)}} </p>
                    <p>  مجموع مبالغ السولار : {{ShekelFormat($filling_amount)}} </p>
                    <p>  مجموع المبالغ المدفوعة : {{ShekelFormat($filling_paid_amount)}} </p>

                    {!! Form::open(["method" => "post","url" => [aurl('/filling/multi_delete')]]) !!}
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">{{!empty($title)?$title:''}}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <form class="form-validate" id="filter_search" action="javascript:void();">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">من تاريخ</label>
                                            <input type="date" class="form-control input-daterange" id="from_date" name="from_date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">الى تاريخ</label>
                                            <input type="date" class="form-control input-daterange" id="to_date" name="to_date">
                                        </div>
                                    </div>


                                </form>
                                <div class="col-md-1">
                                    <button type="button" id="filter"
                                        class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light "
                                        style="margin-top: 2rem; width: 100%;">
                                        بحث
                                    </button>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" id="refresh"
                                        class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1 waves-effect waves-float waves-light "
                                        style="margin-top: 2rem;">
                                        <i class="fa fa-sync-alt"></i> {{ trans('admin.reload') }}
                                    </button>
                                </div>
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
                </div>
                <div class="col-12"><hr></div>
                <div class="col-12">
                    <b>جدول الدفعات :</b>
                    <p>  مجموع الدفعات : {{ShekelFormat($payments_amount)}} </p>
                    <br>
                    <a class="btn btn-info mt-3" href="{{ aurl('payment/create') }}"> إضافة</a>

                    <div class="container mt-5">
                        <table class="table table-bordered mb-5">
                            <thead>
                            <tr class="table-success">
                                <th scope="col">رقم</th>
                                <th scope="col">الكمية</th>
                                <th scope="col">تاريخ الانشاء</th>
                                <th scope="col">العملية</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($payments) > 0)
                            @foreach($payments as $payment)
                                <tr>
                                    <th scope="row">{{ $loop->index+1 }}</th>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td><div class="btn-group">
                                            <button type="button" class="btn btn-success btn-flat dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i> {{ trans('admin.actions') }}</button>
                                            <span class="caret"></span>
                                            <span class="sr-only"></span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                 <a href="{{ aurl('/payment/'.$payment->id)}}" class="dropdown-item" ><i class="fa fa-eye"></i> {{trans('admin.show')}}</a>
                                                <div class="dropdown-divider"></div>
                                                <a data-toggle="modal" data-target="#delete_record{{$payment->id}}" href="#" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> {{trans('admin.delete')}}</a>
                                            </div>
                                        </div>
                                        </td>
                                </tr>
                                <div class="modal fade" id="delete_record{{$payment->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                                                <button class="close" data-dismiss="modal">x</button>
                                            </div>
                                            <div class="modal-body">
                                                <i class="fa fa-exclamation-triangle"></i> {{trans('admin.ask_del')}} {{trans('admin.id')}} ({{$payment->id}})
                                            </div>
                                            <div class="modal-footer">
                                                {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['payment.destroy', $payment->id]
                                                ]) !!}
                                                {!! Form::submit(trans('admin.approval'), ['class' => 'btn btn-danger btn-flat']) !!}
                                                <a class="btn btn-default btn-flat" data-dismiss="modal">{{trans('admin.cancel')}}</a>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>


                <!-- /.row -->
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
    </div>
    @push('js')
        {!! $dataTable->scripts() !!}
        <script>
            $(document).ready(function() {
                $('#filter').click(function() {
                    var from_date = document.getElementById('from_date').value;
                    var to_date = document.getElementById('to_date').value;
                    if (from_date != '' && to_date != '') {
                        $('#dataTableBuilder').DataTable().destroy();
                        $('#dataTableBuilder').DataTable({
                            responsive : true,
                            order: [1, 'desc'],
                            dom: 'Blfrtip',
                            lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, '{{ trans('admin.all_records') }}']],
                            ajax: {
                                url: '{{ route('supplier.show',$supplier->id) }}',
                                data: {
                                    from_date: from_date,
                                    to_date: to_date
                                },
                            }, // JSON file to add data
                            columns: [
                                // columns according to JSON
                                {
                                    name: 'checkbox',
                                    data: 'checkbox',
                                    title: '<div  class="icheck-danger d-inline ml-2">' +
                                        '<input type="checkbox" class="select-all" id="select-all"  onclick="select_all()" >' +
                                        '<label for="select-all"></label>' +
                                        '</div>',
                                    orderable: false,
                                    searchable: false,
                                    exportable: false,
                                    printable: false,
                                    width: '10px',
                                    aaSorting: 'none'
                                },
                                {
                                    name: 'id',
                                    data: 'DT_Row_Index',
                                    title: '#',
                                    width : '10px',
                                    aaSorting : 'none'
                                },
                                {
                                    name: 'quantity',
                                    data: 'quantity',
                                    title: '{{ trans('admin.quantity') }}'
                                },
                                {
                                    name: 'price',
                                    data: 'price',
                                    title: '{{ trans('admin.price') }}'
                                },
                                {
                                    name: 'total_price',
                                    data: 'total_price',
                                    title: 'السعر الكلي'
                                },
                                {
                                    name: 'filling_date',
                                    data: 'filling_date',
                                    title: '{{ trans('admin.filling_date') }}'
                                },
                                {
                                    name: 'note',
                                    data: 'note',
                                    title: '{{ trans('admin.note') }}'
                                },
                                {
                                    name: 'created_at',
                                    data: 'created_at',
                                    title: '{{ trans('admin.created_at') }}',
                                    exportable: false,
                                    printable: false,
                                    searchable: false,
                                    orderable: false
                                },
                                {
                                    name: 'updated_at',
                                    data: 'updated_at',
                                    title: '{{ trans('admin.updated_at') }}',
                                    exportable: false,
                                    printable: false,
                                    searchable: false,
                                    orderable: false
                                },
                                {
                                    name: 'actions',
                                    data: 'actions',
                                    title: '{{ trans('admin.actions') }}',
                                    exportable: false,
                                    printable: false,
                                    searchable: false,
                                    orderable: false
                                }
                            ],
                            language: {
                                sProcessing: '{{ trans('admin.sProcessing') }}',
                                sLengthMenu: '{{ trans('admin.sLengthMenu') }}',
                                sZeroRecords: '{{ trans('admin.sZeroRecords') }}',
                                sEmptyTable: '{{ trans('admin.sEmptyTable') }}',
                                sInfo: '{{ trans('admin.sInfo') }}',
                                sInfoEmpty: '{{ trans('admin.sInfoEmpty') }}',
                                sInfoFiltered: '{{ trans('admin.sInfoFiltered') }}',
                                sInfoPostFix: '{{ trans('admin.sInfoPostFix') }}',
                                sSearch: '{{ trans('admin.sSearch') }}',
                                sUrl: '{{ trans('admin.sUrl') }}',
                                sInfoThousands: '{{ trans('admin.sInfoThousands') }}',
                                sLoadingRecords: '{{ trans('admin.sLoadingRecords') }}',
                                oPaginate: {
                                    sFirst: '{{ trans('admin.sFirst') }}',
                                    sLast: '{{ trans('admin.sLast') }}',
                                    sNext: '{{ trans('admin.sNext') }}',
                                    sPrevious: '{{ trans('admin.sPrevious') }}'
                                },
                                oAria: {
                                    sSortAscending: '{{ trans('admin.sSortAscending') }}',
                                    sSortDescending: '{{ trans('admin.sSortDescending') }}'
                                }
                            },
                            buttons: [
                                        {
                                            extend : 'print',
                                            className : 'btn dark btn-outline',
                                            text : '<i class="fa fa-print"></i>طباعة',
                                            exportOptions: {columns: [1, 2, 3, 4, 5]}
                                        },
                                        {
                                            extend : 'excel',
                                            className : 'btn green btn-outline',
                                            text : '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_excel') }}',
                                            exportOptions: {columns: [ 1, 2, 3, 4, 5]}
                                        },
                                        {
                                            extend : 'pdf',
                                            className : 'btn red btn-outline',
                                            text : '<i class="fa fa-file-pdf"> </i> {{ trans('admin.export_pdf') }}',
                                            exportOptions: {columns: [ 1, 2, 3, 4, 5]}
                                        },
                                        {
                                            extend : 'csv',
                                            className : 'btn purple btn-outline',
                                            text : '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_csv') }}',
                                            exportOptions: {columns: [ 1, 2, 3, 4, 5]}
                                        },
                                        {
                                            text : '<i class="fa fa-trash"></i> {{ trans('admin.delete') }}',
                                            className : 'btn red btn-outline deleteBtn'
                                        },
                                        {
                                            text : '<i class="fa fa-plus"></i> {{ trans('admin.add') }}',
                                            className : 'btn btn-primary',
                                            action : function() {
                                                window.location.href = '{{ \URL::current() }}/create';
                                            }
                                        }
                            ],
                        });
                    } else {
                        alert('Both Date is required');
                    }
                });
                $('#refresh').click(function() {
                    $('#dataTableBuilder').DataTable().destroy();
                    $('#dataTableBuilder').DataTable({
                        responsive : true,
                        order: [1, 'desc'],
                        dom: 'Blfrtip',
                        lengthMenu : [[10, 25, 50, 100, -1], [10, 25, 50, 100, '{{ trans('admin.all_records') }}']],
                        ajax: {
                            url: '{{ route('supplier.show',$supplier->id) }}',
                            data: {
                                reload: 'ture',
                            },
                        }, // JSON file to add data
                        columns: [
                                // columns according to JSON
                                {
                                    name: 'checkbox',
                                    data: 'checkbox',
                                    title: '<div  class="icheck-danger d-inline ml-2">' +
                                        '<input type="checkbox" class="select-all" id="select-all"  onclick="select_all()" >' +
                                        '<label for="select-all"></label>' +
                                        '</div>',
                                    orderable: false,
                                    searchable: false,
                                    exportable: false,
                                    printable: false,
                                    width: '10px',
                                    aaSorting: 'none'
                                },
                                {
                                    name: 'id',
                                    data: 'DT_Row_Index',
                                    title: '#',
                                    width : '10px',
                                    aaSorting : 'none'
                                },
                                {
                                    name: 'quantity',
                                    data: 'quantity',
                                    title: '{{ trans('admin.quantity') }}'
                                },
                                {
                                    name: 'price',
                                    data: 'price',
                                    title: '{{ trans('admin.price') }}'
                                },
                                {
                                    name: 'total_price',
                                    data: 'total_price',
                                    title: 'السعر الكلي'
                                },
                                {
                                    name: 'filling_date',
                                    data: 'filling_date',
                                    title: '{{ trans('admin.filling_date') }}'
                                },
                                {
                                    name: 'note',
                                    data: 'note',
                                    title: '{{ trans('admin.note') }}'
                                },
                                {
                                    name: 'created_at',
                                    data: 'created_at',
                                    title: '{{ trans('admin.created_at') }}',
                                    exportable: false,
                                    printable: false,
                                    searchable: false,
                                    orderable: false
                                },
                                {
                                    name: 'updated_at',
                                    data: 'updated_at',
                                    title: '{{ trans('admin.updated_at') }}',
                                    exportable: false,
                                    printable: false,
                                    searchable: false,
                                    orderable: false
                                },
                                {
                                    name: 'actions',
                                    data: 'actions',
                                    title: '{{ trans('admin.actions') }}',
                                    exportable: false,
                                    printable: false,
                                    searchable: false,
                                    orderable: false
                                }
                            ],
                        language: {
                            sProcessing: '{{ trans('admin.sProcessing') }}',
                            sLengthMenu: '{{ trans('admin.sLengthMenu') }}',
                            sZeroRecords: '{{ trans('admin.sZeroRecords') }}',
                            sEmptyTable: '{{ trans('admin.sEmptyTable') }}',
                            sInfo: '{{ trans('admin.sInfo') }}',
                            sInfoEmpty: '{{ trans('admin.sInfoEmpty') }}',
                            sInfoFiltered: '{{ trans('admin.sInfoFiltered') }}',
                            sInfoPostFix: '{{ trans('admin.sInfoPostFix') }}',
                            sSearch: '{{ trans('admin.sSearch') }}',
                            sUrl: '{{ trans('admin.sUrl') }}',
                            sInfoThousands: '{{ trans('admin.sInfoThousands') }}',
                            sLoadingRecords: '{{ trans('admin.sLoadingRecords') }}',
                            oPaginate: {
                                sFirst: '{{ trans('admin.sFirst') }}',
                                sLast: '{{ trans('admin.sLast') }}',
                                sNext: '{{ trans('admin.sNext') }}',
                                sPrevious: '{{ trans('admin.sPrevious') }}'
                            },
                            oAria: {
                                sSortAscending: '{{ trans('admin.sSortAscending') }}',
                                sSortDescending: '{{ trans('admin.sSortDescending') }}'
                            }
                        },
                        buttons: [
                                    {
                                        extend : 'print',
                                        className : 'btn dark btn-outline',
                                        text : '<i class="fa fa-print"></i>طباعة',
                                        exportOptions: {columns: [1, 2, 3, 4, 5]}
                                    },
                                    {
                                        extend : 'excel',
                                        className : 'btn green btn-outline',
                                        text : '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_excel') }}',
                                        exportOptions: {columns: [ 1, 2, 3, 4, 5]}
                                    },
                                    {
                                        extend : 'pdf',
                                        className : 'btn red btn-outline',
                                        text : '<i class="fa fa-file-pdf"> </i> {{ trans('admin.export_pdf') }}',
                                        exportOptions: {columns: [ 1, 2, 3, 4, 5]}
                                    },
                                    {
                                        extend : 'csv',
                                        className : 'btn purple btn-outline',
                                        text : '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_csv') }}',
                                        exportOptions: {columns: [ 1, 2, 3, 4, 5]}
                                    },
                                    {
                                        extend : 'reload',
                                        className : 'btn blue btn-outline',
                                        text : '<i class="fa fa-sync-alt"></i> {{ trans('admin.reload') }}'
                                    },
                                    {
                                        text : '<i class="fa fa-trash"></i> {{ trans('admin.delete') }}',
                                        className : 'btn red btn-outline deleteBtn'
                                    },
                                    {
                                        text : '<i class="fa fa-plus"></i> {{ trans('admin.add') }}',
                                        className : 'btn btn-primary',
                                        action : function() {
                                            window.location.href = '{{ \URL::current() }}/create';
                                        }
                                    }
                        ],
                    });
                });
            });
        </script>
    @endpush
@endsection
