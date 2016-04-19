<?php

namespace App\Http\Controllers\H5\Auth;

use App\Http\Controllers\H5Controller;
use App\Orms\SmsLog as OrmSmsLog;
use App\User as OrmUser;
use Auth;
use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Sms;
use Validator;
use Template;
use Redirect;
class AuthController extends H5Controller
{
	/*
	 |--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
				// 'name' => 'required|max:255',
				// 'email' => 'required|email|max:255|unique:users',
				'password' => 'required|min:6',
				]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return OrmUser::create([
				//  'name' => $data['name'],
				// 'email' => $data['email'],
				'phone_number' => $data['phone_number'],
				'password' => bcrypt($data['password']),
				]);
	}
	//自动登录
	public function auto_login(Request $request){
		$user_team_member=DB::table('user_team_member')
		->where('id',$request->input('id'))
		->first();
		if(!$user_team_member){
			Template::assign("url", "/");
			Template::assign("error", "已失效");
			Template::render('h5/common/error_redirect');
			exit();
		}
		//是否已经注册
		$count = DB::table('users')
		->where('phone_number', $user_team_member->phone_number)
		->count();
		$url="/h5/activity/join_auto?activity_id=$request->input('ac')&team_member_id=$request->input('tm')&token=$request->input('to')";
		if ($count > 0) {
			Redirect::to($url);
			exit();
		}
		$password=substr($user_team_member->phone_number,-4);
		OrmUser::create([
				'phone_number' => $user_team_member->phone_number,
				'password' => bcrypt($password),
				]);

		Auth::attempt(['phone_number' => $user_team_member->phone_number, 'password' => $password]);
		Redirect::to($url);
	}
	public function getRegister(Request $request)
	{
		Template::render('h5/auth/register');
	}
	public function getLogin(Request $request)
	{
		Template::render('h5/auth/login');
	}
	/**
	 *提交注册
	 */
	public function postRegister(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		//手机号验证

		if (!preg_match('/^1[3|4|5|7|8]\d{9}$/', $request->input('phoneNumber'))) {
			$out['code'] = 1;
			$out['msg'] = '手机号不正确！';
			return $out;
		}
		//验证码
		$smsType = 1;

		if (Cache::get($request->input('phoneNumber') . 'code1')!=$request->input('code')) {
			$out['code'] = 4;
			$out['msg'] = '验证码错误！';
			return $out;
		}

		//密码
		$valid = $this->validator(['password' => $request->input('password')]);
		if ($valid->fails()) {
			$out['code'] = 2;
			$out['msg'] = '密码不符合要求';
			return $out;
		}
		//是否已经注册
		$count = DB::table('users')
		->where('phone_number', $request->input('phoneNumber'))
		->count();
		if ($count > 0) {
			$out['code'] = 3;
			$out['msg'] = '已注册';
			return $out;
		}
		$userData['phone_number'] = $request->input('phoneNumber');
		$userData['password'] = $request->input('password');
		$res = $this->create($userData);

		$out['data']['user']['phone_number']=$userData;
		return $out;

	}
	//发送验证码
	public function sendCode(Sms $sms, Request $request)
	{
		$smsType = 1;
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		//手机号验证

		if (!preg_match('/^1[3|4|5|7|8]\d{9}$/', $request->input('phoneNumber'))) {
			$out['code'] = 2001;
			$out['msg'] = '手机号不正确！';
			return $out;
		}

		if (Cache::has($request->input('phoneNumber') . 'code1')) {
			$out['code'] = 2002;
			$out['msg'] = '已经发送过！';
			return $out;
		}

		$code = rand(1000, 9999);
		$content = "您的验证码是：{$code}。请不要把验证码泄露给其他人。";
		$res = $sms::send($request->input('phoneNumber'), $content);
		if ($res->code != 2) {
			$out['code'] = (int) $res->code;
			$out['msg'] = (string) $res->msg;
			return $out;
		}
		//保存验证码
		$expiredAt = Carbon::now()->addMinutes(3);
		Cache::add($request->input('phoneNumber') . 'code1', $code, $expiredAt);
		//记录发送
		$smsLog = new OrmSmsLog;
		$smsLog->phone_number = $request->input('phoneNumber');
		$smsLog->content = $content;
		$smsLog->code = $code;
		$smsLog->type = $smsType;
		$smsLog->save();
		return $out;
	}
	//登录
	public function postLogin(Request $request)
	{

		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$user = DB::table('users')
		->where('phone_number', $request->input('phoneNumber'))
		->first();
		//不存在
		if (!$user) {
			$out['code'] = 1;
			$out['msg'] = '不存在';
			return $out;
		}
		if (!Auth::attempt(['phone_number' => $request->input('phoneNumber'), 'password' => $request->input('password')])) {
			$out['code'] = 2;
			$out['msg'] = '用户名密码错误';
			return $out;
		}

		return $out;
	}
}
