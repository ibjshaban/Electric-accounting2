<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\RevenueDataTable;
use App\Models\Collection;
use App\Models\Expenses;
use App\Models\OtherOperation;
use App\Models\RevenueFule;
use App\Models\Salary;
use Carbon\Carbon;
use App\Models\revenue;

use App\Http\Controllers\Validations\RevenueRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class RevenueController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:revenue_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:revenue_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:revenue_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:revenue_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(RevenueDataTable $revenue)
            {
               return $revenue->render('admin.revenue.index',['title'=>trans('admin.revenue')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.revenue.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(RevenueRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
		  		$revenue = revenue::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('revenue'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$revenue =  revenue::find($id);
                $total_collection= Collection::where('revenue_id',$revenue->id)->sum('amount');
                $total_fules= RevenueFule::where('revenue_id',$revenue->id)->sum('paid_amount');
                $total_salary= Salary::where('revenue_id',$revenue->id)->sum('total_amount');
                $total_expenses= Expenses::where('revenue_id',$revenue->id)->sum('price');
                $total_other_operation= OtherOperation::where('revenue_id',$revenue->id)->sum('price');
                $total_all= $total_fules+ $total_salary+ $total_expenses+ $total_other_operation;
        		return is_null($revenue) || empty($revenue)?
                    backWithError(trans("admin.undefinedRecord"),aurl("revenue")) :
        		view('admin.revenue.show',[
				    'title'=>trans('admin.show'),
					'revenue'=>$revenue,
					'total_collection'=> $total_collection,
					'total_fules'=> $total_fules,
					'total_salary'=> $total_salary,
					'total_expenses'=> $total_expenses,
					'total_other_operation'=> $total_other_operation,
					'total_all'=> $total_all,
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$revenue =  revenue::find($id);
        		return is_null($revenue) || empty($revenue)?
        		backWithError(trans("admin.undefinedRecord"),aurl("revenue")) :
        		view('admin.revenue.edit',[
				  'title'=>trans('admin.edit'),
				  'revenue'=>$revenue
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
				foreach (array_keys((new RevenueRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(RevenueRequest $request,$id)
            {
              // Check Record Exists
              $revenue =  revenue::find($id);
              if(is_null($revenue) || empty($revenue)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("revenue"));
              }
              $data = $this->updateFillableColumns();
              $data['admin_id'] = admin()->id();
              revenue::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('revenue'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$revenue = revenue::find($id);
		if(is_null($revenue) || empty($revenue)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("revenue"));
		}

		it()->delete('revenue',$id);
		$revenue->delete();
		return redirectWithSuccess(aurl("revenue"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$revenue = revenue::find($id);
				if(is_null($revenue) || empty($revenue)){
					return backWithError(trans('admin.undefinedRecord'),aurl("revenue"));
				}

				it()->delete('revenue',$id);
				$revenue->delete();
			}
			return redirectWithSuccess(aurl("revenue"),trans('admin.deleted'));
		}else {
			$revenue = revenue::find($data);
			if(is_null($revenue) || empty($revenue)){
				return backWithError(trans('admin.undefinedRecord'),aurl("revenue"));
			}

			it()->delete('revenue',$data);
			$revenue->delete();
			return redirectWithSuccess(aurl("revenue"),trans('admin.deleted'));
		}
	}


}
