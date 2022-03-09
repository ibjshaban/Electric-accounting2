<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\FillingDataTable;
use App\Models\fillingItem;
use App\Models\RevenueFule;
use App\Models\Stock;
use App\Models\Supplier;
use Carbon\Carbon;
use App\Models\Filling;

use App\Http\Controllers\Validations\FillingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class FillingController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:filling_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:filling_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:filling_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:filling_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(FillingDataTable $filling ,Request $request)
            {
                if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
                    if ($request->from_date != null && $request->to_date != null) {
                        $filling = Filling::whereBetween('filling_date', [$request->from_date,Carbon::parse($request->to_date)->addDay(1)])->get();
                    } else {
                        $filling = Filling::get();
                    }
                    return datatables($filling)
                    ->addIndexColumn()
                    ->addColumn('actions', 'admin.filling.buttons.actions')
                    ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
                    ->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
                    ->addColumn('total_price', '{{ $quantity*$price }}')
                    ->addColumn('supplier_id', function(Filling $fill){
                        return Supplier::where('id',$fill->supplier_id)->first()->name;
                    })
                    ->addColumn('checkbox', '<div  class="icheck-danger">
                          <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                          <label for="selectdata{{ $id }}"></label>
                        </div>')
                    ->rawColumns(['checkbox', 'actions',])
                        ->make(true);
                }
               return $filling->render('admin.filling.index',['title'=>trans('admin.filling')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
                $stocks= Stock::all()->sortBy('name');
               return view('admin.filling.create',['title'=>trans('admin.create'),'stocks'=> $stocks]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(FillingRequest $request)
            {
                $data = $request->except("_token", "_method");
                DB::beginTransaction();
                $supplier_id= explode('/',str_replace(url('/'), '', url()->previous()))[3];
                try {
                    $filling = new Filling();
                    $filling->name= $data['name'];
                    $filling->quantity= $data['quantity'];
                    $filling->price= $data['price'];
                    $filling->supplier_id= $supplier_id;
                    $filling->filling_date= $data['filling_date'];
                    $filling->note= $data['filling_note'];
                    $filling->save();
                    $supplier= Supplier::withTrashed()->whereId($supplier_id)->first();

                    for ($i=0; $i < count($data['amount']??[]); $i++){
                        RevenueFule::create([
                            'quantity'=> InsertLargeNumber($data['amount'][$i]),
                            'price'=> InsertLargeNumber($data['price']),
                            'paid_amount'=> 0,
                            'stock_id'=> $data['stock'][$i],
                            'revenue_id'=> $data['revenue'][$i],
                            'city_id'=> Stock::whereId($data['stock'][$i])->first()->city_id,
                            'note'=> $data['note'][$i],
                            'filling_id'=> $filling->id,
                        ]);
                    }
                    $supplier->AddFillingsForSupplier(($data['quantity'] * $data['price']));

                    DB::commit();
                }
                catch (\Exception $e){
                    DB::rollBack();

                    return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();

                }
                //Supplier::withTrashed()->whereId($supplier_id)->first()->PayFillingsAutoFromPayments();
                $redirect = isset($request["add_back"]) ?"filling/create":"supplier/".$supplier_id;
                return redirectWithSuccess(aurl($redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$filling =  Filling::find($id);
        		return is_null($filling) || empty($filling)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.filling.show',[
				    'title'=>trans('admin.show'),
					'filling'=>$filling
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
           /* public function edit($id)
            {
        		$filling =  Filling::find($id);
                $stocks= Stock::all()->sortBy('name');
        		return is_null($filling) || empty($filling)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.filling.edit',[
				  'title'=>trans('admin.edit'),
				  'filling'=>$filling,
                    'stocks'=> $stocks
        		]);
            }*/

            /**
             * Baboon Script By [it v 1.6.36]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
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
           /* public function update(FillingRequest $request,$id)
            {
              // Check Record Exists
              $filling =  Filling::find($id);
              if(is_null($filling) || empty($filling)){
              	return backWithError(trans("admin.undefinedRecord"),url()->previous());
              }
              $data = $request;

                DB::beginTransaction();
                try {

                    $filling->name= $data['name'];
                    $filling->quantity= $data['quantity'];
                    $filling->price= $data['price'];
                    $filling->filling_date= $data['filling_date'];
                    $filling->note= $data['filling_note'];
                    $filling->save();

                    $paid_price_amount= 0;
                    foreach ($filling->fule() as $fule) { $paid_price_amount += $fule->paid_amount; $fule->delete();}
                    for ($i=0; $i < count($data['amount']??[]); $i++){
                        $revenue_fuel= new RevenueFule();
                        $revenue_fuel->quantity= InsertLargeNumber($data['amount'][$i]);
                        $revenue_fuel->price= InsertLargeNumber($data['price']);
                        $revenue_fuel->paid_amount= 0;
                        $revenue_fuel->stock_id= $data['stock'][$i];
                        $revenue_fuel->revenue_id= $data['revenue'][$i];
                        $revenue_fuel->city_id= Stock::whereId($data['stock'][$i])->first()->city_id;
                        $revenue_fuel->note= $data['note'][$i];
                        $revenue_fuel->filling_id= $filling->id;
                        $revenue_fuel->save();
                        if ($paid_price_amount){
                            $fule_price_amount= ($revenue_fuel->price* $revenue_fuel->quantity);
                            if ($paid_price_amount >= $fule_price_amount){
                                $revenue_fuel->update(
                                    ['paid_amount' => InsertLargeNumber($revenue_fuel->paid_amount + ($fule_price_amount)),
                                        'is_paid'=> '1'
                                    ]);
                                $paid_price_amount -= $fule_price_amount;
                            }
                            else{
                                $revenue_fuel->update(
                                    ['paid_amount' => InsertLargeNumber($revenue_fuel->paid_amount + ($paid_price_amount))]);
                                $paid_price_amount=0;
                            }
                        }
                    }

                    DB::commit();
                    $redirect = isset($request["save_back"])?"filling/".$id."/edit":"supplier/".$filling->supplier_id;
                    return redirectWithSuccess(aurl($redirect), trans('admin.updated'));
                }
                catch (\Exception $e){
                    DB::rollBack();
                    return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
                }
            }*/

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$filling = Filling::find($id);
		if(is_null($filling) || empty($filling)){
			return backWithSuccess(trans('admin.undefinedRecord'),url()->previous());
		}
        it()->delete('filling',$id);
        try {
            DB::beginTransaction();
            $supplier_id= $filling->supplier_id;
            $paid_price_amount= 0;
            foreach ($filling->fule() as $fule) { $paid_price_amount += $fule->paid_amount; $fule->delete();}
            Supplier::withTrashed()->where('id', $supplier_id)->first()->DeleteFillingFromSupplier($paid_price_amount , ($filling->quantity * $filling->price));
            $filling->delete();
            DB::commit();
            $redirect = "supplier/".$supplier_id;
            return redirectWithSuccess(aurl($redirect), trans('admin.deleted'));
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }


	}


	public function multi_delete(){


        try {
            DB::beginTransaction();
            $data = request('selected_data');
            if(is_array($data)){
                foreach($data as $id){
                    $filling = Filling::find($id);
                    if(is_null($filling) || empty($filling)){
                        return backWithError(trans('admin.undefinedRecord'),url()->previous());
                    }

                    it()->delete('filling',$id);
                    $supplier_id= $filling->supplier_id;
                    $paid_price_amount= 0;
                    foreach ($filling->fule() as $fule) { $paid_price_amount += $fule->paid_amount; $fule->delete();}
                    Supplier::withTrashed()->where('id', $supplier_id)->first()->DeleteFillingFromSupplier($paid_price_amount , ($filling->quantity * $filling->price));
                    $filling->delete();
                }
                DB::commit();
                $redirect = "supplier/".$supplier_id;
                return redirectWithSuccess(aurl($redirect), trans('admin.deleted'));
            }
            else {
                $filling = Filling::find($data);
                if(is_null($filling) || empty($filling)){
                    return backWithError(trans('admin.undefinedRecord'),url()->previous());
                }

                it()->delete('filling',$data);
                $supplier_id= $filling->supplier_id;
                $paid_price_amount= 0;
                foreach ($filling->fule() as $fule) { $paid_price_amount += $fule->paid_amount; $fule->delete();}
                Supplier::withTrashed()->where('id', $supplier_id)->first()->DeleteFillingFromSupplier($paid_price_amount , ($filling->quantity * $filling->price));
                $filling->delete();
                DB::commit();
                $redirect = "supplier/".$supplier_id;
                return redirectWithSuccess(aurl($redirect), trans('admin.deleted'));
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }
	}

    public function dtPrint(Request $request)
    {
        $data = [];
        if ($request->query('reload') == null) {
            $filling = Filling::whereBetween('filling_date', [$request->from_date,Carbon::parse($request->to_date)->addDay(1)])->get();
        } else {
            $fills = Filling::all();
        }

        $i = 1;
        $total = 0;
        foreach($fills as $fill){
            $data[] = [
                'الرقم' => $i,
                trans('admin.quantity') => $fill->quantity,
                trans('admin.price') => $fill->price,
                'السعر الكلي' => $fill->quantity * $fill->price,
                trans('admin.supplier_id') => Supplier::where('id',$fill->supplier_id)->first()->name,
                trans('admin.filling_date') => $fill->filling_date,
                trans('admin.note') => $fill->note,
                'تاريخ الانشاء' => Carbon::parse($fill->created_at)->format('Y-m-d'),
               ];
            $i++;
            $total += ($fill->quantity * $fill->price);
        }

        return view('vendor.datatables.print',[
            'data' => $data,
            'title' => trans('admin.filling'),
            'totalPrice' => $total,
            'total_name' =>  'مجموع السعر الكلي',
        ]);
    }


}
