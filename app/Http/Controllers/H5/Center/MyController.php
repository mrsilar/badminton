<?php

namespace App\Http\Controllers\H5\Center;

use App\Http\Controllers\H5Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;
use Redirect;
use App\Models\UserModel;
use App\Models\ActivityModel;

class MyController extends H5Controller
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
            ->skip($offset)//offset  10
            ->take($pageSize)//limit 5
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        // 验证

        $user = Auth::user();
        $insert = $request->all();
        $inser_data = [];
        $inser_data['name'] = $insert['name'];
        $inser_data['cover_img'] = $insert['cover_img'];
        $inser_data['phone_number'] = $insert['phone_number'];


        if (!phone_filter($insert['phone_number'])) {
            //
            $out['code'] = 1;
            $out['msg'] = '手机号格式错误！';
            return $out;
        }
        DB::table('users')
            ->where('id', $user->id)
            ->update($inser_data);

        $inser_data = [];
        $inser_data['name'] = $insert['name'];
        $inser_data['phone_number'] = $insert['phone_number'];
        if (isset($insert['sex'])) {
            $inser_data['sex'] = $insert['sex'];
        }
        if (!empty($insert['identity_card'])) {
            $inser_data['identity_card'] = $insert['identity_card'];
            if (!check_id($inser_data['identity_card'])) {
                $out['code'] = 2;
                $out['msg'] = '身份证号格式错误！';
                return $out;
            }
        }
        $user_team_member = DB::table('user_team_member')
            ->where('id', $user->user_team_member_id)
            ->count();
        if ($user->user_team_member_id > 0 && $user_team_member > 0) {
            DB::table('user_team_member')
                ->where('id', $user->user_team_member_id)
                ->update($inser_data);
        } else {
            $inser_data['mem_id'] = $user->id;
            $idd = DB::table('user_team_member')
                ->insertGetId($inser_data);
            DB::table('users')
                ->where('id', $user->id)
                ->update(['user_team_member_id' => $idd]);
        }

        return $out;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $user = Auth::user();
        $user->sex = 0;
        $user->identity_card = '';

        if (!$user->user_team_member_id) {
            Template::assign('mem', $user);
            Template::render('h5/member/me/edit');
            exit();
        }

        $re = DB::table('user_team_member')
            ->where('id', $user->user_team_member_id)
            ->first();

        if (!$re) {
            Template::assign('mem', $user);
            Template::render('h5/member/me/edit');
            exit();
        }
        $user->sex = $re->sex;
        $user->identity_card = $re->identity_card;
        $user->mem_id = $user->id;

        Template::assign('mem', $user);
        Template::render('h5/member/me/edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
        $joinActivity = ActivityModel::my_join_activity_list();
        foreach ($joinActivity as $key => &$value) {
            $value->status = get_activity_status($value);
        }
        unset($value);
        //我发布的活动
        $createActivity =
            DB::table('activity')
                ->where('mem_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();

        foreach ($createActivity as $key => &$value) {
            $value->status = get_activity_status($value);
        }
        unset($value);
        Template::assign('create', $createActivity);
        Template::assign('join', $joinActivity);
        Template::render('h5/member/activity/list');
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
        $createActivity = DB::table('club')
            ->where('mem_id', $user->id)
            ->get();
        //人数
        $activity_count = DB::table('activity')
            ->where('mem_id', $user->id)
            ->count();



        Template::assign('create', $createActivity);
        Template::assign('join', $joinActivity);
        Template::assign('activity_count', $activity_count);
        Template::render('h5/member/club/list');
    }

    //我的队员
    public function myPersonList()
    {

        $list = UserModel::person_list();
        Template::assign('list', $list);
        Template::render('h5/member/person/list');
    }

    //我的队伍
    public function myTeamList()
    {
        $user = Auth::user();
        $list =
            DB::table('team_member')
                ->where('mem_id', $user->id)
                ->orderBy('team_id', 'DESC')
                ->orderBy('is_captain', 'DESC')
                ->get();
        $person_ids = [];
        foreach ($list as $row) {
            $person_ids[] = $row->user_team_member_id;
        }
        if (!$person_ids) {
            Template::assign('list', $list);
            Template::render('h5/member/team/list');
            exit();
        }
        $listmem =
            DB::table('user_team_member')
                ->whereIn('id', $person_ids)
                ->get();
        $listmemnew = [];
        foreach ($listmem as $row) {
            $listmemnew[$row->id] = $row;
        }

        $newlist = [];
        foreach ($list as $row) {
            $newlist[$row->team_id]['list'][] = isset($listmemnew[$row->user_team_member_id]) ? $listmemnew[$row->user_team_member_id] : '';
            $newlist[$row->team_id]['info'] = $row;
        }

        Template::assign('list', $newlist);
        Template::render('h5/member/team/list');
    }

    //积分
    public function myScore()
    {
        Template::render('h5/member/score/index');
    }

    //退出
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }


}
