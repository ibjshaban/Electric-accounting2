<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
// your api is integerated but if you want reintegrate no problem
// to configure jwt-auth visit this link https://jwt-auth.readthedocs.io/en/docs/

Route::group(['middleware' => ['ApiLang', 'cors'], 'prefix' => 'v1', 'namespace' => 'Api\V1'], function () {

	Route::get('/', function () {

	});
	// Insert your Api Here Start //
	Route::group(['middleware' => 'guest'], function () {
		Route::post('login', 'Auth\AuthAndLogin@login')->name('api.login');
		Route::post('register', 'Auth\Register@register')->name('api.register');
	});

	Route::group(['middleware' => 'auth:api'], function () {
		Route::get('account', 'Auth\AuthAndLogin@account')->name('api.account');
		Route::post('logout', 'Auth\AuthAndLogin@logout')->name('api.logout');
		Route::post('refresh', 'Auth\AuthAndLogin@refresh')->name('api.refresh');
		Route::post('me', 'Auth\AuthAndLogin@me')->name('api.me');
		Route::post('change/password', 'Auth\AuthAndLogin@change_password')->name('api.change_password');
		//Auth-Api-Start//
		Route::apiResource("city","CityControllerApi", ["as" => "api.city"]);
			Route::post("city/multi_delete","CityControllerApi@multi_delete");
			Route::apiResource("stock","StockControllerApi", ["as" => "api.stock"]);
			Route::post("stock/multi_delete","StockControllerApi@multi_delete");
			Route::apiResource("supplier","SupplierControllerApi", ["as" => "api.supplier"]);
			Route::post("supplier/multi_delete","SupplierControllerApi@multi_delete");
			Route::apiResource("employeetype","EmployeeTypeControllerApi", ["as" => "api.employeetype"]);
			Route::post("employeetype/multi_delete","EmployeeTypeControllerApi@multi_delete");
			Route::apiResource("revenue","RevenueControllerApi", ["as" => "api.revenue"]);
			Route::post("revenue/multi_delete","RevenueControllerApi@multi_delete");
			Route::apiResource("debt","DebtControllerApi", ["as" => "api.debt"]);
			Route::post("debt/multi_delete","DebtControllerApi@multi_delete");
			Route::apiResource("salary","SalaryControllerApi", ["as" => "api.salary"]);
			Route::post("salary/multi_delete","SalaryControllerApi@multi_delete");
			Route::apiResource("expenses","ExpensesControllerApi", ["as" => "api.expenses"]); 
			Route::post("expenses/multi_delete","ExpensesControllerApi@multi_delete"); 
			Route::apiResource("otheroperation","OtherOperationControllerApi", ["as" => "api.otheroperation"]); 
			Route::post("otheroperation/multi_delete","OtherOperationControllerApi@multi_delete"); 
			Route::apiResource("collection","CollectionControllerApi", ["as" => "api.collection"]); 
			Route::post("collection/multi_delete","CollectionControllerApi@multi_delete"); 
			Route::apiResource("filling","FillingControllerApi", ["as" => "api.filling"]); 
			Route::post("filling/multi_delete","FillingControllerApi@multi_delete"); 
			Route::apiResource("revenuefule","RevenueFuleControllerApi", ["as" => "api.revenuefule"]); 
			Route::post("revenuefule/multi_delete","RevenueFuleControllerApi@multi_delete"); 
			Route::apiResource("payment","PaymentControllerApi", ["as" => "api.payment"]); 
			Route::post("payment/multi_delete","PaymentControllerApi@multi_delete"); 
			Route::apiResource("generalrevenue","GeneralRevenueControllerApi", ["as" => "api.generalrevenue"]); 
			Route::post("generalrevenue/multi_delete","GeneralRevenueControllerApi@multi_delete"); 
			Route::apiResource("withdrawalspayments","WithdrawalsPaymentsControllerApi", ["as" => "api.withdrawalspayments"]); 
			Route::post("withdrawalspayments/multi_delete","WithdrawalsPaymentsControllerApi@multi_delete"); 
			//Auth-Api-End//
	});
	// Insert your Api Here End //
});
