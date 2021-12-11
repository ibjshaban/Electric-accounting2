<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\RevenueFule;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\RevenueFuleRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class RevenueFuleControllerApi extends Controller{
	protected $selectColumns = [
		"id",
		"quantity",
		"price",
		"paid_amount",
		"filling_id",
		"stock_id",
		"revenue_id",
		"city_id",
		"note",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.36]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return ['filling_id','stock_id','revenue_id','city_id',];
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$RevenueFule = RevenueFule::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$RevenueFule]);
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(RevenueFuleRequest $request)
    {
    	$data = $request->except("_token");

        $RevenueFule = RevenueFule::create($data);

		  $RevenueFule = RevenueFule::with($this->arrWith())->find($RevenueFule->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$RevenueFule
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
                $RevenueFule = RevenueFule::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($RevenueFule) || empty($RevenueFule)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $RevenueFule
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * update a newly created resource in storage.
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
            	$RevenueFule = RevenueFule::find($id);
            	if(is_null($RevenueFule) || empty($RevenueFule)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();

              RevenueFule::where("id",$id)->update($data);

              $RevenueFule = RevenueFule::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $RevenueFule
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $revenuefule = RevenueFule::find($id);
            	if(is_null($revenuefule) || empty($revenuefule)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("revenuefule",$id);

               $revenuefule->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $revenuefule = RevenueFule::find($id);
	            	if(is_null($revenuefule) || empty($revenuefule)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("revenuefule",$id);
                    	$revenuefule->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $revenuefule = RevenueFule::find($data);
	            	if(is_null($revenuefule) || empty($revenuefule)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("revenuefule",$data);

                    $revenuefule->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }


}
