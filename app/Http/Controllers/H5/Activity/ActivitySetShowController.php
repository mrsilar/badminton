<?php

namespace App\Http\Controllers\H5\Activity;

use App\Http\Controllers\H5Controller;
use App\Orms\Activity as OrmActivity;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;
use Redirect;
use View;
use Cookie;
use App\Models\ActivityModel;
use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\ActivityGroupModel;
use App\Models\ActivitySetShowModel;
use App\Models\Specail\FourModel;
class ActivitySetShowController extends H5Controller
{


	public function mingdangs(Request $request)
	{

		$activity_id = $request->input('activity_id');
		//
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$out = TeamModel::getList(0, 0, 0, $activity_id);

		Template::assign('data', $out['data']);
		Template::assign('i', 0);
		Template::assign('activity_id', $activity_id);
		Template::render('h5/activity/set/mingdangs');
	}

	//抽签
	public function cqjieguo(Request $request)
	{
		if (!$request->input('activity_id')) {

			Template::assign('list', []);
			Template::render('h5/activity/cqjieguo');
			exit;
		}
		$res = DB::table('team')
		->where('activity_id', $request->input('activity_id'))
		->get();

		Template::assign('list', $res);
		Template::render('h5/activity/set/cqjieguo');
	}

	//抽签
	public function postchouqian(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$out = ActivityModel::draw($request->all());
		return $out;
	}


	public function saikuanglist(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		Template::assign('activity_id', $request->input('activity_id'));
		//过滤
		$activity_detail=ActivityModel::detail($request->input('activity_id'));
		if (!$activity_detail) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_turn_id')}");
			Template::assign('error', '改活动不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$config=DB::table('activity_specail_config')
		->where('id',$activity_detail->specail_config)
		->first();
		if(!$config){
			Template::render('h5/activity/set/saikuanglist');
			exit();
		}
		$team_count=DB::table('team')
		->where('activity_id',$request->input('activity_id'))
		->get();

		if (count($team_count)<($config->group_count*$config->team_count) ){
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '报名未结束');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//判断是否分组，若未分组分组
		$activity_turn=DB::table('activity_turn')
		->where('activity_id',$request->input('activity_id'))
		->where('turn',1)
		->first();
		if(!$activity_turn)
		{
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '该阶段不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_match=DB::table('team_match')
		->where('activity_turn_id',$activity_turn->id)
		->get();
		if(!$team_match)
		{
			$out=FourModel::group($activity_turn,$config,$team_count);
		}
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group(['activity_turn_id'=>$activity_turn->id]);
		$out_team_match = ActivitySetShowModel::team_match(['activity_turn_id'=>$activity_turn->id]);

		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/member/activity/specail/four/score?activity_id={$request->input('activity_id')}");
			Template::assign('error', $out['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/member/activity/specail/four/score?activity_id={$request->input('activity_id')}");
			Template::assign('error', $out['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_match_rela=[];
		foreach ($out_team_match['data'] as $row)
		{
			$team_match_rela[$row->team_a][$row->team_b]=$row;
		}
		$win=FourModel::get_win($activity_turn->id);
		if(!empty($win['data'])){
			$win_count_count=0;
			foreach ($out_team_group['data'] as &$row){
				$win_count_count+=@$win['data']['win_count'][$row->team_id];
				$row->win_count=@$win['data']['win_count'][$row->team_id];
				$row->win_count_all=@$win['data']['win_count_all'][$row->team_id];
			}
		}

		unset($row);

		Template::assign('team_group', $out_team_group['data']);
		Template::assign('team_match', $team_match_rela);
		Template::assign('team_match_data', $out_team_match['data']);
		Template::assign('activity_turn_id', $activity_turn->id);
		Template::render('h5/activity/specail/four/big');
	}

	public function jifen()
	{
		Template::render('h5/activity/set/jifen');
	}

	public function bsjieguo()
	{

		Template::render('h5/activity/set/bsjieguo');
	}


	public function set(Request $request)
	{
		$activity_id = $request->input('activity_id');

		$list = DB::table('activity_turn')
		->where('activity_id', $activity_id)
		->get();
		$list_ids = class_column($list, 'id');
		$team_group = DB::table('team_group')
		->whereIn('activity_turn_id', $list_ids)
		->get();
		$team_group_ids = class_column($team_group, 'activity_turn_id');

		//判断是否可以更改
		foreach ($list as &$row) {
			$row->can_change = 0;
			if (in_array($row->id, $team_group_ids)) {
				$row->can_change = 1;
			}
		}
		unset($row);
		Template::assign('list', $list);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/activity/set/set');
	}


	//分组界面
	public function getgroup(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->get();
		Template::assign('turn', $activity_turn);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/activity/set/grouplist');
	}

	//分组情况(内循环到外循环特殊处理)
	public function groupinfo(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();

		if (!$activity_turn) {
			Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', '改轮次不存在');
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}

		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group($request->all());
		$out_team_match = ActivitySetShowModel::team_match($request->all());
		//分组情况
		$team_group = [];
		foreach ($out_team_group['data'] as $row) {
			$team_group[$row->group_num][] = $row;
		}
		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}

		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}


		//第一轮而且外循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 1) {
			$out_group_match = ActivitySetShowModel::group_match($request->all());
			if ($out_team_group['code'] != 0) {
				Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}

			//对打情况
			$team_match_tmp = tran_key($out_team_match['data'], 'group_match_id');
			$team_match_tmp_l=[];
			foreach($out_team_match['data'] as $key=>$val){
				$team_match_tmp_l[$val->group_match_id][$val->team_a][$val->team_b]=$val;
			}
			$team_group= tran_key($out_team_group['data'], 'group_num');
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('group_match_team_match', $out_group_match['data']);
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/activity/set/groupinfo/wai');
			exit();
		}
		//第二轮而且外循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 1) {
			$out_group_match = ActivitySetShowModel::group_match($request->all());
			$out_group_match = tran_key($out_group_match['data'], 'group_group_num');
			$team_group_list =[];
			foreach ($out_team_group['data'] as $row){
				$team_group_list[$row->group_group_num][$row->group_num][]=$row;
			}

			$team_match =[];
			foreach ($out_team_match['data'] as $row){
				$team_match[$row->group_match_id][$row->team_a][$row->team_b]=$row;
			}


			Template::assign('turn', $request->input('turn', 1));
			Template::assign('list', $out_group_match);
			Template::assign('team_match', $team_match);
			Template::assign('team_group_list', $team_group_list);
			Template::render('h5/activity/set/groupinfo/nei_wai');
			exit();
		}

		//内循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 2) {
			$team_group = tran_key($out_team_group['data'], 'group_num');
			$team_match_tmp_l=[];
			foreach($out_team_match['data'] as $key=>$val){
				$team_match_tmp_l[$val->team_group_num][$val->team_a][$val->team_b]=$val;
			}

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/activity/set/groupinfo/nei');
			exit();
		}
		//内循环   内循环
		if ( $activity_turn->turn == 2 &&$activity_turn->game_system == 2) {
			$team_group = tran_key($out_team_group['data'], 'group_num');
			$team_match_tmp_l = [];
			foreach ($out_team_match['data'] as $key => $val) {
				$team_match_tmp_l[$val->team_group_num][$val->team_a][$val->team_b] = $val;
			}
			$rank_from_to = [];
			foreach ($out_team_group['data'] as $row) {
				if (!isset($rank_from_to[$row->group_num])) {
					$rank_from_to[$row->group_num] = [$row->all_rank_from, $row->all_rank_to];
				}
			}
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::assign('rank_from_to', $rank_from_to);
			Template::render('h5/activity/set/groupinfo/nei_nei');
			exit();
		}

		//淘汰
		if ( $activity_turn->game_system == 0) {
			$all_turn=DB::table('activity_turn')
			->where('activity_id',$activity_turn->activity_id)
			->where('turn','<',$activity_turn->turn)
			->get();
			$all_team_match=[];
			foreach ($all_turn as $value) {
				$request=[];
				$request['activity_turn_id']=$value->id;
				$t= ActivitySetShowModel::team_match($request);
				$all_team_match[$value->turn] = $t['data'];
			}
			$all_team_match[$activity_turn->turn] = $out_team_match['data'];
			Template::assign('all_team_match', $all_team_match);
			Template::render('h5/activity/set/groupinfo/tao');
		}

	}
	//分组情况(内循环到外循环特殊处理)
	public function change_table(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();

		if (!$activity_turn) {
			Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', '改轮次不存在');
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}

		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group($request->all());
		$out_team_match = ActivitySetShowModel::team_match($request->all());
		//分组情况
		$team_group = [];
		foreach ($out_team_group['data'] as $row) {
			$team_group[$row->group_num][] = $row;
		}
		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}

		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}


		//第一轮而且外循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 1) {
			$out_group_match = ActivitySetShowModel::group_match($request->all());
			if ($out_team_group['code'] != 0) {
				Template::assign('url', "/h5/activity/groupinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}

			//对打情况
			$team_match_tmp = tran_key($out_team_match['data'], 'group_match_id');
			$team_match_tmp_l=[];
			foreach($out_team_match['data'] as $key=>$val){
				$team_match_tmp_l[$val->group_match_id][$val->team_a][$val->team_b]=$val;
			}
			$team_group= tran_key($out_team_group['data'], 'group_num');
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('group_match_team_match', $out_group_match['data']);
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/activity/set/change_table/wai');
			exit();
		}
		//第二轮而且外循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 1) {
			$out_group_match = ActivitySetShowModel::group_match($request->all());
			$out_group_match = tran_key($out_group_match['data'], 'group_group_num');
			$team_group_list =[];
			foreach ($out_team_group['data'] as $row){
				$team_group_list[$row->group_group_num][$row->group_num][]=$row;
			}

			$team_match =[];
			foreach ($out_team_match['data'] as $row){
				$team_match[$row->group_match_id][$row->team_a][$row->team_b]=$row;
			}


			Template::assign('turn', $request->input('turn', 1));
			Template::assign('list', $out_group_match);
			Template::assign('team_match', $team_match);
			Template::assign('team_group_list', $team_group_list);
			Template::render('h5/activity/set/change_table/nei_wai');
			exit();
		}

		//内循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 2) {
			$team_group = tran_key($out_team_group['data'], 'group_num');
			$team_match_tmp_l=[];
			foreach($out_team_match['data'] as $key=>$val){
				$team_match_tmp_l[$val->team_group_num][$val->team_a][$val->team_b]=$val;
			}

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/activity/set/change_table/nei');
			exit();
		}
		//内循环   内循环
		if ( $activity_turn->turn == 2 &&$activity_turn->game_system == 2) {
			$team_group = tran_key($out_team_group['data'], 'group_num');
			$team_match_tmp_l = [];
			foreach ($out_team_match['data'] as $key => $val) {
				$team_match_tmp_l[$val->team_group_num][$val->team_a][$val->team_b] = $val;
			}
			$rank_from_to = [];
			foreach ($out_team_group['data'] as $row) {
				if (!isset($rank_from_to[$row->group_num])) {
					$rank_from_to[$row->group_num] = [$row->all_rank_from, $row->all_rank_to];
				}
			}
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::assign('rank_from_to', $rank_from_to);
			Template::render('h5/activity/set/change_table/nei_nei');
			exit();
		}
		//淘汰

		if ( $activity_turn->game_system == 0) {
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_match', $out_team_match['data']);
			Template::render('h5/activity/set/change_table/tao');
		}
	}
	//比赛结果
	public function resultlist(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->get();
		Template::assign('turn', $activity_turn);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/activity/set/resultlist');
	}

	public function resultinfo(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();

		if (!$activity_turn) {
			Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', '改轮次不存在');
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}
		$rank = ActivitySetShowModel::team_group($request->all());

		$out_team_match = ActivitySetShowModel::team_match($request->all());
		//第一轮而且外循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 1) {
			//排名

			if ($rank['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 60);
				Template::render('h5/common/error_redirect');
				exit();
			}
			$rank_new=[];
			$rank_new_no=[];
			foreach ($rank['data'] as $row) {
				if ($row->rank > 0) {
					$rank_new[] = $row;
				} else {
					$rank_new_no[] = $row;
				}

			}


			if ($out_team_match['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 60);
				Template::render('h5/common/error_redirect');
				exit();
			}
			//对打情况
			$team_match_tmp = tran_key($out_team_match['data'], 'group_match_id');



			Template::assign('turn', $request->input('turn', 1));
			Template::assign('rank', $rank_new);
			Template::assign('rank_no', $rank_new_no);
			Template::render('h5/activity/set/resultinfo/wai');
			exit();
		}
		//第二轮而且外循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 1) {
			Template::assign('rank', $rank['data']);
			Template::render('h5/activity/set/resultinfo/nei_wai');
			exit();
		}
		if($activity_turn->game_system==0){
			$team_match=tran_key($out_team_match['data'],'team_group_num');
			$rank=tran_key($rank['data'],'group_num');
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_match);
			Template::assign('rank', $rank);
			Template::render('h5/activity/set/resultinfo/tao');
			exit();
		}
		//内循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 2) {
			$rank = ActivitySetShowModel::team_group($request->all());
			if ($rank['code'] != 0) {
				Template::assign('url', "/h5/member/activity/set/rank?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}
			$rank = tran_key($rank['data'], 'group_num');
			ksort($rank);
			//排名
			$rankres = $out;
			if ($request->input('rank') === 0) {
				$rankres = ActivityRankModel::nei($request->all());
			}
			if ($rankres['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('rank', $rank);
			Template::render('h5/activity/set/resultinfo/nei');
			exit();
		}
		//内循环   内循环
		if ( $activity_turn->turn == 2 &&$activity_turn->game_system == 2) {
			$rank = ActivitySetShowModel::team_group($request->all());
			if ($rank['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}
			$ranknew = [];
			foreach ($rank['data'] as $row) {
				$ranknew[$row->group_num]['from'] = $row->all_rank_from;
				$ranknew[$row->group_num]['to'] = $row->all_rank_to;
				$ranknew[$row->group_num]['data'][] = $row;
			}
			//排名
			$rankres = $out;
			if ($request->input('rank') === 0 ) {
				$rankres = ActivityRankModel::nei($request->all());
			}
			if ($rankres['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('rank', $ranknew);
			Template::render('h5/activity/set/resultinfo/nei_nei');
			exit();
		}
		$team_match=tran_key($out_team_match['data'],'team_group_num');
		$rank =tran_key($rank['data'] ,'group_num');
		Template::assign('turn', $request->input('turn', 1));
		Template::assign('team_match',  $team_match);
		Template::assign('rank', $rank);
		Template::render('h5/activity/set/resultinfo/nei');

	}

	public function resultsubinfo(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$out = ActivitySetShowModel::team_member_match($request);
		if ($out['code'] != 0) {
			Template::assign('url', "/h5/activity/resultsubinfo?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_match = ActivitySetShowModel::team_match_by_one_id($request);
		if ($team_match['code'] != 0) {
			Template::assign('url', "/h5/activity/resultsubinfo?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 60);
			Template::render('h5/common/error_redirect');
			exit();
		}

		Template::assign('list', $out['data']);
		Template::assign('team_match', $team_match['data']);
		Template::render('h5/activity/set/resultsubinfo');
	}


	//
	public function edit_join(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->get();
		Template::assign('turn', $activity_turn);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/activity/set/join_edit');
	}
	public function join_more(Request $request){
		//我的队员
		$user=Auth::user();
		$data_member_person = UserModel::person_list(true, $user->id,$request->input('activity_id'));

		Template::assign('activity_id', $request->input('activity_id'));
		Template::assign('team_id', $request->input('team_id'));
		Template::assign('person', $data_member_person);
		Template::render('h5/activity/join_more');
	}

	public function join_more_post(Request $request){

		//我的队员
		$user=Auth::user();
		foreach ($request->input('person')  as $v){
			$c=DB::table('team_member_back')->where('mem_id',$user->id)
			->where('activity_id',$request->input('activity_id'))
			->where('team_id',$request->input('team_id'))
			->where('user_team_member_id',$v)
			->count();
			if($c>0){
				continue;
			}
			$data=[];
			$data['mem_id']=$user->id;
			$data['activity_id']=$request->input('activity_id');
			$data['team_id']=$request->input('team_id');
			$data['user_team_member_id']=$v;
			DB::table('team_member_back')->insert($data);
		}
		$data_member_person = UserModel::person_list(true, $user->id,$request->input('activity_id'));

		Template::assign('activity_id', $request->input('activity_id'));
		Template::assign('team_id', $request->input('team_id'));
		Template::assign('person', $data_member_person);
		Template::render('h5/activity/join_more');
	}
}
