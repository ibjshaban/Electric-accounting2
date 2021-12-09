<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Debt;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\DebtRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class DebtControllerApi extends Controller{
	protected $selectColumns = [
		"id",
		"amount",
		"note",
		"employee_id",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.36]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return ['employee_id',];
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$Debt = Debt::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Debt]);
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(DebtRequest $request)
    {
    	$data = $request->except("_token");

              $data["user_id"] = auth()->id();
        $Debt = Debt::create($data);

		  $Debt = Debt::with($this->arrWith())->find($Debt->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Debt
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
                $Debt = Debt::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Debt) || empty($Debt)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Debt
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * update a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new DebtRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(DebtRequest $request,$id)
            {
            	$Debt = Debt::find($id);
            	if(is_null($Debt) || empty($Debt)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();

              $data["user_id"] = auth()->id();
              Debt::where("id",$id)->update($data);

              $Debt = Debt::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Debt
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $debt = Debt::find($id);
            	if(is_null($debt) || empty($debt)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("debt",$id);

               $debt->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $debt = Debt::find($id);
	            	if(is_null($debt) || empty($debt)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("debt",$id);
                    	$debt->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $debt = Debt::find($data);
	            	if(is_null($debt) || empty($debt)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("debt",$data);

                    $debt->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }


}
