<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\EmployeeTypeDataTable;
use Carbon\Carbon;
use App\Models\EmployeeType;

use App\Http\Controllers\Validations\EmployeeTypeRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class EmployeeTypeController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:employeetype_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:employeetype_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:employeetype_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:employeetype_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(EmployeeTypeDataTable $employeetype)
            {
               return $employeetype->render('admin.employeetype.index',['title'=>trans('admin.employeetype')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.employeetype.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(EmployeeTypeRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$employeetype = EmployeeType::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('employeetype'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$employeetype =  EmployeeType::find($id);
        		return is_null($employeetype) || empty($employeetype)?
        		backWithError(trans("admin.undefinedRecord"),aurl("employeetype")) :
        		view('admin.employeetype.show',[
				    'title'=>trans('admin.show'),
					'employeetype'=>$employeetype
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$employeetype =  EmployeeType::find($id);
        		return is_null($employeetype) || empty($employeetype)?
        		backWithError(trans("admin.undefinedRecord"),aurl("employeetype")) :
        		view('admin.employeetype.edit',[
				  'title'=>trans('admin.edit'),
				  'employeetype'=>$employeetype
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
				foreach (array_keys((new EmployeeTypeRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(EmployeeTypeRequest $request,$id)
            {
              // Check Record Exists
              $employeetype =  EmployeeType::find($id);
              if(is_null($employeetype) || empty($employeetype)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("employeetype"));
              }
              $data = $this->updateFillableColumns();
              EmployeeType::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('employeetype'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$employeetype = EmployeeType::find($id);
		if(is_null($employeetype) || empty($employeetype)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("employeetype"));
		}

		it()->delete('employeetype',$id);
		$employeetype->delete();
		return redirectWithSuccess(aurl("employeetype"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$employeetype = EmployeeType::find($id);
				if(is_null($employeetype) || empty($employeetype)){
					return backWithError(trans('admin.undefinedRecord'),aurl("employeetype"));
				}

				it()->delete('employeetype',$id);
				$employeetype->delete();
			}
			return redirectWithSuccess(aurl("employeetype"),trans('admin.deleted'));
		}else {
			$employeetype = EmployeeType::find($data);
			if(is_null($employeetype) || empty($employeetype)){
				return backWithError(trans('admin.undefinedRecord'),aurl("employeetype"));
			}

			it()->delete('employeetype',$data);
			$employeetype->delete();
			return redirectWithSuccess(aurl("employeetype"),trans('admin.deleted'));
		}
	}


}
