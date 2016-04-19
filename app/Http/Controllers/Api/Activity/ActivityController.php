<?php

namespace App\Http\Controllers\Api\Activity;

use App\Http\Controllers\ApiController;
use App\Orms\Activity as OrmActivity;
use DB;
use Illuminate\Http\Request;
use Validator;
use Auth;
class ActivityController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNum)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $out['data']['page']=[];
        //
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize=2;
        $offset=($pageNum-1)*$pageSize;

        $count= DB::table('activity')
            ->count();

        $page['nowPage']=$pageNum;
        $page['totalPage']=ceil($count/$pageSize);
        $page['totalSize']=$count;
        $out['data']['page'] = $page;
        $res = DB::table('activity')
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();
        if ($res) {
            $out['data']['list'] = $res;
        }

        return $out;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function labelList(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $out['data']['page']=[];
        //
        $pageNum = $request->input('pageNum') < 1 ? 1 : $request->input('pageNum');
        $label=$request->input('label');
        $pageSize=2;
        $offset=($pageNum-1)*$pageSize;

        $count= DB::table('activity')
            ->count();

        $page['nowPage']=$pageNum;
        $page['totalPage']=ceil($count/$pageSize);
        $page['totalSize']=$count;
        $out['data']['page'] = $page;
        $res = DB::table('activity')
            //->where('label','=',$label)
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();
        if ($res) {
            $out['data']['list'] = $res;
        }

        return $out;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required',
        ]);
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
        //
        $ormActivity = new OrmActivity();
        if ($request->input('cover_img')) {
            $ormActivity->cover_img = $request->input('cover_img');
        }
        if ($request->input('title')) {
            $ormActivity->title = $request->input('title');
        }

        if ($request->input('people_count')) {
            $ormActivity->people_count = $request->input('people_count');
        }

        if ($request->input('postion')) {
            $ormActivity->postion = $request->input('postion');
        }

        if ($request->input('start_time')) {
            $ormActivity->start_time = $request->input('start_time');
        }

        if ($request->input('cost')) {
            $ormActivity->cost = $request->input('cost');
        }

        if ($request->input('apply_start_time')) {
            $ormActivity->apply_start_time = $request->input('apply_start_time');
        }

        if ($request->input('apply_end_time')) {
            $ormActivity->apply_end_time = $request->input('apply_end_time');
        }

        if ($request->input('end_time')) {
            $ormActivity->end_time = $request->input('end_time');
        }

        if ($request->input('apply_type')) {
            $ormActivity->apply_type = $request->input('apply_type');
        }

        if ($request->input('min_male_count')) {
            $ormActivity->min_male_count = $request->input('min_male_count');
        }

        if ($request->input('min_female_count')) {
            $ormActivity->min_female_count = $request->input('min_female_count');
        }

        if ($request->input('introduction')) {
            $ormActivity->introduction = $request->input('introduction');
        }

        if ($request->input('rule')) {
            $ormActivity->rule = $request->input('rule');
        }

        if ($request->input('reward')) {
            $ormActivity->reward = $request->input('reward');
        }

        if ($request->input('points')) {
            $ormActivity->points = $request->input('points');
        }

        if ($request->input('link_man')) {
            $ormActivity->link_man = $request->input('link_man');
        }

        if ($request->input('link_mail')) {
            $ormActivity->link_mail = $request->input('link_mail');
        }

        if ($request->input('link_phone')) {
            $ormActivity->link_phone = $request->input('link_phone');
        }

        if ($request->input('link_qq')) {
            $ormActivity->link_qq = $request->input('link_qq');
        }

        $user=Auth::user();
        if(!$user){
            $out['code'] = 2;
            $out['msg'] = '未登录';
            return $out;
        }
        $ormActivity->mem_id = $user->id ;
 
        $ormActivity->save();

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
        $res = OrmActivity::where('id', $id)
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
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $ormActivity = new OrmActivity();

        $ormActivity = $ormActivity->find($request->input('id'));
        if (!$ormActivity) {
            $out['code'] = 1;
            $out['msg'] = '不存在';
            return $out;
        }
        if ($request->input('cover_img')) {
            $ormActivity->cover_img = $request->input('cover_img');
        }
        if ($request->input('title')) {
            $ormActivity->title = $request->input('title');
        }

        if ($request->input('people_count')) {
            $ormActivity->people_count = $request->input('people_count');
        }

        if ($request->input('postion')) {
            $ormActivity->postion = $request->input('postion');
        }

        if ($request->input('start_time')) {
            $ormActivity->start_time = $request->input('start_time');
        }

        if ($request->input('cost')) {
            $ormActivity->cost = $request->input('cost');
        }

        if ($request->input('apply_start_time')) {
            $ormActivity->apply_start_time = $request->input('apply_start_time');
        }

        if ($request->input('apply_end_time')) {
            $ormActivity->apply_end_time = $request->input('apply_end_time');
        }

        if ($request->input('end_time')) {
            $ormActivity->end_time = $request->input('end_time');
        }

        if ($request->input('apply_type')) {
            $ormActivity->apply_type = $request->input('apply_type');
        }

        if ($request->input('min_male_count')) {
            $ormActivity->min_male_count = $request->input('min_male_count');
        }

        if ($request->input('min_female_count')) {
            $ormActivity->min_female_count = $request->input('min_female_count');
        }

        if ($request->input('introduction')) {
            $ormActivity->introduction = $request->input('introduction');
        }

        if ($request->input('rule')) {
            $ormActivity->rule = $request->input('rule');
        }

        if ($request->input('reward')) {
            $ormActivity->reward = $request->input('reward');
        }

        if ($request->input('points')) {
            $ormActivity->points = $request->input('points');
        }

        if ($request->input('link_man')) {
            $ormActivity->link_man = $request->input('link_man');
        }

        if ($request->input('link_mail')) {
            $ormActivity->link_mail = $request->input('link_mail');
        }

        if ($request->input('link_phone')) {
            $ormActivity->link_phone = $request->input('link_phone');
        }

        if ($request->input('link_qq')) {
            $ormActivity->link_qq = $request->input('link_qq');
        }

        $ormActivity->save();

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
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        OrmActivity::destroy($id);
        return $out;
    }
}
