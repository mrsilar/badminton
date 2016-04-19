<?php

namespace App\Http\Controllers\Admin\Club;

use App\Http\Controllers\AdminController;
use App\Orms\Club as OrmClub;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;

class ClubController extends AdminController
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        //
        //
        $out['code'] = 1;
        $out['msg'] = '审核成功';
        $out['data'] = array();
        $user=Auth::user();

        if(!$user->is_admin)
        {
            $out['code'] = 5;
            $out['msg'] = '不是后台用户';
            return $out;
        }
        $res_tmp = DB::table('club')
            ->where('id', $request->input('id'))
            ->first();
        if (!$res_tmp) {
            $out['code'] = 3;
            $out['msg'] = '俱乐部不存在';
            return $out;
        }
                //

        if ($res_tmp->status==$request->input('type') ){
            $out['code'] = 4;
            $out['msg'] = $request->input('type')==1?'已经是审核通过':'已经是审核未通过';
            return $out;
        }
        $res = DB::table('club')
            ->where('id', $request->input('id'))
            ->update(['status' => $request->input('type')]);
        if (!$res) {
            $out['code'] = 2;
            $out['msg'] = '修改失败';
        }
        return $out;
    }



}
