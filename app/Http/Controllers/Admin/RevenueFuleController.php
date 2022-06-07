<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RevenueFuleDataTable;
use App\DataTables\RevenueFuleRevenueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\RevenueFuleRequest;
use App\Models\City;
use App\Models\Filling;
use App\Models\revenue;
use App\Models\RevenueFule;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class RevenueFuleController extends Controller
{

    public function __construct()
    {

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
    public function index(RevenueFuleDataTable $revenuefule)
    {
        return $revenuefule->render('admin.revenuefule.index', ['title' => trans('admin.revenuefule')]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.revenuefule.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(RevenueFuleRequest $request)
    {
        $data = $request->except("_token", "_method");
        $revenuefule = RevenueFule::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('revenuefule' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $revenuefule = RevenueFule::find($id);
        return is_null($revenuefule) || empty($revenuefule) ?
            backWithError(trans("admin.undefinedRecord"), aurl("revenuefule")) :
            view('admin.revenuefule.show', [
                'title' => trans('admin.show'),
                'revenuefule' => $revenuefule
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $revenuefule = RevenueFule::find($id);
        return is_null($revenuefule) || empty($revenuefule) ?
            backWithError(trans("admin.undefinedRecord"), aurl("revenuefule")) :
            view('admin.revenuefule.edit', [
                'title' => trans('admin.edit'),
                'revenuefule' => $revenuefule
            ]);
    }

    public function update(RevenueFuleRequest $request, $id)
    {
        // Check Record Exists
        $revenuefule = RevenueFule::find($id);
        if (is_null($revenuefule) || empty($revenuefule)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenuefule"));
        }
        $data = $this->updateFillableColumns();
        RevenueFule::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('revenuefule' . $redirect), trans('admin.updated'));
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * update a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateFillableColumns()
    {
        $fillableCols = [];
        foreach (array_keys((new RevenueFuleRequest)->attributes()) as $fillableUpdate) {
            if (!is_null(request($fillableUpdate))) {
                $fillableCols[$fillableUpdate] = request($fillableUpdate);
            }
        }
        return $fillableCols;
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * destroy a newly created resource in storage.
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $revenuefule = RevenueFule::find($id);
        if (is_null($revenuefule) || empty($revenuefule)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("revenuefule-revenue/".$revenuefule->revenue_id));
        }

        it()->delete('revenuefule', $id);
        $revenuefule->delete();
        return redirectWithSuccess(aurl("revenuefule-revenue/".$revenuefule->revenue_id), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $revenuefule = RevenueFule::find($id);
                if (is_null($revenuefule) || empty($revenuefule)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("revenuefule-revenue/".$revenuefule->revenue_id));
                }

                it()->delete('revenuefule', $id);
                $revenuefule->delete();
            }
            return redirectWithSuccess(aurl("revenuefule-revenue/".$revenuefule->revenue_id), trans('admin.deleted'));
        } else {
            $revenuefule = RevenueFule::find($data);
            if (is_null($revenuefule) || empty($revenuefule)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("revenuefule-revenue/".$revenuefule->revenue_id));
            }

            it()->delete('revenuefule', $data);
            $revenuefule->delete();
            return redirectWithSuccess(aurl("revenuefule-revenue/".$revenuefule->revenue_id), trans('admin.deleted'));
        }
    }


    ///////*** Show per one revenue
    public function revenueFuleRevenue(RevenueFuleRevenueDataTable $revenuefule, $id)
    {
        $revenue = revenue::find($id);
        $revenue_name= $revenue->name;
        $city_name= City::whereId($revenue->city_id)->first()->name;
        return $revenuefule->with('id', $id)
            ->render('admin.revenuefule.index',
                ['title' => trans('admin.revenuefule'). '/ (' . $revenue_name . ')'. '/ (' . $city_name . ')','id'=> $id]);
    }
    public function revenueFuleRevenuePartition($id)
    {
        $revenue = revenue::find($id);
        $city_id= $revenue->city_id;
        $revenue_fule= null;
        $stocks= RevenueFule::where('revenue_id', $id)
            ->get(['stock_id as id','filling_id'])
            ->unique('id')
            ->map(function ($q){
            $q->name= Stock::whereId($q->id)->first()->name;
            return $q;
        });
        $stock_fuel_amount= 0;
        if (\request()->stock){
            $revenue_fule= RevenueFule::where('revenue_id', $id)
                ->where('stock_id', \request()->stock)
                ->get()
                ->map(function ($q){ $q->filling_date= $q->filling_date; return $q;})
                ->sortByDesc('filling_date');
            $stock_fuel_amount= $revenue_fule->sum('quantity');
        }
        return view('admin.revenuefule.partition', ['title' => 'فصلة سولار لـ '.$revenue->name,'stocks'=> $stocks,
            'revenueFules'=> $revenue_fule,'revenue_id'=> $id,'city_id'=> $city_id,'stock_fuel_amount'=> $stock_fuel_amount]);
    }
    public function revenueFuleRevenuePartitionSave(Request $request,$id)
    {

        DB::beginTransaction();
        try {

            $request_array=collect();
            for($i=0; $i < count($request['revenue']?? []); $i++){
                $item= collect();
                $item->revenue= intval( $request->revenue[$i]);
                $item->amount= floatval($request->amount[$i]);
                $item->note= $request->note[$i];
                $request_array->push($item);
            }

            $stock_id= $request->stock_id;
            $revenue_fule= RevenueFule::where('revenue_id', $id)
                ->where('stock_id', $stock_id)
                ->orderByDesc('quantity')
                ->get();
            $filling_array= $revenue_fule->unique('filling_id')->pluck('filling_id');
            foreach ($revenue_fule as $k=>$fule){
               foreach ($request_array as $key=>$item){
                   if ($fule->revenue_id == intval($item->revenue) && $fule->quantity == floatval($item->amount)){
                       $revenue_fule->forget($k);
                       $request_array->forget($key);
                       //break;
                   }
                   elseif ($fule->quantity == floatval($item->amount)){
                       $fule->update([
                           'revenue_id'=> intval($item->revenue),
                           'note'=> $item->note
                       ]);
                       $revenue_fule->forget($k);
                       $request_array->forget($key);
                       //break;
                   }
               }
            }
            $supplier_data= collect();
            $request_array= $request_array->sortByDesc('amount');
            while(count($revenue_fule) > 0){
                $max=$revenue_fule->max('quantity');
                $fule= $revenue_fule->where('quantity',$max)->first();
                /********/
                $new_supplier_data= collect();
                $new_supplier_data->supplier_id= Filling::whereId($fule->filling_id)->first()->supplier_id;
                $new_supplier_data->total_price= $fule->price * $fule->quantity;
                $new_supplier_data->paid_amount= $fule->paid_amount;
                $supplier_data->push($new_supplier_data);
                /********/
                foreach ($request_array as $key=>$item){
                    if ($fule->quantity >= $item->amount){

                        $NewRevenueFuel= new RevenueFule();
                        $NewRevenueFuel->quantity= $item->amount;
                        $NewRevenueFuel->price= $fule->price;
                        $NewRevenueFuel->paid_amount= 0;
                        $NewRevenueFuel->filling_id= $fule->filling_id;
                        $NewRevenueFuel->stock_id= $fule->stock_id;
                        $NewRevenueFuel->revenue_id= $item->revenue;
                        $NewRevenueFuel->city_id= $fule->city_id;
                        $NewRevenueFuel->note= $item->note;

                        $revenue_fule_item= $revenue_fule->where('id',$fule->id)->first();
                        $revenue_fule_item->quantity -= $item->amount;

                        if ($revenue_fule_item->paid_amount >= ($item->amount * $revenue_fule_item->price) && $revenue_fule_item->paid_amount != 0){
                            $NewRevenueFuel->paid_amount= $item->amount * $revenue_fule_item->price;
                            $revenue_fule_item->paid_amount -= ($item->amount * $revenue_fule_item->price);
                        }
                        else{
                            $NewRevenueFuel->paid_amount= $revenue_fule_item->paid_amount;
                            $revenue_fule_item->paid_amount = 0;
                        }
                        $NewRevenueFuel->save();
                        $request_array->forget($key);
                        if(floatval($fule->quantity) == 0){
                            $revenue_fule= $revenue_fule->where('id', $fule->id)->reject();
                            $fule->delete();
                        }
                    }
                }
             }
            foreach ($filling_array as $filling_id){
                $filling = Filling::whereId($filling_id)->first();
                $sum= RevenueFule::where('filling_id',$filling_id)->sum('quantity');
                $filling->update(['quantity'=> $sum]);
            }
            foreach ($supplier_data->groupBy('supplier_id') as $supplier_id=> $group){
                $supplier= Supplier::withTrashed()->where('id', $supplier_id)->first();
            }

            DB::commit();
            return redirectWithSuccess(aurl('revenuefule-revenue/'.$id), 'تمت عملية الفصل بنجاح');
        }
        catch (\Exception $e){
                DB::rollBack();

                return redirectWithError(aurl('/revenuefule-revenue/'.$id.'/partition?stock='.$request->stock_id ),'لم تتم العملية حدث خطأ ما');
        }
    }

    //Create per one revenue
    public function revenueFulCreate($id)
    {
        $revenueFule = revenue::find($id);
        $revenueCity = $revenueFule->city_id;
        $revenue = $revenueFule->name;

        return view('admin.revenuefule.revenuefule-revenue.create', ['title' => trans('admin.create'). '/(' . $revenue . ')', 'revenueFule' => $revenueFule, 'revenueCity' => $revenueCity]);
    }

    //Store expenses by one revenue
    public function revenueFulStore(Request $request, $id){

        $data = $request->except("_token", "_method");
        $data['revenue_id'] = $id;
        $revenue = revenue::find($data['revenue_id']);
        $revenueCity = $revenue->city_id;
        $data['city_id'] = $revenueCity;
        $revenueFule = RevenueFule::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('revenuefule-revenue/'.$id. $redirect), trans('admin.added'));
    }

    //Edit per one revenue
    public function revenueFulEdit($id)
    {

        $revenueFule = RevenueFule::find($id);
        $revenueCity = $revenueFule->city_id;
        $revenue = revenue::find($revenueFule->revenue_id)->name;
        return view('admin.revenuefule.revenuefule-revenue.edit', ['title' => trans('admin.edit').'/(' . $revenue . ')','revenueFule' => $revenueFule, 'revenueCity' => $revenueCity]);
    }

    //Update per one revenue
    public function revenueFulUpdate(Request $request, $id){
        $revenueFule = RevenueFule::find($id);
        $revenu_id=$revenueFule->revenue_id;
        if (is_null($revenueFule) || empty($revenueFule)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenuefule-revenue"));
        }
        $data = $request->except("_token", "_method","save");
        RevenueFule::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $revenu_id . "/edit" : "";
        return redirectWithSuccess(aurl('revenuefule-revenue/'.$revenu_id. $redirect), trans('admin.updated'));
    }


}
