<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/11/21
 * Time: 9:53
 */

namespace App\Models;

use DB;
use Auth;
use App\Models\ActivityModel;

class ActivityGroupModel extends BaseModel
{

	public static $out;

	public function __construct()
	{
		parent::__construct();
		self::$out['code'] = 0;
		self::$out['msg'] = 'ok';
		self::$out['data'] = array();
	}

	//分组
	public static function group($req = [])
	{
		$out = self::$out;
		//过滤
		if (!isset($req['activity_turn_id'])) {
			$out['code'] = 1;
			$out['msg'] = 'activity_turn_id 参数错误';
			return $out;
		}
		if (!isset($req['game_system'])) {
			$out['code'] = 2;
			$out['msg'] = 'game_system 参数错误';
			return $out;
		}
		if (!in_array($req['game_system'], [0, 1, 2])) {
			$out['code'] = 2;
			$out['msg'] = 'game_system 参数错误';
			return $out;
		}
		if (in_array($req['game_system'], [1, 2]) && empty($req['group_count'])) {
			$out['code'] = 6;
			$out['msg'] = '分组数 参数错误';
			return $out;
		}
		$activity_turn = DB::table('activity_turn')
		->where('id', $req['activity_turn_id'])
		->first();
		if (!$activity_turn) {
			$out['code'] = 3;
			$out['msg'] = '分组不存在';
			return $out;
		}
		$activity_detail = ActivityModel::detail($activity_turn->activity_id);
		if (time() < strtotime($activity_detail->apply_end_time)) {
			$out['code'] = 4;
			$out['msg'] = '活动报名未结束';
			return $out;
		}
		//自动抽签
		$out = ActivityModel::draw_all($activity_detail->id);

		if ($out['code'] != 0) {
			return $out;
		}
		$teams = DB::table('team')
		->where('activity_id', $activity_turn->activity_id)
		->where('draw_id', '>', 0)
		->orderBy('draw_id', 'asc')
		->get();
		if (count($teams) < 3) {
			$out['code'] = 5;
			$out['msg'] = '队伍数小于3';
			return $out;
		}
		DB::table('activity_turn')
		->where('id', $activity_turn->id)
		->update(['game_system' => $req['game_system']]);

		if ($req['game_system'] == 0) {
			try {
				$out = self::group_tao($activity_turn, $teams);
			} catch (\Exception $e) {
				$out['code'] = $e->getCode();
				$out['msg'] = $e->getMessage();
			}
		} elseif ($req['game_system'] == 1) {
			try {
				$out = self::group_wai($activity_turn, $teams, $req['group_count']);
			} catch (\Exception $e) {
				$out['code'] = $e->getCode();
				$out['msg'] = $e->getMessage();
			}
		} elseif ($req['game_system'] = 2) {
			try {
				$out = self::group_nei($activity_turn, $teams, $req['group_count']);
			} catch (\Exception $e) {
				$out['code'] = $e->getCode();
				$out['msg'] = $e->getMessage();
			}
		}
		return $out;
	}

	//外循环
	public static function  group_wai($activity_turn, $teams, $group_count)
	{
		$out = self::$out;

		$team_group_count = DB::table('team_group')
		->where('activity_turn_id', $activity_turn->id)
		->count();
		if ($team_group_count > 0) {
			$out['code'] = 92;
			$out['msg'] = '已分组！';
			return $out;
		}
		//上一轮是内循环时
		$prev = false;
		if ($activity_turn->turn > 1) {
			$activity_turn_prev = DB::table('activity_turn')
			->where('activity_id', $activity_turn->activity_id)
			->where('turn', $activity_turn->turn - 1)
			->where('game_system', 2)
			->first();
			if ($activity_turn_prev) {
				$prev = true;
			}
		}
		//上一轮是内循环时
		if ($prev) {
			$out = self::group_nei_wai($activity_turn, $activity_turn_prev, $group_count);
			return $out;
		}

		$out = self::group_wai_more($activity_turn, $teams, $group_count);
		return $out;
	}

	//外循环
	public static function group_wai_more($activity_turn, $teams, $group_count)
	{
		$out = self::$out;
		//开启事务
		DB::beginTransaction();
		try {
			//分组
			$team_count = count($teams);
			$group_result = team_group($team_count, $group_count);

			if ($group_result < 1) {
				$out['code'] = 91;
				$out['msg'] = '分组失败！';
				return $out;
			}
			$inserts = [];
			$g_count = 1;
			$team_group_nums = [];
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
				if (!in_array($g_count, $team_group_nums)) {
					$team_group_nums[] = $g_count;
				}
				$insert['team_id'] = $value->id;
				$inserts[] = $insert;
			}


			DB::table('team_group')
			->insert($inserts);
			//组与组对打
			$reval = rsort_circle($team_group_nums);


			$group_match_inserts = [];
			foreach ($reval as $rowi) {
				foreach ($rowi as $row) {
					$insert = [];
					$insert['activity_turn_id'] = $activity_turn->id;
					$insert['group_a'] = $row[0];
					$insert['group_b'] = $row[1];
					$group_match_inserts[] = $insert;
				}

			}

			DB::table('group_match')
			->insert($group_match_inserts);
			//组与组里的队伍与队伍打
			$group_match = DB::table('group_match')
			->where('activity_turn_id', $activity_turn->id)
			->get();
			$team_group = DB::table('team_group')
			->where('activity_turn_id', $activity_turn->id)
			->get();

			$team_group_tmp = [];
			foreach ($team_group as $row) {
				$team_group_tmp[$row->group_num][] = $row;
			}

			$insert_team_matchs = [];

			$insert_team_matchs = [];
			foreach ($group_match as $row) {
				foreach ($team_group_tmp[$row->group_a] as $rowa) {
					foreach ($team_group_tmp[$row->group_b] as $rowb) {

						$insert_team_match = [];
						$insert_team_match['team_a'] = $rowa->team_id;
						$insert_team_match['team_b'] = $rowb->team_id;
						$insert_team_match['activity_turn_id'] = $activity_turn->id;
						$insert_team_match['group_match_id'] = $row->id;
						$insert_team_matchs[] = $insert_team_match;
					}
				}

			}
			shuffle($insert_team_matchs);

			DB::table('team_match')
			->insert($insert_team_matchs);
			$out = self::team_team($activity_turn);
			if ($out['code'] != 0) {
				throw new \Exception($out['msg'], $out['code']);
			}
			DB::commit();
			return $out;
		} catch (\Exception $e) {
			DB::rollBack();
			$out['code'] = $e->getCode();
			$out['msg'] = $e->getMessage();
			return $out;
		}

		return $out;
	}

	/**
	 * 内循环到外循环
	 * @param $activity_turn
	 * @param $activity_turn_prev
	 * @return mixed
	 * 首先，进行大的分组(前几名一组)
	 * 然后，进行小的分组(大组里上一轮一组的跟其他不是一组的打)
	 * 再分配队伍与队伍
	 * 最后分配队伍里的项目
	 */
	public static function group_nei_wai($activity_turn, $activity_turn_prev, $group_count)
	{

		$out = self::$out;


		//获取上一轮信息
		$team_group_prev = DB::table('team_group')
		->where('activity_turn_id', $activity_turn_prev->id)
		->get();
		foreach ($team_group_prev as $row) {
			if ($row->rank < 1 || $row->rank > 9999) {
				$out['code'] = 97;
				$out['msg'] = '上一轮未打分！';
				return $out;
			}
		}
		//分组是否合法
		$team_group_prev_tmp = [];
		foreach ($team_group_prev as $row) {
			$team_group_prev_tmp[$row->group_num][] = $row;
		}

		$team_group_one_count = count($team_group_prev_tmp[1]);
		if ($group_count > $team_group_one_count) {
			$out['code'] = 98;
			$out['msg'] = '非法分组！';
			return $out;
		}
		if ($group_count != $team_group_one_count) {//分成一
			$group_result = team_group($team_group_one_count, $group_count);
			if ($group_result < 1) {
				$out['code'] = 99;
				$out['msg'] = '分组失败！';
				return $out;
			}
		} else {
			$group_result = 1;
		}

		//开启事务
		DB::beginTransaction();
		try {
			//分组
			$team_group_inserts = [];
			foreach ($team_group_prev_tmp as $rows) {
				foreach ($rows as $key => $row) {
					$insert = [];
					$insert['activity_turn_id'] = $activity_turn->id;
					$insert['group_num'] = $row->group_num;
					$insert['team_id'] = $row->team_id;
					for ($i = 1; $i <= $group_count; $i++) {
						if ($row->rank <= $i * $group_result) {
							$group_num = $i;
							break;
						}
					}
					$team_group_prev_tmp_count = count($team_group_prev_tmp);
					$insert['all_rank_from'] = ($group_num - 1) * $team_group_prev_tmp_count * $group_result + 1;
					$insert['all_rank_to'] = $group_num * $team_group_prev_tmp_count * $group_result;
					$insert['group_group_num'] = $group_num;
					$team_group_inserts[] = $insert;
				}
			}

			DB::table('team_group')
			->insert($team_group_inserts);

			$team_group_inserts_tmp = [];
			foreach ($team_group_inserts as $row) {
				$team_group_inserts_tmp[$row['group_group_num']][] = $row;
			}
			//组与组打

			$group_match_inserts = [];
			foreach ($team_group_inserts_tmp as $key => $row) {

				$team_group_nums = array_column($row, 'group_num');
				$team_group_nums = array_unique($team_group_nums);
				$reval = c_3_2($team_group_nums);
				foreach ($reval as $val) {
					$insert = [];
					$insert['activity_turn_id'] = $activity_turn->id;
					$insert['group_a'] = $val[0];
					$insert['group_b'] = $val[1];
					$insert['group_group_num'] = $key;
					$group_match_inserts[] = $insert;
				}
			}
			 
			DB::table('group_match')
			->insert($group_match_inserts);
			//分配队伍与队伍
			$team_group_inserts_tmp_all = [];
			foreach ($team_group_inserts as $row) {
				$team_group_inserts_tmp_all[$row['group_group_num']][$row['group_num']][] = $row;
			}
			$group_matchs = DB::table('group_match')
			->where('activity_turn_id', $activity_turn->id)
			->get();
			$team_match_inserts = [];
			foreach ($group_matchs as $row) {
				$group_as = $team_group_inserts_tmp_all[$row->group_group_num][$row->group_a];
				$group_bs = $team_group_inserts_tmp_all[$row->group_group_num][$row->group_b];
				foreach ($group_as as $row_a) {
					foreach ($group_bs as $row_b) {
						$insert = [];
						$insert['team_a'] = $row_a['team_id'];
						$insert['team_b'] = $row_b['team_id'];
						$insert['activity_turn_id'] = $activity_turn->id;
						$insert['group_match_id'] = $row->id;
						$team_match_inserts[] = $insert;
					}
				}
			}

			DB::table('team_match')
			->insert($team_match_inserts);
			//队伍里的项目
			$out = self::team_team($activity_turn);
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
		return $out;
	}


	//内循环
	public static function  group_nei($activity_turn, $teams, $group_count)
	{
		$out = self::$out;

		$team_group_count = DB::table('team_group')
		->where('activity_turn_id', $activity_turn->id)
		->count();
		if ($team_group_count > 0) {
			$out['code'] = 92;
			$out['msg'] = '已分组！';
			return $out;
		}
		//上一轮是内循环时
		$prev = false;
		if ($activity_turn->turn > 1) {
			$activity_turn_prev = DB::table('activity_turn')
			->where('activity_id', $activity_turn->activity_id)
			->where('turn', $activity_turn->turn - 1)
			->where('game_system', 2)
			->first();
			if ($activity_turn_prev) {
				$prev = true;
			}
		}
		//上一轮是内循环时
		if ($prev) {
			$out = self::group_nei_nei($activity_turn, $activity_turn_prev, $group_count);
			return $out;
		}

		$out = self::group_nei_more($activity_turn, $teams, $group_count);

		return $out;
	}

	/**
	 * 内循环
	 * @param $activity_turn
	 * @param $teams
	 * @param $group_count
	 */
	public static function group_nei_more($activity_turn, $teams, $group_count)
	{
		//开启事务
		DB::beginTransaction();
		try {
			//添加下一组
			if ($activity_turn->turn > 1) {
				$out['code'] = 97;
				$out['msg'] = '已结束！';
				return $out;
			}
			$fsa = DB::table('activity_turn')
			->where('activity_id', $activity_turn->activity_id)
			->where('turn', $activity_turn->turn + 1)
			->count();
			if ($fsa < 1) {
				$inert['activity_id'] = $activity_turn->activity_id;
				$inert['turn'] = $activity_turn->turn + 1;
				$inert['game_system'] = 10;
				DB::table('activity_turn')
				->insert($inert);
			}
			//分组
			$team_count = count($teams);
			$group_result = team_group($team_count, $group_count);
			if ($group_result < 1) {
				$out['code'] = 91;
				$out['msg'] = '分组失败！';
				return $out;
			}
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
			$team_group_tmp = [];
			foreach ($inserts as $row) {
				$team_group_tmp[$row['group_num']][] = $row;
			}
			$team_match_inserts = [];
			foreach ($team_group_tmp as $key => $rowii) {
				$team_ids = array_column($rowii, 'team_id');
				$team_relea = rsort_circle($team_ids);
				foreach ($team_relea as $rows) {
					foreach ($rows as $row) {
						$inert = [];
						$inert['team_a'] = $row[0];
						$inert['team_b'] = $row[1];
						$inert['activity_turn_id'] = $activity_turn->id;
						$inert['team_group_num'] = $key;
						$team_match_inserts[] = $inert;
					}
				}
			}

			DB::table('team_match')
			->insert($team_match_inserts);

			//队伍内项目与项目
			$out = self::team_team($activity_turn);
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

	/**
	 * 内循环到内循环
	 * @param $activity_turn
	 * @param $activity_turn_prev
	 * @param $group_count
	 */
	public static function group_nei_nei($activity_turn, $activity_turn_prev, $group_count)
	{
		$out = self::$out;
		//分组
		//获取上一轮信息
		$team_group_prev = DB::table('team_group')
		->where('activity_turn_id', $activity_turn_prev->id)
		->get();
		
		foreach ($team_group_prev as $row) {
			if ($row->rank < 1 || $row->rank > 9999) {
				$out['code'] = 97;
				$out['msg'] = '上一轮未打分！';
				 return $out;
			}
		}
		//分组是否合法

		$team_group_prev_tmp = [];
		foreach ($team_group_prev as $row) {
			$team_group_prev_tmp[$row->group_num][] = $row;
		}

		$team_group_one_count = count($team_group_prev_tmp[1]);
		if ($group_count > $team_group_one_count) {
			$out['code'] = 98;
			$out['msg'] = '非法分组！';
			return $out;
		}
		if ($group_count != $team_group_one_count) {//分成一
			$group_result = team_group($team_group_one_count, $group_count);
			if ($group_result < 1) {
				$out['code'] = 99;
				$out['msg'] = '分组失败！';
				return $out;
			}
		} else {
			$group_result = 1;
		}
		
		//开启事务
		DB::beginTransaction();
		try {
			//分组
			$team_group_inserts = [];
			$group_num = 1;
			foreach ($team_group_prev_tmp as $key => $rows) {
				foreach ($rows as $row) {
					$insert = [];
					$insert['activity_turn_id'] = $activity_turn->id;
					$insert['team_id'] = $row->team_id;
					for ($i = 1; $i <= $group_count; $i++) {
						if ($row->rank <= $i * $group_result) {
							$group_num = $i;
							break;
						}
					}
					$group_group_inserts_tmp_count = count($team_group_prev_tmp);
					$insert['group_num'] = $group_num;
					$insert['all_rank_from'] = ($group_num - 1) * $group_result * $group_group_inserts_tmp_count + 1;
					$insert['all_rank_to'] = $group_num * $group_result * $group_group_inserts_tmp_count;

					$team_group_inserts[] = $insert;
				}
			}


			DB::table('team_group')
			->insert($team_group_inserts);
			//组内队伍打

			$team_group_tmp = [];
			foreach ($team_group_inserts as $row) {
				$team_group_tmp[$row['group_num']][] = $row;
			}
			$team_match_inserts = [];
			$sets = [];//集合

			foreach ($team_group_tmp as $key => $rowii) {
				$team_ids = array_column($rowii, 'team_id');
				$team_relea = rsort_circle($team_ids);
			dump($team_relea);
				foreach ($team_relea as $rows) {
					foreach ($rows as $row) {
						$inert = [];
						$inert['team_a'] = $row[0];
						$inert['team_b'] = $row[1];
						$inert['activity_turn_id'] = $activity_turn->id;
						$inert['team_group_num'] = $key;
						$team_match_inserts[] = $inert;
					}
				}

			}

			DB::table('team_match')
			->insert($team_match_inserts);
			//队伍内项目打
			$out = self::team_team($activity_turn);
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

		return $out;
	}

	/**
	 * 只支持一直淘汰
	 * @param $activity_turn
	 * @param $teams
	 * @return mixed
	 */
	public static function  group_tao($activity_turn, $teams)
	{
		$out = self::$out;

		$team_group_count = DB::table('team_group')
		->where('activity_turn_id', $activity_turn->id)
		->count();
		if ($team_group_count > 0) {
			$out['code'] = 92;
			$out['msg'] = '已分组！';
			return $out;
		}
		//上一轮是淘汰时
		$prev = false;
		if ($activity_turn->turn > 1) {
			$activity_turn_prev = DB::table('activity_turn')
			->where('activity_id', $activity_turn->activity_id)
			->where('turn', $activity_turn->turn - 1)
			->where('game_system', 0)
			->first();
			if ($activity_turn_prev) {
				$prev = true;
			}
		}

		if ($prev) {
			$out = self::group_tao_tao($activity_turn, $activity_turn_prev, $teams);
			return $out;
		}

		$out = self::group_tao_more($activity_turn, $teams);

		return $out;
		$out = self::$out;


	}

	/**
	 * 淘汰
	 * @param $activity_turn
	 * @param $teams
	 */
	public static function group_tao_more($activity_turn, $teams)
	{
		$out = self::$out;
		//开启事务
		DB::beginTransaction();
		try {
			$team_count = count($teams);
			//添加下一轮
			if ($team_count > 2) {
				$inert = [];
				$inert['activity_id'] = $activity_turn->activity_id;
				$inert['turn'] = $activity_turn->turn + 1;
				$inert['game_system'] = 10;
				DB::table('activity_turn')
				->insert($inert);
			}

			//分组

			$team_count_yu = $team_count % 2;
			$team_count_2 = ($team_count_yu == 0) ? $team_count : ($team_count + 1);
			$group_count = $team_count_2 / 2;
			$group_result = 2;

			$team_group_inserts = [];
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
				$insert['all_rank_from'] = 1;
				$insert['all_rank_to'] = $team_count;
				$team_group_inserts[] = $insert;
			}

			DB::table('team_group')
			->insert($team_group_inserts);
			//组内队伍打
			$team_groups = DB::table('team_group')
			->where('activity_turn_id', $activity_turn->id)
			->get();

			$team_group_tmp = [];
			foreach ($team_groups as $key => $value) {
				$team_group_tmp[$value->group_num][] = $value;
			}

			$team_match_inserts = [];
			foreach ($team_group_tmp as $key => $value) {
				$insert = [];
				if (!isset($value[1])) {
					continue;
				}
				$insert['activity_turn_id'] = $activity_turn->id;
				$insert['team_group_num'] = $key;
				$insert['team_a'] = $value[0]->team_id;
				$insert['team_b'] = $value[1]->team_id;
				$team_match_inserts[] = $insert;
			}

			DB::table('team_match')->insert($team_match_inserts);
			//队伍内项目打
			$out = self::team_team($activity_turn);
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
		return $out;
	}

	/**
	 * 淘汰到淘汰
	 * @param $activity_turn
	 * @param $teams
	 */
	public static function group_tao_tao($activity_turn, $activity_turn_prev, $teams)
	{
		$out = self::$out;
		//分组
		
		//获取上一轮信息
		$team_group_prev = DB::table('team_group')
		->where('activity_turn_id', $activity_turn_prev->id)
		->get();
		//更新分数
		$team_match = DB::table('team_match')
		->where('activity_turn_id', $activity_turn_prev->id)
		->get();
		$win_team_ids=[];
		foreach ($team_match  as $row){
			
			if($row->win_a>$row->win_b){
				if(!in_array($row->team_a,$win_team_ids)){
					$win_team_ids[]=$row->team_a;
				}		
			}
			if($row->win_a<$row->win_b){
				if(!in_array($row->team_b,$win_team_ids)){
					$win_team_ids[]=$row->team_b;
				}
			}
		}
	
			foreach ($win_team_ids as $value) {
				DB::table('team_group')
				->where('activity_turn_id', $activity_turn_prev->id)
				->where('team_id',$value)
				->update(['rank'=>1]);
			}
			
			if(count($win_team_ids)<count($team_match)){ 
				$out['code'] = 97;
				$out['msg'] = '上一轮未打分！';
				return $out;
			}
		//获取上一轮所有的胜者
		$team_group_prev_valid = [];
		foreach ($team_group_prev as $row) {
			if ($row->rank == 1) {
				$team_group_prev_valid[] = $row;
			}

		}

		//开启事务
		DB::beginTransaction();
		try {
			$team_count = count($team_group_prev_valid);
			//添加下一轮
			if ($team_count > 2) {
				$inert = [];
				$inert['activity_id'] = $activity_turn->activity_id;
				$inert['turn'] = $activity_turn->turn + 1;
				$inert['game_system'] = 10;
				DB::table('activity_turn')
				->insert($inert);
			}

			//分组
			$team_count_yu = $team_count % 2;
			$team_count_2 = ($team_count_yu == 0) ? $team_count : ($team_count + 1);
			$group_count = $team_count_2 / 2;
			$group_result = 2;

			$team_group_inserts = [];
			$g_count = 1;

			shuffle($team_group_prev_valid);

			foreach ($team_group_prev_valid as $key => $value) {
				$insert = [];
				$i = $key + 1;
				$insert['activity_turn_id'] = $activity_turn->id;
				if ($g_count < $group_count) {
					if ($i > $g_count * $group_result) {
						$g_count++;
					}
				}
				$insert['group_num'] = $g_count;
				$insert['team_id'] = $value->team_id;
				$insert['all_rank_from'] = 1;
				$insert['all_rank_to'] = $team_count;
				$team_group_inserts[] = $insert;
			}

			DB::table('team_group')
			->insert($team_group_inserts);
			//组内队伍打
			$team_groups = DB::table('team_group')
			->where('activity_turn_id', $activity_turn->id)
			->get();

			$team_group_tmp = [];
			foreach ($team_groups as $key => $value) {
				$team_group_tmp[$value->group_num][] = $value;
			}

			$team_match_inserts = [];
			foreach ($team_group_tmp as $key => $value) {
				$insert = [];
				if (!isset($value[1])) {
					continue;
				}
				$insert['activity_turn_id'] = $activity_turn->id;
				$insert['team_group_num'] = $key;
				$insert['team_a'] = $value[0]->team_id;
				$insert['team_b'] = $value[1]->team_id;
				$team_match_inserts[] = $insert;
			}

			DB::table('team_match')->insert($team_match_inserts);
			//队伍内项目打
			$out = self::team_team($activity_turn);
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
		return $out;
	}

	public static function team_team($activity_turn)
	{
		$out = self::$out;
		//队伍与队伍打
		$activity = ActivityModel::detail($activity_turn->activity_id);
		$team_match = DB::table('team_match')
		->where('activity_turn_id', $activity_turn->id)
		->get();
		$activity_category = DB::table('activity_category')
		->where('activity_id', $activity->id)
		->get();

		$team_match_member_inserts = [];
		if ($activity->apply_type == 1) {//个人
			foreach ($team_match as $row) {
				foreach ($activity_category as $val_a) {
					foreach ($activity_category as $val_b) {
						$inert = [];
						$inert['team_match_id'] = $row->id;
						$inert['category_a_id'] = $val_a->id;
						$inert['category_b_id'] = $val_b->id;

						$team_match_member_inserts[] = $inert;
					}
				}
			}
		} else {//团体
			foreach ($team_match as $row) {
				foreach ($activity_category as $val) {
					$inert = [];
					$inert['team_match_id'] = $row->id;
					$inert['category_a_id'] = $val->id;
					$inert['category_b_id'] = $val->id;
					$team_match_member_inserts[] = $inert;

				}
			}
		}

		DB::table('team_member_match')->insert($team_match_member_inserts);

		//队员对打关系
		$team_member_match_category_member_inserts = [];
		foreach ($team_match as $row) {
			$team_member_match_tmp = DB::table('team_member_match')
			->where('team_match_id', $row->id)
			->get();
			foreach ($team_member_match_tmp as $val) {
				//获取对应的队员
				$item_user_a = DB::table('activity_category_member')
				->where('team_id', $row->team_a)
				->where('activity_category_id', $val->category_a_id)
				->get();
				$item_user_b = DB::table('activity_category_member')
				->where('team_id', $row->team_b)
				->where('activity_category_id', $val->category_b_id)
				->get();
				$b_user = [];
				foreach ($item_user_b as $vi) {
					$b_user[] = $vi->user_team_member_id;
				}
				foreach ($item_user_a as $key => $vi) {
					$tmp = [];
					$tmp['team_member_match_id'] = $val->id;
					$tmp['user_team_member_id_a'] = $vi->user_team_member_id;
					if (isset($b_user[$key])) {
						$tmp['user_team_member_id_b'] = $b_user[$key];
					}
					$team_member_match_category_member_inserts[] = $tmp;
				}
			}
		}


		DB::table('team_member_match_category_member')->insert($team_member_match_category_member_inserts);

		return $out;
	}

}