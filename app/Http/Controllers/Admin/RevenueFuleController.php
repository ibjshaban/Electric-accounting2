<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RevenueFuleDataTable;
use App\DataTables\RevenueFuleRevenueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\RevenueFuleRequest;
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

        $this->middleware('AdminRole:revenuefule_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:revenuefule_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:revenuefule_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:revenuefule_delete', [
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
        $revenue = revenue::find($id)->name;
        return $revenuefule->with('id', $id)
            ->render('admin.revenuefule.index',
                ['title' => trans('admin.revenuefule'). '/(' . $revenue . ')','id'=> $id]);
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

        if (\request()->stock){
            $revenue_fule= RevenueFule::where('revenue_id', $id)->where('stock_id', \request()->stock)
                ->get()
                ->map(function ($q){$q->filling = Filling::whereId($q->filling_id)->first(); return $q;});
        }
        return view('admin.revenuefule.partition', ['title' => 'فصلة سولار لـ '.$revenue->name,'stocks'=> $stocks,
            'revenueFules'=> $revenue_fule,'revenue_id'=> $id,'city_id'=> $city_id]);
    }
    public function revenueFuleRevenuePartitionSave(Request $request,$id)
    {
       // $revenue = revenue::find($id);


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
            foreach ($revenue_fule->pluck('filling_id') as $rev){
                Filling::whereId($rev)->first();
            }
            foreach ($revenue_fule as $k=>$fule){
               foreach ($request_array as $key=>$item){
                   if ($fule->revenue_id == intval($item->revenue) && $fule->quantity == floatval($item->amount)){
                       $revenue_fule->forget($k);
                       $request_array->forget($key);
                       break;
                   }
               }
            }
            foreach ($revenue_fule as $k=>$fule){
                foreach ($request_array as $key=>$item){
                    if ($fule->quantity == floatval($item->amount)){
                        $fule->update([
                            'revenue_id'=> intval($item->revenue),
                            'note'=> $item->note
                        ]);
                        $revenue_fule->forget($k);
                        $request_array->forget($key);
                        break;
                    }
                }
            }

            $request_array= $request_array->sortByDesc('amount');

            $index=0;
            while(count($revenue_fule) > 0){
                $max=$revenue_fule->max('quantity');
                $fule= $revenue_fule->where('quantity',$max)->first();

                foreach ($request_array as $key=>$item){

                    if ($fule->quantity >= $item->amount){

                        RevenueFule::create([
                            'quantity'=> $item->amount,
                            'price'=> $fule->price,
                            'paid_amount'=> 0,
                            'filling_id'=> $fule->filling_id,
                            'stock_id'=> $fule->stock_id,
                            'revenue_id'=> $item->revenue,
                            'city_id'=> $fule->city_id,
                            'note'=> $item->note,
                        ]);

                        $revenue_fule->where('id',$fule->id)->first()->quantity -= $item->amount;
                        $request_array->forget($key);
                        if($fule->quantity == 0){
                            $fule->delete();
                            $revenue_fule->forget($index);
                        }
                    }
                }
                $index++;
            }

            $supplier_array= [];
            foreach ($filling_array as $filling_id){
                $filling = Filling::whereId($filling_id)->first();

                if (!in_array($filling->suplier_id,$supplier_array)){
                    array_push($supplier_array,$filling->supplier_id);
                    //Supplier::withTrashed()->whereId($filling->supplier_id)->first()->PayFillingsAutoFromPayments();
                }

                $sum= RevenueFule::where('filling_id',$filling_id)->sum( 'quantity');
                $filling->update(['quantity'=> $sum]);
            }

            DB::commit();
            return redirectWithSuccess(aurl('revenuefule-revenue/'.$id), 'تمت عملية الفصل بنجاح');
        }
        catch (\Exception $e){
                DB::rollBack();
                dd($e);
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
