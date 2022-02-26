<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\AdminsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\AdminsRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [It V 1.5.0 | https://it.phpanonymous.com]
// Copyright Reserved  [It V 1.5.0 | https://it.phpanonymous.com]
class Admins extends Controller {

	public function __construct() {

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
	public function index(AdminsDataTable $admins) {
		return $admins->render('admin.admins.index', ['title' => trans('admin.admins')]);
	}

	/**
	 * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
	 * Show the form for creating a new resource.
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.admins.create', ['title' => trans('admin.create')]);
	}

	/**
	 * Baboon Script By [It V 1.5.0 | https://it.phpanonymous.com]
	 * Store a newly created resource in storage.
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response Or Redirect
	 */
	public function store(AdminsRequest $request) {

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

            if (!admin()->user()->role('admins_log')){
                $queries= DB::getQueryLog();
                foreach ($queries as $index=>$query){
                    $t =vsprintf(str_replace('?', '%s', $query['query']), collect($query['bindings'])->map(function ($binding) {
                        $binding = addslashes($binding);
                        return is_numeric($binding) ? $binding : "'{$binding}'";
                    })->toArray());
                    $queries[$index] = $t;
                }
                DB::rollBack();
                $status=AddNewLog('إضافة مسؤول جديد',$queries,admin()->id(),'store','admins',null,$data);
                if ($status){
                    DB::commit();
                    return redirectWithSuccess(aurl('admins'), trans('admin.logged'));
                }
                DB::rollBack();
                return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
            }
            DB::commit();
            return redirectWithSuccess(aurl('admins'), trans('admin.added'));
        }
        catch (\Exception $exception){
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
	public function show($id) {
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
	public function edit($id) {
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
	public function updateFillableColumns() {
		$fillableCols = [];
		foreach (array_keys((new AdminsRequest)->attributes()) as $fillableUpdate) {
			if (!is_null(request($fillableUpdate))) {
				$fillableCols[$fillableUpdate] = request($fillableUpdate);
			}
		}
		return $fillableCols;
	}

	public function update(AdminsRequest $request, $id) {

        try {
            DB::beginTransaction();
            DB::enableQueryLog();
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
            if (!admin()->user()->role('admins_log')){
                $queries= DB::getQueryLog();
                foreach ($queries as $index=>$query){
                    $t =vsprintf(str_replace('?', '%s', $query['query']), collect($query['bindings'])->map(function ($binding) {
                        $binding = addslashes($binding);
                        return is_numeric($binding) ? $binding : "'{$binding}'";
                    })->toArray());
                    $queries[$index] = $t;
                }
                DB::rollBack();
                $status= AddNewLog('تعديل مسؤول',$queries,admin()->id(),'update','admins',$id,$data);
                if ($status){
                    DB::commit();
                    return redirectWithSuccess(aurl('admins'), trans('admin.logged'));
                }
                DB::rollBack();
                return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
            }
            DB::commit();
            return redirectWithSuccess(aurl('admins'), trans('admin.updated'));
        }
        catch (\Exception $exception){
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
	public function destroy($id) {

        try {
            DB::beginTransaction();
            DB::enableQueryLog();
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
            if (!admin()->user()->role('admins_log')){
                $queries= DB::getQueryLog();
                foreach ($queries as $index=>$query){
                    $t =vsprintf(str_replace('?', '%s', $query['query']), collect($query['bindings'])->map(function ($binding) {
                        $binding = addslashes($binding);
                        return is_numeric($binding) ? $binding : "'{$binding}'";
                    })->toArray());
                    $queries[$index] = $t;
                }
                DB::rollBack();
                $status= AddNewLog('حذف مسؤول',$queries,admin()->id(),'delete','admins',$id,null);
                if ($status){
                    DB::commit();
                    return redirectWithSuccess(aurl('admins'), trans('admin.logged'));
                }
                DB::rollBack();
                return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
            }
            DB::commit();
            return backWithSuccess(trans('admin.deleted'));

        }
        catch (\Exception $exception){
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

}
