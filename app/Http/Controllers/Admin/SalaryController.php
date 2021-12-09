<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\SalaryDataTable;
use Carbon\Carbon;
use App\Models\Salary;

use App\Http\Controllers\Validations\SalaryRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class SalaryController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:salary_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:salary_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:salary_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:salary_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(SalaryDataTable $salary)
            {
               return $salary->render('admin.salary.index',['title'=>trans('admin.salary')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.salary.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(SalaryRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
		  		$salary = Salary::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('salary'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$salary =  Salary::find($id);
        		return is_null($salary) || empty($salary)?
        		backWithError(trans("admin.undefinedRecord"),aurl("salary")) :
        		view('admin.salary.show',[
				    'title'=>trans('admin.show'),
					'salary'=>$salary
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$salary =  Salary::find($id);
        		return is_null($salary) || empty($salary)?
        		backWithError(trans("admin.undefinedRecord"),aurl("salary")) :
        		view('admin.salary.edit',[
				  'title'=>trans('admin.edit'),
				  'salary'=>$salary
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
				foreach (array_keys((new SalaryRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(SalaryRequest $request,$id)
            {
              // Check Record Exists
              $salary =  Salary::find($id);
              if(is_null($salary) || empty($salary)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("salary"));
              }
              $data = $this->updateFillableColumns();
              $data['admin_id'] = admin()->id();
              Salary::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('salary'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$salary = Salary::find($id);
		if(is_null($salary) || empty($salary)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("salary"));
		}

		it()->delete('salary',$id);
		$salary->delete();
		return redirectWithSuccess(aurl("salary"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$salary = Salary::find($id);
				if(is_null($salary) || empty($salary)){
					return backWithError(trans('admin.undefinedRecord'),aurl("salary"));
				}

				it()->delete('salary',$id);
				$salary->delete();
			}
			return redirectWithSuccess(aurl("salary"),trans('admin.deleted'));
		}else {
			$salary = Salary::find($data);
			if(is_null($salary) || empty($salary)){
				return backWithError(trans('admin.undefinedRecord'),aurl("salary"));
			}

			it()->delete('salary',$data);
			$salary->delete();
			return redirectWithSuccess(aurl("salary"),trans('admin.deleted'));
		}
	}


}
