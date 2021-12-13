<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\EmployeeDataTable;
use Carbon\Carbon;
use App\Models\Employee;

use App\Http\Controllers\Validations\EmployeeRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class EmployeeController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:employee_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:employee_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:employee_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:employee_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(EmployeeDataTable $employee)
            {
               return $employee->render('admin.employee.index',['title'=>trans('admin.employee')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.employee.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(EmployeeRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$employee = Employee::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('employee'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$employee =  Employee::find($id);
        		return is_null($employee) || empty($employee)?
        		backWithError(trans("admin.undefinedRecord"),aurl("employee")) :
        		view('admin.employee.show',[
				    'title'=>trans('admin.show'),
					'employee'=>$employee
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$employee =  Employee::find($id);
        		return is_null($employee) || empty($employee)?
        		backWithError(trans("admin.undefinedRecord"),aurl("employee")) :
        		view('admin.employee.edit',[
				  'title'=>trans('admin.edit'),
				  'employee'=>$employee
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
				foreach (array_keys((new EmployeeRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(EmployeeRequest $request,$id)
            {
              // Check Record Exists
              $employee =  Employee::find($id);
              if(is_null($employee) || empty($employee)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("employee"));
              }
              $data = $this->updateFillableColumns();
              Employee::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('employee'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$employee = Employee::find($id);
		if(is_null($employee) || empty($employee)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("employee"));
		}

		it()->delete('employee',$id);
		$employee->delete();
		return redirectWithSuccess(aurl("employee"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$employee = Employee::find($id);
				if(is_null($employee) || empty($employee)){
					return backWithError(trans('admin.undefinedRecord'),aurl("employee"));
				}

				it()->delete('employee',$id);
				$employee->delete();
			}
			return redirectWithSuccess(aurl("employee"),trans('admin.deleted'));
		}else {
			$employee = Employee::find($data);
			if(is_null($employee) || empty($employee)){
				return backWithError(trans('admin.undefinedRecord'),aurl("employee"));
			}

			it()->delete('employee',$data);
			$employee->delete();
			return redirectWithSuccess(aurl("employee"),trans('admin.deleted'));
		}
	}

	public function movementShow(){
	    return view('admin.employee.movement-show');
    }


}
