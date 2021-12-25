<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use App\Models\Admin;
use Carbon\Carbon;
use DB;
use Mail;

class AdminAuthenticated extends Controller {

	public function login_page() {
		return view('admin.login', ['title' => trans('admin.login_page')]);
	}

	public function lock_screen() {
		$admin = Admin::where('mobile', request('mobile'))->first();
		admin()->logout();
		if (is_null($admin) || empty($admin)) {
			return redirect(aurl('login'));
		}
		return view('admin.lock_screen', [
			'title' => trans('admin.lock_screen'),
			'admin' => $admin,
		]);
	}

	public function login_post() {
		$rememberme = request('rememberme') == 1 ? true : false;
		if (admin()->attempt(['mobile' => request('mobile'), 'password' => request('password')], $rememberme)) {
			return redirect(aurl(''));
		} else {
			session()->flash('error', trans('admin.error_loggedin'));
			return back();
		}
	}

	public function logout() {
		admin()->logout();
		return redirect(aurl(''));
	}

	public function reset_password_change($tokenstr) {

		$this->validate(request(),
			[
				'password' => 'required|min:6|confirmed',
				'password_confirmation' => 'required',
				'mobile' => 'required|mobile',
			], [], [
				'password' => trans('admin.password'),
				'password_confirmation' => trans('admin.password_confirmation'),
			]);
		$token = DB::table('password_resets')->where('token', $tokenstr)->where('created_at', '>', Carbon::now()->subHours(2))->first();

		if (!empty($token)) {
			$admin = Admin::where('mobile', $token->mobile)->update(['password' => bcrypt(request('password'))]);
			session()->flash('success', trans('admin.password_is_changed'));
			if (request()->has('andlogin')) {
				auth()->guard('admin')->attempt(['mobile' => $token->mobile, 'password' => request('password')]);
				return redirect(aurl('/'));
			}
			DB::table('password_resets')->where('token', $tokenstr)->delete();
			return redirect(aurl('login'));
		} else {
			session()->flash('error', trans('admin.time_token_ended'));
			return redirect(aurl('login'));
		}
	}

	public function reset_password_final($token) {

		$token = DB::table('password_resets')->where('token', $token)->where('created_at', '>', Carbon::now()->subHours(2))->first();

		empty($token) ? session()->flash('error', trans('admin.time_token_ended')) : '';

		return !empty($token) ? view('admin.reset_password', ['token' => $token]) :
		redirect(aurl('login'));

	}
	public function reset_password() {
		$user = Admin::where('mobile', request('mobile'))->first();
		if (!empty($user)) {
			$token = app('auth.password.broker')->createToken($user);
			$data = DB::table('password_resets')->insert([
				'mobile' => request('mobile'),
				'token' => $token,
				'created_at' => Carbon::now(),
			]);
			$sendmail = Mail::to(request('mobile'))->send(new AdminResetPassword([
				'url' => aurl('password/reset/' . $token),
				'data' => $user,
			]));
			session()->flash('success', trans('admin.reset_link_sent'));
			return redirect(aurl('forgot/password'));
		} else {
			session()->flash('error', trans('admin.mobile_not_found'));
			return redirect(aurl('forgot/password'));
		}
	}

	public function account() {
		return view('admin.account', ['title' => trans('admin.account')]);
	}

	public function account_post() {

		$rules = [
			'name' => 'required',
			'mobile' => 'nullable|numeric|unique:admins',
			'password' => 'sometimes|nullable|confirmed',
			'password_confirmation' => '',
			'photo_profile' => 'sometimes|nullable|' . it()->image(),
		];
		$data = $this->validate(request(), $rules, [], [
			'name' => trans('admin.name'),
			'mobile' => trans('admin.mobile'),
			'password' => trans('admin.password'),
			'password_confirmation' => '',
		]);
		///// Check the Already Password ///////
		if (!empty(request('password')) && \Hash::check(request('password'), admin()->user()->password)) {
			session()->flash('error', trans('admin.the_password_is_old'));
			return back();
		}
		///// Check the Already Password ///////
		unset($data['password_confirmation']);
		if (!empty(request('password'))) {
			$data['password'] = bcrypt(request('password'));
		} else {
			unset($data['password']);
		}
		if (request()->hasFile('photo_profile')) {
			it()->delete(admin()->user()->photo_profile);
			$data['photo_profile'] = it()->upload('photo_profile', 'admin/' . admin()->user()->id);
		}
		admin()->user()->update($data);
		session()->flash('success', !empty(request('password')) ? trans('admin.updated_account_and_password') : trans('admin.updated'));
		return back();
	}

}
