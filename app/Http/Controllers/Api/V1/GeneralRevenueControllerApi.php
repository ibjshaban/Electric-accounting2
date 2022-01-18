<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GeneralRevenue;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\GeneralRevenueRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class GeneralRevenueControllerApi extends Controller{
	protected $selectColumns = [
		"id",
		"name",
		"price",
		"date",
		"note",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.36]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return [];
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$GeneralRevenue = GeneralRevenue::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$GeneralRevenue]);
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(GeneralRevenueRequest $request)
    {
    	$data = $request->except("_token");

              $data["user_id"] = auth()->id();
        $GeneralRevenue = GeneralRevenue::create($data);

		  $GeneralRevenue = GeneralRevenue::with($this->arrWith())->find($GeneralRevenue->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$GeneralRevenue
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
                $GeneralRevenue = GeneralRevenue::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($GeneralRevenue) || empty($GeneralRevenue)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $GeneralRevenue
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * update a newly created resource in storage.
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
            	$GeneralRevenue = GeneralRevenue::find($id);
            	if(is_null($GeneralRevenue) || empty($GeneralRevenue)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();

              $data["user_id"] = auth()->id();
              GeneralRevenue::where("id",$id)->update($data);

              $GeneralRevenue = GeneralRevenue::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $GeneralRevenue
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $generalrevenue = GeneralRevenue::find($id);
            	if(is_null($generalrevenue) || empty($generalrevenue)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("generalrevenue",$id);

               $generalrevenue->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $generalrevenue = GeneralRevenue::find($id);
	            	if(is_null($generalrevenue) || empty($generalrevenue)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("generalrevenue",$id);
                    	$generalrevenue->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $generalrevenue = GeneralRevenue::find($data);
	            	if(is_null($generalrevenue) || empty($generalrevenue)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("generalrevenue",$data);

                    $generalrevenue->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }


}
