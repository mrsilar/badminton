<?php

namespace App\Http\Controllers\Web\Center;

use App\Http\Controllers\WebController;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;

class MyTeamMember extends WebController
{
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'team_name' => 'required',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNum)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $out['data']['page'] = [];
        //分页
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize = 2;
        $offset = ($pageNum - 1) * $pageSize;

        $user = Auth::user();
        if (!$user) {
            $out['code'] = 1;
            $out['msg'] = '未登录';
            return $out;
        }

        $count = DB::table('user_team_member')
            ->where('mem_id', $user->id)
            ->count();
        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $out['data']['page'] = $page;
        //队伍
        $res = DB::table('user_team_member')
            ->where('mem_id', $user->id)
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();

        if (!$res) {
            return $out;
        }

        $out['data']['list'] = $res;
        return $out;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        // 验证
        /*        $v = $this->validator($request);
        if ($v->fails()) {
        $out['code'] = 1;
        $out['msg'] = $v->errors();
        return $out;
        }*/

        $user = Auth::user();
        if (!$user) {
            $out['code'] = 2;
            $out['msg'] = '未登录';
            return $out;
        }
        $inser_data = $request->all();
        if (isset($inser_data['phoneNumber'])) {
            $inser_data['phone_number'] = $inser_data['phoneNumber'];
            unset($inser_data['phoneNumber']);
        }
        if (isset($inser_data['identityCard'])) {
            $inser_data['identity_card'] = $inser_data['identityCard'];
            unset($inser_data['identityCard']);
        }
        $inser_data['mem_id'] = $user->id;
        DB::table('user_team_member')
            ->insert($inser_data);
        return $out;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();

        $team = DB::table('user_team_member')
            ->where('id', $id)
            ->first();

        if (!$team) {
            return $out;
        }

        $out['data'] = $team;
        return $out;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $inser_data = $request->all();
        $id = $inser_data['id'];
        if (isset($inser_data['phoneNumber'])) {
            $inser_data['phone_number'] = $inser_data['phoneNumber'];
            unset($inser_data['phoneNumber']);
        }
        if (isset($inser_data['identityCard'])) {
            $inser_data['identity_card'] = $inser_data['identityCard'];
            unset($inser_data['identityCard']);
        }
        $team = DB::table('user_team_member')
            ->where('id', $id)
            ->update($inser_data);

        if (!$team) {
            return $out;
        }

        $out['data'] = $team;
        return $out;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        DB::table('user_team_member')
            ->where('id', '=', $id)->delete();
        return $out;
    }

    //我的活动
    public function myActivityList()
    {
        $user = Auth::user();
        //我参加的活动
        $join =
        DB::table('user_activity')
            ->where('mem_id', $user->id)
            ->get();
        $activityIds = [];
        foreach ($join as $key => $value) {
            $activityIds[] = $value->activity_id;
        }
        $joinActivity = DB::table('activity')
            ->whereIn('id', $activityIds)
            ->get();
        //我发布的活动
        $createActivity =
        DB::table('activity')
            ->where('mem_id', $user->id)
            ->get();

        Template::assign('create', $createActivity);
        Template::assign('join', $joinActivity);
        Template::render('web/member/activity/list');
    }

    //我的俱乐部
    public function myClubList()
    {
        $user = Auth::user();
        //我参加的俱乐部
        $join =
        DB::table('user_club')
            ->where('mem_id', $user->id)
            ->get();
        $activityIds = [];
        foreach ($join as $key => $value) {
            $activityIds[] = $value->club_id;
        }
        $joinActivity = DB::table('club')
            ->whereIn('id', $activityIds)
            ->get();
        //我发布的俱乐部
        $createActivity =
        DB::table('club')
            ->where('mem_id', $user->id)
            ->get();

        Template::assign('create', $createActivity);
        Template::assign('join', $joinActivity);
        Template::render('web/member/club/list');
    }
    //我的队员
    public function myPersonList()
    {
        $user = Auth::user();
        $list =
        DB::table('user_team_member')
            ->where('mem_id', $user->id)
            ->get();

        Template::assign('list', $list);
        Template::render('web/member/person/list');
    }
    //积分
    public function myScore()
    {
        Template::render('web/member/score/index');
    }
}
