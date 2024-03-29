<?php
namespace App\Http\Controllers\Admin;
use App\ActivityLogNoteType;
use App\DataTables\RevenueSalaryDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\SalaryDataTable;
use App\Models\City;
use App\Models\Debt;
use App\Models\Employee;
use App\Models\revenue;
use Carbon\Carbon;
use App\Models\Salary;

use App\Http\Controllers\Validations\SalaryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class SalaryController extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:salary_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:salary_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:salary_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:salary_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}



            /**
             * Baboon Script By [it v 1.6.36]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(SalaryDataTable $salary)
            {
               return $salary->render('admin.salary.index',['title'=>trans('admin.salary')]);
            }
            public function revenueSalary (RevenueSalaryDataTable $salary, $id)
            {
                $revenue = revenue::find($id);
                $city= City::whereId($revenue->city_id)->first();
                $city_name= $city? $city->name : '';
               return $salary->with('id', $id)->render('admin.salary.index',['title'=>trans('admin.salary'). '/(' . $revenue->name . ')/'.$city_name]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create($id)
            {
                $revenue= revenue::whereId($id)->first();
                $revenue_name = $revenue->name;
                $employees= collect();
                if (isset($revenue->city_id)) {
                    $salary_employee_id= Salary::where('revenue_id',$revenue->id)->distinct()->pluck('employee_id');
                    $employees= Employee::where('city_id',$revenue->city_id)->whereNotIn('id',$salary_employee_id)->get();
                }
               return view('admin.salary.create',['title'=>trans('admin.create'). '/(' . $revenue_name . ')'],compact('employees'));
            }

            /**
             * Baboon Script By [it v 1.6.36]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(SalaryRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['admin_id'] = admin()->id();
		  		$salary = Salary::create($data);
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('salary'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.36]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
                $salary =  Salary::find($id);
                $revenue = revenue::find($salary->revenue_id)->name;
                return is_null($salary) || empty($salary)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.salary.show',[
				    'title'=>trans('admin.show').'/('.$revenue.')',
					'salary'=>$salary
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.36]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
          /*  public function edit($id)
            {
        		$salary =  Salary::find($id);
                $revenue = revenue::find($salary->revenue_id)->name;
        		return is_null($salary) || empty($salary)?
        		backWithError(trans("admin.undefinedRecord"),url()->previous()) :
        		view('admin.salary.edit',[
				  'title'=>trans('admin.edit').'/('.$revenue.')',
				  'salary'=>$salary
        		]);
            }*/


            /**
             * Baboon Script By [it v 1.6.36]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new SalaryRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

         /*   public function update(SalaryRequest $request,$id)
            {
              // Check Record Exists
              $salary =  Salary::find($id);
              if(is_null($salary) || empty($salary)){
              	return backWithError(trans("admin.undefinedRecord"),url()->previous());
              }
              $data = $this->updateFillableColumns();
              $data['admin_id'] = admin()->id();
              Salary::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('salary'.$redirect), trans('admin.updated'));
            }*/

            /**
             * Baboon Script By [it v 1.6.36]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
        try {
            DB::beginTransaction();
            // code
            $salary = Salary::find($id);
            if(is_null($salary) || empty($salary)){
                return backWithSuccess(trans('admin.undefinedRecord'),url()->previous());
            }

            it()->delete('salary',$id);
            $this->BackDebtDiscountForEmployee($salary->employee_id, $salary->discount);
            $revenue= revenue::whereId($salary->revenue_id)->first();
            $city_id= $revenue ? $revenue->city_id : null;
            AddNewLog(ActivityLogNoteType::salaries,'حذف راتب لموظف',$salary->salary,
                'delete',$city_id,null,'/revenue-salary/'.$salary->revenue_id);
            $salary->delete();
            // code

            DB::commit();
            return redirectWithSuccess(url()->previous(),trans('admin.deleted'));
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors('لم تتم العملية حدث خطأ ما')->withInput();
        }
	}

	/*public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$salary = Salary::find($id);
				if(is_null($salary) || empty($salary)){
					return backWithError(trans('admin.undefinedRecord'),url()->previous());
				}

				it()->delete('salary',$id);
                $this->BackDebtDiscountForEmployee($salary->employee_id, $salary->discount);
				$salary->delete();
			}
			return redirectWithSuccess(url()->previous(),trans('admin.deleted'));
		}else {
			$salary = Salary::find($data);
			if(is_null($salary) || empty($salary)){
				return backWithError(trans('admin.undefinedRecord'),url()->previous());
			}

			it()->delete('salary',$data);
            $this->BackDebtDiscountForEmployee($salary->employee_id, $salary->discount);
			$salary->delete();
			return redirectWithSuccess( url()->previous(),trans('admin.deleted'));
		}
	}*/

	public function deposit_salary(Request $request){

        try {
            DB::beginTransaction();
            // code
            $status =$this->createSalaryForEmployee($request->id,$request->revenue_id,$request->discount,
                $request->paid_date,$request->note);
            if (!$status[0]){
                return response('لم تتم العملية حدث خطأ ما',422);
            }
            $revenue= revenue::whereId($request->revenue_id)->first();
            $city_id= $revenue ? $revenue->city_id : null;
            AddNewLog(ActivityLogNoteType::salaries,'إيداع راتب جديد لموظف',$status[1],
                'store',$city_id,$request->revenue_id,'/revenue-salary/'.$request->revenue_id);
            // code
            DB::commit();
            return response('تمت عملية إضافة الراتب للموظف بنجاح',200);

        }
        catch (\Exception $exception){
            DB::rollBack();
            return response('لم تتم العملية حدث خطأ ما',422);
        }

    }
    public function createSalaryForEmployee($employee_id,$revenue_id,$discount,$paid_date,$note){
	    $employee = Employee::whereId($employee_id)->first();
	    $discount= $discount && $discount != "NaN"?  $discount : 0;
	    $status= false;
        $salary_amount= 0;
	    if (isset($employee)){
 	        if ($employee->debt() > 0 && is_numeric($discount) && $discount > 0){
            if (!($discount <= $employee->salary && $discount <= $employee->debt())){
                return false;
                }
            }
 	        DB::beginTransaction();
            try {

                $salary =Salary::create([
                    'total_amount'=> $employee->salary,
                    'discount'=> $discount,
                    'salary'=> $employee->salary - $discount,
                    'note'=> $note,
                    'payment_date'=> $paid_date,
                    'employee_id'=> $employee->id,
                    'revenue_id'=> $revenue_id,
                    'admin_id'=> admin()->id()
                ]);
                foreach (Debt::where('employee_id', $employee->id)->where('remainder', '!=', 0)->get() as $item){
                    if ($item->remainder >= $discount){
                        $item->update(['remainder'=> ($item->remainder - $discount)]);
                        break;
                    }
                    else{
                        $discount= $discount - $item->remainder;
                        $item->update(['remainder'=> 0]);
                        if ($discount == 0){
                            break;
                        }
                    }
                }
                DB::commit();
                $status= true;
                $salary_amount= $salary->salary;
            }
            catch (Exception $e){
                DB::rollBack();
            }
        }
	    return [$status,$salary_amount];
    }
    public function BackDebtDiscountForEmployee($employee_id,$discount){

	    //$employee = Employee::whereId($employee_id)->first();
        if ($discount > 0){
            $debts= Debt::where('employee_id', $employee_id)->get();
            foreach ($debts as $item){
                if ($item->remainder == $item->amount){
                    continue;
                }

                $debt_discount= $item->amount - $item->remainder;
                if ($debt_discount >= $discount){

                    $item->update(['remainder'=> ($item->remainder + $discount)]);
                    break;
                }
                else{
                    $discount= $discount - $debt_discount;
                    $item->update(['remainder'=> ($debt_discount+$item->remainder)]);
                    if ($discount == 0){
                        break;
                    }
                }
            }
        }
        return;

    }

}
