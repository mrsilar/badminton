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
use App\Models\ActivityRankModel;

class ActivitySetController extends H5Controller
{


	public function zhangcheng(Request $request)
	{
		$detail = DB::table('activity')
		->where('id', $request->input('activity_id'))
		->first();
		Template::assign('detail', $detail);
		Template::render('h5/activity/zhangcheng');
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
		Template::render('h5/activity/saikuanglist');
	}

	public function jifen()
	{
		Template::render('h5/activity/jifen');
	}

	public function bsjieguo()
	{

		Template::render('h5/activity/bsjieguo');
	}

	public function score(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$out = ActivityModel::team_member_match($request->all());
		Template::assign('list', $out['data']);

		Template::render('h5/activity/score');
	}

	public function postscore(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$user = Auth::user();
		$can_score = ActivityModel::can_score($request->input('activityId'), $user);
		if (!$can_score) {
			$out['code'] = 33;
			$out['msg'] = '没有打分的权限';
			return $out;
		}
		//能否继续打分
		$team_member_match = DB::table('team_member_match')
		->where('id', $request->input('memberMatchId'))
		->first();
		$team_match = DB::table('team_match')
		->where('id', $team_member_match->team_match_id)
		->first();
		$team_group = DB::table('team_group')
		->where('activity_turn_id', $team_match->activity_turn_id)
		->get();
		$can = false;
		foreach ($team_group as $row) {
			if ($row->rank == 10000 || $row->rank < 1) {
				$can = true;
			}
		}
		if (!$can) {
			$out['code'] = 34;
			$out['msg'] = '已排名，不能打分！';
			return $out;
		}

		if ($team_member_match->score_count >=3) {
			$out['code'] = 35;
			$out['msg'] = '打分次数已经到达三次，不能继续修改！';
			return $out;
		}

		$out = ActivityModel::postscore($request->all());

		return $out;
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
		Template::render('h5/activity/set');
	}


	public function postgroup(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$out = ActivityGroupModel::group($request->all());

		if ($out['msg'] != 'ok') {
			Template::assign('url', "/h5/member/activity/set/group?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		Template::assign('url', "/h5/member/activity/set/group?activity_turn_id={$request->input('activity_turn_id')}");
		Template::assign('error', '成功');
		Template::render('h5/common/error_redirect');
		exit();

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
		Template::render('h5/activity/resultlist');
	}

	public function resultinfo(Request $request)
	{
		//队伍排名
		$team_group = DB::table('team_group')
		->where('activity_turn_id', $request->input('activity_turn_id'))
		->orderBy('rank', 'asc')
		->get();
		$team_group_ids = class_column($team_group, 'team_id');
		$teams = DB::table('team')
		->whereIn('id', $team_group_ids)
		->get();
		$teams = tran_key($teams);
		foreach ($team_group as &$row) {
			$row->team_name = $teams[$row->team_id]->name;
		}
		unset($row);
		$new_team_group = [];
		foreach ($team_group as $row) {
			$new_team_group[$row->group_num][] = $row;
		}
		ksort($new_team_group);
		//队伍比分
		$team_match = ActivityModel::team_match(['activity_turn_id' => $request->input('activity_turn_id')]);

		//第几轮
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();
		Template::assign('team_group', $new_team_group);
		Template::assign('activity_turn', $activity_turn);
		Template::assign('team_match', $team_match['data']);
		Template::render('h5/activity/resultinfo');
	}

	public function resultsubinfo(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$out = ActivityModel::team_member_match($request);

		Template::assign('list', $out['data']);
		Template::render('h5/activity/resultsubinfo');
	}

	//活动设置
	public function setlist(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->get();


		$activity = ActivityModel::detail($request->input('activity_id'));
		$user = Auth::user();
		//简单权限
		if ($user->id != $activity->mem_id) {
			Template::assign('url', "/h5/member/activity");
			Template::assign('error', '该活动不是您创建的，没有权限');
			Template::render('h5/common/error_redirect');
			exit();
		}
		if ($activity->specail_config > 0) {
			if ($activity->specail_config == 1) {
				Template::assign('activity_id', $request->input('activity_id'));
				Template::assign('turn', $activity_turn[0]);
				Template::render('h5/member/activity/specail/four/choose');
			} else {

			}
			exit;
		}
		Template::assign('turn', $activity_turn);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/member/activity/set/list');
	}

	//选择进行的炒作类型
	public function set_select(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();
		Template::assign('turn', $activity_turn);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/member/activity/set/select');
	}

	//分组
	public function set_group(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();
		$activity_turn_prev = [];
		if ($activity_turn->turn > 1) {
			$activity_turn_prev = DB::table('activity_turn')
			->where('activity_id', $activity_turn->activity_id)
			->where('turn', $activity_turn->turn - 1)
			->first();
		}
		//判断是否可以更改
		$team_group_count = DB::table('team_group')
		->where('activity_turn_id', $request->input('activity_turn_id'))
		->count();

		$can_change = 1;
		if ($team_group_count > 0) {
			$can_change = 0;
		}
		$activity_turn->can_change = $can_change;
		//判断可以分组的数量
		$team_count_list = [];
		if ($activity_turn->turn == 1) {
			$team_count = DB::table('team')
			->where('activity_id', $activity_turn->activity_id)
			->count();
			$team_count_list = team_group_list($team_count);


		} else {
			$activity_turn_prev = DB::table('activity_turn')
			->where('activity_id', $activity_turn->activity_id)
			->where('turn', $activity_turn->turn - 1)
			->first();
			$team_group_count = DB::table('team_group')
			->where('activity_turn_id', $activity_turn_prev->id)
			->where('group_num', 1)
			->count();
			$team_count_list = team_group_list($team_group_count);
		}
		Template::assign('row', $activity_turn);

		Template::assign('row_prev', $activity_turn_prev);
		Template::assign('team_count_list', $team_count_list);
		Template::render('h5/member/activity/set/group');
	}
	public function set_score_tao(Request $request){
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();
		$url="/h5/member/activity/set/score?activity_turn_id=$request->input('activity_turn_id')";
		if (!$activity_turn) {
			Template::assign('url', $url);
			Template::assign('error', '改轮次不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group($request->all());
		$out_team_match = ActivitySetShowModel::team_match($request->all());

		if ($out_team_group['code'] != 0) {
			Template::assign('url', $url);
			Template::assign('error', $out['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		if ($out_team_group['code'] != 0) {
			Template::assign('url', $url);
			Template::assign('error', $out['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_match_tmp = tran_key($out_team_match['data'], 'team_group_num');

		Template::assign('turn', $request->input('turn', 1));
		Template::assign('team_group', $team_match_tmp);
		Template::render('h5/member/activity/set/score/tao');

	}
	//打分主界面
	public function set_score(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();

		if (!$activity_turn) {
			Template::assign('url', "/h5/member/activity/set/score?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', '改轮次不存在');
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}
		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group($request->all());
		$out_team_match = ActivitySetShowModel::team_match($request->all());

		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/member/activity/set/score?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}

		if ($out_team_group['code'] != 0) {
			Template::assign('url', "/h5/member/activity/set/score?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', $out['msg']);
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}


		//第一轮而且外循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 1) {

			$out_group_match = ActivitySetShowModel::group_match($request->all());
			if ($out_team_group['code'] != 0) {
				Template::assign('url', "/h5/member/activity/set/score?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}

			//对打情况
			$team_match_tmp = tran_key($out_team_match['data'], 'group_match_id');
			$team_match_tmp_l = [];
			foreach ($out_team_match['data'] as $key => $val) {
				$team_match_tmp_l[$val->group_match_id][$val->team_a][$val->team_b] = $val;
			}
			$team_group = tran_key($out_team_group['data'], 'group_num');

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('group_match_team_match', $out_group_match['data']);
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/member/activity/set/score/wai');
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
			Template::render('h5/member/activity/set/score/nei_wai');
			exit();
		}
		//内循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 2) {
			$team_group = tran_key($out_team_group['data'], 'group_num');
			$team_match_tmp_l = [];
			foreach ($out_team_match['data'] as $key => $val) {
				$team_match_tmp_l[$val->team_group_num][$val->team_a][$val->team_b] = $val;
			}

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/member/activity/set/score/nei');
			exit();
		}
		//内循环   内循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 2) {
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
			Template::render('h5/member/activity/set/score/nei_nei');
			exit();
		}
		$team_match_tmp = tran_key($out_team_match['data'], 'team_group_num');

		Template::assign('turn', $request->input('turn', 1));
		Template::assign('team_group', $team_match_tmp);
		Template::render('h5/member/activity/set/score/tao');
	}

	//打分
	public function set_score_sub(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$team_match = ActivitySetShowModel::team_match_by_one_id($request->all());
		$out = ActivitySetShowModel::team_member_match($request->all());

		$activity_turn = DB::table('activity_turn')
		->where('id', $team_match['data']->activity_turn_id)
		->first();

		$activity = ActivityModel::detail($activity_turn->activity_id);
		Template::assign('activity_id', $activity_turn->activity_id);
		Template::assign('activity', $activity);
		Template::assign('team_match', $team_match['data']);
		Template::assign('list', $out['data']);
		Template::render('h5/member/activity/set/score_sub');
	}

	//晋级
	public function set_go(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->get();
		Template::assign('turn', $activity_turn);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/member/activity/set/go');
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
		Template::render('h5/activity/join_edit');
	}

	//rank
	public function rank(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$out = ActivitySetShowModel::rank_tao($request);
		Redirect::back();
	}

	//排名
	public function set_rank(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();

		if (!$activity_turn) {
			Template::assign('url', "/h5/member/activity/set/rank?activity_turn_id={$request->input('activity_turn_id')}");
			Template::assign('error', '改轮次不存在');
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}

		Template::assign('rank_is', 0);
		if ($request->input('rank') == 1) {
			Template::assign('rank_is', 1);
		}
		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		//第一轮而且外循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 1) {
			//排名
			$rank = ActivitySetShowModel::team_group($request->all());
			if ($rank['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}
			$rank_new = [];
			$rank_new_no = [];
			foreach ($rank['data'] as $row) {
				if ($row->rank > 0) {
					$rank_new[] = $row;
				} else {
					$rank_new_no[] = $row;
				}

			}
			//排名
			$rankres = $out;
			if ($request->input('rank') === 0) {
				$rankres = ActivityRankModel::wai($request->all());
			}
			if ($rankres['code'] != 0) {
				Template::assign('url', "/h5/activity/resultinfo?activity_turn_id={$request->input('activity_turn_id')}");
				Template::assign('error', $out['msg']);
				Template::render('h5/common/error_redirect');
				exit();
			}
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('rank', $rank_new);
			Template::assign('rank_no', $rank_new_no);
			Template::render('h5/member/activity/set/rank/wai');
			exit();
		}
		//第二轮而且外循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 1) {
			//排名
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
				$ranknew[$row->group_group_num]['from'] = $row->all_rank_from;
				$ranknew[$row->group_group_num]['to'] = $row->all_rank_to;
				$ranknew[$row->group_group_num]['data'][] = $row;
			}
			//排名
			$rankres = $out;
			if ($request->input('rank') == 1) {
				$rankres = ActivityRankModel::wai($request->all());
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
			Template::render('h5/member/activity/set/rank/nei_wai');
			exit();
		}
		//淘汰
		if ($activity_turn->game_system == 0) {
			//排名
			$rank = ActivitySetShowModel::team_match($request->all());
			$from_to=DB::table('team_group')
			->where('activity_turn_id',$request->input('activity_turn_id'))
			->first();
			foreach ($rank ['data'] as &$value) {
				$value->status_a=' 待定';
				$value->status_b='待定';
				if($value->win_a!=$value->win_b){
					$value->status_a=$value->win_a>$value->win_b?'晋级':'淘汰'	;
					$value->status_b=$value->win_a<$value->win_b?'晋级':'淘汰'	;
				}

			}
			unset($value);
			$rank = tran_key($rank['data'], 'team_group_num');
			Template::assign('turn', $request->input('turn', 1));
			Template::assign('rank', $rank);
			Template::assign('	ft', $from_to);
			Template::render('h5/member/activity/set/rank/tao');
			exit();
		}
		//内循环第一轮
		if ($activity_turn->turn == 1) {
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
			Template::render('h5/member/activity/set/rank/nei');
			exit();
		}
		//内循环第二轮
		$rank = ActivitySetShowModel::team_group($request->all());
		if ($rank['code'] != 0) {
			Template::assign('url', "/h5/member/activity/set/rank?activity_turn_id={$request->input('activity_turn_id')}");
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
		Template::render('h5/member/activity/set/rank/nei_nei');

	}

	//修改比分
	public function post_set_rank(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		if ($request->input('id') < 1) {
			$out['code'] = 1;
			$out['msg'] = 'id为空';
			return $out;
		}
		if ($request->input('rank') < 1) {
			$out['code'] = 2;
			$out['msg'] = 'rank为空';
			return $out;
		}

		$team_group_first = DB::table('team_group')
		->where('id', $request->input('id'))
		->first();
		if (!$team_group_first) {
			$out['code'] = 3;
			$out['msg'] = 'team_group_first不存在';
			return $out;
		}
		if ($team_group_first->all_rank_from) {
			if ($request->input('rank') < $team_group_first->all_rank_from) {
				$out['code'] = 4;
				$out['msg'] = '名次应大于' . $team_group_first->all_rank_from;
				return $out;
			}
		}
		if ($team_group_first->all_rank_from) {
			if ($request->input('rank') > $team_group_first->all_rank_to) {
				$out['code'] = 4;
				$out['msg'] = '名次应小于于' . $team_group_first->all_rank_to;
				return $out;
			}
		}
		$up['rank'] = $request->input('rank');
		DB::table('team_group')
		->where('id', $request->input('id'))
		->update($up);

		return $out;
	}

	public function jinji(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		if ($request->input('activity_turn_id') < 1) {
			$out['code'] = 1;
			$out['msg'] = 'activity_turn_id为空';
			return $out;
		}
		if ($request->input('team_id') < 1) {
			$out['code'] = 2;
			$out['msg'] = 'team_id为空';
			return $out;
		}

		$team_group_first = DB::table('team_group')
		->where('activity_turn_id', $request->input('activity_turn_id'))
		->where('team_id', $request->input('team_id'))
		->first();
		if (!$team_group_first) {
			$out['code'] = 3;
			$out['msg'] = 'team_group_first不存在';
			return $out;
		}

		$up['rank'] = 1;
		DB::table('team_group')
		->where('id', $team_group_first->id)
		->update($up);

		$team_group_se = DB::table('team_group')
		->where('activity_turn_id', $request->input('activity_turn_id'))
		->where('group_num', $team_group_first->group_num)
		->where('team_id', '<>', $team_group_first->team_id)
		->first();

		$up['rank'] = 2;
		DB::table('team_group')
		->where('id', $team_group_se->id)
		->update($up);

		return $out;
	}

	//打分主界面
	public function change_member(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$activity_turn = DB::table('activity_turn')
		->where('id', $request->input('activity_turn_id'))
		->first();
		$url = "/h5/member/activity/set/select?activity_turn_id={$request->input('activity_turn_id')}";
		if (!$activity_turn) {
			Template::assign('url', $url);
			Template::assign('error', '改轮次不存在');
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}
		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group($request->all());
		$out_team_match = ActivitySetShowModel::team_match($request->all());

		if ($out_team_group['code'] != 0) {
			Template::assign('url', $url);
			Template::assign('error', $out['msg']);
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}

		if ($out_team_group['code'] != 0) {
			Template::assign('url', $url);
			Template::assign('error', $out['msg']);
			Template::assign('time', 10);
			Template::render('h5/common/error_redirect');
			exit();
		}


		//第一轮而且外循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 1) {

			$out_group_match = ActivitySetShowModel::group_match($request->all());
			if ($out_team_group['code'] != 0) {
				Template::assign('url', $url);
				Template::assign('error', $out['msg']);
				Template::assign('time', 10);
				Template::render('h5/common/error_redirect');
				exit();
			}

			//对打情况
			$team_match_tmp = tran_key($out_team_match['data'], 'group_match_id');
			$team_match_tmp_l = [];
			foreach ($out_team_match['data'] as $key => $val) {
				$team_match_tmp_l[$val->group_match_id][$val->team_a][$val->team_b] = $val;
			}
			$team_group = tran_key($out_team_group['data'], 'group_num');

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('group_match_team_match', $out_group_match['data']);
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/member/activity/set/change_member/wai');
			exit();
		}
		//第二轮而且外循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 1) {
			$out_group_match = ActivitySetShowModel::group_match($request->all());

			$out_team_match = tran_key($out_team_match['data'], 'group_match_id');
			foreach ($out_group_match['data'] as $key => &$value) {
				$value->team_match = $out_team_match[$value->id];
			}
			unset($value);

			$out_group_match = tran_key($out_group_match['data'], 'group_group_num');

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('list', $out_group_match);
			Template::render('h5/member/activity/set/score/nei_wai');
			exit();
		}
		//内循环
		if ($activity_turn->turn == 1 && $activity_turn->game_system == 2) {
			$team_group = tran_key($out_team_group['data'], 'group_num');
			$team_match_tmp_l = [];
			foreach ($out_team_match['data'] as $key => $val) {
				$team_match_tmp_l[$val->team_group_num][$val->team_a][$val->team_b] = $val;
			}

			Template::assign('turn', $request->input('turn', 1));
			Template::assign('team_group', $team_group);
			Template::assign('team_match', $team_match_tmp_l);
			Template::render('h5/member/activity/set/change_member/nei');
			exit();
		}
		//内循环   内循环
		if ($activity_turn->turn == 2 && $activity_turn->game_system == 2) {
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
			Template::render('h5/member/activity/set/change_member/nei_nei');
			exit();
		}
		$team_match_tmp = tran_key($out_team_match['data'], 'team_group_num');

		Template::assign('turn', $request->input('turn', 1));
		Template::assign('team_group', $team_match_tmp);
		Template::render('h5/member/activity/set/score/tao');
	}
	//队伍修改
	public function manager_team_list(Request $request){
		//我的队伍列表
		$user=Auth::user();
		$team_list=DB::table('team')
		->where('activity_id',$request->input('activity_id',0))
		->where('mem_id',$user->id)
		->get();
		Template::assign('team_list', $team_list);
		Template::assign('activity_id', $request->input('activity_id',0));
		Template::render('h5/member/activity/team/list');
	}
}
