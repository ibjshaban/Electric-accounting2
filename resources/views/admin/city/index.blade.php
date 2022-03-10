@extends('admin.index')
@section('content')
{!! Form::open(["method" => "post","url" => [aurl('/city/multi_delete')]]) !!}
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

<script>
    $(document).ready(function() {
        $('#filter').click(function() {
            var from_date = document.getElementById('from_date').value;
            var to_date = document.getElementById('to_date').value;
            if (from_date != '' && to_date != '') {
                $('#dataTableBuilder').DataTable().destroy();
                $('#dataTableBuilder').DataTable({
                    responsive: true,
                    order: [1, 'desc'],
                    dom: 'Blfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, '{{ trans('admin.all_records') }}']
                    ],
                    ajax: {
                        url: '{{ route('city.index') }}',
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
                            name: 'name',
                            data: 'name',
                            title: '{{ trans('admin.name') }}'
                        },
                        {
                            name: 'created_at',
                            data: 'created_at',
                            title: '{{ trans('admin.created_at') }}',
                            exportable: true,
                            printable: true,
                            searchable: true,
                            orderable: true
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
                    buttons: [{
                            extend: 'print',
                            className: 'btn dark btn-outline',
                            text: '<i class="fa fa-print"></i>طباعة',
                            exportOptions: {
                                columns: [1, 2, 3]
                            },
                            action: function() {
                                    window.location.href =
                                        '/admin/print/cities?from_date='+from_date+'&to_date='+to_date;
                                    }
                        },
                        {
                            extend: 'excel',
                            className: 'btn green btn-outline',
                            text: '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_excel') }}',
                            exportOptions: {
                                columns: [1, 2, 3]
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'btn red btn-outline',
                            text: '<i class="fa fa-file-pdf"> </i> {{ trans('admin.export_pdf') }}',
                            exportOptions: {
                                columns: [1, 2, 3]
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'btn purple btn-outline',
                            text: '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_csv') }}',
                            exportOptions: {
                                columns: [1, 2, 3]
                            }
                        },
                        {
                                extend : 'reload',
                                className : 'btn blue btn-outline',
                                text : '<i class="fa fa-sync-alt"></i> {{ trans('admin.reload') }}'
                            },
                        {
                            text: '<i class="fa fa-trash"></i> {{ trans('admin.delete') }}',
                            className: 'btn red btn-outline deleteBtn'
                        },
                        {
                            text: '<i class="fa fa-plus"></i> {{ trans('admin.add') }}',
                            className: 'btn btn-primary',
                            action: function() {
                                window.location.href =
                                    '{{ \URL::current() }}/create';
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
                responsive: true,
                order: [1, 'desc'],
                dom: 'Blfrtip',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, '{{ trans('admin.all_records') }}']
                ],
                ajax: {
                    url: '{{ route('city.index') }}',
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
                            name: 'name',
                            data: 'name',
                            title: '{{ trans('admin.name') }}'
                        },
                        {
                            name: 'created_at',
                            data: 'created_at',
                            title: '{{ trans('admin.created_at') }}',
                            exportable: true,
                            printable: true,
                            searchable: true,
                            orderable: true
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
                buttons: [{
                        extend: 'print',
                        className: 'btn dark btn-outline',
                        text: '<i class="fa fa-print"></i>طباعة',
                        exportOptions: {
                            columns: [1, 2, 3]
                        },
                        action: function() {
                            window.location.href = '{{ \URL::current() }}?action=print';
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn green btn-outline',
                        text: '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_excel') }}',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn red btn-outline',
                        text: '<i class="fa fa-file-pdf"> </i> {{ trans('admin.export_pdf') }}',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn purple btn-outline',
                        text: '<i class="fa fa-file-excel"> </i> {{ trans('admin.export_csv') }}',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        extend: 'reload',
                        className: 'btn blue btn-outline',
                        text: '<i class="fa fa-sync-alt"></i> {{ trans('admin.reload') }}'
                    },
                    {
                        text: '<i class="fa fa-trash"></i> {{ trans('admin.delete') }}',
                        className: 'btn red btn-outline deleteBtn'
                    },
                    {
                        text: '<i class="fa fa-plus"></i> {{ trans('admin.add') }}',
                        className: 'btn btn-primary',
                        action: function() {
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
