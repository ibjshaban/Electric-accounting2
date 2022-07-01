<?php

namespace App\DataTables;

use App\Models\Supplier;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

// Auto DataTable By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved [it v 1.6.36]
class SupplierDataTable extends DataTable
{
    protected $title;
    public function __construct()
    {
        $this->title = trans('admin.admins');

    }

    /**
     * dataTable to render Columns.
     * Auto Ajax Method By Baboon Script [it v 1.6.36]
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)
        ->addIndexColumn()
            ->addColumn('actions', 'admin.supplier.buttons.actions')
            ->addColumn('name', 'admin.supplier.buttons.style')
            ->addColumn('photo_profile', '{!! view("admin.show_image",["image"=>$photo_profile])->render() !!}')
            ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
            ->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox', 'actions','photo_profile','name']);
    }


    /**
     * Get the query object to be processed by dataTables.
     * Auto Ajax Method By Baboon Script [it v 1.6.36]
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        return Supplier::query()->withTrashed()->select("suppliers.*");

    }


    /**
     * Optional method if you want to use html builder.
     *[it v 1.6.36]
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        $html = $this->builder()
            ->columns($this->getColumns())
            //->ajax('')
            ->parameters([
                'searching' => true,
                'paging' => true,
                'bLengthChange' => true,
                'bInfo' => true,
                'responsive' => true,
                'dom' => 'Blfrtip',
                "lengthMenu" => [[10, 25, 50, 100, -1], [10, 25, 50, 100, trans('admin.all_records')]],
                'buttons' => [
                    [
                        'extend' => 'print',
                        'className' => 'btn btn-outline',
                        'text' => '<i class="fa fa-print"></i> ' . trans('admin.print')
                    ], [
                        'extend' => 'excel',
                        'className' => 'btn btn-outline',
                        'text' => '<i class="fa fa-file-excel"> </i> ' . trans('admin.export_excel')
                    ], [
                        'extend' => 'csv',
                        'className' => 'btn btn-outline',
                        'text' => '<i class="fa fa-file-excel"> </i> ' . trans('admin.export_csv')
                    ], [
                        'extend' => 'pdf',
                        'className' => 'btn btn-outline',
                        'text' => '<i class="fa fa-file-pdf"> </i> ' . trans('admin.export_pdf')
                    ], [
                        'extend' => 'reload',
                        'className' => 'btn btn-outline',
                        'text' => '<i class="fa fa-sync-alt"></i> ' . trans('admin.reload')
                    ], [
                        'text' => '<i class="fa fa-trash"></i> ' . trans('admin.delete'),
                        'className' => 'btn btn-outline deleteBtn',
                    ], [
                        'text' => '<i class="fa fa-plus"></i> ' . trans('admin.add'),
                        'className' => 'btn btn-primary',
                        'action' => 'function(){
                        	window.location.href =  "' . \URL::current() . '/create";
                        }',
                    ],
                ],
                'initComplete' => "function () {



            " . filterElement('1,2,1,3', 'input') . "



	            }",
                'order' => [[1, 'desc']],

                'language' => [
                    'sProcessing' => trans('admin.sProcessing'),
                    'sLengthMenu' => trans('admin.sLengthMenu'),
                    'sZeroRecords' => trans('admin.sZeroRecords'),
                    'sEmptyTable' => trans('admin.sEmptyTable'),
                    'sInfo' => trans('admin.sInfo'),
                    'sInfoEmpty' => trans('admin.sInfoEmpty'),
                    'sInfoFiltered' => trans('admin.sInfoFiltered'),
                    'sInfoPostFix' => trans('admin.sInfoPostFix'),
                    'sSearch' => trans('admin.sSearch'),
                    'sUrl' => trans('admin.sUrl'),
                    'sInfoThousands' => trans('admin.sInfoThousands'),
                    'sLoadingRecords' => trans('admin.sLoadingRecords'),
                    'oPaginate' => [
                        'sFirst' => trans('admin.sFirst'),
                        'sLast' => trans('admin.sLast'),
                        'sNext' => trans('admin.sNext'),
                        'sPrevious' => trans('admin.sPrevious'),
                    ],
                    'oAria' => [
                        'sSortAscending' => trans('admin.sSortAscending'),
                        'sSortDescending' => trans('admin.sSortDescending'),
                    ],
                ]
            ]);

        return $html;

    }


    /**
     * Get columns.
     * Auto getColumns Method By Baboon Script [it v 1.6.36]
     * @return array
     */

    protected function getColumns()
    {
        return [

            [
                'name' => 'checkbox',
                'data' => 'checkbox',
                'title' => '<div  class="icheck-danger">
                  <input type="checkbox" class="select-all" id="select-all"  onclick="select_all()" >
                  <label for="select-all"></label>
                </div>',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'width' => '10px',
                'aaSorting' => 'none'
            ],
            [
                'name' => 'id',
                'data' => 'DT_Row_Index',
                'title' => trans('admin.record_id'),
                'width' => '10px',
                'aaSorting' => 'none'
            ],
            [
                'name' => 'name',
                'data' => 'name',
                'title' => trans('admin.name'),
            ],
            [
                'name' => 'phone',
                'data' => 'phone',
                'title' => trans('admin.phone'),
            ],
            [
                'name' => 'photo_profile',
                'data' => 'photo_profile',
                'title' => trans('admin.photo_profile'),
            ],
            [
                'name' => 'created_at',
                'data' => 'created_at',
                'title' => trans('admin.created_at'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'name' => 'actions',
                'data' => 'actions',
                'title' => trans('admin.actions'),
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
        ];
    }

    /**
     * Get filename for export.
     * Auto filename Method By Baboon Script
     * @return string
     */
    protected function filename()
    {
        return 'supplier_' . time();
    }

}
