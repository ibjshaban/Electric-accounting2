<?php

namespace App\DataTables;

use App\Models\RevenueFule;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

// Auto DataTable By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved [it v 1.6.36]
class RevenueFuleRevenueDataTable extends DataTable
{


    /**
     * dataTable to render Columns.
     * Auto Ajax Method By Baboon Script [it v 1.6.36]
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataTable(DataTables $dataTables, $query)
    {
        return datatables($query)

            ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
            ->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
            ->addColumn('total_price', '{{ $quantity*$price }}')
            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->editColumn('paid_amount', 'admin.revenuefule.revenuefule-revenue.buttons.style')
            ->rawColumns(['checkbox','paid_amount']);
    }


    /**
     * Get the query object to be processed by dataTables.
     * Auto Ajax Method By Baboon Script [it v 1.6.36]
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        return RevenueFule::query()->with(['filling_id', 'stock_id', 'revenue_id', 'city_id',])->where('revenue_id', $this->id)->select("revenue_fules.*");

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
                    ], /*[
                        'text' => '<i class="fa fa-trash"></i> ' . trans('admin.delete'),
                        'className' => 'btn btn-outline deleteBtn',
                    ], [
                        'text' => '<i class="fa fa-plus"></i> ' . trans('admin.add'),
                        'className' => 'btn btn-primary',
                        'action' => 'function(){
                        	window.location.href =  "' . \URL::current() . '/create";
                        }',
                    ],*/
                ],
                'initComplete' => "function () {



            " . filterElement('1,2,1,3,1,4,1,9', 'input') . "

                        //filling_idquantity,price,paid_amount,filling_id,stock_id,revenue_id,city_id,note5
            " . filterElement('5', 'select', \App\Models\Filling::pluck("name", "name")) . "
            //stock_idquantity,price,paid_amount,filling_id,stock_id,revenue_id,city_id,note6
            " . filterElement('6', 'select', \App\Models\Stock::pluck("name", "name")) . "
            //revenue_idquantity,price,paid_amount,filling_id,stock_id,revenue_id,city_id,note7
            //city_idquantity,price,paid_amount,filling_id,stock_id,revenue_id,city_id,note8


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
                'name' => 'stock_id.name',
                'data' => 'stock_id.name',
                'title' => trans('admin.stock_id'),
            ],
            [
                'name' => 'quantity',
                'data' => 'quantity',
                'title' => trans('admin.quantity'),
            ],
            [
                'name' => 'price',
                'data' => 'price',
                'title' => trans('admin.price'),
            ],
            [
                'name' => 'total_price',
                'data' => 'total_price',
                'title' => 'السعر الكلي',
            ],
            [
                'name' => 'paid_amount',
                'data' => 'paid_amount',
                'title' => trans('admin.paid_amount'),
            ],
            [
                'name' => 'filling_id.name',
                'data' => 'filling_id.name',
                'title' => trans('admin.filling_id'),
            ],
            [
                'name' => 'filling_id.filling_date',
                'data' => 'filling_id.filling_date',
                'title' => trans('admin.filling_date'),
            ],
            [
                'name' => 'note',
                'data' => 'note',
                'title' => trans('admin.note'),
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
        return 'revenuefule_' . time();
    }

}
