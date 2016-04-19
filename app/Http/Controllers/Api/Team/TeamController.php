<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\ApiController;
use App\Orms\Team as OrmTeam;
use App\Orms\TeamMember as OrmTeamMember;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class TeamController extends ApiController
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

        $count = DB::table('team')
            ->count();
        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $out['data']['page'] = $page;
        //队伍
        $ormTeam = new OrmTeam();
        $ormTeamMember = new OrmTeamMember();
        $res = $ormTeam
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get()
            ->toArray();

        if (!$res) {
            return $out;
        }

        //队员
        $team_ids = array_column($res, 'id');
        $mems = $ormTeamMember
            ->whereIn('team_id', $team_ids)
            ->get()
            ->toArray();
        $user_team_member_ids = array_column($mems, 'user_team_member_id');
        $user_team_member = DB::table('user_team_member')
            ->whereIn('id', $user_team_member_ids)
            ->get();
        $new_user_team_member = [];
        foreach ($user_team_member as $key => $value) {
            $new_user_team_member[$value->id] = $value;
        }

        foreach ($mems as $key => &$value) {
            if (isset($new_user_team_member[$value['user_team_member_id']])) {
                $value['name'] = $new_user_team_member[$value['user_team_member_id']]->name;
                $value['identity_card'] = $new_user_team_member[$value['user_team_member_id']]->identity_card;
                $value['sex'] = $new_user_team_member[$value['user_team_member_id']]->sex;
                $value['phone_number'] = $new_user_team_member[$value['user_team_member_id']]->phone_number;
            } else {
                $value['name'] = '';
                $value['identity_card'] = '';
                $value['sex'] = '';
                $value['phone_number'] = '';
            }
        }
        unset($value);
        $newMems = [];
        foreach ($mems as $key => $value) {
            if ($value['is_captain'] == 1) {
                $newMems[$value['team_id']]['captain'][] = $value;
                continue;
            }
            if ($value['is_backup'] == 1) {
                $newMems[$value['team_id']]['backup'][] = $value;
                continue;
            }

            $newMems[$value['team_id']]['common'][] = $value;
        }

        foreach ($res as $key => &$value) {
            if (isset($newMems[$value['id']])) {
                $value['members'] = $newMems[$value['id']];
            } else {
                $value['members'] = [];
            }
        }
        unset($value);
        //

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
        $v = $this->validator($request);
        if ($v->fails()) {
            $out['code'] = 1;
            $out['msg'] = $v->errors();
            return $out;
        }
        $ormTeam = new OrmTeam();
        //队伍
        $ormTeam->name = $request->input('team_name');
        $ormTeam->save();
        //查看身份证是否重复
        $ids = array_column($request->input('member'), 'identity_card');
        $count = OrmTeamMember::whereIn('identity_card', $ids)
            ->count();

        if ($count) {

            $out['code'] = 3;
            $out['msg'] = '身份重复';
            return $out;
        }
        foreach ($request->input('member') as $key => $value) {
            $ormTeamMember = new OrmTeamMember();
            if (empty($value['name'])) {
                $out['code'] = 2;
                $out['msg'] = '队伍名称不能为空';
                return $out;
            }
            $ormTeamMember->team_id = $ormTeam->id;
            $ormTeamMember->name = $value['name'];
            if (!empty($value['phone_number'])) {
                $ormTeamMember->phone_number = $value['phone_number'];
            }

            if (!empty($value['identity_card'])) {
                $ormTeamMember->identity_card = $value['identity_card'];
            }

            if (!empty($value['sex'])) {
                $ormTeamMember->sex = $value['sex'];
            }

            if (!empty($value['is_captain'])) {
                $ormTeamMember->is_captain = $value['is_captain'];
            }

            if (!empty($value['is_backup'])) {
                $ormTeamMember->is_backup = $value['is_backup'];
            }
            $ormTeamMember->save();

        }
        $user = Auth::user();
        if (!$user) {
            $out['code'] = 2;
            $out['msg'] = '未登录';
            return $out;
        }
        $ormActivity->mem_id = $user->id;
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
        //
        $ormTeam = new OrmTeam();
        $ormTeamMember = new OrmTeamMember();
        $team = $ormTeam->where('id', $id)
            ->first();

        if (!$team) {
            return $out;
        }
        $mems = $ormTeamMember::where('team_id', $id)
            ->get()
            ->toArray();
        //队员
        $user_team_member_ids = array_column($mems, 'user_team_member_id');
        $user_team_member = DB::table('user_team_member')
            ->whereIn('id', $user_team_member_ids)
            ->get();
        $new_user_team_member = [];
        foreach ($user_team_member as $key => $value) {
            $new_user_team_member[$value->id] = $value;
        }

        foreach ($mems as $key => &$value) {
            if (isset($new_user_team_member[$value['user_team_member_id']])) {
                $value['name'] = $new_user_team_member[$value['user_team_member_id']]->name;
                $value['identity_card'] = $new_user_team_member[$value['user_team_member_id']]->identity_card;
                $value['sex'] = $new_user_team_member[$value['user_team_member_id']]->sex;
                $value['phone_number'] = $new_user_team_member[$value['user_team_member_id']]->phone_number;
            } else {
                $value['name'] = '';
                $value['identity_card'] = '';
                $value['sex'] = '';
                $value['phone_number'] = '';
            }
        }
        unset($value);

        $newMems = [];
        foreach ($mems as $key => $value) {
            if ($value['is_captain'] == 1) {
                $newMems['captain'][] = $value;
                continue;
            }
            $newMems['common'][] = $value;
        }
        $team['member'] = $newMems;
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
    public function update(Request $request, $id)
    {
        //

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
        OrmTeam::destroy($id);
        OrmTeamMember::where('team_id', '=', $id)->delete();
        return $out;
    }
}
