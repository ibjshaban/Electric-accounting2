<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BasicParent;
use App\Models\City;
use App\Models\Debt;
use App\Models\GeneralRevenue;
use App\Models\revenue;
use App\Models\Setting;
use App\Models\WithdrawalsPayments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller {

	public function home() {

	    /******************* Right Side *************/
	    $general_revenue= GeneralRevenue::all()->sum('price');
	    $cities= City::all()->sortBy('name');
	    $cities->map(function ($q){
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
	   /******************************************/
        $title = trans('admin.dashboard');
		return view('admin.home',compact('title','general_revenue','cities'));

	}

	public function statistics() {
		return view('admin.statistics', ['title' => 'الاحصائيات']);
	}

	public function prepareKey($key) {
		$setting = setting()->theme_setting;
		if (!empty($setting) && !empty($setting->{$key})) {
			$$key = $setting->{$key};
		} else {
			$$key = '';
		}

		if (request()->has($key)) {
			if (!empty(request($key))) {
				return [$key => request($key)];
			} else {
				return [$key => ''];
			}
		} else {
			return [$key => $$key];
		}

	}

	public function theme_setting() {
		$data_setting = [];
		$data_setting = array_merge($data_setting, $this->prepareKey('brand_color'));
		$data_setting = array_merge($data_setting, $this->prepareKey('sidebar_class'));
		$data_setting = array_merge($data_setting, $this->prepareKey('main_header'));
		$data_setting = array_merge($data_setting, $this->prepareKey('navbar'));
		//return print_r($data_setting);
		return json_encode($data_setting);
	}

	public function theme($id) {
		if (request()->ajax()) {
			$update = Setting::find(setting()->id);
			$update->theme_setting = $this->theme_setting();
			$update->save();
			return setting()->theme_setting;
		} else {
			return 'no ajax request';
		}
	}
}
