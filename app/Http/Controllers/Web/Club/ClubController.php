<?php

namespace App\Http\Controllers\Web\Club;

use App\Http\Controllers\WebController;
use App\Orms\Club as OrmClub;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;
use App\Models\ClubModel;

class ClubController extends WebController
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
		$out = ClubModel::lists($pageNum);
		Template::assign('list', $out['list']);
		Template::assign('page', $out['page']);
		Template::render('h5/club/list');
		//  return $out;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		//
		$detail = [];
		if ($request->input('id')) {
			$detail = DB::table('club')
			->where('id', $request->input('id'))
			->first();
		}
		Template::assign('detail', $detail);
		Template::assign('club_id', $request->input('id',0));
		Template::render('h5/member/club/create');
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
		$out['msg'] = '';
		$out['data'] = [];
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

		if ($request->input('postion')) {
			$ormClub->postion = $request->input('postion');
		}
		if ($request->input('province')) {
			$ormClub->province = $request->input('province');
		}
		if ($request->input('city')) {
			$ormClub->city = $request->input('city');
		}

		$user = Auth::user();
		if($request->input('club_id')>0){
			$ormClub->mem_id = $user->id;
			$ormClub->save();
			$idata['mem_id'] = $user->id;
			$idata['club_id'] = $ormClub->id;
			DB::table('user_club')
			->update($idata);
			return $out;
		}else{
			$ormClubs = DB::table('club')
			->where('mem_id', $user->id)
			->count();
			if ($ormClubs) {
				$out['code'] = 2;
				$out['msg'] = '目前一个用户只能创建一个俱乐部！';
				return $out;
			}
		}


		$ormClub->mem_id = $user->id;
		$ormClub->save();
		$idata['mem_id'] = $user->id;
		$idata['club_id'] = $ormClub->id;
		DB::table('user_club')
		->insert($idata);

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
	public function edit($id)
	{
		//
		$res = OrmClub::where('id', $id)
		->first();
		//发布的活动
		$activity = DB::table('activity')
		->where('club_id', $id)
		->get();

		//成员
		$mem = DB::table('user_club')
		->where('club_id', $id)
		->get();
		$mem_ids=class_column($mem,'mem_id');
		$me=DB::table('users')
		->whereIn('id',$mem_ids)
		->get();

		Template::assign('detail', $res);
		Template::assign('activity', $activity);
		Template::assign('member', $me);
		Template::render('h5/club/detail');
		// return $out;
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
		OrmClub::destroy($id);
		return $out;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
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
		$d['name'] = '羽毛球';
		$d['id'] = 1;
		$d2['name'] = '篮球';
		$d2['id'] = 2;
		$out['data'][] = $d;
		$out['data'][] = $d2;
		return $out;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
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
	public function 	join(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		//
		if($request->input('club_id')<1){
			$out['code'] = 3;
			$out['msg'] = 'club_id错误';
			return  $out;
		}
		$user=Auth::user();
		if(!$user){
			$out['code'] = 1;
			$out['msg'] = '未登录';
			return  $out;
		}
		
		$user_club = DB::table('user_club')
		->where('club_id', $request->input('club_id'))
		->where('mem_id',$user->id)
		->count();
		if($user_club>0){
			$out['code'] = 2;
			$out['msg'] = '已加入';
			return  $out;
		}
		$data_insert=[];
		$data_insert['club_id']=$request->input('club_id',0);
		$data_insert['mem_id']=$user->id;
		DB::table('user_club')
			->insert($data_insert);
		
		return $out;
	}

}
