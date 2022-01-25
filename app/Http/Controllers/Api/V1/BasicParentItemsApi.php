<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BasicParentItem;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\BasicParentItemsRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class BasicParentItemsApi extends Controller{
	protected $selectColumns = [
		"id",
		"name",
		"price",
		"discount",
		"date",
		"amount",
		"note",
		"basic_id",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.37]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return [];
            }


            /**
             * Baboon Api Script By [it v 1.6.37]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$BasicParentItem = BasicParentItem::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$BasicParentItem]);
            }


            /**
             * Baboon Api Script By [it v 1.6.37]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(BasicParentItemsRequest $request)
    {
    	$data = $request->except("_token");
    	
        $BasicParentItem = BasicParentItem::create($data); 

		  $BasicParentItem = BasicParentItem::with($this->arrWith())->find($BasicParentItem->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$BasicParentItem
        ]);
    }


            /**
             * Display the specified resource.
             * Baboon Api Script By [it v 1.6.37]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
                $BasicParentItem = BasicParentItem::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($BasicParentItem) || empty($BasicParentItem)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $BasicParentItem
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.37]
             * update a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new BasicParentItemsRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(BasicParentItemsRequest $request,$id)
            {
            	$BasicParentItem = BasicParentItem::find($id);
            	if(is_null($BasicParentItem) || empty($BasicParentItem)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              BasicParentItem::where("id",$id)->update($data);

              $BasicParentItem = BasicParentItem::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $BasicParentItem
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.37]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $basicparentitems = BasicParentItem::find($id);
            	if(is_null($basicparentitems) || empty($basicparentitems)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


               it()->delete("basicparentitem",$id);

               $basicparentitems->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $basicparentitems = BasicParentItem::find($id);
	            	if(is_null($basicparentitems) || empty($basicparentitems)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	it()->delete("basicparentitem",$id);
                    	$basicparentitems->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $basicparentitems = BasicParentItem::find($data);
	            	if(is_null($basicparentitems) || empty($basicparentitems)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	it()->delete("basicparentitem",$data);

                    $basicparentitems->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}