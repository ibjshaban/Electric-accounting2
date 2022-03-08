<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CollectionDataTable;
use App\DataTables\RevenueCollectionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\CollectionRequest;
use App\Models\Collection;
use App\Models\Employee;
use App\Models\revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class CollectionController extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:collection_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:collection_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:collection_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:collection_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(CollectionDataTable $collection, Request $request)
    {
        if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
            if ($request->from_date != null && $request->to_date != null) {
                $debts = Collection::whereBetween('collection_date', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
            } else {
                $debts = Collection::get();
            }
            return datatables($debts)
                ->addIndexColumn()
                ->addColumn('actions', 'admin.collection.buttons.actions')
                ->addColumn('employee_id', function (Collection $collection) {
                    return Employee::where('id', $collection->employee_id)->first()->name ?? '';
                })
                ->addColumn('revenue_id', function (Collection $collection) {
                    return revenue::where('id', $collection->revenue_id)->first()->name ?? '';
                })
                ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')
                ->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')
                ->addColumn('checkbox', '<div  class="icheck-success">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" onclick="change_status({{$id}})" {{$status  ? "checked" : ""}}>
                  <label for="selectdata{{ $id }}"></label>
                </div>')
                ->rawColumns(['checkbox', 'actions',])
                ->make(true);
        }
        return $collection->render('admin.collection.index', ['title' => trans('admin.collection')]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.collection.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(CollectionRequest $request)
    {
        $data = $request->except("_token", "_method");
        if ($data['collect_type'] == '0') {
            $data['source'] = null;
        } else {
            $data['employee_id'] = null;
        }
        unset($data['collect_type']);
        $collection = Collection::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('collection' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collection = Collection::find($id);
        return is_null($collection) || empty($collection) ?
            backWithError(trans("admin.undefinedRecord"), aurl("collection")) :
            view('admin.collection.show', [
                'title' => trans('admin.show'),
                'collection' => $collection
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collection = Collection::find($id);
        return is_null($collection) || empty($collection) ?
            backWithError(trans("admin.undefinedRecord"), aurl("collection")) :
            view('admin.collection.edit', [
                'title' => trans('admin.edit'),
                'collection' => $collection
            ]);
    }

    public function update(CollectionRequest $request, $id)
    {
        // Check Record Exists
        $collection = Collection::find($id);
        if (is_null($collection) || empty($collection)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("collection"));
        }
        $data = $this->updateFillableColumns();
        if ($data['collect_type'] == '0') {
            $data['source'] = null;
        } else {
            $data['employee_id'] = null;
        }
        unset($data['collect_type']);
        Collection::where('id', $id)->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('collection' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new CollectionRequest)->attributes()) as $fillableUpdate) {
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
        $collection = Collection::find($id);
        if (is_null($collection) || empty($collection)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("revenue-collection/" . $collection->revenue_id));
        }

        it()->delete('collection', $id);
        $collection->delete();
        return redirectWithSuccess(aurl("revenue-collection/" . $collection->revenue_id), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $collection = Collection::find($id);
                if (is_null($collection) || empty($collection)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("revenue-collection/" . $collection->revenue_id));
                }

                it()->delete('collection', $id);
                $collection->delete();
            }
            return redirectWithSuccess(aurl("revenue-collection/" . $collection->revenue_id), trans('admin.deleted'));
        } else {
            $collection = Collection::find($data);
            if (is_null($collection) || empty($collection)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("revenue-collection/" . $collection->revenue_id));
            }

            it()->delete('collection', $data);
            $collection->delete();
            return redirectWithSuccess(aurl("revenue-collection/" . $collection->revenue_id), trans('admin.deleted'));
        }
    }

    //***********
    //Show expenses for one revenue
    public function revenueCollection(RevenueCollectionDataTable $collection, $id)
    {
        $revenue = revenue::find($id);
        $revenue_name = $revenue->name;
        return $collection->with('id', $id)->render('admin.collection.index', ['title' => trans('admin.collection') . '/(' . $revenue_name . ')']);
    }

    public function revenueCollectionCreate($id)
    {
        $revenue = revenue::find($id)->name;
        $collection = revenue::find($id);
        $revenue_total_amount= revenue::whereId($id)->first()->total_amount;
        $sum_employee_collection= Collection::where(['revenue_id'=>$id])->whereNotNull('employee_id')->sum('amount');
        $remain_total= $revenue_total_amount - $sum_employee_collection;
        return view('admin.collection.revenue-collection.create', ['title' => trans('admin.create') . '/(' . $revenue . ')', 'collection' => $collection,'remain_total'=> $remain_total]);
    }

    //Create collection by one revenue
    public function revenueCollectionStore(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required',
            'collection_date' => 'required',
            'note' => 'nullable',
        ]);
        $data = $request->except("_token", "_method");
        $data['revenue_id'] = $id;
        $revenue_total_amount= revenue::whereId($id)->first()->total_amount;
        $sum_request_amount= 0;
        for ($i = 0; $i < count($data['amount'] ?? []); $i++){
            if ($data['employee_id'][$i]){
                $sum_request_amount += $data['amount'][$i];
            }
        }
        $sum_employee_collection= Collection::where(['revenue_id'=>$id])->whereNotNull('employee_id')->sum('amount');
        $remain_total= $revenue_total_amount - $sum_employee_collection;
        if ($revenue_total_amount > $sum_employee_collection){
            if ($remain_total >= $sum_request_amount){
                for ($i = 0; $i < count($data['amount'] ?? []); $i++) {
                    if ($data['employee_id'][$i] == "" && $data['source'][$i] == "") {
                        return redirectWithError(aurl('revenue-collection/' . $id . '/create'), 'ادخل احدى القيمتان (الموظف او المحصل)');
                    } elseif ($data['employee_id'][$i] != '' && $data['source'][$i] != '') {
                        return redirectWithError(aurl('revenue-collection/' . $id . '/create'), 'لا يمكن ادخال القيمتان (الموظف و المحصل) معاً');
                    }

                    Collection::create([
                        'employee_id' => $data['employee_id'][$i],
                        'source' => $data['source'][$i],
                        'amount' => InsertLargeNumber($data['amount'][$i], 2),
                        'collection_date' => $data['collection_date'][$i],
                        'note' => $data['note'][$i],
                        'revenue_id' => $data['revenue_id'],
                    ]);
                }
                $redirect = isset($request["add_back"]) ? "/create" : "";
                return redirectWithSuccess(aurl('revenue-collection/' . $id . $redirect), trans('admin.added'));
            }
        }
        return redirectWithError(aurl('revenue-collection/' . $id.'/create'), $remain_total.'مجموع التحصيلات المدخلة أكبر من المبلغ المطلوب للمجموعة, المبلغ المتبقي لتحصيل مبلغ المجموعة يساوي ')->withInput();

    }

    public function revenueCollectionEdit($id)
    {
        $collection = Collection::find($id);
        $collections = Collection::all();
        $revenue = revenue::find($collection->revenue_id)->name;
        return view('admin.collection.revenue-collection.edit', ['title' => trans('admin.edit') . '/(' . $revenue . ')', 'collection' => $collection, 'collections' => $collections]);
    }

    //Edit collection by one revenue
    public function revenueCollectionUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'amount' => 'required',
            'collection_date' => 'required',
            'note' => 'nullable',
        ]);

        // Check Record Exists
        $collection = Collection::find($id);
        $revenu_id = $collection->revenue_id;
        if (is_null($collection) || empty($collection)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("revenue-collection"));
        }

        $data = $request->except("_token", "_method", "save");
        if ($data['employee_id'] == "" && $data['source'] == "") {
            return redirectWithError(aurl('revenue-collection/' . $id . '/edit'), 'ادخل احدى القيمتان (الموظف او المحصل)');
        } elseif ($data['employee_id'] != '' && $data['source'] != '') {
            return redirectWithError(aurl('revenue-collection/' . $id . '/edit'), 'لا يمكن ادخال القيمتان (الموظف و المحصل) معاً');
        }
        Collection::where('id', $id)->update($data);
        /*for ($i = 1; $i < count($data['amount'] ?? []); $i++) {

            Collection::where('id',55)->update([
                'employee_id' => $data['employee_id'][$i],
                'source' => $data['source'][$i],
                'amount' => InsertLargeNumber($data['amount'][$i], 2),
                'collection_date' => $data['collection_date'][$i],
                'note' => $data['note'][$i],
            ]);
            //DB::table('collections')->update([$data]);
        }*/
        $redirect = isset($request["save_back"]) ? "/" . $collection->revenue_id . "/edit" : "";
        return redirectWithSuccess(aurl('revenue-collection/' . $collection->revenue_id . $redirect), trans('admin.updated'));
    }

    public function change_status(Request $request)
    {
        $status = $request->status == 'false' ? 0 : 1;
        Collection::whereId($request->id)->first()->update(['status' => $status]);
        return response()->json(null, 200);
    }


}
