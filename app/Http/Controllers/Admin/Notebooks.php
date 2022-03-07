<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NotebooksDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\NotebooksRequest;
use App\Models\Notebook;
use Carbon\Carbon;
use Illuminate\Http\Request;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class Notebooks extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:notebooks_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:notebooks_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:notebooks_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:notebooks_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(NotebooksDataTable $notebooks,Request $request)
    {
        if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
            if ($request->from_date != null && $request->to_date != null) {
                $notebooks = Notebook::whereBetween('created_at', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
            } else {
                $notebooks = Notebook::get();
            }
            return datatables($notebooks)
                ->addIndexColumn()
                ->addColumn('actions', 'admin.notebooks.buttons.actions')

                ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
                ->rawColumns(['checkbox', 'actions',])
                ->make(true);
        }
        return $notebooks->render('admin.notebooks.index', ['title' => trans('admin.notebooks')]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.notebooks.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.37]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(NotebooksRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $notebooks = Notebook::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('notebooks' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.37]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notebooks = Notebook::find($id);
        return is_null($notebooks) || empty($notebooks) ?
            backWithError(trans("admin.undefinedRecord"), aurl("notebooks")) :
            view('admin.notebooks.show', [
                'title' => trans('admin.show'),
                'notebooks' => $notebooks
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notebooks = Notebook::find($id);
        return is_null($notebooks) || empty($notebooks) ?
            backWithError(trans("admin.undefinedRecord"), aurl("notebooks")) :
            view('admin.notebooks.edit', [
                'title' => trans('admin.edit'),
                'notebooks' => $notebooks
            ]);
    }

    public function update(NotebooksRequest $request, $id)
    {
        // Check Record Exists
        $notebooks = Notebook::find($id);
        if (is_null($notebooks) || empty($notebooks)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("notebooks"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        Notebook::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('notebooks' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new NotebooksRequest)->attributes()) as $fillableUpdate) {
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
        $notebooks = Notebook::find($id);
        if (is_null($notebooks) || empty($notebooks)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("notebooks"));
        }

        it()->delete('notebook', $id);
        $notebooks->delete();
        return redirectWithSuccess(aurl("notebooks"), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $notebooks = Notebook::find($id);
                if (is_null($notebooks) || empty($notebooks)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("notebooks"));
                }

                it()->delete('notebook', $id);
                $notebooks->delete();
            }
            return redirectWithSuccess(aurl("notebooks"), trans('admin.deleted'));
        } else {
            $notebooks = Notebook::find($data);
            if (is_null($notebooks) || empty($notebooks)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("notebooks"));
            }

            it()->delete('notebook', $data);
            $notebooks->delete();
            return redirectWithSuccess(aurl("notebooks"), trans('admin.deleted'));
        }
    }


}
