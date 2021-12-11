<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Filling;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\FillingRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class FillingControllerApi extends Controller{
	protected $selectColumns = [
		"id",
		"quantity",
		"price",
		"supplier_id",
		"filling_date",
		"note",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.36]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return ['supplier_id',];
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$Filling = Filling::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Filling]);
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(FillingRequest $request)
    {
    	$data = $request->except("_token");

        $Filling = Filling::create($data);

		  $Filling = Filling::with($this->arrWith())->find($Filling->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Filling
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
                $Filling = Filling::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Filling) || empty($Filling)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Filling
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * update a newly created resource in storage.
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
            	$Filling = Filling::find($id);
            	if(is_null($Filling) || empty($Filling)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();

              Filling::where("id",$id)->update($data);

              $Filling = Filling::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Filling
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $filling = Filling::find($id);
            	if(is_null($filling) || empty($filling)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("filling",$id);

               $filling->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $filling = Filling::find($id);
	            	if(is_null($filling) || empty($filling)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("filling",$id);
                    	$filling->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $filling = Filling::find($data);
	            	if(is_null($filling) || empty($filling)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("filling",$data);

                    $filling->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }


}
