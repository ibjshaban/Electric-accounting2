<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\WithdrawalsPayments;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\WithdrawalsPaymentsRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class WithdrawalsPaymentsControllerApi extends Controller{
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
            	$WithdrawalsPayments = WithdrawalsPayments::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$WithdrawalsPayments]);
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(WithdrawalsPaymentsRequest $request)
    {
    	$data = $request->except("_token");

              $data["user_id"] = auth()->id();
        $WithdrawalsPayments = WithdrawalsPayments::create($data);

		  $WithdrawalsPayments = WithdrawalsPayments::with($this->arrWith())->find($WithdrawalsPayments->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$WithdrawalsPayments
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
                $WithdrawalsPayments = WithdrawalsPayments::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($WithdrawalsPayments) || empty($WithdrawalsPayments)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $WithdrawalsPayments
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.36]
             * update a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new WithdrawalsPaymentsRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(WithdrawalsPaymentsRequest $request,$id)
            {
            	$WithdrawalsPayments = WithdrawalsPayments::find($id);
            	if(is_null($WithdrawalsPayments) || empty($WithdrawalsPayments)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();

              $data["user_id"] = auth()->id();
              WithdrawalsPayments::where("id",$id)->update($data);

              $WithdrawalsPayments = WithdrawalsPayments::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $WithdrawalsPayments
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $withdrawalspayments = WithdrawalsPayments::find($id);
            	if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("withdrawalspayments",$id);

               $withdrawalspayments->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $withdrawalspayments = WithdrawalsPayments::find($id);
	            	if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("withdrawalspayments",$id);
                    	$withdrawalspayments->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $withdrawalspayments = WithdrawalsPayments::find($data);
	            	if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("withdrawalspayments",$data);

                    $withdrawalspayments->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }


}
