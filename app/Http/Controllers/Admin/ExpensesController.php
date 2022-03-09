<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLogNoteType;
use App\DataTables\ExpensesDataTable;
use App\DataTables\RevenueExpensesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\ExpensesRequest;
use App\Models\Expenses;
use App\Models\ExpensesItem;
use App\Models\revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class ExpensesController extends Controller
{
    private $revenue;

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
        $revenue = revenue::find($expenses->revenue_id)->name;
        return is_null($expenses) || empty($expenses) ?
            backWithError(trans("admin.undefinedRecord"), aurl("expenses")) :
            view('admin.expenses.show', [
                'title' => trans('admin.show').'/('.$revenue.')',
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
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("revenue-expenses/" . $expenses->revenue_id));
        }

        it()->delete('expenses', $id);
        foreach ($expenses->item() as $ex) { $ex->delete();}
        AddNewLog(ActivityLogNoteType::expenses,'حذف مصاريف تشغيلية',$expenses->price,
                'delete',null,$expenses->revenue_id,'/revenue-salary/'.$expenses->revenue_id);
        $expenses->delete();
        return redirectWithSuccess(aurl("revenue-expenses/" . $expenses->revenue_id), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $expenses = Expenses::find($id);
                if (is_null($expenses) || empty($expenses)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("revenue-expenses"));
                }

                it()->delete('expenses', $id);
                foreach ($expenses->item() as $ex) { $ex->delete();}
                AddNewLog(ActivityLogNoteType::expenses,'حذف مصاريف تشغيلية',$expenses->price,
                    'delete',null,$expenses->revenue_id,'/revenue-salary/'.$expenses->revenue_id);
                $expenses->delete();
            }
            return redirectWithSuccess(aurl("revenue-expenses/" . $expenses->revenue_id), trans('admin.deleted'));
        } else {
            $expenses = Expenses::find($data);
            if (is_null($expenses) || empty($expenses)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("revenue-expenses/" . $expenses->revenue_id));
            }

            it()->delete('expenses', $data);
            foreach ($expenses->item() as $ex) { $ex->delete();}
            AddNewLog(ActivityLogNoteType::expenses,'حذف مصاريف تشغيلية',$expenses->price,
                'delete',null,$expenses->revenue_id,'/revenue-salary/'.$expenses->revenue_id);
            $expenses->delete();
            return redirectWithSuccess(aurl("revenue-expenses/" . $expenses->revenue_id), trans('admin.deleted'));
        }
    }

    //Show expenses for one revenue
    public function revenueExpenses(RevenueExpensesDataTable $expenses,Request $request, $id)
    {
        $revenue = revenue::find($id)->name;
        if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
            if ($request->from_date != null && $request->to_date != null) {
                $expenses = Expenses::where('revenue_id', $id)->whereBetween('date', [$request->from_date,Carbon::parse($request->to_date)->addDay(1)])->get();
            } else {
                $expenses = Expenses::where('revenue_id', $id)->get();
            }
            return datatables($expenses)
            ->addIndexColumn()
            ->addColumn('revenue_id',function(Expenses $expenses){
                return Expenses::where('id',$expenses->revenue_id)->first()->name ?? '';
            })
            ->addColumn('actions', 'admin.expenses.revenue-expenses.buttons.actions')
            ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
            ->rawColumns(['checkbox', 'actions',])
                ->make(true);
        }
        return $expenses->with('id', $id)->render('admin.expenses.index', ['title' => trans('admin.expenses') . '/(' . $revenue . ')']);
    }

    public function revenueCreate($id)
    {
        $revenue = revenue::find($id);
        $revenue_name = $revenue->name;
        return view('admin.expenses.revenue-expenses.create', ['title' => trans('admin.create') . '/(' . $revenue_name . ')', 'expenses' => $revenue]);
    }

    //Create expenses by one revenue
    public function revenueStore(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'date' => 'nullable|string',
        ], [], ['name' => 'البيان']);
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $data['revenue_id'] = $id;
        DB::beginTransaction();
        $expenses_price = 0;
        try {
            $expenses = new Expenses();
            $expenses->name = $data['name'];
            $expenses->date = $data['date'];
            $expenses->admin_id = $data['admin_id'];
            $expenses->revenue_id = $data['revenue_id'];
            $expenses->discount = $data['discount'];
            $expenses->price = 0;
            $expenses->save();

            for ($i = 0; $i < count($data['item'] ?? []); $i++) {
                ExpensesItem::create([
                    'item' => $data['item'][$i],
                    'item_number' => $data['item_number'][$i],
                    'amount' => InsertLargeNumber($data['amount'][$i]),
                    'price' => InsertLargeNumber($data['price'][$i]),
                    'expenses_id' => $expenses->id,
                ]);
                $expenses_price += ($data['price'][$i] * $data['amount'][$i]);
            }
            $expenses->update(['price' => InsertLargeNumber(($expenses_price- $expenses->discount))]);

            AddNewLog(ActivityLogNoteType::expenses,'إضافة مصاريف تشغيلية',$expenses->price,
                'store',null,$expenses->revenue_id,'/revenue-salary/'.$expenses->revenue_id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();

        }

        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('revenue-expenses/' . $id . $redirect), trans('admin.added'));
    }

    public function revenueEdit($id)
    {

        $expenses = Expenses::find($id);
        $revenue = revenue::find($expenses->revenue_id)->name;
        return view('admin.expenses.revenue-expenses.edit', ['title' => trans('admin.edit') . '/(' . $revenue . ')', 'expenses' => $expenses]);
    }

    //Edit expenses by one revenue
    public function revenueUpdate(Request $request, $id)
    {
        // Check Record Exists
        $this->validate($request, [
            'name' => 'required|string',
            'date' => 'nullable|string',
        ], [], ['name' => 'البيان']);
        $expenses = Expenses::find($id);
        $revenu_id = $expenses->revenue_id;
        if (is_null($expenses) || empty($expenses)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenue-expenses"));
        }
        $data = $request->except("_token", "_method", "save");
        $data['admin_id'] = admin()->id();
        DB::beginTransaction();
        $expenses_price = 0;
        try {

            $expenses->name = $data['name'];
            $expenses->date = $data['date'];
            $expenses->admin_id = $data['admin_id'];
            $expenses->discount = $data['discount'];
            //$expenses->price = 0;
            $expenses->save();
            ExpensesItem::where('expenses_id', $expenses->id)->delete();
            for ($i = 0; $i < count($data['item'] ?? []); $i++) {
                ExpensesItem::create([
                    'item' => $data['item'][$i],
                    'item_number' => $data['item_number'][$i],
                    'amount' => InsertLargeNumber($data['amount'][$i]),
                    'price' => InsertLargeNumber($data['price'][$i]),
                    'expenses_id' => $expenses->id,
                ]);
                $expenses_price += ($data['price'][$i] * $data['amount'][$i]);
            }
            $expenses->update(['price' => InsertLargeNumber(($expenses_price- $expenses->discount))]);

            AddNewLog(ActivityLogNoteType::expenses,'تعديل مصاريف تشغيلية',$expenses->price,
                'update',null,$expenses->revenue_id,'/revenue-salary/'.$expenses->revenue_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }
        $redirect = isset($request["save_back"]) ? "/" . $revenu_id . "/edit" : "";
        return redirectWithSuccess(aurl('revenue-expenses/' . $revenu_id . $redirect), trans('admin.updated'));
    }


}
