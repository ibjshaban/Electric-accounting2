<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\RevenueCollectionDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\CollectionDataTable;
use App\Models\revenue;
use Carbon\Carbon;
use App\Models\Collection;

use App\Http\Controllers\Validations\CollectionRequest;
use Illuminate\Http\Request;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CollectionController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:collection_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:collection_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:collection_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:collection_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(CollectionDataTable $collection)
            {
               return $collection->render('admin.collection.index',['title'=>trans('admin.collection')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.collection.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(CollectionRequest $request)
            {
                $data = $request->except("_token", "_method");
                if ($data['collect_type'] == '0'){
                    $data['source']= null;
                }
                else{
                    $data['employee_id']= null;
                }
                unset($data['collect_type']);
            			  		$collection = Collection::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('collection'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$collection =  Collection::find($id);
        		return is_null($collection) || empty($collection)?
        		backWithError(trans("admin.undefinedRecord"),aurl("collection")) :
        		view('admin.collection.show',[
				    'title'=>trans('admin.show'),
					'collection'=>$collection
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$collection =  Collection::find($id);
        		return is_null($collection) || empty($collection)?
        		backWithError(trans("admin.undefinedRecord"),aurl("collection")) :
        		view('admin.collection.edit',[
				  'title'=>trans('admin.edit'),
				  'collection'=>$collection
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
				foreach (array_keys((new CollectionRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(CollectionRequest $request,$id)
            {
              // Check Record Exists
              $collection =  Collection::find($id);
              if(is_null($collection) || empty($collection)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("collection"));
              }
              $data = $this->updateFillableColumns();
              if ($data['collect_type'] == '0'){
                  $data['source']= null;
              }
              else{
                  $data['employee_id']= null;
              }
              unset($data['collect_type']);
              Collection::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('collection'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$collection = Collection::find($id);
		if(is_null($collection) || empty($collection)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("revenue-collection/".$collection->revenue_id));
		}

		it()->delete('collection',$id);
		$collection->delete();
		return redirectWithSuccess(aurl("revenue-collection/".$collection->revenue_id),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$collection = Collection::find($id);
				if(is_null($collection) || empty($collection)){
					return backWithError(trans('admin.undefinedRecord'),aurl("revenue-collection/".$collection->revenue_id));
				}

				it()->delete('collection',$id);
				$collection->delete();
			}
			return redirectWithSuccess(aurl("revenue-collection/".$collection->revenue_id),trans('admin.deleted'));
		}else {
			$collection = Collection::find($data);
			if(is_null($collection) || empty($collection)){
				return backWithError(trans('admin.undefinedRecord'),aurl("revenue-collection/".$collection->revenue_id));
			}

			it()->delete('collection',$data);
			$collection->delete();
			return redirectWithSuccess(aurl("revenue-collection/".$collection->revenue_id),trans('admin.deleted'));
		}
	}

	//***********
    //Show expenses for one revenue
    public function revenueCollection(RevenueCollectionDataTable $collection, $id)
    {
        return $collection->with('id', $id)->render('admin.collection.index', ['title' => trans('admin.collection')]);
    }

    public function revenueCollectionCreate($id)
    {
        $collection = revenue::find($id);
        return view('admin.collection.revenue-collection.create', ['title' => trans('admin.create'),'collection' => $collection]);
    }

    //Create collection by one revenue
    public function revenueCollectionStore(CollectionRequest $request, $id){
        $data = $request->except("_token", "_method");
        $data['revenue_id'] = $id;
        if ($data['collect_type'] == '0'){
            $data['source']= null;
        }
        else{
            $data['employee_id']= null;
        }
        unset($data['collect_type']);
        $collection = Collection::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('revenue-collection/'.$id. $redirect), trans('admin.added'));
    }

    public function revenueCollectionEdit($id)
    {
        $collection = Collection::find($id);
        return view('admin.collection.revenue-collection.edit', ['title' => trans('admin.edit'),'collection' => $collection]);
    }

    //Edit collection by one revenue
    public function revenueCollectionUpdate(CollectionRequest $request, $id){
        // Check Record Exists
        $collection = Collection::find($id);
        $revenu_id=$collection->revenue_id;
        if (is_null($collection) || empty($collection)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenue-collection"));
        }

        $data = $request->except("_token", "_method", "save");
        if ($data['collect_type'] == '0'){
            $data['source']= null;
        }
        else{
            $data['employee_id']= null;
        }
        unset($data['collect_type']);
        Collection::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $collection->revenue_id . "/edit" : "";
        return redirectWithSuccess(aurl('revenue-collection/'.$collection->revenue_id. $redirect), trans('admin.updated'));
    }


}
