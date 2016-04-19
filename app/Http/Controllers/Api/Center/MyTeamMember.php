<?php

namespace App\Http\Controllers\Api\Center;

use App\Http\Controllers\ApiController;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class MyTeamMember extends ApiController
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
}
