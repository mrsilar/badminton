<?php

namespace App\Models;

use App\Orms\Team as OrmTeam;
use App\Orms\TeamMember as OrmTeamMember;
use DB;
use Auth;
use App\Models\ActivityModel;
use Sms;
class TeamModel extends BaseModel
{

	public static function getList($pageNum = 0, $pageSize = 0, $team_id = 0, $activity_id)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$offset = ($pageNum - 1) * $pageSize;

		$te = DB::table('team');
		if ($pageNum) {
			$te->skip($offset);//offset  10
			$te->take($pageSize);//limit 5
		}
		if ($activity_id) {
			$te->where('activity_id', $activity_id);
		}
		if ($team_id) {
			$te->where('id', $team_id);
		}

		$teamsb = $te->get();

		if (!$teamsb) {
			$out['code'] = 1;
			$out['msg'] = 'team 暂无数据！';
			return $out;
		}
		//关系表
		$team_idss = class_column($teamsb, 'id');

		$team_member = DB::table('team_member')
		->orderBy('team_id', 'asc')
		->orderBy('is_captain', 'desc')
		->whereIn('team_id', $team_idss)
		->get();

		if (!$team_member) {
			$out['code'] = 2;
			$out['msg'] = 'team_member 暂无数据！';
			return $out;
		}
		$team_ids = [];
		$team_user_ids = [];
		foreach ($team_member as $row) {
			if (!in_array($row->team_id, $team_ids))
				$team_ids[] = $row->team_id;
			if (!in_array($row->user_team_member_id, $team_user_ids))
				$team_user_ids[] = $row->user_team_member_id;
		}


		$teams_tem = [];
		foreach ($teamsb as &$row) {
			$teams_tem[$row->id] = $row;
		}
		unset($row);

		foreach ($team_member as &$row) {
			$row->team_info = isset($teams_tem[$row->team_id]) ? $teams_tem[$row->team_id] : '';
		}
		unset($row);

		//队员
		$mems = DB::table('user_team_member')
		->whereIn('id', $team_user_ids)
		->get();
		$user_team_member = DB::table('user_team_member')
		->whereIn('id', $team_user_ids)
		->get();
		$new_user_team_member = [];
		foreach ($user_team_member as $key => $value) {
			$new_user_team_member[$value->id] = $value;
		}

		foreach ($team_member as &$row) {
			$row->user_team_member_info = isset($new_user_team_member[$row->user_team_member_id]) ? $new_user_team_member[$row->user_team_member_id] : '';
		}
		unset($row);

		$team_member_tmp = [];
		foreach ($team_member as $row) {
			if(!isset($row->team_info->has_captain)){
				$row->team_info->has_captain=0;
			}

			if($row->is_captain){
				$row->team_info->has_captain=1;
			}
			$team_member_tmp[$row->team_id]['team_info'] = $row->team_info;
			unset($row->team_info);
			$team_member_tmp[$row->team_id]['list'][] = $row;
		}
		$out['data'] = $team_member_tmp;
		return $out;
	}

	/**
	 * 队伍报名活动
	 * 先区分是不是个人中的单项  如果是则队伍名就是这个人的名字而且不去重
	 * @param $request
	 * @return mixed
	 */
	public static function join_activity($request)
	{
		//@todo duiyuanpanduan
		$join_activity_id = $request->input('id');
		$apply_item = $request->input('apply_item');
		$join_team_name = $request->input('team_name');
		$join_team_captain = $request->input('duizhang');
		$join_team_user_id =
		$user = Auth::user();
		//过滤
		if (!$join_activity_id) {
			$out['code'] = 1;
			$out['msg'] = '活动id不能为空';
			return $out;
		}
		$activity = ActivityModel::detail($join_activity_id);
		if (time() < strtotime($activity->apply_start_time)) {
			$out['code'] = 8;
			$out['msg'] = "报名未开始！";
			return $out;
		}
		if (time() > strtotime($activity->apply_end_time)) {
			$out['code'] = 9;
			$out['msg'] = "报名已截止！";
			return $out;
		}

		if (time() > strtotime($activity->apply_end_time)) {
			$out['code'] = 9;
			$out['msg'] = "报名已截止！";
			return $out;
		}
		$xc = DB::table('team')->
		where('activity_id', $join_activity_id)
		// ->where('mem_id', $user->id)
		->count();
		if ($activity->specail_config > 0) {
			if (self::team_exit($request)) {
				$out['code'] = 12;
				$out['msg'] = '队伍已存在';
				return $out;
			
			}
			$activity_specail_config_first = DB::table('activity_specail_config')
			->where('id', $activity->specail_config)
			->first();

			if ($xc >=( $activity_specail_config_first->group_count*$activity_specail_config_first->team_count)) {
				$out['code'] = 10;
				$out['msg'] = "{$activity_specail_config_first->team_count}只队伍已满！";
				return $out;
			}
		
		}
		

		//比赛项目类型
		if (!$join_team_name) {//个人而且单项
			return self::join_activity_1($request);
		} elseif ($join_team_captain) {//团体
			return self::join_activity_2($request);
		} else {//个人非单项
			return self::join_activity_3($request);
		}

	}
	/**
	 *  "apply_item" => array:1 [
    0 => array:3 [
      "itemId" => "238"
      "item" => "10"
      "people" => array:1 [
        0 => "1030"
      ]
    ]
	 */
/* 	public static function send_code($activity_id=0,$appley_item){
		$sms =new Sms();
		$code = rand(1000, 9999);
		$content = "您的验证码是：{$code}。请不要把验证码泄露给其他人。";
		$res = $sms::send($request->input('phoneNumber'), $content);
		if ($res->code != 2) {
			$out['code'] = (int) $res->code;
			$out['msg'] = (string) $res->msg;
			return $out;
		}
		
	}  */
	//个人且单项
	private static function join_activity_1($request)
	{
		$out['code'] = 0;
		$out['msg'] = '报名成功!';
		$user = Auth::user();
		$ids = [$user->user_team_member_id];
		if (self::has_join($ids)) {
			$out['code'] = 13;
			$out['msg'] = '有队员已参加正在进行的活动,请刷新页面重新获取';
			return $out;
		}
		//入库队伍信息
		$team_insert = [];
		$team_insert['name'] = $user->name;
		$team_insert['mem_id'] = $user->id;
		$team_insert['is_one'] = 1;
		$team_insert['activity_id'] = $request->input('id');
		$insert_team_id = DB::table('team')
		->insertGetId($team_insert);
		$category_re = DB::table('activity_category')
		->where('activity_id', $request->input('id'))
		->first();
		$category = [$category_re->apply_item];
		$ids = [
		[
		'item' => $category,
		'people' => [$user->user_team_member_id]
		]
		];
		self::save_team_member($ids, $request->input('id'), $insert_team_id, $user->name);
		return $out;
	}

	//团体
	private static function join_activity_2($request)
	{

		$user = Auth::user();
		$out['code'] = 0;
		$out['msg'] = "报名成功！";
		if (!$request->input('team_name')) {
			$out['code'] = 2;
			$out['msg'] = '队伍名称不能为空';
			return $out;
		}

		if (!$request->input('duizhang')) {
			$out['code'] = 3;
			$out['msg'] = '队长不能为空';
			return $out;
		}

		if (self::team_exit($request)) {
			$out['code'] = 12;
			$out['msg'] = '队伍已存在';
			return $out;

		}
		$apply_item = $request->input('apply_item');

		$ids = [];
		foreach ($apply_item as $row) {
			//
			if (!isset($row['people'])) {
				$out['code'] = 13;
				$out['msg'] = '人数不足';
				return $out;
			}

			if (count($row['people']) < get_people_num($row['item'])) {
				$out['code'] = 14;
				$out['msg'] = '人数不足';
				return $out;
			}
			foreach ($row['people'] as $val) {
				if (!in_array($val, $ids)) {
					$ids[] = $val;
				}
			}
		}

		if (self::has_join($ids)) {
			$out['code'] = 13;
			$out['msg'] = '有队员已参加正在进行的活动,请刷新页面重新获取';
			return $out;
		}

		//开启事务
		DB::beginTransaction();
		try {
			//入库队伍信息
			$team_insert = [];
			$team_insert['name'] = $request->input('team_name');
			$team_insert['mem_id'] = $user->id;
			$team_insert['activity_id'] = $request->input('id');
			$insert_team_id = DB::table('team')
			->insertGetId($team_insert);
			//队员
			self::save_team_member($apply_item, $request->input('id'), $insert_team_id, $team_insert['name']);
			//队长
			$team_member_insert['activity_id'] = $request->input('id');
			$team_member_insert['team_id'] = $insert_team_id;
			$team_member_insert['user_team_member_id'] = $request->input('duizhang');
			$team_member_insert['team_name'] = $request->input('team_name');
			$team_member_insert['mem_id'] = $user->id;
			$team_member_insert['is_captain'] = 1;
			$team_member_inserts [] = $team_member_insert;
			DB::table('team_member')
			->insert($team_member_inserts);

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
		}

		return $out;
	}

	//个人非单项
	private static function join_activity_3($request)
	{
		$user = Auth::user();
		$out['code'] = 0;
		$out['msg'] = '报名成功！';

		if (!$request->input('team_name')) {
			$out['code'] = 2;
			$out['msg'] = '队伍名称不能为空';
			return $out;
		}
		$apply_item = $request->input('apply_item');

		$ids = [];
		foreach ($apply_item as $row) {
			if (!isset($row['people'])) {
				$out['code'] = 13;
				$out['msg'] = '人数不足';
				return $out;
			}
			if (count($row['people']) < get_people_num($row['item'])) {
				$out['code'] = 14;
				$out['msg'] = '人数不足';
				return $out;
			}
			foreach ($row['people'] as $val) {
				if (!in_array($val, $ids)) {
					$ids[] = $val;
				}
			}
		}

		if (self::has_join($ids)) {
			$out['code'] = 13;
			$out['msg'] = '有队员已参加正在进行的活动,请刷新页面重新获取';
			return $out;
		}

		//入库队伍信息
		$team_insert = [];
		$team_insert['name'] = $request->input('team_name');
		$team_insert['mem_id'] = $user->id;
		$team_insert['activity_id'] = $request->input('id');
		$insert_team_id = DB::table('team')
		->insertGetId($team_insert);
		self::save_team_member($apply_item, $request->input('id'), $insert_team_id, $team_insert['name']);

		return $out;
	}

	//是否已经参加
	private static function has_join($user_team_member_ids = [])
	{
		$result = DB::table('team_member')
		->whereIn('user_team_member_id', $user_team_member_ids)
		->get();
		if (!$result) return false;
		//该活动是否正在进行
		$activity_ids = class_column($result, 'activity_id');
		$out = DB::table('activity')
		->whereIn('id', $activity_ids)
		->where('end_time', '>', date('Y-m-d H-i-s', time()))
		->count();
		if ($out < 1) return false;
		return true;
	}

	//队伍是否已存在
	private static function team_exit($request)
	{
		$team_count = DB::table('team_member')
		->where('activity_id', $request->input('id'))
		->where('team_name', $request->input('team_name'))
		->count();
		if ($team_count < 1) return false;
		return true;
	}

	//保存队伍
	private static function save_team_member($user_team_member_ids, $join_activity_id, $team_id, $join_team_name)
	{

		$user = Auth::user();
		//队伍队员关系表

		$team_member_inserts = [];
		$activity_category_member_inserts = [];
		foreach ($user_team_member_ids as $key => $value) {
			foreach ($value['people'] as $k => $v) {
				//队伍与队员
				$team_member_insert = [];
				$team_member_insert['activity_id'] = $join_activity_id;
				$team_member_insert['team_id'] = $team_id;
				$team_member_insert['user_team_member_id'] = $v;
				$team_member_insert['team_name'] = $join_team_name;
				$team_member_insert['mem_id'] = $user->id;
				$team_member_inserts [] = $team_member_insert;
				//项目与队员关系
				$activity_category_member_insert = [];
				$activity_category_member_insert['activity_category_id'] = $value['itemId'];
				$activity_category_member_insert['user_team_member_id'] = $v;
				$activity_category_member_insert['team_id'] = $team_id;
				$activity_category_member_inserts[] = $activity_category_member_insert;

			}
		}

		DB::table('team_member')
		->insert($team_member_inserts);
		DB::table('activity_category_member')
		->insert($activity_category_member_inserts);
		
		//验证队员
		//	self::send_code($request->input('id',0),$request->input('apply_item',[]));更新token
	}


}
