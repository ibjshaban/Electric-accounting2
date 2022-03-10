<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLogNoteType;
use App\DataTables\OtherOperationDataTable;
use App\DataTables\RevenueOtherOperationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\OtherOperationRequest;
use App\Models\OtherOperation;
use App\Models\revenue;
use Illuminate\Http\Request;

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
        return redirectWithSuccess(url()->previous(), trans('admin.added'));
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
            backWithError(trans("admin.undefinedRecord"), url()->previous()) :
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
            backWithError(trans("admin.undefinedRecord"), url()->previous()) :
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
            return backWithError(trans("admin.undefinedRecord"), url()->previous());
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        OtherOperation::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(url()->previous(), trans('admin.updated'));
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
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("revenue-otheroperation/".$otheroperation->revenue_id));
        }

        it()->delete('otheroperation', $id);
        $otheroperation->delete();
        AddNewLog(ActivityLogNoteType::other_operation,'حذف مصاريف أخرى لايرادة',$otheroperation->price,
            'delete',null,$otheroperation->revenue_id,'/revenue-otheroperation/'.$otheroperation->revenue_id);
        return redirectWithSuccess(aurl("revenue-otheroperation/".$otheroperation->revenue_id), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $otheroperation = OtherOperation::find($id);
                if (is_null($otheroperation) || empty($otheroperation)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("revenue-otheroperation/".$otheroperation->revenue_id));
                }

                it()->delete('otheroperation', $id);
                $otheroperation->delete();

                AddNewLog(ActivityLogNoteType::other_operation,'حذف مصاريف أخرى لايرادة',$otheroperation->price,
                    'delete',null,$otheroperation->revenue_id,'/revenue-otheroperation/'.$otheroperation->revenue_id);
            }
            return redirectWithSuccess(aurl("revenue-otheroperation/".$otheroperation->revenue_id), trans('admin.deleted'));
        } else {
            $otheroperation = OtherOperation::find($data);
            if (is_null($otheroperation) || empty($otheroperation)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("revenue-otheroperation/".$otheroperation->revenue_id));
            }

            it()->delete('otheroperation', $data);
            $otheroperation->delete();

            AddNewLog(ActivityLogNoteType::other_operation,'حذف مصاريف أخرى لايرادة',$otheroperation->price,
                'delete',null,$otheroperation->revenue_id,'/revenue-otheroperation/'.$otheroperation->revenue_id);

            return redirectWithSuccess(aurl("revenue-otheroperation/".$otheroperation->revenue_id), trans('admin.deleted'));
        }
    }
    ///////////////////////////

    public function revenueOtherOperation(RevenueOtherOperationDataTable $otheroperation, $id)
    {
        $revenue = revenue::find($id)->name;
        return $otheroperation->with('id', $id)->render('admin.otheroperation.index', ['title' => trans('admin.otheroperation') . '/(' . $revenue . ')']);
    }

    public function otherOperationCreate($id)
    {
        $revenue = revenue::find($id)->name;
        $otheroperation = revenue::find($id);
        return view('admin.otheroperation.revenue-otheroperation.create', ['title' => trans('admin.create') . '/(' . $revenue . ')','otheroperation' => $otheroperation]);
    }

    //Create expenses by one otherOperation
    public function otherOperationStore(Request $request, $id){
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $data['revenue_id'] = $id;
        $otheroperation = OtherOperation::create($data);
        AddNewLog(ActivityLogNoteType::other_operation,'إضافة مصاريف أخرى لايرادة',$data['price'],
            'store',null,$data['revenue_id'],'/revenue-otheroperation/'.$data['revenue_id']);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('revenue-otheroperation/'.$id. $redirect), trans('admin.added'));
    }

    public function otherOperationEdit($id)
    {
        $otheroperation = OtherOperation::find($id);
        $revenue = revenue::find($otheroperation->revenue_id)->name;
        return view('admin.otheroperation.revenue-otheroperation.edit', ['title' => trans('admin.edit'). '/(' . $revenue . ')','otheroperation' => $otheroperation]);
    }

    //Edit expenses by one otherOperation
    public function otherOperationUpdate(Request $request, $id){
        // Check Record Exists
        $otheroperation = OtherOperation::find($id);
        $revenu_id=$otheroperation->revenue_id;
        if (is_null($otheroperation) || empty($otheroperation)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenue-otheroperation"));
        }
        $data = $request->except("_token", "_method","save");
        $data['admin_id'] = admin()->id();
        //$data['revenue_id'] = $revenu_id;
        OtherOperation::where('id', $id)->update($data);

        AddNewLog(ActivityLogNoteType::other_operation,'تعديل مصاريف أخرى لايرادة',$data['price'],
            'update',null,$data['revenue_id'],'/revenue-otheroperation/'.$data['revenue_id']);

        $redirect = isset($request["save_back"]) ? "/" . $revenu_id . "/edit" : "";
        return redirectWithSuccess(aurl('revenue-otheroperation/'.$revenu_id. $redirect), trans('admin.updated'));
    }


}
