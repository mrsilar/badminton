<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/11/21
 * Time: 9:57
 */
namespace App\Models;
use Auth;
use DB;
class TeamMemberModel extends BaseModel
{
    /**
     * 检查身份证
     */
    public static function check_id($str = '')
    {
        return preg_match('/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/', $str);
    }
    public static function save($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();

        $insert = [];
        if (!$request->input('name')) {
            $out['code'] = 1;
            $out['msg'] = '名字不能为空';
            return $out;
        }

        if (!$request->input('phone_number')) {
            $out['code'] = 2;
            $out['msg'] = '手机号不能为空';
            return $out;
        }
       // if (!$request->input('identity_card')) {
        //    $out['code'] = 3;
         //   $out['msg'] = '身份证号不能为空';
          //  return $out;
        //}
        if (!phone_filter($request->input('phone_number'))) {
            $out['code'] = 4;
            $out['msg'] = '手机号不正确';
            return $out;
        }
        if ($request->input('identity_card') && !check_id($request->input('identity_card'))) {
            $out['code'] = 5;
            $out['msg'] = '身份证号不正确';
            return $out;
        }

        $insert['name'] = $request->input('name');
        $insert['phone_number'] = $request->input('phone_number');
        $insert['identity_card'] = $request->input('identity_card');
        $insert['created_at'] =date('Y-m-d H:i:s', time());
        $insert['updated_at'] = date('Y-m-d H:i:s', time());
        if ($request->input('sex')) {
            $insert['sex'] = $request->input('sex');
        }

        $user = Auth::user();
        $insert['mem_id'] = $user->id;

        DB::table('user_team_member')
            ->insert($insert);
        return $out;
    }
}