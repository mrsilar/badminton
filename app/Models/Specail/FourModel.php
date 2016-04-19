<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/12/13
 * Time: 22:56
 */

namespace App\Models\Specail;

use DB;
use Auth;
use App\Models\ActivityModel;
use App\Models\ActivityGroupModel;
use App\Models\BaseModel;
class FourModel extends BaseModel
{
	public static function out(){
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		return$out;
	}
	/**
	 * 分组
	 */
	public static function group($activity_turn,$config,$teams){

		$out=self::out();
		//开启事务
		DB::beginTransaction();
		try {
			//分组
			$team_count = count($teams);
			$group_count =$config->group_count;
			$group_result =$config->team_count;
			$inserts = [];
			$g_count = 1;
			foreach ($teams as $key => $value) {
				$insert = [];
				$i = $key + 1;
				$insert['activity_turn_id'] = $activity_turn->id;
				if ($g_count < $group_count) {
					if ($i > $g_count * $group_result) {
						$g_count++;
					}
				}
				$insert['group_num'] = $g_count;
				$insert['team_id'] = $value->id;
				$inserts[] = $insert;
			}
			DB::table('team_group')
			->insert($inserts);
			//组内队伍与队伍打


			$team_match_inserts = [];
			$sets = [];//集合
			$team_ids=class_column($teams,'id');
			$team_relea=rsort_circle($team_ids);

			foreach ($team_relea as $rows) {
				foreach ($rows as $row) {
					$inert = [];
					$inert['team_a'] = $row[0];
					$inert['team_b'] = $row[1];
					$inert['activity_turn_id'] = $activity_turn->id;
					$inert['team_group_num'] = 1;
					$team_match_inserts[] = $inert;
				}
			}
			DB::table('team_match')
			->insert($team_match_inserts);

			//队伍内项目与项目
			$out = ActivityGroupModel::team_team($activity_turn);
			if ($out['code'] != 0) {
				throw new \Exception($out['msg'], $out['code']);
			}
			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			$out['code'] = $e->getCode();
			$out['msg'] = $e->getMessage();
			return $out;
		}
	}
	//计算生词净胜
	public static function get_win($activity_turn_id){
		$out=self::out();
		$team_match=DB::table('team_match')
		->where('activity_turn_id',$activity_turn_id)
		->get();
		if(!$team_match)
		{
			$out['code']=1;
			$out['msg']='team_match不存在';
			return $out;
		}
		$win=[];
		$win_all=[];

		foreach ($team_match as $row){
			if(!isset($win[$row->team_a])) $win[$row->team_a]=0;
			if(!isset($win[$row->team_b])) $win[$row->team_b]=0;
			if(!isset($win_all[$row->team_a])) $win_all[$row->team_a]=0;
			if(!isset($win_all[$row->team_b])) $win_all[$row->team_b]=0;
			if($row->win_b>0||$row->win_a>0){
				$win[$row->team_a]+=$row->win_a>$row->win_b?1:0;
				$win[$row->team_b]+=$row->win_a>$row->win_b?0:1;
					
				$win_all[$row->team_a]+=$row->win_a-$row->win_b;
				$win_all[$row->team_b]+=$row->win_b-$row->win_a;
			}

		}
		foreach ( $win  as $key=>$row)
		{
				$up=[];
				$up['win_count']=$row;
				DB::table('team_group')
				->where('activity_turn_id',$activity_turn_id)
				->where('team_id',$key)
				->update($up);
		}
		foreach ( $win_all  as $key=>$row)
		{
			$up=[];
			$up['win_count_all']=$row;
			DB::table('team_group')
			->where('activity_turn_id',$activity_turn_id)
			->where('team_id',$key)
			->update($up);
		}
		$out['data']['win_count']=$win;
		$out['data']['win_count_all']=$win_all;
		return $out;
	}
}