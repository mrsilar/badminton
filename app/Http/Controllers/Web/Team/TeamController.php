<?php

namespace App\Http\Controllers\Web\Team;

use App\Http\Controllers\WebController;
use App\Models\TeamModel;
use App\Orms\Team as OrmTeam;
use App\Orms\TeamMember as OrmTeamMember;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;
use Redirect;
class TeamController extends WebController
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
        
        $count = DB::table('team')
            ->count();
        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $res = TeamModel::getList($pageNum, $pageSize);

        //return $out;
        Template::assign('list', $res);
        Template::assign('page', $page);
        Template::render('h5/team/list');
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
        $out=TeamModel::getList(0,0,$id,0);
        if(!$out['data'])
        {
            Template::assign('detail',  $out['data']);
            Template::render('h5/team/detail');
            exit();
        }

        Template::assign('detail',  $out['data'][$id]);
        Template::render('h5/team/detail');
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
    public function destroy(Request $request)
    {
        //
        $id = $request->input('id');
         $user = Auth::user();
        DB::table('team')
            ->where('mem_id',$user->id)
            ->where('id',$id)
            ->delete();
        DB::table('team_member')
            ->where('mem_id',$user->id)
            ->where('team_id',$id)
            ->delete();
        return Redirect::to('/h5/member/team');
    }

    //报名
    public function joinActivity(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = [];
        //取值

        $out=TeamModel::join_activity($request);
        
        return $out;
    }
}
