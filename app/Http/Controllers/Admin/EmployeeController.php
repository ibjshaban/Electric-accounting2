<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EmployeeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validations\EmployeeRequest;
use App\Http\Requests;
use App\Models\Debt;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use PDF;

// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class EmployeeController extends Controller
{

    public function __construct()
    {

        $this->middleware('AdminRole:employee_show', [
            'only' => ['index', 'show'],
        ]);
        $this->middleware('AdminRole:employee_add', [
            'only' => ['create', 'store'],
        ]);
        $this->middleware('AdminRole:employee_edit', [
            'only' => ['edit', 'update'],
        ]);
        $this->middleware('AdminRole:employee_delete', [
            'only' => ['destroy', 'multi_delete'],
        ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeeDataTable $employee)
    {
        return $employee->render('admin.employee.index', ['title' => trans('admin.employee')]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.employee.create', ['title' => trans('admin.create')]);
    }

    /**
     * Baboon Script By [it v 1.6.36]
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response Or Redirect
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->except("_token", "_method");
        if (request()->hasFile('photo_profile')) {
            $data['photo_profile'] = it()->upload('photo_profile', 'admins');
        } else {
            $data['photo_profile'] = "";
        }
        $employee = Employee::create($data);
        $redirect = isset($request["add_back"]) ? "/create" : "";
        return redirectWithSuccess(aurl('employee' . $redirect), trans('admin.added'));
    }

    /**
     * Display the specified resource.
     * Baboon Script By [it v 1.6.36]
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::withTrashed()->find($id);
        return is_null($employee) || empty($employee) ?
            backWithError(trans("admin.undefinedRecord"), aurl("employee")) :
            view('admin.employee.show', [
                'title' => trans('admin.show'),
                'employee' => $employee
            ]);
    }


    /**
     * Baboon Script By [it v 1.6.36]
     * edit the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::whereId($id)->withTrashed()->first();
        return is_null($employee) || empty($employee) ?
            backWithError(trans("admin.undefinedRecord"), aurl("employee")) :
            view('admin.employee.edit', [
                'title' => trans('admin.edit'),
                'employee' => $employee
            ]);
    }

    public function update(EmployeeRequest $request, $id)
    {
        // Check Record Exists
        $employee = Employee::withTrashed()->find($id);
        if (is_null($employee) || empty($employee)) {
            return backWithError(trans("admin.undefinedRecord"), aurl("employee"));
        }
        $data = $this->updateFillableColumns();
        if (request()->hasFile('photo_profile')) {
            it()->delete($employee->photo_profile);
            $data['photo_profile'] = it()->upload('photo_profile', 'admins');
        }
        unset($data['is_delete']);
        if ($request->is_delete) {
            $data['deleted_at'] = null;
        } else {
            $data['deleted_at'] = now();
        }
        $employee->update($data);
        $redirect = isset($request["save_back"]) ? "/" . $id . "/edit" : "";
        return redirectWithSuccess(aurl('employee' . $redirect), trans('admin.updated'));
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
        foreach (array_keys((new EmployeeRequest)->attributes()) as $fillableUpdate) {
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
        $employee = Employee::find($id);
        if (is_null($employee) || empty($employee)) {
            return backWithSuccess(trans('admin.undefinedRecord'), aurl("employee"));
        }

        it()->delete('employee', $id);
        $employee->delete();
        return redirectWithSuccess(aurl("employee"), trans('admin.deleted'));
    }


    public function multi_delete()
    {
        $data = request('selected_data');
        if (is_array($data)) {
            foreach ($data as $id) {
                $employee = Employee::find($id);
                if (is_null($employee) || empty($employee)) {
                    return backWithError(trans('admin.undefinedRecord'), aurl("employee"));
                }

                it()->delete('employee', $id);
                $employee->delete();
            }
            return redirectWithSuccess(aurl("employee"), trans('admin.deleted'));
        } else {
            $employee = Employee::find($data);
            if (is_null($employee) || empty($employee)) {
                return backWithError(trans('admin.undefinedRecord'), aurl("employee"));
            }

            it()->delete('employee', $data);
            $employee->delete();
            return redirectWithSuccess(aurl("employee"), trans('admin.deleted'));
        }
    }

    public function movementShow($id)
    {
        $salaries = Salary::where('employee_id', $id)
            ->get(['total_amount', 'discount', 'salary', 'note', 'employee_id', 'payment_date', DB::raw("0 as type")])
            ->toBase();
        //dd($salaries[0]->employee_id);
        $debts = Debt::where('employee_id', $id)
            ->get()->map(function ($q) {
                $data = collect();
                $data->total_amount = $q->amount;
                $data->note = $q->note;
                $data->payment_date = $q->created_at->format('Y-m-d');
                $data->type = 1;
                return $data;
            });
        $data = $salaries->merge($debts)->sortBy('payment_date')->reverse();
        return view('admin.employee.movement-show', compact('data', 'salaries'));
    }

    public function pdfview($id)
    {
        $salaries = Salary::where('employee_id', $id)
            ->get(['total_amount', 'discount', 'salary', 'note', 'payment_date', DB::raw("0 as type")])
            ->toBase();
        //dd($salaries);
        $debts = Debt::where('employee_id', $id)
            ->get()->map(function ($q) {
                $data = collect();
                $data->total_amount = $q->amount;
                $data->note = $q->note;
                $data->payment_date = $q->created_at->format('Y-m-d');
                $data->type = 1;
                return $data;
            });
        $data3 = $salaries->merge($debts)->sortBy('payment_date')->reverse();

        $headerHtml = view()->make('admin.employee.header')->render();
        $pdf = PDF::setOption('enable-local-file-access', true)->setOption('header-html', $headerHtml)->loadView('admin.employee.print', ['data' => $data3]);
        return $pdf->download('hello.pdf');
    }

    public function printView(){
        $salaries = Salary::where('employee_id', 12)
            ->get(['total_amount', 'discount', 'salary', 'note', 'payment_date', DB::raw("0 as type")])
            ->toBase();
        //dd($salaries);
        $debts = Debt::where('employee_id', 12)
            ->get()->map(function ($q) {
                $data = collect();
                $data->total_amount = $q->amount;
                $data->note = $q->note;
                $data->payment_date = $q->created_at->format('Y-m-d');
                $data->type = 1;
                return $data;
            });
        $data3 = $salaries->merge($debts)->sortBy('payment_date')->reverse();
        return view('admin.employee.print', ['data' => $data3]);
    }

}
