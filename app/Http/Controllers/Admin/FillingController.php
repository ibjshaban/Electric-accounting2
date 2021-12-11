<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\FillingDataTable;
use Carbon\Carbon;
use App\Models\Filling;

use App\Http\Controllers\Validations\FillingRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class FillingController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:filling_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:filling_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:filling_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:filling_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(FillingDataTable $filling)
            {
               return $filling->render('admin.filling.index',['title'=>trans('admin.filling')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.filling.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(FillingRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$filling = Filling::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('filling'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$filling =  Filling::find($id);
        		return is_null($filling) || empty($filling)?
        		backWithError(trans("admin.undefinedRecord"),aurl("filling")) :
        		view('admin.filling.show',[
				    'title'=>trans('admin.show'),
					'filling'=>$filling
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$filling =  Filling::find($id);
        		return is_null($filling) || empty($filling)?
        		backWithError(trans("admin.undefinedRecord"),aurl("filling")) :
        		view('admin.filling.edit',[
				  'title'=>trans('admin.edit'),
				  'filling'=>$filling
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
				foreach (array_keys((new FillingRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(FillingRequest $request,$id)
            {
              // Check Record Exists
              $filling =  Filling::find($id);
              if(is_null($filling) || empty($filling)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("filling"));
              }
              $data = $this->updateFillableColumns();
              Filling::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('filling'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$filling = Filling::find($id);
		if(is_null($filling) || empty($filling)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("filling"));
		}

		it()->delete('filling',$id);
		$filling->delete();
		return redirectWithSuccess(aurl("filling"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$filling = Filling::find($id);
				if(is_null($filling) || empty($filling)){
					return backWithError(trans('admin.undefinedRecord'),aurl("filling"));
				}

				it()->delete('filling',$id);
				$filling->delete();
			}
			return redirectWithSuccess(aurl("filling"),trans('admin.deleted'));
		}else {
			$filling = Filling::find($data);
			if(is_null($filling) || empty($filling)){
				return backWithError(trans('admin.undefinedRecord'),aurl("filling"));
			}

			it()->delete('filling',$data);
			$filling->delete();
			return redirectWithSuccess(aurl("filling"),trans('admin.deleted'));
		}
	}


}
