<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\AdminController;
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
class AuthController extends AdminController
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


    public function getLogin(Request $request)
     {
         return view('admin/auth/login');
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
        if(!$user->is_admin){
            $out['code'] = 3;
            $out['msg'] = '不是后台用户';
            return $out;
        }
        return $out;
    }
}
