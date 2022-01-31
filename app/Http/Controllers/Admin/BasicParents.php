<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BasicParentItemsDataTable;
use App\DataTables\BasicParentsDataTable;
use App\DataTables\PaymentsDataTable;
use App\DataTables\WithdrawalsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\BasicParentsRequest;
use App\Models\BasicParent;
use App\Models\BasicParentItem;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\Cast\Object_;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class BasicParents extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:basicparents_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:basicparents_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:basicparents_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:basicparents_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(BasicParentsDataTable $basicparents)
    {
        return $basicparents->render('admin.basicparents.index', ['title' => trans('admin.basicparents')]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.basicparents.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.37]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(BasicParentsRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $basicparents = BasicParent::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('basicparents' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.37]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, BasicParentItemsDataTable $basicparentitemsTable)
    {
        $basicparents = BasicParent::find($id);

        $basicparentitems = BasicParentItem::where('basic_id', $id)->get();
        return is_null($basicparents) || empty($basicparents) ?
            backWithError(trans("admin.undefinedRecord"), aurl("basicparents")) :
            /*view('admin.basicparents.show', [
                'title' => trans('admin.show'),
                'basicparents' => $basicparents
            ]) */ $basicparentitemsTable->with(['basic_id'=>$id, 'basicparents'=>$basicparents])->render('admin.basicparents.show', ['title' => trans('admin.show'), 'basicparents' => $basicparents]);
    }
    public function show_withdrawalspayments($id)
    {
        $basicparents = BasicParent::find($id);
        $datatable= collect();
        if (\Request::is('admin/withdrawals/*')){
            $datatable= new WithdrawalsDataTable();
        }
        else{
            $datatable= new PaymentsDataTable();
        }

        return is_null($basicparents) || empty($basicparents) ?
            backWithError(trans("admin.undefinedRecord"), aurl(\Request::is('admin/withdrawals/*') ? "withdrawals" : "payments")) :
            $datatable->with(['parent_id'=>$id])->render('admin.basicparents.show', ['title' => trans('admin.show'), 'basicparents' => $basicparents]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $basicparents = BasicParent::find($id);
        return is_null($basicparents) || empty($basicparents) ?
            backWithError(trans("admin.undefinedRecord"), aurl("basicparents")) :
            view('admin.basicparents.edit', [
                'title' => trans('admin.edit'),
                'basicparents' => $basicparents
            ]);
    }

    public function update(BasicParentsRequest $request, $id)
    {
        // Check Record Exists
        $basicparents = BasicParent::find($id);
        if (is_null($basicparents) || empty($basicparents)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("basicparents"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        BasicParent::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('basicparents' . $redirect), trans('admin.updated'));
    }

    /**
     * Baboon Script By [it v 1.6.37]
     * update a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateFillableColumns()
    {
        $fillableCols = [];
        foreach (array_keys((new BasicParentsRequest)->attributes()) as $fillableUpdate) {
            if (!is_null(request($fillableUpdate))) {
                $fillableCols[$fillableUpdate] = request($fillableUpdate);
            }
        }
        return $fillableCols;
    }

    /**
     * Baboon Script By [it v 1.6.37]
     * destroy a newly created resource in storage.
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $basicparents = BasicParent::find($id);
        if (is_null($basicparents) || empty($basicparents)) {
            return backWithSuccess(trans('admin.undefinedRecord'));
        }

        it()->delete('basicparent', $id);
        $basicparents->delete();

        return backWithSuccess( trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $basicparents = BasicParent::find($id);
                if (is_null($basicparents) || empty($basicparents)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("startup"));
                }

                it()->delete('basicparent', $id);
                $basicparents->delete();
            }
            return backWithSuccess(trans('admin.deleted'));
        } else {
            $basicparents = BasicParent::find($data);
            if (is_null($basicparents) || empty($basicparents)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("startup"));
            }

            it()->delete('basicparent', $data);
            $basicparents->delete();
            return backWithSuccess(trans('admin.deleted'));
        }
    }

    // -------------------- Startup basic -----------------------------------------//
    public function indexStartup()
    {

        $currentRoute = \Route::current()->uri;
        $item = CheckParentRoute($currentRoute);
        $title = CheckParentTitle($currentRoute);
        $basicparents = BasicParent::where('item', $item)->get();
        return view('admin.basicparents.index', ['title' => $title, 'basicparents'=>$basicparents]);
        //return $basicparents->with('item', $item)->render('admin.basicparents.index', ['title' => $title]);
    }

    public function createStartup()
    {
        $currentRoute = \Route::current()->uri;
        $title = CheckParentTitle($currentRoute);
        return view('admin.basicparents.create', ['title' => $title . '/' . trans('admin.create')]);
    }
    public function storeStartup(BasicParentsRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        /*if (\Request::is('admin/startup/*')) {
            $data['item'] = '0';
        }*/
        $currentRoute = \Route::current()->uri;
        $item = CheckParentRoute($currentRoute);
        $tokens = explode('/', $currentRoute);
        $data['item'] = $item;
        $path = $tokens[sizeof($tokens)-2];
        $basicparents = BasicParent::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl($path . $redirect), trans('admin.added'));
    }
    public function editStartup($id)
    {
        $currentRoute = \Route::current()->uri;
        $title = CheckParentTitle($currentRoute);

        $basicparents = BasicParent::find($id);
        return is_null($basicparents) || empty($basicparents) ?
            backWithError(trans("admin.undefinedRecord"), aurl("startup")) :
            view('admin.basicparents.edit', [
                'title' => $title.'/'. trans('admin.edit'),
                'basicparents' => $basicparents
            ]);
    }
    public function updateStartup(BasicParentsRequest $request, $id)
    {
        // Check Record Exists
        $basicparents = BasicParent::find($id);
        if (is_null($basicparents) || empty($basicparents)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("basicparents"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();

        $currentRoute = \Route::current()->uri;
        //dd($currentRoute);
        $tokens = explode('/', $currentRoute);
        $path = $tokens[sizeof($tokens)-3];

        BasicParent::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl($path . $redirect), trans('admin.updated'));
    }

    //------------------------------ ------------------------------------//
}
