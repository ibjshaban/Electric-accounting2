<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\SubItemsDataTable;
use Carbon\Carbon;
use App\Models\SubItem;

use App\Http\Controllers\Validations\SubItemsRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class SubItems extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:subitems_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:subitems_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:subitems_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:subitems_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.37]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(SubItemsDataTable $subitems)
            {
               return $subitems->render('admin.subitems.index',['title'=>trans('admin.subitems')]);
            }


            /**
             * Baboon Script By [it v 1.6.37]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.subitems.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.37]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(SubItemsRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$subitems = SubItem::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('subitems'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.37]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$subitems =  SubItem::find($id);
        		return is_null($subitems) || empty($subitems)?
        		backWithError(trans("admin.undefinedRecord"),aurl("subitems")) :
        		view('admin.subitems.show',[
				    'title'=>trans('admin.show'),
					'subitems'=>$subitems
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.37]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$subitems =  SubItem::find($id);
        		return is_null($subitems) || empty($subitems)?
        		backWithError(trans("admin.undefinedRecord"),aurl("subitems")) :
        		view('admin.subitems.edit',[
				  'title'=>trans('admin.edit'),
				  'subitems'=>$subitems
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.37]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new SubItemsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(SubItemsRequest $request,$id)
            {
              // Check Record Exists
              $subitems =  SubItem::find($id);
              if(is_null($subitems) || empty($subitems)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("subitems"));
              }
              $data = $this->updateFillableColumns(); 
              SubItem::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('subitems'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.37]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$subitems = SubItem::find($id);
		if(is_null($subitems) || empty($subitems)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("subitems"));
		}
               
		it()->delete('subitem',$id);
		$subitems->delete();
		return redirectWithSuccess(aurl("subitems"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$subitems = SubItem::find($id);
				if(is_null($subitems) || empty($subitems)){
					return backWithError(trans('admin.undefinedRecord'),aurl("subitems"));
				}
                    	
				it()->delete('subitem',$id);
				$subitems->delete();
			}
			return redirectWithSuccess(aurl("subitems"),trans('admin.deleted'));
		}else {
			$subitems = SubItem::find($data);
			if(is_null($subitems) || empty($subitems)){
				return backWithError(trans('admin.undefinedRecord'),aurl("subitems"));
			}
                    
			it()->delete('subitem',$data);
			$subitems->delete();
			return redirectWithSuccess(aurl("subitems"),trans('admin.deleted'));
		}
	}
            

}