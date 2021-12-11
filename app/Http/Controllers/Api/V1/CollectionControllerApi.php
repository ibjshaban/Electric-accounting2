<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Collection;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\CollectionRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CollectionControllerApi extends Controller{
	protected $selectColumns = [
		"id",
		"employee_id",
		"revenue_id",
		"amount",
		"collection_date",
		"source",
		"note",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.36]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return ['employee_id','revenue_id',];
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$Collection = Collection::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Collection]);
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(CollectionRequest $request)
    {
    	$data = $request->except("_token");

        $Collection = Collection::create($data);

		  $Collection = Collection::with($this->arrWith())->find($Collection->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Collection
        ]);
    }


            /**
             * Display the specified resource.
             * Baboon Api Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
                $Collection = Collection::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Collection) || empty($Collection)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Collection
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * update a newly created resource in storage.
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
            	$Collection = Collection::find($id);
            	if(is_null($Collection) || empty($Collection)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();

              Collection::where("id",$id)->update($data);

              $Collection = Collection::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Collection
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $collection = Collection::find($id);
            	if(is_null($collection) || empty($collection)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("collection",$id);

               $collection->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $collection = Collection::find($id);
	            	if(is_null($collection) || empty($collection)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("collection",$id);
                    	$collection->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $collection = Collection::find($data);
	            	if(is_null($collection) || empty($collection)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("collection",$data);

                    $collection->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }


}
