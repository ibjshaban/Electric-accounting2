<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\CityDataTable;
use Carbon\Carbon;
use App\Models\City;

use App\Http\Controllers\Validations\CityRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Citys extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:city_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:city_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:city_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:city_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(CityDataTable $city)
            {
               return $city->render('admin.city.index',['title'=>trans('admin.city')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.city.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(CityRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$city = City::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('city'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$city =  City::find($id);
        		return is_null($city) || empty($city)?
        		backWithError(trans("admin.undefinedRecord"),aurl("city")) :
        		view('admin.city.show',[
				    'title'=>trans('admin.show'),
					'city'=>$city
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$city =  City::find($id);
        		return is_null($city) || empty($city)?
        		backWithError(trans("admin.undefinedRecord"),aurl("city")) :
        		view('admin.city.edit',[
				  'title'=>trans('admin.edit'),
				  'city'=>$city
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
				foreach (array_keys((new CityRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(CityRequest $request,$id)
            {
              // Check Record Exists
              $city =  City::find($id);
              if(is_null($city) || empty($city)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("city"));
              }
              $data = $this->updateFillableColumns();
              City::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('city'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$city = City::find($id);
		if(is_null($city) || empty($city)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("city"));
		}

		it()->delete('city',$id);
		$city->delete();
		return redirectWithSuccess(aurl("city"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$city = City::find($id);
				if(is_null($city) || empty($city)){
					return backWithError(trans('admin.undefinedRecord'),aurl("city"));
				}

				it()->delete('city',$id);
				$city->delete();
			}
			return redirectWithSuccess(aurl("city"),trans('admin.deleted'));
		}else {
			$city = City::find($data);
			if(is_null($city) || empty($city)){
				return backWithError(trans('admin.undefinedRecord'),aurl("city"));
			}

			it()->delete('city',$data);
			$city->delete();
			return redirectWithSuccess(aurl("city"),trans('admin.deleted'));
		}
	}


}
