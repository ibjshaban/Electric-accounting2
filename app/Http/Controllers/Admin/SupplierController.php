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
    public function index(SupplierDataTable $supplier)
    {
        return $supplier->render('admin.supplier.index', ['title' => trans('admin.supplier')]);
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
        return redirectWithSuccess(aurl('supplier' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(FillingSingleSupplierDataTable $filling,$id)
    {
        $supplier = Supplier::withTrashed()->find($id);
        //$supplier->PayFillingsAutoFromPayments();
        $financial_difference= $supplier->FinancialDifferenceBetweenPaymentsAndFillings();

        return is_null($supplier) || empty($supplier) ?
            backWithError(trans("admin.undefinedRecord"), aurl("supplier")) :
            $filling->render('admin.supplier.show', [
                'title' => trans('admin.show'),
                'supplier' => $supplier,
                'financial_difference' => $financial_difference,
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
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
        $supplier = Supplier::find($id);
        if (is_null($supplier) || empty($supplier)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("supplier"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        if (request()->hasFile('photo_profile')) {
            it()->delete($supplier->photo_profile);
            $data['photo_profile'] = it()->upload('photo_profile', 'admins');
        }
        Supplier::where('id', $id)->update($data);
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


    public function multi_delete()
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
    }


}
