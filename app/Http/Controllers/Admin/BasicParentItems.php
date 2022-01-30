<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BasicParentItemsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\BasicParentItemsRequest;
use App\Models\BasicParent;
use App\Models\BasicParentItem;
use App\Models\SubItem;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class BasicParentItems extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:basicparentitems_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:basicparentitems_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:basicparentitems_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:basicparentitems_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(BasicParentItemsDataTable $basicparentitems)
    {
        return $basicparentitems->render('admin.basicparentitems.index', ['title' => trans('admin.basicparentitems')]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $basicparent = BasicParent::find($id);
        return view('admin.basicparentitems.create', ['title' => $basicparent->name . '/' . trans('admin.create'), 'id' => $id, 'basicparent' => $basicparent]);
    }

    /**
     * Baboon Script By [it v 1.6.37]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(BasicParentItemsRequest $request, $id)
    {
        $data = $request->except("_token", "_method");
        DB::beginTransaction();
        $parentItem_price = 0;
        try {
            $parentItem = new BasicParentItem();
            $parentItem->name = $data['name'];
            $parentItem->date = $data['date'];
            $parentItem->discount = $data['discount'];
            $parentItem->price = 0;
            $parentItem->amount = 0;
            $parentItem->basic_id = $id;
            $parentItem->save();

            for ($i = 0; $i < count($data['price'] ?? []); $i++) {
                SubItem::create([
                    'price' => InsertLargeNumber($data['price'][$i]),
                    'amount' => InsertLargeNumber($data['amount'][$i]),
                    'note' => $data['note'][$i],
                    'parent_item_id' => $parentItem->id,
                ]);
                $parentItem_price += ($data['price'][$i] * $data['amount'][$i]);
            }
            $parentItem->update(['price' => InsertLargeNumber(($parentItem_price- $parentItem->discount))]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return backWithError($e);

        }
/*        for ($i = 0; $i < count($data['name'] ?? []); $i++) {
            if ($parent->item != '2') {
                BasicParentItem::create([
                    'name' => $data['name'][$i],
                    'price' => InsertLargeNumber($data['price'][$i], 2),
                    'discount' => InsertLargeNumber($data['discount'][$i], 2),
                    'amount' => $data['amount'][$i],
                    'date' => $data['date'][$i],
                    'note' => $data['note'][$i],
                    'basic_id' => $id,
                ]);
            } else {
                BasicParentItem::create([
                    'name' => $data['name'][$i],
                    'price' => InsertLargeNumber($data['price'][$i], 2),
                    'date' => $data['date'][$i],
                    'note' => $data['note'][$i],
                    'basic_id' => $id,
                ]);
            }

        }*/
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('basicparents/' . $id . '' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.37]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $basicparentitems = BasicParentItem::find($id);
       //$parent_item = BasicParent::where('id', $basicparentitems->basic_id)->first();
        return is_null($basicparentitems) || empty($basicparentitems) ?
            backWithError(trans("admin.undefinedRecord"), aurl("basicparentitems")) :
            view('admin.basicparentitems.show', ['title' => trans('admin.show'), 'basicparentitems' => $basicparentitems]);
    }


    /**
     * Baboon Script By [it v 1.6.37]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $basicparentitems = BasicParentItem::find($id);
        $basicparent = BasicParent::where('id', $basicparentitems->basic_id)->first();
        return is_null($basicparentitems) || empty($basicparentitems) ?
            backWithSuccess(trans("admin.undefinedRecord")) :
            view('admin.basicparentitems.edit', [
                'title' => $basicparent->name . '/' . trans('admin.edit'),
                'basicparentitems' => $basicparentitems,
                'basicparent' => $basicparent
            ]);
    }

    public function update(BasicParentItemsRequest $request, $id)
    {
        $parentItem = BasicParentItem::find($id);
        $data = $request->except("_token", "_method");
        DB::beginTransaction();
        $parentItem_price = 0;
        try {
            $parentItem->name = $data['name'];
            $parentItem->date = $data['date'];
            $parentItem->discount = $data['discount'];
//            $parentItem->price = 0;
//            $parentItem->amount = 0;
            $parentItem->save();
            SubItem::where('parent_item_id', $parentItem->id)->delete();

            for ($i = 0; $i < count($data['price'] ?? []); $i++) {
                SubItem::create([
                    'price' => InsertLargeNumber($data['price'][$i]),
                    'amount' => InsertLargeNumber($data['amount'][$i]),
                    'note' => $data['note'][$i],
                    'parent_item_id' => $parentItem->id,
                ]);
                $parentItem_price += ($data['price'][$i] * $data['amount'][$i]);
            }
            $parentItem->update(['price' => InsertLargeNumber(($parentItem_price- $parentItem->discount))]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return backWithError($e);

        }
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('basicparents/' . $parentItem->basic_id . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new BasicParentItemsRequest)->attributes()) as $fillableUpdate) {
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
        $basicparentitems = BasicParentItem::find($id);
        $basicparents_id = BasicParent::where('id', $basicparentitems->basic_id)->first()->id;

        if (is_null($basicparentitems) || empty($basicparentitems)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("basicparents/" . $basicparents_id));
        }

        it()->delete('basicparentitem', $id);
        $basicparentitems->delete();
        return redirectWithSuccess(aurl("basicparents/" . $basicparents_id), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $basicparentitems = BasicParentItem::find($id);
                $basicparents_id = BasicParent::where('id', $basicparentitems->basic_id)->first()->id;
                if (is_null($basicparentitems) || empty($basicparentitems)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("basicparents/" . $basicparents_id));
                }

                it()->delete('basicparentitem', $id);
                $basicparentitems->delete();
            }
            return redirectWithSuccess(aurl("basicparents/" . $basicparents_id), trans('admin.deleted'));
        } else {
            $basicparentitems = BasicParentItem::find($data);
            $basicparents_id = BasicParent::where('id', $basicparentitems->basic_id)->first(['id'])->id;
            if (is_null($basicparentitems) || empty($basicparentitems)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("basicparents/" . $basicparents_id));
            }

            it()->delete('basicparentitem', $data);
            $basicparentitems->delete();
            return redirectWithSuccess(aurl("basicparents/" . $basicparents_id), trans('admin.deleted'));
        }
    }


}
