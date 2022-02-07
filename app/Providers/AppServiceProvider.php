<?php
namespace App\Providers;

use App\Models\BasicParent;
use App\Models\City;
use App\Models\Debt;
use App\Models\GeneralRevenue;
use App\Models\revenue;
use App\Models\WithdrawalsPayments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */

	public function boot() {

        /******************* Right Side *************/
        $general_revenue= GeneralRevenue::all()->sum('price');
        $cities= City::all()->sortBy('name');
        $cities
            ->map(function ($q){
                $revenues= revenue::where('city_id',$q->id)
                    ->orderByDesc('open_date')
                    ->get(['id','name','open_date'])
                    ->map(function ($w){
                        $w->open_date=  Carbon::parse($w->open_date)->format('Y');
                        $w->profit= $w->profit();
                        return $w;
                    });
                $q->profit= $revenues->sum('profit');
                $q->revenue= $revenues->take(12)->groupBy('open_date');
                return $q;
            });
        $box_total= $cities->sum('profit') + $general_revenue;
        /******************* Left Side *************/
        $debts_total= Debt::all()->sum("remainder");
        $operating_expenses_total= 0;
        $heavy_expenses_total= 0;
        $rent_book_total= 0;
        $other_book_total= 0;
        $withdrawals_totals= WithdrawalsPayments::whereIn('parent_id',BasicParent::where('item','4')->get()->pluck('id'))->sum("price");
        $payments_totals= WithdrawalsPayments::whereIn('parent_id',BasicParent::where('item','5')->get()->pluck('id'))->sum("price");
        $total_alls= $box_total - ($debts_total+$withdrawals_totals+$payments_totals);
        /******************* End *************/
        view()->share('operating_expenses_total',$operating_expenses_total);
        view()->share('heavy_expenses_total',$heavy_expenses_total);
        view()->share('rent_book_total',$rent_book_total);
        view()->share('other_book_total',$other_book_total);
        view()->share('box_total',$box_total);
        view()->share('debts_total',$debts_total);
        view()->share('withdrawals_totals',$withdrawals_totals);
        view()->share('payments_totals',$payments_totals);
        view()->share('total_alls',$total_alls);

	    /****************/
		app()->singleton('admin', function () {
			return 'admin';
		});
		if (file_exists(base_path('config/itconfiguration.php'))) {
			Schema::defaultStringLength(config('itconfiguration.SchemadefaultStringLength'));
			if (config('itconfiguration.ForeignKeyConstraints')) {
				Schema::enableForeignKeyConstraints();
			} else {
				Schema::disableForeignKeyConstraints();
			}
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register() {
		//
	}
}
