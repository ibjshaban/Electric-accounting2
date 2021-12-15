<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RevenueFuleDataTable;
use App\DataTables\RevenueFuleRevenueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\RevenueFuleRequest;
use App\Models\revenue;
use App\Models\RevenueFule;
use Illuminate\Http\Request;

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
        return $revenuefule->with('id', $id)->render('admin.revenuefule.index', ['title' => trans('admin.revenuefule')]);
    }

    //Create per one revenue
    public function revenueFulCreate($id)
    {
        $revenueFule = revenue::find($id);
        $revenueCity = revenue::find($id)->city_id;
        return view('admin.revenuefule.revenuefule-revenue.create', ['title' => trans('admin.create'), 'revenueFule' => $revenueFule, 'revenueCity' => $revenueCity]);
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
        return view('admin.revenuefule.revenuefule-revenue.edit', ['title' => trans('admin.edit'),'revenueFule' => $revenueFule, 'revenueCity' => $revenueCity]);
    }

    //Update per one revenue
    public function revenueFulUpdate(Request $request, $id){
        // Check Record Exists
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
