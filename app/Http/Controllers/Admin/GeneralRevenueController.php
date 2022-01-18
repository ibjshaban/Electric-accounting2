<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\GeneralRevenueDataTable;
use Carbon\Carbon;
use App\Models\GeneralRevenue;

use App\Http\Controllers\Validations\GeneralRevenueRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class GeneralRevenueController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:generalrevenue_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:generalrevenue_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:generalrevenue_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:generalrevenue_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(GeneralRevenueDataTable $generalrevenue)
            {
               return $generalrevenue->render('admin.generalrevenue.index',['title'=>trans('admin.generalrevenue')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.generalrevenue.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(GeneralRevenueRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
		  		$generalrevenue = GeneralRevenue::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('generalrevenue'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$generalrevenue =  GeneralRevenue::find($id);
        		return is_null($generalrevenue) || empty($generalrevenue)?
        		backWithError(trans("admin.undefinedRecord"),aurl("generalrevenue")) :
        		view('admin.generalrevenue.show',[
				    'title'=>trans('admin.show'),
					'generalrevenue'=>$generalrevenue
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$generalrevenue =  GeneralRevenue::find($id);
        		return is_null($generalrevenue) || empty($generalrevenue)?
        		backWithError(trans("admin.undefinedRecord"),aurl("generalrevenue")) :
        		view('admin.generalrevenue.edit',[
				  'title'=>trans('admin.edit'),
				  'generalrevenue'=>$generalrevenue
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
				foreach (array_keys((new GeneralRevenueRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(GeneralRevenueRequest $request,$id)
            {
              // Check Record Exists
              $generalrevenue =  GeneralRevenue::find($id);
              if(is_null($generalrevenue) || empty($generalrevenue)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("generalrevenue"));
              }
              $data = $this->updateFillableColumns();
              $data['admin_id'] = admin()->id();
              GeneralRevenue::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('generalrevenue'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$generalrevenue = GeneralRevenue::find($id);
		if(is_null($generalrevenue) || empty($generalrevenue)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("generalrevenue"));
		}

		it()->delete('generalrevenue',$id);
		$generalrevenue->delete();
		return redirectWithSuccess(aurl("generalrevenue"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$generalrevenue = GeneralRevenue::find($id);
				if(is_null($generalrevenue) || empty($generalrevenue)){
					return backWithError(trans('admin.undefinedRecord'),aurl("generalrevenue"));
				}

				it()->delete('generalrevenue',$id);
				$generalrevenue->delete();
			}
			return redirectWithSuccess(aurl("generalrevenue"),trans('admin.deleted'));
		}else {
			$generalrevenue = GeneralRevenue::find($data);
			if(is_null($generalrevenue) || empty($generalrevenue)){
				return backWithError(trans('admin.undefinedRecord'),aurl("generalrevenue"));
			}

			it()->delete('generalrevenue',$data);
			$generalrevenue->delete();
			return redirectWithSuccess(aurl("generalrevenue"),trans('admin.deleted'));
		}
	}


}
