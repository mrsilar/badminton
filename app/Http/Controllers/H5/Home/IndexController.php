<?php

namespace App\Http\Controllers\H5\Home;

use App\Http\Controllers\H5Controller;
use DB;
use Template;
use Illuminate\Http\Request;
use Auth;

class IndexController extends H5Controller
{
    //首页
    public function index(Request $request)
    {
        //轮播图
        $img = DB::table('img')
            ->where('type', 22)//轮播
            ->get();
        //活动
        $res = DB::table('activity')
            ->whereIn('label', [1, 2, 3])
            ->get();
        $newRes = [];
        $activity_ids = [];
        //状态转化enlist 报名中  draw抽签   match比赛 result成绩 end结束
        $status = [
            'enlist' => '报名中',
            'draw' => '抽签',
            'match' => '比赛',
            'result' => '成绩',
            'end' => '结束',
        ];

        //状态转化enlist 报名中  draw抽签   match比赛 result成绩 end结束
        $status = [
            'enlist' => '报名中',
            'draw' => '抽签',
            'match' => '比赛',
            'result' => '成绩',
            'end' => '结束',
        ];
        foreach ($res as $key => $value) {

            $value->status = get_activity_status($value);
            $activity_ids[] = $value->id;
            $newRes[$value->label][] = $value;
        }

        //统计信息
        $out = [];
        $ts = 0;
       // $times = DB::select('SELECT end_time)-TO_SECONDS(start_time) as count FROM `activity`');
        $ts=1000000;
/*         foreach ($times as $key => $value) {
            $ts = $ts + $value->count;
        } */
        $out['time'] = bcdiv($ts, 3600);
        $out['register'] = DB::table('users')
            ->count();
        $out['activity'] = DB::table('activity')
            ->count();

        Template::assign('count', $out);
        Template::assign('list', $newRes);
        Template::assign('img', $img);
        Template::render('h5/index/index');
    }

    //发现
    public function find()
    {
        Template::render('h5/index/find');
    }

    //我的
    public function my()
    {
        $user = Auth::user();
        Template::assign('mem', $user);
        Template::render('h5/index/my');
    }

}
