<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\DebtDataTable;
use Carbon\Carbon;
use App\Models\Debt;

use App\Http\Controllers\Validations\DebtRequest;
use App\Models\Employee;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class DebtController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:debt_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:debt_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:debt_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:debt_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(DebtDataTable $debt, HttpRequest $request)
            {
                if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
                    if ($request->from_date != null && $request->to_date != null) {
                        $debts = Debt::whereBetween('created_at', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
                    } else {
                        $debts = Debt::get();
                    }
                    return datatables($debts)
                    ->addIndexColumn()
                    ->addColumn('actions', 'admin.debt.buttons.actions')
                    ->addColumn('employee_name',function(Debt $debt){
                        return Employee::where('id',$debt->employee_id)->first()->name ?? '';
                    })
                    ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')->addColumn('checkbox', '<div  class="icheck-danger">
                          <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                          <label for="selectdata{{ $id }}"></label>
                        </div>')
                    ->rawColumns(['checkbox', 'actions',])
                        ->make(true);
                }
               return $debt->render('admin.debt.index',['title'=>trans('admin.debt')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.debt.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(DebtRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
            	$data['remainder'] = $request->amount;
		  		$debt = Debt::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('debt'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$debt =  Debt::find($id);
        		return is_null($debt) || empty($debt)?
        		backWithError(trans("admin.undefinedRecord"),aurl("debt")) :
        		view('admin.debt.show',[
				    'title'=>trans('admin.show'),
					'debt'=>$debt
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$debt =  Debt::find($id);
        		return is_null($debt) || empty($debt)?
        		backWithError(trans("admin.undefinedRecord"),aurl("debt")) :
        		view('admin.debt.edit',[
				  'title'=>trans('admin.edit'),
				  'debt'=>$debt
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new DebtRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(DebtRequest $request,$id)
            {
              // Check Record Exists
              $debt =  Debt::find($id);

              $remainder= $debt->remainder;
              if ($request->amount != $debt->amount){
                  $discount_amount= $debt->amount - $debt->remainder;
                  if ($discount_amount == 0){
                      $remainder = $request->amount;
                  }
                  else{
                      $remainder= $request->amount - $discount_amount ;
                  }
              }

              if(is_null($debt) || empty($debt)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("debt"));
              }
              $data = $this->updateFillableColumns();
              $data['remainder'] = $remainder;
              $data['admin_id'] = admin()->id();
              Debt::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('debt'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$debt = Debt::find($id);
		if(is_null($debt) || empty($debt)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("debt"));
		}

		it()->delete('debt',$id);
		$debt->delete();
		return redirectWithSuccess(aurl("debt"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$debt = Debt::find($id);
				if(is_null($debt) || empty($debt)){
					return backWithError(trans('admin.undefinedRecord'),aurl("debt"));
				}

				it()->delete('debt',$id);
				$debt->delete();
			}
			return redirectWithSuccess(aurl("debt"),trans('admin.deleted'));
		}else {
			$debt = Debt::find($data);
			if(is_null($debt) || empty($debt)){
				return backWithError(trans('admin.undefinedRecord'),aurl("debt"));
			}

			it()->delete('debt',$data);
			$debt->delete();
			return redirectWithSuccess(aurl("debt"),trans('admin.deleted'));
		}
	}


    public function dtPrint(HttpRequest $request)
    {
        $data = [];
        if ($request->query('reload') == null) {
            $debts = Debt::where('created_at', '>=', $request->query('from_date'))->where('created_at', '<=', Carbon::parse($request->query('to_date'))->addDay(1))->get();
        } else {
            $debts = Debt::all();
        }

        $i = 1;
        $total = 0;
        foreach($debts as $debt){
            $data[] = [
                'الرقم' => $i,
                'الموظف' => Employee::where('id',$debt->employee_id)->first()->name ?? 'لا يوجد',
                'الكمية' => $debt->amount,
                'الباقي' => $debt->remainder,
                'ملاحظات' => $debt->note,
                'تاريخ الانشاء' => Carbon::parse($debt->created_at)->format('Y-m-d'),
               ];
            $i++;
            $total += $debt->amount;
        }

        return view('vendor.datatables.print',[
            'data' => $data,
            'title' => trans('admin.debt'),
            'totalPrice' => $total,
            'total_name' => 'مجموع الكمية',
        ]);
    }

}
