<?php
namespace App\Http\Controllers\Admin;
use App\DataTables\BasicParentsDataTable;
use App\DataTables\PaymentsDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\WithdrawalsDataTable;
use App\Http\Controllers\Validations\BasicParentsRequest;
use App\Models\BasicParent;
use Carbon\Carbon;
use App\Models\WithdrawalsPayments;

use App\Http\Controllers\Validations\WithdrawalsPaymentsRequest;
use Illuminate\Validation\Rule;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class WithdrawalsPaymentsController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:withdrawals_show', [
			'only' => ['index_withdrawals', 'show_withdrawals'],
		]);
		$this->middleware('AdminRole:withdrawals_add', [
			'only' => ['create_withdrawals', 'store_withdrawals'],
		]);
		$this->middleware('AdminRole:withdrawals_edit', [
			'only' => ['edit_withdrawals', 'update_withdrawals'],
		]);
		$this->middleware('AdminRole:withdrawals_delete', [
			'only' => ['destroy_withdrawals', 'multi_delete_withdrawals'],
		]);

        $this->middleware('AdminRole:payments_show', [
            'only' => ['index_payments', 'show_payments'],
        ]);
        $this->middleware('AdminRole:payments_add', [
            'only' => ['create_payments', 'store_payments'],
        ]);
        $this->middleware('AdminRole:payments_edit', [
            'only' => ['edit_payments', 'update_payments'],
        ]);
        $this->middleware('AdminRole:payments_delete', [
            'only' => ['destroy_payments', 'multi_delete_payments'],
        ]);
	}
            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index_withdrawals(WithdrawalsDataTable $withdrawals)
            {
               return $withdrawals->render('admin.withdrawalspayments.index',['title'=> 'مسحوبات شخصية']);
            }
            public function index_payments(PaymentsDataTable $payments)
            {
               return $payments->render('admin.withdrawalspayments.index',['title'=> 'دفعات التجار']);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create_withdrawals()
            {

                    return view('admin.withdrawalspayments.create',['title'=>trans('admin.create')]);
            }

            public function create_payments()
            {
                    return view('admin.withdrawalspayments.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store_withdrawals(WithdrawalsPaymentsRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
                $data['parent_id']= $request->route('parent_id');
		  		$withdrawalspayments = WithdrawalsPayments::create($data);
		  		$url= 'withdrawals/'.$request->parent_id;
                $redirect = isset($request["add_back"])? '/basicparents/'.$url.'/create': $url;
                return redirectWithSuccess(aurl($redirect), trans('admin.added')); }

            public function store_payments(WithdrawalsPaymentsRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
                $data['parent_id']= $request->route('parent_id');
		  		$withdrawalspayments = WithdrawalsPayments::create($data);
		  		$url= 'payments/'.$request->parent_id;
                $redirect = isset($request["add_back"])? '/basicparents/'.$url.'/create': $url;
                return redirectWithSuccess(aurl($redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show_withdrawals($id)
            {
        		$withdrawalspayments =  WithdrawalsPayments::find($id);
        		return is_null($withdrawalspayments) || empty($withdrawalspayments)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.withdrawalspayments.show',[
				    'title'=>trans('admin.show'),
					'withdrawalspayments'=>$withdrawalspayments
        		]);
            }
            public function show_payments($id)
            {
        		$withdrawalspayments =  WithdrawalsPayments::find($id);
        		return is_null($withdrawalspayments) || empty($withdrawalspayments)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.withdrawalspayments.show',[
				    'title'=>trans('admin.show'),
					'withdrawalspayments'=>$withdrawalspayments
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit_withdrawals($id)
            {
        		$withdrawalspayments =  WithdrawalsPayments::find($id);

        		return is_null($withdrawalspayments) || empty($withdrawalspayments)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.withdrawalspayments.edit',[
				  'title'=>trans('admin.edit'),
				  'withdrawalspayments'=>$withdrawalspayments
        		]);
            }

            public function edit_payments($id)
            {
        		$withdrawalspayments =  WithdrawalsPayments::find($id);
        		return is_null($withdrawalspayments) || empty($withdrawalspayments)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.withdrawalspayments.edit',[
				  'title'=>trans('admin.edit'),
				  'withdrawalspayments'=>$withdrawalspayments
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new WithdrawalsPaymentsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update_withdrawals(WithdrawalsPaymentsRequest $request,$id)
            {
              // Check Record Exists
              $withdrawalspayments =  WithdrawalsPayments::find($id);
              if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("withdrawals"));
              }
              $data = $this->updateFillableColumns();
              $data['admin_id'] = admin()->id();
              $withdrawalspayments->update($data);
              $redirect = isset($request["save_back"])?"/withdrawals/".$id."/edit": 'withdrawals';
              return redirectWithSuccess(aurl($redirect), trans('admin.updated'));
            }
            public function update_payments(WithdrawalsPaymentsRequest $request,$id)
            {
              // Check Record Exists
              $withdrawalspayments =  WithdrawalsPayments::find($id);
              if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("payments"));
              }
              $data = $this->updateFillableColumns();
              $data['admin_id'] = admin()->id();
              $withdrawalspayments->update($data);
              $redirect = isset($request["save_back"])?"/payments/".$id."/edit": 'payments';
              return redirectWithSuccess(aurl($redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */

            public function destroy_withdrawals($id){
                $withdrawalspayments = WithdrawalsPayments::find($id);
                if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
                    return backWithSuccess(trans('admin.undefinedRecord'),aurl("withdrawals"));
                }
                $parent_id= $withdrawalspayments->parent_id;
                it()->delete('withdrawalspayments',$id);
                $withdrawalspayments->delete();
                return redirectWithSuccess(aurl("withdrawals/".$parent_id),trans('admin.deleted'));
            }
            public function destroy_payments($id){
                $withdrawalspayments = WithdrawalsPayments::find($id);
                if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
                    return backWithSuccess(trans('admin.undefinedRecord'),aurl("payments"));
                }
                $parent_id= $withdrawalspayments->parent_id;
                it()->delete('withdrawalspayments',$id);
                $withdrawalspayments->delete();
                return redirectWithSuccess(aurl("payments/".$parent_id),trans('admin.deleted'));
            }

            public function multi_delete_withdrawals(){
                $data = request('selected_data');
                if(is_array($data)){
                    foreach($data as $id){
                        $withdrawalspayments = WithdrawalsPayments::find($id);
                        if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
                            return backWithError(trans('admin.undefinedRecord'),url()->previous());
                        }

                        it()->delete('withdrawalspayments',$id);
                        $withdrawalspayments->delete();
                    }
                    return redirectWithSuccess(aurl("withdrawals"),trans('admin.deleted'));
                }else {
                    $withdrawalspayments = WithdrawalsPayments::find($data);
                    if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
                        return backWithError(trans('admin.undefinedRecord'),aurl("withdrawals"));
                    }

                    it()->delete('withdrawalspayments',$data);
                    $withdrawalspayments->delete();
                    return redirectWithSuccess(aurl("withdrawals"),trans('admin.deleted'));
                }
            }
            public function multi_delete_payments(){
                $data = request('selected_data');
                if(is_array($data)){
                    foreach($data as $id){
                        $withdrawalspayments = WithdrawalsPayments::find($id);
                        if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
                            return backWithError(trans('admin.undefinedRecord'),aurl("payments"));
                        }

                        it()->delete('withdrawalspayments',$id);
                        $withdrawalspayments->delete();
                    }
                    return redirectWithSuccess(aurl("payments"),trans('admin.deleted'));
                }else {
                    $withdrawalspayments = WithdrawalsPayments::find($data);
                    if(is_null($withdrawalspayments) || empty($withdrawalspayments)){
                        return backWithError(trans('admin.undefinedRecord'),aurl("payments"));
                    }

                    it()->delete('withdrawalspayments',$data);
                    $withdrawalspayments->delete();
                    return redirectWithSuccess(aurl("payments"),trans('admin.deleted'));
                }
            }

    // -------------------- Startup basic -----------------------------------------//
    public function indexStartup(BasicParentsDataTable $basicparents)
    {
        $currentRoute = \Route::current()->uri;
        $item = CheckParentRoute($currentRoute);
        $title = CheckParentTitle($currentRoute);
        return $basicparents->with('item', $item)->render('admin.basicparents.index', ['title' => $title]);
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
