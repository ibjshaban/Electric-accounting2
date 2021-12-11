<?php
namespace App\Http\Controllers\ValidationsApi\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FillingRequest extends FormRequest {

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
             'quantity'=>'required|numeric',
             'price'=>'required|numeric',
             'supplier_id'=>'required|integer',
             'filling_date'=>'required',
             'note'=>'nullable',
		];
	}


	protected function onUpdate() {
		return [
             'quantity'=>'required|numeric',
             'price'=>'required|numeric',
             'supplier_id'=>'required|integer',
             'filling_date'=>'required',
             'note'=>'nullable',
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
             'quantity'=>trans('admin.quantity'),
             'price'=>trans('admin.price'),
             'supplier_id'=>trans('admin.supplier_id'),
             'filling_date'=>trans('admin.filling_date'),
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
