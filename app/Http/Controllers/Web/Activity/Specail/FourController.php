<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/12/13
 * Time: 22:54
 */


namespace App\Http\Controllers\Web\Activity\Specail;

use App\Http\Controllers\WebController;
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
use App\Models\Specail\FourModel;
use App\Models\ActivitySetShowModel;
use App\Models\ActivityRankModel;

class FourController extends WebController
{
	/**
	 * 分组情况(内循环到外循环特殊处理
	 */
	public function score(Request $request)
	{

		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		//过滤
		$activity_detail = ActivityModel::detail($request->input('activity_id'));
		if (!$activity_detail) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '改活动不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$config = DB::table('activity_specail_config')
		->where('id', $activity_detail->specail_config)
		->first();
		if (!$config) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '改活动不是特色活动');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_count = DB::table('team')
		->where('activity_id', $request->input('activity_id'))
		->get();

		if (count($team_count) < ($config->group_count * $config->team_count)) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '队伍数量不足');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//判断是否分组，若未分组分组
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->where('turn', 1)
		->first();
		if (!$activity_turn) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '该阶段不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_match = DB::table('team_match')
		->where('activity_turn_id', $activity_turn->id)
		->get();
//dump($team_match);die;
		if (!$team_match) {
			$out = FourModel::group($activity_turn, $config, $team_count);
//dump($out);die;
			if ($out['code'] != 0) {
				Template::assign('url', "/h5/member/activity/specail/four/score?activity_id={$request->input('activity_id')}");
				Template::assign('error', $out['msg']);
				Template::render('h5/common/error_redirect');
				exit();
			}
		}
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group(['activity_turn_id' => $activity_turn->id]);
		$out_team_match = ActivitySetShowModel::team_match(['activity_turn_id' => $activity_turn->id]);

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

		$team_match_rela = [];
		foreach ($out_team_match['data'] as $row) {
			$team_match_rela[$row->team_a][$row->team_b] = $row;
		}
		$win = FourModel::get_win($activity_turn->id);
		if (!empty($win['data'])) {
			$win_count_count = 0;
			foreach ($out_team_group['data'] as &$row) {
				$win_count_count += @$win['data']['win_count'][$row->team_id];
				$row->win_count = @$win['data']['win_count'][$row->team_id];
				$row->win_count_all = @$win['data']['win_count_all'][$row->team_id];
			}
		}
		unset($row);
		Template::assign('team_group', $out_team_group['data']);
		Template::assign('team_match', $team_match_rela);
		Template::assign('activity_turn_id', $activity_turn->id);

		Template::render('h5/member/activity/specail/four/big');
	}

	public function score_sub(Request $request)
	{
		if ($request->input('team_match_id') < 1) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', '参数错误');
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_match = DB::table('team_match')
		->where('id', $request->input('team_match_id'))
		->first();
		if (!$team_match) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//活动基础信息
		$activty_turn = DB::table('activity_turn')
		->where('id', $team_match->activity_turn_id)
		->first();
		$act = ActivityModel::detail($activty_turn->activity_id);
		//队伍信息
		$teams = DB::table('team')
		->whereIn('id', [$team_match->team_a, $team_match->team_b])
		->get();
		$new_teams = [];
		foreach ($teams as $key => $row) {
			$new_teams[$row->id] = $row;
		}
		$team_match->team_a_name = $new_teams[$team_match->team_a]->name;
		$team_match->team_a_draw_id = $new_teams[$team_match->team_a]->draw_id;
		$team_match->team_b_name = $new_teams[$team_match->team_b]->name;
		$team_match->team_b_draw_id = $new_teams[$team_match->team_b]->draw_id;
		if (!$team_match) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//分组信息
		$team_member_match = ActivitySetShowModel::team_member_match(['team_match_id' => $request->input('team_match_id')]);
		if ($team_member_match['code'] != 0) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', $team_member_match['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_member_match_l = [];
		foreach ($team_member_match['data'] as $row) {
			$team_member_match_l[$row->category_a_id][$row->category_b_id] = $row;
		}
		
	$team_item = ActivitySetShowModel::team_item([$team_match->team_a, $team_match->team_b], $activty_turn->activity_id);
		$team_item_a = [];
		$team_item_b = [];
		foreach ($team_item['data'] as $key => $val) {
			if ($key == $team_match->team_a) {
				$team_item_a = $val;
			} else {
				$team_item_b = $val;
			}
		}


		Template::assign('team_item_a', $team_item_a);
		Template::assign('team_item_b', $team_item_b);
		Template::assign('activity_id', $activty_turn->activity_id);
		Template::assign('team_member_match', $team_member_match_l);
		Template::assign('team_match', $team_match);
		Template::assign('activity', $act);
		Template::render('h5/member/activity/specail/four/small');
	}

	public function score_sub_show(Request $request)
	{
		if ($request->input('team_match_id') < 1) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', '参数错误');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_match = DB::table('team_match')
		->where('id', $request->input('team_match_id'))
		->first();

		$teams = DB::table('team')
		->whereIn('id', [$team_match->team_a, $team_match->team_b])
		->get();
		$new_teams = [];
		foreach ($teams as $key => $row) {
			$new_teams[$row->id] = $row;
		}


		$team_match->team_a_name = $new_teams[$team_match->team_a]->name;
		$team_match->team_a_draw_id = $new_teams[$team_match->team_a]->draw_id;
		$team_match->team_b_name = $new_teams[$team_match->team_b]->name;
		$team_match->team_b_draw_id = $new_teams[$team_match->team_b]->draw_id;
		if (!$team_match) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}

		$activty_turn = DB::table('activity_turn')
		->where('id', $team_match->activity_turn_id)
		->first();
		$team_item = ActivitySetShowModel::team_item([$team_match->team_a, $team_match->team_b], $activty_turn->activity_id);

		if ($team_item['code'] != 0) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', $team_item['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_member_match = ActivitySetShowModel::team_member_match(['team_match_id' => $request->input('team_match_id')]);
		if ($team_member_match['code'] != 0) {
			Template::assign('url', "/h5/member/activity/specail/four/score_sub?team_match_id={$request->input('team_match_id')}");
			Template::assign('error', $team_member_match['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}
		$activty_turn = DB::table('activity_turn')
		->where('id', $team_match->activity_turn_id)
		->first();

		$team_member_match_tmp = [];
		foreach ($team_member_match['data'] as $row) {
			$team_member_match_tmp[$row->category_a_id][$row->category_b_id] = $row;
		}
		$team_item_a = [];
		$team_item_b = [];
		foreach ($team_item['data'] as $key => $val) {
			if ($key == $team_match->team_a) {
				$team_item_a = $val;
			} else {
				$team_item_b = $val;
			}
		}

		Template::assign('team_member_match', $team_member_match_tmp);
		Template::assign('team_match', $team_match);
		Template::assign('team_item_a', $team_item_a);
		Template::assign('team_item_b', $team_item_b);
		Template::render('h5/activity/specail/four/small');
	}

	public function rank(Request $request)
	{
		$rank = ActivitySetShowModel::team_group($request->all());
		$url = "/h5/member/activity/set?activity_id={$request->input('activity_id')}";
		if ($rank['code'] != 0) {
			Template::assign('url', $url);
			Template::assign('error', $rank['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}
		//查看是否可以排名
		if ($request->input('rank', 0) == 1) {
			//排名
			$r = ActivityRankModel::rank_four($request->input('activity_turn_id'));

			if ($r['code'] != 0) {
				Template::assign('url', $url);
				Template::assign('error', $r['msg']);
				Template::render('h5/common/error_redirect');
				exit();
			}
			foreach ($r['data'] as $key => $row) {
				$up = [];
				$up['rank'] = $key + 1;
				DB::table('team_group')
				->where('activity_turn_id', $request->input('activity_turn_id'))
				->where('team_id', $row)
				->update($up);
			}

		}
		$rank_is = $request->input('rank', 1);
		Template::assign('rank_is', $rank_is);
		Template::assign('rank', $rank['data']);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::assign('activity_turn_id', $request->input('activity_turn_id'));
		Template::render('h5/member/activity/specail/four/rank');
	}

	//人员调整
	public function change_member(Request $request)
	{

		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		//过滤
		$activity_detail = ActivityModel::detail($request->input('activity_id'));
		if (!$activity_detail) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '改活动不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$config = DB::table('activity_specail_config')
		->where('id', $activity_detail->specail_config)
		->first();
		if (!$config) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '改活动不是特色活动');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_count = DB::table('team')
		->where('activity_id', $request->input('activity_id'))
		->get();

		if (count($team_count) < ($config->group_count * $config->team_count)) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '队伍数量不足');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//判断是否分组，若未分组分组
		$activity_turn = DB::table('activity_turn')
		->where('activity_id', $request->input('activity_id'))
		->where('turn', 1)
		->first();
		if (!$activity_turn) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
			Template::assign('error', '该阶段不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_match = DB::table('team_match')
		->where('activity_turn_id', $activity_turn->id)
		->get();
		if (!$team_match) {
			$out = FourModel::group($activity_turn, $config, $team_count);
			if ($out['code'] != 0) {
				Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_id')}");
				Template::assign('error', $out['msg']);
				Template::render('h5/common/error_redirect');
				exit();
			}
		}
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group(['activity_turn_id' => $activity_turn->id]);
		$out_team_match = ActivitySetShowModel::team_match(['activity_turn_id' => $activity_turn->id]);

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

		$team_match_rela = [];
		foreach ($out_team_match['data'] as $row) {
			$team_match_rela[$row->team_a][$row->team_b] = $row;
		}

		Template::assign('team_group', $out_team_group['data']);
		Template::assign('team_match', $team_match_rela);
		Template::assign('activity_turn_id', $activity_turn->id);

		Template::render('h5/member/activity/specail/four/change_member');
	}

	public function change_member_small(Request $request)
	{
		$user=Auth::user();
		$c_a=0;
		$c_b=0;
		////
		$redirect_url = "/h5/member/activity/specail/four/change_member_small?team_match_id={$request->input('team_match_id')}";
		if ($request->input('team_match_id') < 1) {
			Template::assign('url', $redirect_url);
			Template::assign('error', '参数错误');
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_match = DB::table('team_match')
		->where('id', $request->input('team_match_id'))
		->first();
		if (!$team_match) {
			Template::assign('url', $redirect_url);
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//活动基础信息
		$activty_turn = DB::table('activity_turn')
		->where('id', $team_match->activity_turn_id)
		->first();
		$act = ActivityModel::detail($activty_turn->activity_id);
		if($user->id==$act->mem_id){
			$c_a=1;
			$c_b=1;
		}
		//队伍信息
		$teams = DB::table('team')
		->whereIn('id', [$team_match->team_a, $team_match->team_b])
		->get();
		if($c_a==0){
			foreach ($teams  as $row){
				if($row->id==$team_match->team_a&&$row->mem_id==$user->id){
					$c_a=1;
					break;
				}
			}
		}
		if($c_b==0){
			foreach ($teams  as $row){
				if($row->id==$team_match->team_b&&$row->mem_id==$user->id){
					$c_b=1;
					break;
				}
			}
		}
		$new_teams = [];
		foreach ($teams as $key => $row) {
			$new_teams[$row->id] = $row;
		}
		$team_match->team_a_name = $new_teams[$team_match->team_a]->name;
		$team_match->team_a_draw_id = $new_teams[$team_match->team_a]->draw_id;
		$team_match->team_b_name = $new_teams[$team_match->team_b]->name;
		$team_match->team_b_draw_id = $new_teams[$team_match->team_b]->draw_id;
		if (!$team_match) {
			Template::assign('url', $redirect_url);
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//分组信息
		$team_member_match = ActivitySetShowModel::team_member_match(['team_match_id' => $request->input('team_match_id')]);

		if ($team_member_match['code'] != 0) {
			Template::assign('url', $redirect_url);
			Template::assign('error', $team_member_match['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_member_match_l = [];
		foreach ($team_member_match['data'] as $row) {
			$team_member_match_l[$row->category_a_id][$row->category_b_id] = $row;
		}

		Template::assign('activity_id', $activty_turn->activity_id);
		Template::assign('team_member_match', $team_member_match_l);
		Template::assign('team_match', $team_match);
		Template::assign('activity', $act);
		Template::assign('c_a', $c_a);
		Template::assign('c_b', $c_b);  
		Template::render('h5/member/activity/specail/four/change_member_small');
	}

	public function change_member_last(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$team_match = DB::table('team_match')
		->where('id', $request->input('team_match_id'))
		->first();
		$redirect_url = "/h5/member/activity/specail/four/chang_team?team_match_id={$request->input('team_match_id')}";
		if (!$team_match) {
			Template::assign('url', $redirect_url);
			Template::assign('error', '不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//可以替换的人员
		$user = Auth::user();
	
		$activity_turn = DB::table('activity_turn')
		->where('id', $team_match->activity_turn_id)
		->first();
		$team_id=$request->input('type')=='a'?$team_match->team_a:$team_match->team_b;
		$data_member_person = UserModel::person_list(true, $user->id, $activity_turn->activity_id);
		Template::assign('person_list', $data_member_person);
		Template::assign('team_match_id', $request->input('team_match_id'));
		Template::assign('type', $request->input('type'));
		Template::assign('mem_id', $request->input('mem_id'));
		Template::render('h5/member/activity/specail/four/change_member_last');
	}

	public function change_member_last_post(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();


		$user = Auth::user();
		
			$team_match = DB::table('team_match')
		->where('id', $request->input('team_match_id'))
		->first();
		$redirect_url = "/h5/member/activity/specail/four/chang_team?team_match_id={$request->input('team_match_id')}";
		if (!$team_match) {
			Template::assign('url', $redirect_url);
			Template::assign('error', '不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		
		if($request->input('type')=='a'){
		$team_id=$team_match->team_a;
		}else{
			$team_id=$team_match->team_b;
		}
		$team_one = DB::table('team')
		->where('id', $team_id)
		->first();
	$activity_turn=DB::table('activity_turn')
	->where('id',$team_match->activity_turn_id)
	->first();

		$activity = ActivityModel::detail($activity_turn->activity_id);	
		if ($activity->mem_id == $user->id||$team_one->mem_id==$user->id) {

		} else{
			Template::assign('url', $redirect_url);
			Template::assign('error', '该队伍不是您创建的');
			Template::render('h5/common/error_redirect');
			exit();
		}

		DB::beginTransaction();
		try {
			//
			$team_member_match=DB::table('team_member_match')
			->where('team_match_id',$request->input('team_match_id'))
			->get();
			$team_member_match_ids=class_column($team_member_match,'id');
			$up = [];

			if ($request->input('type') == 'a') {
				$up['user_team_member_id_a'] =$request->input('person_id');
				DB::table('team_member_match_category_member')
			->whereIn('team_member_match_id', $team_member_match_ids)
			->where('user_team_member_id_a',$request->input('mem_id'))
			->update($up);
			} else {
			$up['user_team_member_id_b'] =$request->input('person_id');
				DB::table('team_member_match_category_member')
			->whereIn('team_member_match_id', $team_member_match_ids)
			->where('user_team_member_id_b',$request->input('mem_id'))
			->update($up);
			}
			DB::commit();

		} catch (\Exception $e) {
			DB::rollBack();
			$out['code'] = $e->getCode();
			$out['msg'] = $e->getMessage();
			Template::assign('url', $redirect_url);
			Template::assign('error', $out['msg']);
			Template::render('h5/common/error_redirect');
			exit();
		}
		Template::assign('url', $redirect_url);
		Template::assign('error', '更新成功');
		Template::render('h5/common/error_redirect');
		exit();
	}
	
	public  function  chang_table(Request $request){
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

		Template::assign('team_group', $out_team_group['data']);
		Template::assign('team_match', $team_match_rela);
		Template::assign('team_match_data', $out_team_match['data']);
		Template::assign('activity_turn_id', $activity_turn->id);
		Template::render('h5/activity/specail/four/big_change');
	}
	
	public function chang_team(Request $request){
		$user=Auth::user();
		$c_a=0;
		$c_b=0;
		////
		$redirect_url = "/h5/member/activity/specail/four/change_member_small?team_match_id={$request->input('team_match_id')}";
		if ($request->input('team_match_id') < 1) {
			Template::assign('url', $redirect_url);
			Template::assign('error', '参数错误');
			Template::render('h5/common/error_redirect');
			exit();
		}

		$team_match = DB::table('team_match')
		->where('id', $request->input('team_match_id'))
		->first();
		if (!$team_match) {
			Template::assign('url', $redirect_url);
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//活动基础信息
		$activty_turn = DB::table('activity_turn')
		->where('id', $team_match->activity_turn_id)
		->first();
		$act = ActivityModel::detail($activty_turn->activity_id);
		if($user->id==$act->mem_id){
			$c_a=1;
			$c_b=1;
		}

		//队伍信息
		$teams = DB::table('team')
		->whereIn('id', [$team_match->team_a, $team_match->team_b])
		->get();
		if($c_a==0){
			foreach ($teams  as $row){
				if($row->id==$team_match->team_a&&$row->mem_id==$user->id){
					$c_a=1;
					break;
				}
			}
		}
		if($c_b==0){
			foreach ($teams  as $row){
				if($row->id==$team_match->team_b&&$row->mem_id==$user->id){
					$c_b=1;
					break;
				}
			}
		}
		$new_teams = [];
		foreach ($teams as $key => $row) {
			$new_teams[$row->id] = $row;
		}
		$team_match->team_a_name = $new_teams[$team_match->team_a]->name;
		$team_match->team_a_draw_id = $new_teams[$team_match->team_a]->draw_id;
		$team_match->team_b_name = $new_teams[$team_match->team_b]->name;
		$team_match->team_b_draw_id = $new_teams[$team_match->team_b]->draw_id;
		if (!$team_match) {
			Template::assign('url', $redirect_url);
			Template::assign('error', 'team_match不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//分组信息
		$team_member_match = ActivitySetShowModel::team_member_match(['team_match_id' => $request->input('team_match_id')]);

		$activity_category=DB::table('activity_category')
		->where('activity_id',$activty_turn->activity_id)
		->get();
		$activity_category=class_column($activity_category,'id');

		$a_team=[];
		$b_team=[];
		$a_team_key=[];
		$b_team_key=[];
		foreach ($team_member_match['data'] as $value) {
			if(in_array($value->category_a_id,$activity_category)&&!in_array($value->category_a_id,$a_team_key)){
			$a_team_key[]=$value->category_a_id;
			$a_tmp=[];
			$a_tmp['category_id']=$value->category_a_id;
			$a_tmp['category_list']=$value->category_a_list;
			$a_team[]=$a_tmp;
			}
			
					if(in_array($value->category_b_id,$activity_category)&&!in_array($value->category_b_id,$b_team_key)){
							$b_team_key[]=$value->category_b_id;
			$b_tmp=[];
			$b_tmp['category_id']=$value->category_b_id;
			$b_tmp['category_list']=$value->category_b_list;
			$b_team[]=$b_tmp;
			}
		}
		$c_a_out=[];
		$c_b_out=[];
		if($c_a){
		$c_a_out=$a_team;
		}
		if($c_b){
				$c_b_out=$b_team;
		}



		Template::assign('c_a', $c_a_out);
		Template::assign('c_b', $c_b_out);  
		Template::assign('team_match', $team_match);  
		Template::render('h5/member/activity/specail/four/change_team');
	}
}