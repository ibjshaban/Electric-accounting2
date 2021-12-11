<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CollectionRequest extends FormRequest {

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
             'employee_id'=>'sometimes|nullable|integer',
             'revenue_id'=>'',
             'amount'=>'required|numeric',
             'collection_date'=>'required|after:today',
             'source'=>'sometimes|nullable|string',
             'note'=>'sometimes|nullable|string',
		];
	}

	protected function onUpdate() {
		return [
             'employee_id'=>'sometimes|nullable|integer',
             'revenue_id'=>'',
             'amount'=>'required|numeric',
             'collection_date'=>'required|after:today',
             'source'=>'sometimes|nullable|string',
             'note'=>'sometimes|nullable|string',
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
             'employee_id'=>trans('admin.employee_id'),
             'revenue_id'=>trans('admin.revenue_id'),
             'amount'=>trans('admin.amount'),
             'collection_date'=>trans('admin.collection_date'),
             'source'=>trans('admin.source'),
             'note'=>trans('admin.note'),
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
