<?php
namespace App\DataTables;
use App\Models\Salary;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
// Auto DataTable By Baboon Script
// Baboon Maker has been Created And Developed By [it v 1.6.36]
// Copyright Reserved [it v 1.6.36]
class SalaryDataTable extends DataTable
{

    protected $title;
    public function __construct()
    {
        $this->title = trans('admin.salary');

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
            ->addColumn('actions', 'admin.salary.buttons.actions')

   		->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')   		->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')            ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox','actions',]);
    }


     /**
     * Get the query object to be processed by dataTables.
     * Auto Ajax Method By Baboon Script [it v 1.6.36]
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
	public function query()
    {
        return Salary::query()->with(['employee_id','revenue_id',])->select("salaries.*");

    }


    	 /**
	     * Optional method if you want to use html builder.
	     *[it v 1.6.36]
	     * @return \Yajra\Datatables\Html\Builder
	     */
    	public function html()
	    {
	      $html =  $this->builder()
            ->columns($this->getColumns())
            //->ajax('')
            ->parameters([
               'searching'   => true,
               'paging'   => true,
               'bLengthChange'   => true,
               'bInfo'   => true,
               'responsive'   => true,
                'dom' => 'Blfrtip',
                "lengthMenu" => [[10, 25, 50,100, -1], [10, 25, 50,100, trans('admin.all_records')]],
                'buttons' => [
                	[
					  'extend' => 'print',
					  'className' => 'btn btn-outline',
					  'text' => '<i class="fa fa-print"></i> '.trans('admin.print')
					 ],	[
					'extend' => 'excel',
					'className' => 'btn btn-outline',
					'text' => '<i class="fa fa-file-excel"> </i> '.trans('admin.export_excel')
					],	[
					'extend' => 'csv',
					'className' => 'btn btn-outline',
					'text' => '<i class="fa fa-file-excel"> </i> '.trans('admin.export_csv')
					],	[
					 'extend' => 'pdf',
					 'className' => 'btn btn-outline',
					 'text' => '<i class="fa fa-file-pdf"> </i> '.trans('admin.export_pdf')
					],	[
					'extend' => 'reload',
					'className' => 'btn btn-outline',
					'text' => '<i class="fa fa-sync-alt"></i> '.trans('admin.reload')
					],	/*[
						'text' => '<i class="fa fa-trash"></i> '.trans('admin.delete'),
						'className'    => 'btn btn-outline deleteBtn',
                    ],*/
                ],
                'initComplete' => "function () {



            ". filterElement('1,2,3,4,5,6', 'input') . "

                        //employee_idtotal_amount,discount,salary,note,payment_date,employee_id,revenue_id7
            ". filterElement('7', 'select', \App\Models\Employee::pluck("name","name")) . "
            //revenue_idtotal_amount,discount,salary,note,payment_date,employee_id,revenue_id8
            ". filterElement('8', 'select', \App\Models\revenue::pluck("name","name")) . "


	            }",
                'order' => [[1, 'desc']],

                    'language' => [
                       'sProcessing' => trans('admin.sProcessing'),
							'sLengthMenu'        => trans('admin.sLengthMenu'),
							'sZeroRecords'       => trans('admin.sZeroRecords'),
							'sEmptyTable'        => trans('admin.sEmptyTable'),
							'sInfo'              => trans('admin.sInfo'),
							'sInfoEmpty'         => trans('admin.sInfoEmpty'),
							'sInfoFiltered'      => trans('admin.sInfoFiltered'),
							'sInfoPostFix'       => trans('admin.sInfoPostFix'),
							'sSearch'            => trans('admin.sSearch'),
							'sUrl'               => trans('admin.sUrl'),
							'sInfoThousands'     => trans('admin.sInfoThousands'),
							'sLoadingRecords'    => trans('admin.sLoadingRecords'),
							'oPaginate'          => [
								'sFirst'            => trans('admin.sFirst'),
								'sLast'             => trans('admin.sLast'),
								'sNext'             => trans('admin.sNext'),
								'sPrevious'         => trans('admin.sPrevious'),
							],
							'oAria'            => [
								'sSortAscending'  => trans('admin.sSortAscending'),
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
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'printable'      => false,
                'width'          => '10px',
                'aaSorting'      => 'none'
            ],
[
                'name' => 'id',
                'data' => 'DT_Row_Index',
                'title' => trans('admin.record_id'),
                'width'          => '10px',
                'aaSorting'      => 'none'
            ],
				[
                 'name'=>'total_amount',
                 'data'=>'total_amount',
                 'title'=>trans('admin.total_amount'),
		    ],
				[
                 'name'=>'discount',
                 'data'=>'discount',
                 'title'=>trans('admin.discount'),
		    ],
				[
                 'name'=>'salary',
                 'data'=>'salary',
                 'title'=>trans('admin.salary'),
		    ],
                [
                    'name'=>'employee_id.debt',
                    'data'=>'employee_id.debt',
                    'title'=> 'الدين الكلي',
                ],
				[
                 'name'=>'note',
                 'data'=>'note',
                 'title'=>trans('admin.note'),
		    ],
				[
                 'name'=>'payment_date',
                 'data'=>'payment_date',
                 'title'=>trans('admin.payment_date'),
		    ],
				[
                 'name'=>'employee_id.name',
                 'data'=>'employee_id.name',
                 'title'=>trans('admin.employee_id'),
		    ],
				[
                 'name'=>'revenue_id.name',
                 'data'=>'revenue_id.name',
                 'title'=>trans('admin.revenue_id'),
		    ],
            [
	                'name' => 'created_at',
	                'data' => 'created_at',
	                'title' => trans('admin.created_at'),
	                'exportable' => false,
	                'printable'  => false,
	                'searchable' => false,
	                'orderable'  => false,
	            ],
	                    [
	                'name' => 'updated_at',
	                'data' => 'updated_at',
	                'title' => trans('admin.updated_at'),
	                'exportable' => false,
	                'printable'  => false,
	                'searchable' => false,
	                'orderable'  => false,
	            ],
	                    [
	                'name' => 'actions',
	                'data' => 'actions',
	                'title' => trans('admin.actions'),
	                'exportable' => false,
	                'printable'  => false,
	                'searchable' => false,
	                'orderable'  => false,
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
	        return 'salary_' . time();
	    }

}
