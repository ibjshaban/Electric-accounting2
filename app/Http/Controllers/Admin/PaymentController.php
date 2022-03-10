<?php
namespace App\Http\Controllers\Admin;
use App\ActivityLogNoteType;
use App\Http\Controllers\Controller;
use App\DataTables\PaymentDataTable;
use App\Models\Filling;
use App\Models\RevenueFule;
use App\Models\Supplier;
use Carbon\Carbon;
use App\Models\Payment;

use App\Http\Controllers\Validations\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class PaymentController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:payment_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:payment_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:payment_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:payment_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(PaymentDataTable $payment , Request $request)
            {
                if ($request->from_date != null && $request->to_date != null || $request->reload != null) {
                    if ($request->from_date != null && $request->to_date != null) {
                        $payments = Payment::whereBetween('created_at', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
                    } else {
                        $payments = Payment::get();
                    }
                    return datatables($payments)
                        ->addIndexColumn()
                        ->addColumn('actions', 'admin.payment.buttons.actions')
                        ->addColumn('supplier_id',function(Payment $payment){
                            return Supplier::where('id',$payment->supplier_id)->first()->name ?? '';
                        })
                        ->addColumn('created_at', '{{ date("Y-m-d H:i:s",strtotime($created_at)) }}')->addColumn('updated_at', '{{ date("Y-m-d H:i:s",strtotime($updated_at)) }}')->addColumn('checkbox', '<div  class="icheck-danger">
                                    <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata{{ $id }}" value="{{ $id }}" >
                                    <label for="selectdata{{ $id }}"></label>
                                    </div>')
                        ->rawColumns(['checkbox', 'actions',])
                        ->make(true);
                }
               return $payment->render('admin.payment.index',['title'=>trans('admin.payment')]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {

               return view('admin.payment.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(PaymentRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();

                try {
                    DB::beginTransaction();
                    $supplier= Supplier::withTrashed()->whereId($data['supplier_id'])->first();
                    $payment = Payment::create($data);
                    $supplier->AddPayments($data['amount']);
                    AddNewLog(ActivityLogNoteType::supplier_payments,'إضافة دفعة سولار جديدة',$data['amount'],'store',null,null,'supplier/'.$payment->supplier_id);
                    DB::commit();
                    $redirect = isset($request["add_back"])?"/payment/create": 'supplier/'.$payment->supplier_id;
                    return redirectWithSuccess(aurl($redirect), trans('admin.added'));

                }
                catch (\Exception $e){
                    DB::rollBack();
                    dd($e);
                    return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
                }
            }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$payment =  Payment::find($id);
        		return is_null($payment) || empty($payment)?
        		backWithError(trans("admin.undefinedRecord"),aurl("payment")) :
        		view('admin.payment.show',[
				    'title'=>trans('admin.show'),
					'payment'=>$payment
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$payment =  Payment::find($id);
        		return is_null($payment) || empty($payment)?
        		backWithError(trans("admin.undefinedRecord"),aurl("payment")) :
        		view('admin.payment.edit',[
				  'title'=>trans('admin.edit'),
				  'payment'=>$payment
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
				foreach (array_keys((new PaymentRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

           /* public function update(PaymentRequest $request,$id)
            {
              // Check Record Exists
              $payment =  Payment::find($id);
              if(is_null($payment) || empty($payment)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("payment"));
              }
                try {
                    DB::beginTransaction();
                    if ($payment->amount != $request->amount){

                        $data = $this->updateFillableColumns();
                        $data['admin_id'] = admin()->id();
                        $data['supplier_id'] = $payment->supplier_id;
                        $supplier= Supplier::withTrashed()->whereId($data['supplier_id'])->first();
                        if ($payment->amount > $data['amount']){
                            $supplier->DeletePaymentsFromFule($payment->amount - $data['amount']);
                        }
                        else{
                            $supplier->AddPayments($data['amount'] - $payment->amount);
                        }

                        Payment::where('id',$id)->update($data);
                    }
                    $redirect = isset($request["save_back"])?"/".$id."/edit":"";
                    DB::commit();
                    return redirectWithSuccess(aurl('supplier/'.$payment->supplier_id.$redirect), trans('admin.updated'));

                }
                catch (\Exception $e){
                    DB::rollBack();
                    return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
                }
            }*/

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$payment = Payment::find($id);
		if(is_null($payment) || empty($payment)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("payment"));
		}

		it()->delete('payment',$id);
        try {
		    DB::beginTransaction();
            Supplier::withTrashed()->whereId($payment->supplier_id)->first()->DeletePaymentsFromFule($payment->amount);
            AddNewLog(ActivityLogNoteType::supplier_payments,'حذف دفعة سولار لمورد',$payment->amount,'delete',null,null,'supplier/'.$payment->supplier_id);
            $payment->delete();
            DB::commit();
            return backWithSuccess(trans('admin.deleted'));

        }
		catch (\Exception $e){
		    DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }

	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
            try {
                DB::beginTransaction();
                foreach($data as $id){
                    $payment = Payment::find($id);
                    if(is_null($payment) || empty($payment)){
                        return backWithError(trans('admin.undefinedRecord'),aurl("payment"));
                    }

                    it()->delete('payment',$id);
                    Supplier::withTrashed()->whereId($payment->supplier_id)->first()->DeletePaymentsFromFule($payment->amount);
                    $payment->delete();
                }
                DB::commit();
                return redirectWithSuccess(aurl("payment"),trans('admin.deleted'));

            }
            catch (\Exception $e){
                DB::rollBack();
                return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
            }

		}else {

			$payment = Payment::find($data);
			if(is_null($payment) || empty($payment)){
				return backWithError(trans('admin.undefinedRecord'),aurl("payment"));
			}

			it()->delete('payment',$data);

            try {
                DB::beginTransaction();
                Supplier::withTrashed()->whereId($payment->supplier_id)->first()->DeletePaymentsFromFule($payment->amount);
                $payment->delete();
                DB::commit();
                return redirectWithSuccess(aurl("payment"),trans('admin.deleted'));

            }
            catch (\Exception $e){
                DB::rollBack();
                return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
            }
		}
	}


    public function dtPrint(Request $request)
    {
        $data = [];
        if ($request->query('reload') == null) {
            $payments = Payment::whereBetween('created_at', [$request->from_date, Carbon::parse($request->to_date)->addDay(1)])->get();
        } else {
            $payments = Payment::get();
        }

        $i = 1;
        $total = 0;
        foreach($payments as $payment){
            $data[] = [
                'الرقم' => $i,
                'المبلغ' => $payment->amount,
                trans('admin.created_at') => Carbon::parse($payment->created_at)->format('Y-m-d'),
                trans('admin.updated_at') => Carbon::parse($payment->updated_at)->format('Y-m-d'),
            ];
            $i++;
            $total += $payment->amount;
        }

        return view('vendor.datatables.print',[
            'data' => $data,
            'title' => trans('admin.payment'),
            'totalPrice' => $total,
            'total_name' => 'المبلغ',
        ]);
    }
}
