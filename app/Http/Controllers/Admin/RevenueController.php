<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RevenueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\RevenueRequest;
use App\Models\City;
use App\Models\Collection;
use App\Models\Expenses;
use App\Models\OtherOperation;
use App\Models\revenue;
use App\Models\RevenueFule;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class RevenueController extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:revenue_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:revenue_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:revenue_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:revenue_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(RevenueDataTable $revenue, Request $request)
    {
        if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
            if ($request->from_date != null && $request->to_date != null) {
                $revenues = revenue::whereBetween('open_date', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
            } else {
                $revenues = revenue::get();
            }
            return datatables($revenues)
                ->addIndexColumn()
                ->addColumn('actions', 'admin.revenue.buttons.actions')
                ->addColumn('city_name',function(revenue $revenue){
                    return City::where('id',$revenue->city_id)->first()->name ?? '';
                })
                ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
                ->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
                ->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                  <label for="selectdata{{ $id }}"></label>
                </div>')
                ->editColumn('close_date', 'admin.revenue.buttons.style')
                ->rawColumns(['checkbox', 'actions', 'close_date'])
                ->make(true);
        }
        return $revenue->render('admin.revenue.index', ['title' => trans('admin.revenue')]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.revenue.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(RevenueRequest $request)
    {
        $data = $request->except("_token", "_method");
        $data['admin_id'] = admin()->id();
        $revenue = revenue::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('revenue' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $revenue = revenue::find($id);
        $title = $revenue->name;

        ////
       /* $total_collections = DB::select('SELECT SUM(amount) AS amount FROM collections WHERE revenue_id = ' . $revenue->id . ' AND employee_id IN
                                               (SELECT id FROM employees WHERE type_id = 1)');
        $total_collection = $total_collections[0]->amount;*/
        $total_collection= Collection::where(['revenue_id'=>$revenue->id])->whereNotNull('employee_id')->sum('amount');
        //////
        $total_other_collection = Collection::where(['revenue_id' => $revenue->id])->whereNull('employee_id')->sum('amount');

        //$total_collection= Collection::where(['revenue_id'=>$revenue->id])->sum('amount');
        $total_fules = RevenueFule::where('revenue_id', $revenue->id)->sum('paid_amount');
        $total_salary = Salary::where('revenue_id', $revenue->id)->sum('total_amount');
        $total_expenses = Expenses::where('revenue_id', $revenue->id)->sum('price');
        $total_other_operation = OtherOperation::where('revenue_id', $revenue->id)->sum('price');
        $total_all = $total_fules + $total_salary + $total_expenses + $total_other_operation;
        ////
        $net_profit =($total_collection + $total_other_collection) - $total_all;
        return is_null($revenue) || empty($revenue) ?
            backWithError(trans("admin.undefinedRecord"), aurl("revenue")) :
            view('admin.revenue.show', [
                'title' => $title,
                'revenue' => $revenue,
                'total_collection' => $total_collection,
                'total_other_collection' => $total_other_collection,
                'total_fules' => $total_fules,
                'total_salary' => $total_salary,
                'total_expenses' => $total_expenses,
                'total_other_operation' => $total_other_operation,
                'total_all' => $total_all,
                'net_profit' => $net_profit,
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $revenue = revenue::find($id);
        return is_null($revenue) || empty($revenue) ?
            backWithError(trans("admin.undefinedRecord"), aurl("revenue")) :
            view('admin.revenue.edit', [
                'title' => trans('admin.edit'),
                'revenue' => $revenue
            ]);
    }

    public function update(RevenueRequest $request, $id)
    {
        // Check Record Exists
        $revenue = revenue::find($id);
        if (is_null($revenue) || empty($revenue)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenue"));
        }
        $data = $this->updateFillableColumns();
        $data['admin_id'] = admin()->id();
        $data['status'] = !is_null($request->status) && $request->status ? 0 : 1;
        revenue::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('revenue' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new RevenueRequest)->attributes()) as $fillableUpdate) {
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
        $revenue = revenue::find($id);
        if (is_null($revenue) || empty($revenue)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("revenue"));
        }
        $collection= Collection::where(['revenue_id'=>$revenue->id])->exists();
        $fules = RevenueFule::where('revenue_id', $revenue->id)->exists();
        $salary = Salary::where('revenue_id', $revenue->id)->exists();
        $expenses = Expenses::where('revenue_id', $revenue->id)->exists();
        $other_operation = OtherOperation::where('revenue_id', $revenue->id)->exists();
        if($collection || $fules || $salary || $expenses || $other_operation){
            return backWithError('لحذف الإيرادة يجب حذف كل ما هو مرتبط بها من التحصيلات و الوقود و الرواتب و المصاريف', aurl("revenue"));
        }
        it()->delete('revenue', $id);
        $revenue->delete();
        return redirectWithSuccess(aurl("revenue"), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $revenue = revenue::find($id);
                if (is_null($revenue) || empty($revenue)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("revenue"));
                }
                $collection= Collection::where(['revenue_id'=>$revenue->id])->exists();
                $fules = RevenueFule::where('revenue_id', $revenue->id)->exists();
                $salary = Salary::where('revenue_id', $revenue->id)->exists();
                $expenses = Expenses::where('revenue_id', $revenue->id)->exists();
                $other_operation = OtherOperation::where('revenue_id', $revenue->id)->exists();
                if($collection || $fules || $salary || $expenses || $other_operation){
                    return backWithError('لحذف الإيرادة يجب حذف كل ما هو مرتبط بها من التحصيلات و الوقود و الرواتب و المصاريف', aurl("revenue"));
                }
                it()->delete('revenue', $id);
                $revenue->delete();
            }
            return redirectWithSuccess(aurl("revenue"), trans('admin.deleted'));
        } else {
            $revenue = revenue::find($data);
            if (is_null($revenue) || empty($revenue)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("revenue"));
            }
            $collection= Collection::where(['revenue_id'=>$revenue->id])->exists();
            $fules = RevenueFule::where('revenue_id', $revenue->id)->exists();
            $salary = Salary::where('revenue_id', $revenue->id)->exists();
            $expenses = Expenses::where('revenue_id', $revenue->id)->exists();
            $other_operation = OtherOperation::where('revenue_id', $revenue->id)->exists();
            if($collection || $fules || $salary || $expenses || $other_operation){
                return backWithError('لحذف الإيرادة يجب حذف كل ما هو مرتبط بها من التحصيلات و الوقود و الرواتب و المصاريف', aurl("revenue"));
            }
            it()->delete('revenue', $data);
            $revenue->delete();
            return redirectWithSuccess(aurl("revenue"), trans('admin.deleted'));
        }
    }

    public function getRevenueByCity(Request $request){
        $revenues= revenue::where('city_id',$request->id)->where('status',1)->orderByDesc('created_at')->get();
        if (isset($revenues)){
            return response()->json(['revenues'=> $revenues],200);
        }
        return response()->json(null,500);
    }


    public function dtPrint(Request $request)
    {
        $data = [];
        if ($request->query('reload') == null) {
            $revenues = revenue::whereBetween('open_date', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
        } else {
            $revenues = revenue::get();
        }

        $i = 1;
        $total = 0;
        foreach($revenues as $revenue){
            $data[] = [
                'الرقم' => $i,
                trans('admin.name') => $revenue->name,
                trans('admin.open_date') => $revenue->open_date,
                trans('admin.total_amount') => $revenue->total_amount,
                trans('admin.city_id') => City::where('id',$revenue->city_id)->first()->name ?? '',
                trans('admin.close_date') => Carbon::parse($revenue->close_date)->format('Y-m-d'),
                trans('admin.created_at') => Carbon::parse($revenue->created_at)->format('Y-m-d'),
                trans('admin.updated_at') => Carbon::parse($revenue->updated_at)->format('Y-m-d'),
            ];
            $i++;
            $total += $revenue->total_amount;
        }

        return view('vendor.datatables.print',[
            'data' => $data,
            'title' => trans('admin.revenue'),
            'totalPrice' => $total,
            'total_name' => trans('admin.total_amount'),
        ]);
    }
}
