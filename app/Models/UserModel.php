<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/11/21
 * Time: 9:56
 */
namespace App\Models;

use DB;
use Auth;

class UserModel extends BaseModel
{

	/**
	 * 我的队员列表
	 * @param $request
	 * @return array
	 */
	public static function person_list($filter = false, $user_id = 0,$activity_id=0)
	{
		if ($user_id > 0) {

		} else {
			$user = Auth::user();
			$user_id = $user->id;
		}
		$tem = DB::table('user_team_member');

		$tem->where('mem_id', $user_id);
		//去除所有参加活动的没结束的活动
		if ($filter) {
			//获取所有的身份证号，判断其中有正在参加其他活动的身份证号，去除这部分用户
			//获取所有参加活动的身份证号
			$user_team_member=DB::table('user_team_member')
				->where('mem_id',$user_id)
				->get();

			$identity_cards= class_column($user_team_member, 'identity_card');
			$identity_cards_all=DB::table('user_team_member')
				->whereIn('identity_card',$identity_cards)
				->get();
			$user_ids_all= class_column($identity_cards_all, 'id');
			//判断其中有正在参加其他活动的身份证号
			$team_member_activity=DB::table('team_member')
			->whereIn('user_team_member_id',$user_ids_all)
			->get();

			$activity_ids=class_column($team_member_activity, 'activity_id');
			$activity=DB::table('activity')
			->whereIn('id',$activity_ids)
			->where('end_time','>',date('Y-m-d H-i-s',time()))
			->get();
			$activity_ids_on = class_column($activity, 'id');
			$user_team_member_ids_on=[];
			$activity_ids_on[]=$activity_id;
			
			foreach ( $team_member_activity as $key => $value) {
				if(in_array($value->activity_id, $activity_ids_on ))
				{
					$user_team_member_ids_on []=$value->user_team_member_id;
				}
			}
			//去除这部分用户
			if($user_team_member_ids_on){
				$tem->whereNotIn('id', $user_team_member_ids_on);
			}

		}
		$tem->orderBy('id', 'DESC');
		$list = $tem->get();
		return $list;
	}
}