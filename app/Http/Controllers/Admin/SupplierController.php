<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FillingSingleSupplierDataTable;
use App\DataTables\SupplierDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\SupplierRequest;
use App\Models\Filling;
use App\Models\Payment;
use App\Models\RevenueFule;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class SupplierController extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:supplier_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:supplier_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:supplier_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:supplier_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::withTrashed()->get();
        return view('admin.supplier.index', ['title' => trans('admin.supplier'), 'suppliers'=>$suppliers]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(SupplierRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        if (request()->hasFile('photo_profile')) {
            $data['photo_profile'] = it()->upload('photo_profile', 'admins');
        } else {
            $data['photo_profile'] = "";
        }
        $supplier = Supplier::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return backWithSuccess(aurl('supplier' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(FillingSingleSupplierDataTable $filling,Request $request,$id)
    {
        $supplier = Supplier::withTrashed()->find($id);
        $payments = Payment::where('supplier_id', $id)->orderBy('created_at','DESC')->paginate(10);
        if($request->from_date != null && $request->to_date != null || $request->reload != null){
            if($request->from_date != null && $request->to_date != null){
                $fillings = Filling::where('supplier_id',$id)->whereBetween('created_at',[$request->from_date,Carbon::parse($request->to_date)->addDay(1)])->get();
            }else{
                $fillings = Filling::where('supplier_id',$id)->get();
            }
            return datatables($fillings)
                    ->addIndexColumn()
                    ->addColumn('actions', 'admin.filling.buttons.actions')
                    ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
                    ->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
                    ->addColumn('total_price', '{{ $quantity*$price }}')
                    ->addColumn('checkbox', '<div  class="icheck-danger">
                        <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                        <label for="selectdata{{ $id }}"></label>
                        </div>')
                    ->rawColumns(['checkbox', 'actions',])
                    ->make(true);
        }
        $filling_paid_amount= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $id)->pluck('id'))
            ->sum('paid_amount');
        $filling_amount= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $id)->pluck('id'))
        ->sum(DB::raw('quantity * price'));
        $payments_amount = Payment::where('supplier_id', $id)->sum('amount');
        return is_null($supplier) || empty($supplier) ?
            backWithError(trans("admin.undefinedRecord"), aurl("supplier")) :
            $filling->render('admin.supplier.show', [
                'title' => trans('admin.show'),
                'supplier' => $supplier,
                'payments' => $payments,
                'filling_paid_amount'=> $filling_paid_amount,
                'filling_amount'=> $filling_amount,
                'payments_amount'=> $payments_amount,
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::withTrashed()->find($id);
        return is_null($supplier) || empty($supplier) ?
            backWithError(trans("admin.undefinedRecord"), aurl("supplier")) :
            view('admin.supplier.edit', [
                'title' => trans('admin.edit'),
                'supplier' => $supplier
            ]);
    }

    public function update(SupplierRequest $request, $id)
    {
        // Check Record Exists
        $supplier = Supplier::withTrashed()->find($id);
        if (is_null($supplier) || empty($supplier)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("supplier"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        if (request()->hasFile('photo_profile')) {
            it()->delete($supplier->photo_profile);
            $data['photo_profile'] = it()->upload('photo_profile', 'admins');
        }
        Supplier::withTrashed()->where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('supplier' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new SupplierRequest)->attributes()) as $fillableUpdate) {
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
        $supplier = Supplier::find($id);

        if (is_null($supplier) || empty($supplier)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("supplier"));
        }

        it()->delete('supplier', $id);
        $supplier->delete();
        return redirectWithSuccess(aurl("supplier"), trans('admin.deleted'));
    }

    /*public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $supplier = Supplier::find($id);
                if (is_null($supplier) || empty($supplier)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("supplier"));
                }

                it()->delete('supplier', $id);
                $supplier->delete();
            }
            return redirectWithSuccess(aurl("supplier"), trans('admin.deleted'));
        } else {
            $supplier = Supplier::find($data);
            if (is_null($supplier) || empty($supplier)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("supplier"));
            }

            it()->delete('supplier', $data);
            $supplier->delete();
            return redirectWithSuccess(aurl("supplier"), trans('admin.deleted'));
        }
    }*/


}
