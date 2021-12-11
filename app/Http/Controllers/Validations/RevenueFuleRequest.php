<?php
namespace App\Http\Controllers\Validations;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RevenueFuleRequest extends FormRequest {

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
             'paid_amount'=>'required|numeric',
             'filling_id'=>'required|integer',
             'stock_id'=>'required|integer',
             'revenue_id'=>'required|integer',
             'city_id'=>'required|integer',
             'note'=>'nullable',
		];
	}

	protected function onUpdate() {
		return [
             'quantity'=>'required|numeric',
             'price'=>'required|numeric',
             'paid_amount'=>'required|numeric',
             'filling_id'=>'required|integer',
             'stock_id'=>'required|integer',
             'revenue_id'=>'required|integer',
             'city_id'=>'required|integer',
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
             'paid_amount'=>trans('admin.paid_amount'),
             'filling_id'=>trans('admin.filling_id'),
             'stock_id'=>trans('admin.stock_id'),
             'revenue_id'=>trans('admin.revenue_id'),
             'city_id'=>trans('admin.city_id'),
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
