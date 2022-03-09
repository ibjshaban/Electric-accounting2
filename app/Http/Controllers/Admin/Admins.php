<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\AdminsRequest;
use App\Models\Admin;
use App\Models\AdminGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [It V 1.5.0 | https://it.phpanonymous.com]
// Copyright Reserved  [It V 1.5.0 | https://it.phpanonymous.com]
class Admins extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:admins_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:admins_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:admins_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:admins_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }

    /**
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
            if ($request->from_date != null && $request->to_date != null) {
                $admins = Admin::where('created_at', '>=', $request->from_date)->where('created_at', '<=', Carbon::parse($request->to_date)->addDay(1))->get();
            } else {
                $admins = Admin::get();
            }
            return datatables($admins)
                ->addIndexColumn()
                ->addColumn('group_name', function (Admin $admin) {
                    return AdminGroup::where('id', $admin->group_id)->first()->group_name;
                })
                ->addColumn('actions', 'admin.admins.buttons.actions')
                ->addColumn('photo_profile', '{!! view("admin.show_image",["image"=>$photo_profile])->render() !!}')
                ->addColumn('checkbox', '<div  class="icheck-danger">
                        <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata" value="{{ $id }}" >
                        <label for="selectdata"></label>
                        </div>')
                ->rawColumns(['checkbox', 'actions', 'photo_profile'])
                ->make(true);
        }
        $admins = new AdminsDataTable();
        return $admins->with(['printTitle' => trans('admin.admins')])->render('admin.admins.index', ['title' => trans('admin.admins')]);
    }

    /**
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(AdminsRequest $request)
    {

        try {
            DB::beginTransaction();
            DB::enableQueryLog();
            // code
            $data = $request->except("_token", "_method");
            if (request()->hasFile('photo_profile')) {
                $data['photo_profile'] = it()->upload('photo_profile', 'admins');
            } else {
                $data['photo_profile'] = "";
            }
            $data['password'] = bcrypt(request('password'));
            Admin::create($data);
            // code


            DB::commit();
            return redirectWithSuccess(aurl('admins'), trans('admin.added'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admins = Admin::find($id);
        return is_null($admins) || empty($admins) ?
            backWithError(trans("admin.undefinedRecord")) :
            view('admin.admins.show', [
                'title' => trans('admin.show'),
                'admins' => $admins,
            ]);
    }

    /**
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admins = Admin::find($id);
        return is_null($admins) || empty($admins) ?
            backWithError(trans("admin.undefinedRecord")) :
            view('admin.admins.edit', [
                'title' => trans('admin.edit'),
                'admins' => $admins,
            ]);
    }

    /**
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * update a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFillableColumns()
    {
        $fillableCols = [];
        foreach (array_keys((new AdminsRequest)->attributes()) as $fillableUpdate) {
            if (!is_null(request($fillableUpdate))) {
                $fillableCols[$fillableUpdate] = request($fillableUpdate);
            }
        }
        return $fillableCols;
    }

    public function update(AdminsRequest $request, $id)
    {

        try {
            DB::beginTransaction();
            // code
            $admins = Admin::find($id);
            if (is_null($admins) || empty($admins)) {
                return backWithError(trans("admin.undefinedRecord"));
            }
            $data = $this->updateFillableColumns();
            if (!empty(request('password'))) {
                $data['password'] = bcrypt(request('password'));
            }

            if (request()->hasFile('photo_profile')) {
                it()->delete($admins->photo_profile);
                $data['photo_profile'] = it()->upload('photo_profile', 'admins');
            }
            Admin::where('id', $id)->update($data);
            // code

            DB::commit();
            return redirectWithSuccess(aurl('admins'), trans('admin.updated'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }
    }

    /**
     * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
     * destroy a newly created resource in storage.
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            DB::beginTransaction();
            // code
            $admins = Admin::find($id);
            if (is_null($admins) || empty($admins)) {
                return backWithError(trans('admin.undefinedRecord'));
            }
            if (!empty($admins->photo_profile)) {
                it()->delete($admins->photo_profile);
            }
            $admins->delete();
            // code
            
            DB::commit();
            return backWithSuccess(trans('admin.deleted'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }
    }

    /*public function multi_delete() {



		$data = request('selected_data');
		if (is_array($data)) {
			foreach ($data as $id) {
				$admins = Admin::find($id);
				if (is_null($admins) || empty($admins)) {
					return backWithError(trans('admin.undefinedRecord'));
				}
				if (!empty($admins->photo_profile)) {
					it()->delete($admins->photo_profile);
				}

				$admins->delete();

			}
			return backWithSuccess(trans('admin.deleted'));
		} else {
			$admins = Admin::find($data);
			if (is_null($admins) || empty($admins)) {
				return backWithError(trans('admin.undefinedRecord'));
			}

			if (!empty($admins->photo_profile)) {
				it()->delete($admins->photo_profile);
			}

			$admins->delete();
			return backWithSuccess(trans('admin.deleted'));
		}
	}*/

    public function dtPrint(Request $request)
    {
        $data = [];
        if ($request->query('reload') == null) {
            $admins = Admin::where('created_at', '>=', $request->query('from_date'))->where('created_at', '<=', Carbon::parse($request->query('to_date'))->addDay(1))->get();
        } else {
            $admins = Admin::all();
        }

        $i = 1;
        foreach($admins as $admin){
            $data[] = [
                'الرقم' => $i,
                'البيان' => $admin->name,
                'الصورة الشخصية' => '',
                'الجوال' => $admin->mobile,
                'مجموعة المشرفين' => AdminGroup::where('id',$admin->group_id)->first()->group_name
            ];
            $i++;
        }

        return view('vendor.datatables.print',[
            'data' => $data,
            'title' => trans('admin.admins'),
        ]);
    }
}
