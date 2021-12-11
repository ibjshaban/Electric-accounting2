<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OtherOperationDataTable;
use App\DataTables\RevenueOtherOperationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\OtherOperationRequest;
use App\Models\OtherOperation;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class OtherOperationController extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:otheroperation_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:otheroperation_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:otheroperation_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:otheroperation_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(OtherOperationDataTable $otheroperation)
    {
        return $otheroperation->render('admin.otheroperation.index', ['title' => trans('admin.otheroperation')]);
    }

    public function revenueOtherOperation(RevenueOtherOperationDataTable $otheroperation, $id)
    {
        return $otheroperation->with('id', $id)->render('admin.otheroperation.index', ['title' => trans('admin.otheroperation')]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.otheroperation.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(OtherOperationRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $otheroperation = OtherOperation::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('otheroperation' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $otheroperation = OtherOperation::find($id);
        return is_null($otheroperation) || empty($otheroperation) ?
            backWithError(trans("admin.undefinedRecord"), aurl("otheroperation")) :
            view('admin.otheroperation.show', [
                'title' => trans('admin.show'),
                'otheroperation' => $otheroperation
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $otheroperation = OtherOperation::find($id);
        return is_null($otheroperation) || empty($otheroperation) ?
            backWithError(trans("admin.undefinedRecord"), aurl("otheroperation")) :
            view('admin.otheroperation.edit', [
                'title' => trans('admin.edit'),
                'otheroperation' => $otheroperation
            ]);
    }

    public function update(OtherOperationRequest $request, $id)
    {
        // Check Record Exists
        $otheroperation = OtherOperation::find($id);
        if (is_null($otheroperation) || empty($otheroperation)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("otheroperation"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        OtherOperation::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('otheroperation' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new OtherOperationRequest)->attributes()) as $fillableUpdate) {
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
        $otheroperation = OtherOperation::find($id);
        if (is_null($otheroperation) || empty($otheroperation)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("otheroperation"));
        }

        it()->delete('otheroperation', $id);
        $otheroperation->delete();
        return redirectWithSuccess(aurl("otheroperation"), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $otheroperation = OtherOperation::find($id);
                if (is_null($otheroperation) || empty($otheroperation)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("otheroperation"));
                }

                it()->delete('otheroperation', $id);
                $otheroperation->delete();
            }
            return redirectWithSuccess(aurl("otheroperation"), trans('admin.deleted'));
        } else {
            $otheroperation = OtherOperation::find($data);
            if (is_null($otheroperation) || empty($otheroperation)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("otheroperation"));
            }

            it()->delete('otheroperation', $data);
            $otheroperation->delete();
            return redirectWithSuccess(aurl("otheroperation"), trans('admin.deleted'));
        }
    }


}
