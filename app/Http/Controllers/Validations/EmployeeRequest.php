<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRequest extends FormRequest {

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
             'name'=>'required|string',
             'id_number'=>'nullable|integer',
             'address'=>'nullable|string',
             'phone'=>'nullable|string',
             'type_id'=>'required|integer',
             'city_id'=>'required|integer',
             'salary'=>'required|numeric',
		];
	}

	protected function onUpdate() {
		return [
             'name'=>'required|string',
             'id_number'=>'nullable|integer',
             'address'=>'nullable|string',
             'phone'=>'nullable|string',
             'type_id'=>'required|integer',
             'city_id'=>'required|integer',
             'salary'=>'required|numeric',
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
             'name'=>trans('admin.name'),
             'id_number'=>trans('admin.id_number'),
             'address'=>trans('admin.address'),
             'phone'=>trans('admin.phone'),
             'type_id'=>trans('admin.type_id'),
             'city_id'=>trans('admin.city_id'),
             'salary'=>trans('admin.salary'),
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
