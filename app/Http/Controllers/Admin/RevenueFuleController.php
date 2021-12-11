<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\RevenueFuleRevenueDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\RevenueFuleDataTable;
use Carbon\Carbon;
use App\Models\RevenueFule;

use App\Http\Controllers\Validations\RevenueFuleRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class RevenueFuleController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:revenuefule_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:revenuefule_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:revenuefule_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:revenuefule_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(RevenueFuleDataTable $revenuefule)
            {
               return $revenuefule->render('admin.revenuefule.index',['title'=>trans('admin.revenuefule')]);
            }
            public function revenueFuleRevenue(RevenueFuleRevenueDataTable $revenuefule, $id)
            {
               return $revenuefule->with('id', $id)->render('admin.revenuefule.index',['title'=>trans('admin.revenuefule')]);
            }
            public function revenueFuleRevenueCreate(){
                return view('admin.revenuefule.sec-create',['title'=>trans('admin.create')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.revenuefule.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(RevenueFuleRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$revenuefule = RevenueFule::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('revenuefule'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$revenuefule =  RevenueFule::find($id);
        		return is_null($revenuefule) || empty($revenuefule)?
        		backWithError(trans("admin.undefinedRecord"),aurl("revenuefule")) :
        		view('admin.revenuefule.show',[
				    'title'=>trans('admin.show'),
					'revenuefule'=>$revenuefule
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$revenuefule =  RevenueFule::find($id);
        		return is_null($revenuefule) || empty($revenuefule)?
        		backWithError(trans("admin.undefinedRecord"),aurl("revenuefule")) :
        		view('admin.revenuefule.edit',[
				  'title'=>trans('admin.edit'),
				  'revenuefule'=>$revenuefule
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
				foreach (array_keys((new RevenueFuleRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(RevenueFuleRequest $request,$id)
            {
              // Check Record Exists
              $revenuefule =  RevenueFule::find($id);
              if(is_null($revenuefule) || empty($revenuefule)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("revenuefule"));
              }
              $data = $this->updateFillableColumns();
              RevenueFule::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('revenuefule'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$revenuefule = RevenueFule::find($id);
		if(is_null($revenuefule) || empty($revenuefule)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("revenuefule"));
		}

		it()->delete('revenuefule',$id);
		$revenuefule->delete();
		return redirectWithSuccess(aurl("revenuefule"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$revenuefule = RevenueFule::find($id);
				if(is_null($revenuefule) || empty($revenuefule)){
					return backWithError(trans('admin.undefinedRecord'),aurl("revenuefule"));
				}

				it()->delete('revenuefule',$id);
				$revenuefule->delete();
			}
			return redirectWithSuccess(aurl("revenuefule"),trans('admin.deleted'));
		}else {
			$revenuefule = RevenueFule::find($data);
			if(is_null($revenuefule) || empty($revenuefule)){
				return backWithError(trans('admin.undefinedRecord'),aurl("revenuefule"));
			}

			it()->delete('revenuefule',$data);
			$revenuefule->delete();
			return redirectWithSuccess(aurl("revenuefule"),trans('admin.deleted'));
		}
	}


}
