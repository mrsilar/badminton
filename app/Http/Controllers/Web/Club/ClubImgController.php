<?php

namespace App\Http\Controllers\H5\Club;

use App\Http\Controllers\H5Controller;
use App\Orms\Club as OrmClub;
use DB;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Template;
class ClubImgController extends H5Controller
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
    public function index(Request $request)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $out['data']['page'] = [];
        //
        $pageNum = $request->input('pageNumber ') < 1 ? 1 : $request->input('pageNumber ');
        $pageSize = 20;
        $offset = ($pageNum - 1) * $pageSize;

        $count = DB::table('club_img')
                ->where('club_id',$request->input('clubId'))
            ->count();

        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $out['data']['page'] = $page;
       
        $res =DB::table('club_img')
            ->where('club_id',$request->input('clubId'))
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();
        if ($res) {
            $out['data']['list'] = $res;
        }
        Template::assign('list',$res);
        Template::assign('page',$page);
        Template::render('h5/club_img/list');
       // return $out;
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
        if (isset($inser_data['coverImg'])) {
            $inser_data['cover_img'] = $inser_data['coverImg'];
            unset($inser_data['coverImg']);
        }
      
       $inser_data['mem_id'] = $user->id;
        DB::table('club_img')
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

        $team = DB::table('club_img')
            ->where('id', $id)
            ->first();

        if (!$team) {
            return $out;
        }
        Template::assign('detail',$team);
        Template::render('h5/club_img/detail');
        //$out['data'] = $team;
        //return $out;
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
        if (isset($inser_data['coverImg'])) {
            $inser_data['cover_img'] = $inser_data['coverImg'];
            unset($inser_data['coverImg']);
        }
        $team = DB::table('club_img')
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
        DB::table('club_img')
        ->where('id', '=', $id)->delete();
        return $out;
    }

 

    
}
