<?php

namespace App\Http\Controllers\H5\Club;

use App\Http\Controllers\H5Controller;
use App\Orms\Club as OrmClub;
use DB;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Template;
class ClubController extends H5Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
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
        //
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize = 2;
        $offset = ($pageNum - 1) * $pageSize;

        $count = DB::table('club')
            ->count();

        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $out['data']['page'] = $page;
        $ormClub = new OrmClub();
        $res = $ormClub
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();
        if ($res) {
            $out['data']['list'] = $res;
        }

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
        $ormClub = new OrmClub();

        $ormClub->name = $request->input('name');
        if ($request->input('cover_img')) {
            $ormClub->cover_img = $request->input('cover_img');
        }

        if ($request->input('summary')) {
            $ormClub->summary = $request->input('summary');
        }
        $user=Auth::user();
        if(!$user){
            $out['code'] = 2;
            $out['msg'] = '未登录';
            return $out;
        }
        $ormClub->mem_id = $user->id ;
        $ormClub->save();
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
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $res = OrmClub::where('id', $id)
            ->first();
        if ($res) {
            $out['data'] = $res;
        }

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
        //
        $ormClub = new OrmClub();

        $ormClub = $ormClub->find($request->input('id'));
        if (!$ormClub) {
            $out['code'] = 1;
            $out['msg'] = '不存在';
            return $out;
        }
        $v = $this->validator($request);
        if ($v->fails()) {
            $out['code'] = 1;
            $out['msg'] = $v->errors();
        }

        $ormClub->name = $request->input('name');
        if ($request->input('cover_img')) {
            $ormClub->cover_img = $request->input('cover_img');
        }

        if ($request->input('summary')) {
            $ormClub->summary = $request->input('summary');
        }

        $ormClub->save();
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
        OrmClub::destroy($id);
        return $out;
    }

 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function item($id)
    {
        //
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $d['name']='羽毛球';
        $d['id']=1;
        $d2['name']='篮球';
        $d2['id']=2;
        $out['data'][] = $d;
        $out['data'][] = $d2;
        return $out;
    }
 
        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function config($id)
    {
        //
        //
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $res = DB::table('club_config')
            ->where('club_id', $id)
            ->get();
        if ($res) {
            $out['data'] = $res;
        }

        return $out;
    }
}
