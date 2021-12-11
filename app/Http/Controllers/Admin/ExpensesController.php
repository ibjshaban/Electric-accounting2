<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExpensesDataTable;
use App\DataTables\RevenueExpensesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\ExpensesRequest;
use App\Models\Expenses;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class ExpensesController extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:expenses_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:expenses_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:expenses_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:expenses_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(ExpensesDataTable $expenses)
    {
        return $expenses->render('admin.expenses.index', ['title' => trans('admin.expenses')]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.expenses.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(ExpensesRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $expenses = Expenses::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('expenses' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expenses = Expenses::find($id);
        return is_null($expenses) || empty($expenses) ?
            backWithError(trans("admin.undefinedRecord"), aurl("expenses")) :
            view('admin.expenses.show', [
                'title' => trans('admin.show'),
                'expenses' => $expenses
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenses = Expenses::find($id);
        return is_null($expenses) || empty($expenses) ?
            backWithError(trans("admin.undefinedRecord"), aurl("expenses")) :
            view('admin.expenses.edit', [
                'title' => trans('admin.edit'),
                'expenses' => $expenses
            ]);
    }

    public function update(ExpensesRequest $request, $id)
    {
        // Check Record Exists
        $expenses = Expenses::find($id);
        if (is_null($expenses) || empty($expenses)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("expenses"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        Expenses::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('expenses' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new ExpensesRequest)->attributes()) as $fillableUpdate) {
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
        $expenses = Expenses::find($id);
        if (is_null($expenses) || empty($expenses)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("expenses"));
        }

        it()->delete('expenses', $id);
        $expenses->delete();
        return redirectWithSuccess(aurl("expenses"), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $expenses = Expenses::find($id);
                if (is_null($expenses) || empty($expenses)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("expenses"));
                }

                it()->delete('expenses', $id);
                $expenses->delete();
            }
            return redirectWithSuccess(aurl("expenses"), trans('admin.deleted'));
        } else {
            $expenses = Expenses::find($data);
            if (is_null($expenses) || empty($expenses)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("expenses"));
            }

            it()->delete('expenses', $data);
            $expenses->delete();
            return redirectWithSuccess(aurl("expenses"), trans('admin.deleted'));
        }
    }

    //Show expenses for one revenue
    public function revenueExpenses(RevenueExpensesDataTable $expenses, $id)
    {
        return $expenses->with('id', $id)->render('admin.expenses.index', ['title' => trans('admin.expenses')]);
    }


}
