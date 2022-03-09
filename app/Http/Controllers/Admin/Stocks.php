<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\StockDataTable;
use Carbon\Carbon;
use App\Models\Stock;

use App\Http\Controllers\Validations\StockRequest;
use App\Models\City;
use Illuminate\Http\Request;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Stocks extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:stock_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:stock_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:stock_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:stock_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(StockDataTable $stock ,Request $request)
            {
                if($request->from_date != null && $request->to_date != null || $request->reload != null){
                    if($request->from_date != null && $request->to_date != null){
                        $stocks = Stock::whereBetween('created_at',[$request->from_date,Carbon::parse($request->to_date)->addDay(1)])->get();
                    }else{
                        $stocks = Stock::get();
                    }
                    return datatables($stocks)
                            ->addIndexColumn()
                            ->addColumn('actions', 'admin.stock.buttons.actions')
                            ->addColumn('city_name',function(Stock $stock){
                                return City::where('id',$stock->city_id)->first()->name;
                            })
                            ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')   		->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')            ->addColumn('checkbox', '<div  class="icheck-danger">
                                <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                                <label for="selectdata{{ $id }}"></label>
                                </div>')
                            ->rawColumns(['checkbox','actions',])
                            ->make(true);
                }
               return $stock->render('admin.stock.index',['title'=>trans('admin.stock')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.stock.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(StockRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$stock = Stock::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('stock'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$stock =  Stock::find($id);
        		return is_null($stock) || empty($stock)?
        		backWithError(trans("admin.undefinedRecord"),aurl("stock")) :
        		view('admin.stock.show',[
				    'title'=>trans('admin.show'),
					'stock'=>$stock
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$stock =  Stock::find($id);
        		return is_null($stock) || empty($stock)?
        		backWithError(trans("admin.undefinedRecord"),aurl("stock")) :
        		view('admin.stock.edit',[
				  'title'=>trans('admin.edit'),
				  'stock'=>$stock
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
				foreach (array_keys((new StockRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(StockRequest $request,$id)
            {
              // Check Record Exists
              $stock =  Stock::find($id);
              if(is_null($stock) || empty($stock)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("stock"));
              }
              $data = $this->updateFillableColumns();
              Stock::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('stock'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$stock = Stock::find($id);
		if(is_null($stock) || empty($stock)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("stock"));
		}

		it()->delete('stock',$id);
		$stock->delete();
		return redirectWithSuccess(aurl("stock"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$stock = Stock::find($id);
				if(is_null($stock) || empty($stock)){
					return backWithError(trans('admin.undefinedRecord'),aurl("stock"));
				}

				it()->delete('stock',$id);
				$stock->delete();
			}
			return redirectWithSuccess(aurl("stock"),trans('admin.deleted'));
		}else {
			$stock = Stock::find($data);
			if(is_null($stock) || empty($stock)){
				return backWithError(trans('admin.undefinedRecord'),aurl("stock"));
			}

			it()->delete('stock',$data);
			$stock->delete();
			return redirectWithSuccess(aurl("stock"),trans('admin.deleted'));
		}
	}


    public function dtPrint(Request $request)
    {
        $data = [];
        if ($request->query('reload') == null) {
            $stocks = Stock::whereBetween('created_at',[$request->from_date,Carbon::parse($request->to_date)->addDay(1)])->get();
        } else {
            $stocks = Stock::get();
        }

        $i = 1;
        foreach($stocks as $stock){
            $data[] = [
                'الرقم' => $i,
                trans('admin.name') => $stock->name,
                trans('admin.city_id') => City::where('id',$stock->city_id)->first()->name ?? '',
                trans('admin.created_at') => Carbon::parse($stock->created_at)->format('Y-m-d'),
            ];
            $i++;
        }

        return view('vendor.datatables.print',[
            'data' => $data,
            'title' => trans('admin.stock'),
            'totalPrice' => 0,
            'total_name' => null,
        ]);
    }
}
