<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SalaryRequest extends FormRequest {

	/**
	 * Baboon Script By [it v 1.6.36]
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Baboon Script By [it v 1.6.36]
	 * Get the validation rules that apply to the request.
	 *
	 * @return array (onCreate,onUpdate,rules) methods
	 */
	protected function onCreate() {
		return [
             'total_amount'=>'required|numeric',
             'discount'=>'required|numeric',
             'salary'=>'required|numeric',
             'note'=>'nullable|string',
             'payment_date'=>'required',
             'employee_id'=>'required|integer',
		];
	}


	protected function onUpdate() {
		return [
             'total_amount'=>'required|numeric',
             'discount'=>'required|numeric',
             'salary'=>'required|numeric',
             'note'=>'nullable|string',
             'payment_date'=>'required',
             'employee_id'=>'required|integer',
		];
	}

	public function rules() {
		return request()->isMethod('put') || request()->isMethod('patch') ?
		$this->onUpdate() : $this->onCreate();
	}


	/**
	 * Baboon Script By [it v 1.6.36]
	 * Get the validation attributes that apply to the request.
	 *
	 * @return array
	 */
	public function attributes() {
		return [
             'total_amount'=>trans('admin.total_amount'),
             'discount'=>trans('admin.discount'),
             'salary'=>trans('admin.salary'),
             'note'=>trans('admin.note'),
             'payment_date'=>trans('admin.payment_date'),
             'employee_id'=>trans('admin.employee_id'),
		];
	}

	/**
	 * Baboon Script By [it v 1.6.36]
	 * response redirect if fails or failed request
	 *
	 * @return redirect
	 */
	public function response(array $errors) {
		return $this->ajax() || $this->wantsJson() ?
		response([
			'status' => false,
			'StatusCode' => 422,
			'StatusType' => 'Unprocessable',
			'errors' => $errors,
		], 422) :
		back()->withErrors($errors)->withInput(); // Redirect back
	}



}
