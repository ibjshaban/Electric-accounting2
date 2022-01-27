<?php

use Illuminate\Support\Facades\Route;

\L::Panel(app('admin'));///SetLangredirecttoadmin
\L::LangNonymous();//RunRouteLang'namespace'=>'Admin',

Route::group(['prefix' => app('admin'), 'middleware' => 'Lang'], function () {
    Route::get('lock/screen', 'Admin\AdminAuthenticated@lock_screen');
    Route::get('theme/{id}', 'Admin\Dashboard@theme');
    Route::group(['middleware' => 'admin_guest'], function () {

        Route::get('login', 'Admin\AdminAuthenticated@login_page');
        Route::post('login', 'Admin\AdminAuthenticated@login_post');
        Route::view('forgot/password', 'admin.forgot_password');

        Route::post('reset/password', 'Admin\AdminAuthenticated@reset_password');
        Route::get('password/reset/{token}', 'Admin\AdminAuthenticated@reset_password_final');
        Route::post('password/reset/{token}', 'Admin\AdminAuthenticated@reset_password_change');
    });

    Route::view('need/permission', 'admin.no_permission');

    Route::group(['middleware' => 'admin:admin'], function () {
        if (class_exists(\UniSharp\LaravelFilemanager\Lfm::class)) {
            Route::group(['prefix' => 'filemanager'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });
        }

////////AdminRoutes/*Start*///////////////
        Route::get('/', 'Admin\Dashboard@home');
        Route::get('/statistics', 'Admin\Dashboard@statistics');
        Route::any('logout', 'Admin\AdminAuthenticated@logout');
        Route::get('account', 'Admin\AdminAuthenticated@account');
        Route::post('account', 'Admin\AdminAuthenticated@account_post');
        Route::resource('settings', 'Admin\Settings');
        Route::resource('admingroups', 'Admin\AdminGroups');
        Route::post('admingroups/multi_delete', 'Admin\AdminGroups@multi_delete');
        Route::resource('admins', 'Admin\Admins');
        Route::post('admins/multi_delete', 'Admin\Admins@multi_delete');
        Route::resource('city', 'Admin\Citys');
        Route::post('city/multi_delete', 'Admin\Citys@multi_delete');


        Route::resource('stock', 'Admin\Stocks');
        Route::post('stock/multi_delete', 'Admin\Stocks@multi_delete');

        Route::resource('supplier', 'Admin\SupplierController');
        Route::post('supplier/multi_delete', 'Admin\SupplierController@multi_delete');

        Route::resource('employeetype', 'Admin\EmployeeTypeController');
        Route::post('employeetype/multi_delete', 'Admin\EmployeeTypeController@multi_delete');

        Route::resource('employee', 'Admin\EmployeeController');
        Route::post('employee/multi_delete', 'Admin\EmployeeController@multi_delete');

        Route::resource('revenue', 'Admin\RevenueController');
        Route::post('revenue/multi_delete', 'Admin\RevenueController@multi_delete');

        Route::resource('debt', 'Admin\DebtController');
        Route::post('debt/multi_delete', 'Admin\DebtController@multi_delete');

        Route::resource('salary', 'Admin\SalaryController')->except('create');
        Route::get('/revenue-salary/{id}/create', 'Admin\SalaryController@create');
        Route::post('/revenue-salary/deposit', 'Admin\SalaryController@deposit_salary')->name('deposit_salary');
        Route::post('salary/multi_delete', 'Admin\SalaryController@multi_delete');
        Route::get('/revenue-salary/{id}', 'Admin\SalaryController@revenueSalary');

        Route::resource('expenses', 'Admin\ExpensesController');
        Route::post('expenses/multi_delete', 'Admin\ExpensesController@multi_delete');

//**revenue-expenses**
        Route::get('revenue-expenses/{id}', 'Admin\ExpensesController@revenueExpenses');
        Route::get('revenue-expenses/{id}/create', 'Admin\ExpensesController@revenueCreate');
        Route::post('revenue-expenses/create/{id}', 'Admin\ExpensesController@revenueStore');
        Route::get('revenue-expenses/{id}/edit', 'Admin\ExpensesController@revenueEdit');
        Route::put('revenue-expenses/edit/{id}', 'Admin\ExpensesController@revenueUpdate');
//************


        Route::resource('otheroperation', 'Admin\OtherOperationController');
        Route::post('otheroperation/multi_delete', 'Admin\OtherOperationController@multi_delete');

//**revenue-otheroperation**
        Route::get('revenue-otheroperation/{id}', 'Admin\OtherOperationController@revenueOtherOperation');
        Route::get('revenue-otheroperation/{id}/create', 'Admin\OtherOperationController@otherOperationCreate');
        Route::post('revenue-otheroperation/create/{id}', 'Admin\OtherOperationController@otherOperationStore');
        Route::get('revenue-otheroperation/{id}/edit', 'Admin\OtherOperationController@otherOperationEdit');
        Route::put('revenue-otheroperation/edit/{id}', 'Admin\OtherOperationController@otherOperationUpdate');
//************

        Route::resource('collection', 'Admin\CollectionController');
        Route::post('collection/multi_delete', 'Admin\CollectionController@multi_delete');
        Route::post('collection/status', 'Admin\CollectionController@change_status')->name('change_collection_status');

//**revenue-collection**
        Route::get('revenue-collection/{id}', 'Admin\CollectionController@revenueCollection');
        Route::get('revenue-collection/{id}/create', 'Admin\CollectionController@revenueCollectionCreate');
        Route::post('revenue-collection/create/{id}', 'Admin\CollectionController@revenueCollectionStore');
        Route::get('revenue-collection/{id}/edit', 'Admin\CollectionController@revenueCollectionEdit');
        Route::put('revenue-collection/edit/{id}', 'Admin\CollectionController@revenueCollectionUpdate');
//************

        Route::resource('filling', 'Admin\FillingController')->except('create');
        Route::post('filling/multi_delete', 'Admin\FillingController@multi_delete');
        Route::get('/filling/{supplier_id}/create', 'Admin\FillingController@create');
        Route::post('/getrevenue/city', 'Admin\RevenueController@getRevenueByCity')->name('getRevenueByCity');

        Route::resource('revenuefule', 'Admin\RevenueFuleController');
        Route::post('revenuefule/multi_delete', 'Admin\RevenueFuleController@multi_delete');


//**revenue-expenses**
        Route::get('revenuefule-revenue/{id}', 'Admin\RevenueFuleController@revenueFuleRevenue');
        Route::get('revenuefule-revenue/{id}/create', 'Admin\RevenueFuleController@revenueFulCreate');
        Route::post('revenuefule-revenue/create/{id}', 'Admin\RevenueFuleController@revenueFulStore');
        Route::get('revenuefule-revenue/{id}/edit', 'Admin\RevenueFuleController@revenueFulEdit');
        Route::put('revenuefule-revenue/edit/{id}', 'Admin\RevenueFuleController@revenueFulUpdate');
//************

        Route::get('financial-movements/{id}', 'Admin\EmployeeController@movementShow');
        Route::get('revenue-fule-revenue/create', 'Admin\RevenueFuleController@revenueFuleRevenueCreate');


        Route::resource('payment', 'Admin\PaymentController');
        Route::post('payment/multi_delete', 'Admin\PaymentController@multi_delete');

        //PDFlaravel-snappy
        Route::get('generate-pdf/{id}', 'Admin\EmployeeController@pdfview')->name('generate-pdf');
        Route::get('print-view', 'Admin\EmployeeController@printView')->name('print-view');


//Startbasicparent
        Route::resource('basicparents', 'Admin\BasicParents');
        Route::post('basicparents/multi_delete', 'Admin\BasicParents@multi_delete');

        //start-upbasicparent
        Route::get('startup', 'Admin\BasicParents@indexStartup');
        Route::get('startup/create', 'Admin\BasicParents@createStartup');
        Route::post('startup/store', 'Admin\BasicParents@storeStartup');
        Route::get('startup/{id}/edit', 'Admin\BasicParents@editStartup');
        Route::put('startup/update/{id}', 'Admin\BasicParents@updateStartup');

//heavy-expensesbasicparent
        Route::get('heavy-expenses', 'Admin\BasicParents@indexStartup');
        Route::get('heavy-expenses/create', 'Admin\BasicParents@createStartup');
        Route::post('heavy-expenses/store', 'Admin\BasicParents@storeStartup');
        Route::get('heavy-expenses/{id}/edit', 'Admin\BasicParents@editStartup');
        Route::put('heavy-expenses/update/{id}', 'Admin\BasicParents@updateStartup');

//rentalsbasicparent
        Route::get('rentals', 'Admin\BasicParents@indexStartup');
        Route::get('rentals/create', 'Admin\BasicParents@createStartup');
        Route::post('rentals/store', 'Admin\BasicParents@storeStartup');
        Route::get('rentals/{id}/edit', 'Admin\BasicParents@editStartup');
        Route::put('rentals/update/{id}', 'Admin\BasicParents@updateStartup');

//rentalsbasicparent
        Route::get('other-notebooks', 'Admin\BasicParents@indexStartup');
        Route::get('other-notebooks/create', 'Admin\BasicParents@createStartup');
        Route::post('other-notebooks/store', 'Admin\BasicParents@storeStartup');
        Route::get('other-notebooks/{id}/edit', 'Admin\BasicParents@editStartup');
        Route::put('other-notebooks/update/{id}', 'Admin\BasicParents@updateStartup');

//Items
        Route::resource('basicparentitems', 'Admin\BasicParentItems');
        Route::post('basicparentitems/multi_delete', 'Admin\BasicParentItems@multi_delete');

        Route::get('startup-items/{id}/create', 'Admin\BasicParentItems@create');
        Route::post('startup-items/store/{id}', 'Admin\BasicParentItems@store');

////////AdminRoutes/*End*///////////////

        Route::resource('generalrevenue', 'Admin\GeneralRevenueController');
        Route::post('generalrevenue/multi_delete', 'Admin\GeneralRevenueController@multi_delete');

        Route::resource('withdrawalspayments', 'Admin\WithdrawalsPaymentsController')->except('create', 'destroy', 'show', 'index', 'edit');

        Route::get('/withdrawals/{type}/create', 'Admin\WithdrawalsPaymentsController@create_withdrawals')->name('withdrawalspayments-withdrawals');
        Route::get('/withdrawals', 'Admin\WithdrawalsPaymentsController@index_withdrawals');
        Route::get('/withdrawals/{id}/edit', 'Admin\WithdrawalsPaymentsController@edit_withdrawals');
        Route::delete('/withdrawals/{id}', 'Admin\WithdrawalsPaymentsController@destroy_withdrawals')->name('destroy_withdrawals');
        Route::get('/withdrawals/{id}', 'Admin\WithdrawalsPaymentsController@show_withdrawals');
        Route::put('/withdrawals/{id}', 'Admin\WithdrawalsPaymentsController@update_withdrawals');
        Route::post('/withdrawals', 'Admin\WithdrawalsPaymentsController@store_withdrawals');

        Route::get('/payments/{type}/create', 'Admin\WithdrawalsPaymentsController@create_payments')->name('withdrawalspayments-payments');
        Route::get('/payments', 'Admin\WithdrawalsPaymentsController@index_payments');
        Route::get('/payments/{id}/edit', 'Admin\WithdrawalsPaymentsController@edit_payments');
        Route::delete('/payments/{id}', 'Admin\WithdrawalsPaymentsController@destroy_payments')->name('destroy_payments');
        Route::get('/payments/{id}', 'Admin\WithdrawalsPaymentsController@show_payments');
        Route::put('/payments/{id}', 'Admin\WithdrawalsPaymentsController@update_payments');
        Route::post('/payments', 'Admin\WithdrawalsPaymentsController@store_payments');

        Route::post('withdrawals/multi_delete', 'Admin\WithdrawalsPaymentsController@multi_delete_withdrawals')->name('multi_delete_withdrawals');
        Route::post('payments/multi_delete', 'Admin\WithdrawalsPaymentsController@multi_delete_payments')->name('multi_delete_payments');
        ////////AdminRoutes/*End*///////////////

        Route::resource('notebooks', 'Admin\notebooks');
        Route::post('notebooks/multi_delete', 'Admin\notebooks@multi_delete');
    });

});
