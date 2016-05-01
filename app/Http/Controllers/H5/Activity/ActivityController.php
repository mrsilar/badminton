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

class ActivityController extends H5Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($pageNum, Request $request)
	{

		//######分页start
		$pageNum = $pageNum < 1 ? 1 : $pageNum;
		$pageSize = 5;
		$offset = ($pageNum - 1) * $pageSize;
		$count = DB::table('activity')
		->count();
		$page['nowPage'] = $pageNum;
		$page['totalPage'] = ceil($count / $pageSize);
		$page['totalSize'] = $count;
		$prev = ($pageNum - 1) < 1 ? 1 : ($pageNum - 1);
		$next = ($pageNum + 1) > $page['totalPage'] ? $page['totalPage'] : $pageNum + 1;
		$page['prevUrl'] = "/h5/activity/list/{$prev}";
		$page['nextUrl'] = "/h5/activity/list/{$next}";
		$page['url'] = "/h5/activity/list/";
		//######分页end
		$item_id = $request->input('item');
		$province = $request->input('province');
		$city = $request->input('city');
		$status = $request->input('status');

		$te = DB::table('activity')
		->orderBy('id','DESC')
		->skip($offset)//offset  10
		->take($pageSize);//limit 5;

		if ($item_id) {
			$te->where('item_id', $item_id);
		}

		if ($province) {
			$te->where('province', $province);
		}
		if ($city) {
			$te->where('city', $city);
		}

		if ($status) {

			if ($status == 'enlist') {
				$te->where('apply_end_time', '>', date('Y-m-d H-i-s', time()));
			} elseif ($status == 'draw') {
				$te->where('apply_end_time', '<', date('Y-m-d H-i-s', time()));
				$te->where('start_time', '>', date('Y-m-d H-i-s', time()));
			} elseif ($status == 'match') {
				$te->where('end_time', '>', date('Y-m-d H-i-s', time()));
				$te->where('start_time', '<', date('Y-m-d H-i-s', time()));
			} elseif ($status == 'result') {
				$te->where('end_time', '<', date('Y-m-d H-i-s', time()));
			}


		}
		

		$res = $te->get();
		foreach($res as &$row){
			$row->status=get_activity_status($row);
		}
		unset($row);

		$activity_ids = [];
		//状态转化enlist 报名中  draw抽签   match比赛 result成绩 end结束
		$status = [
		'enlist' => '报名中',
		'draw' => '抽签',
		'match' => '比赛',
		'result' => '成绩',
		];
		//
		$item = DB::table('activity_item')
		->get();
		Template::assign('status', $status);
		Template::assign('item', $item);
		Template::assign('list', $res);
		Template::assign('page', $page);
		Template::render('h5/activity/list');
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
		$out['data']['page'] = [];
		//
		$pageNum = $request->input('pageNum') < 1 ? 1 : $request->input('pageNum');
		$label = $request->input('label');
		$pageSize = 20;
		$offset = ($pageNum - 1) * $pageSize;

		$count = DB::table('activity')
		->count();

		$page['nowPage'] = $pageNum;
		$page['totalPage'] = ceil($count / $pageSize);
		$page['totalSize'] = $count;
		$out['data']['page'] = $page;
		$res = DB::table('activity')
		->where('label', '=', $label)
		->orderBy('id', 'DESC')
		->skip($offset)//offset  10
		->take($pageSize)//limit 5
		->get();
		if ($res) {
			$out['data']['list'] = $res;
		}

		Template::assign('list', $res);
		Template::assign('page', $page);
		Template::render('h5/index');
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
	public function create(Request $request)
	{
		//
		$item = DB::table('activity_item')
		->get();

		$detail = [];
		if ($request->input('id')) {
			$detail = DB::table('activity')
			->where('id', $request->input('id'))
			->first();
		}

		Template::assign('detail', $detail);
		Template::assign('item', $item);
		Template::assign('can_change', 1);
		if($detail){
			if($detail->specail_config){
				$specail_game_system = DB::table('activity_specail_config')
				->get();
				$specail_game_system = tran_key($specail_game_system, 'type', true);

				Template::assign('specail_game_system', $specail_game_system);
				Template::render('h5/member/activity/create_specail');
				exit();
			}
		}
		Template::assign('specail_game_system', []);
		Template::render('h5/member/activity/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		// 验证

		$out = ActivityModel::save($request->all());
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
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		$user = Auth::user();
		//
		$res = ActivityModel::detail($id);
		//活动状态
		$res->status = get_activity_status($res);
		//星期几转化
		$res->date_x = date_week($res->start_time);
		$res->date_y = date_week($res->end_time);
		//报名人数
		$count = DB::table('team_member')
		->where('activity_id', $id)
		->count();
		$team_count = DB::table('team')
		->where('activity_id', $id)
		->count();
		//发布俱乐部
		$club = [];
		$club = DB::table('club')
		->where('mem_id', $res->mem_id)
		->first();
		//是否能够抽签
		$can_draw = 0;
		$user_id = 0;
		if ($user) {
			$user_id = $user->id;
			if (time() > strtotime($res->apply_end_time) && time() < strtotime($res->start_time)) {
				$team = DB::table('team')
				->where('mem_id', $user->id)
				->where('activity_id', $id)
				->first();
				if ($team) {
					$can_draw = 1;
				}
			}
			
		}

		Template::assign('team_count', $team_count);
		Template::assign('count', $count);
		Template::assign('club', $club);
		Template::assign('detail', $res);
		Template::assign('can_draw', $can_draw);
		//mingdan

		$out = TeamModel::getList(0, 0, 0, $id);
		Template::assign('team_data', $out['data']);
		Template::assign('i', 0);

				Template::assign('activity_id', $id);
		//过滤
		$activity_detail=ActivityModel::detail($id);
		if (!$activity_detail) {
			Template::assign('url', "/h5/member/activity/set?activity_id={$request->input('activity_turn_id')}");
			Template::assign('error', '该活动不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$config=DB::table('activity_specail_config')
		->where('id',$activity_detail->specail_config)
		->first();
		if(!$config){
			Template::render('h5/activity/detailold');
			//Template::render('h5/activity/set/saikuanglist');
			exit();
		}
		$team_count=DB::table('team')
		->where('activity_id',$id)
		->get();

	/*	if (count($team_count)<($config->group_count*$config->team_count) ){
			Template::assign('url', "/h5/member/activity/set?activity_id={$id}");
			Template::assign('error', '报名未结束');
			Template::render('h5/common/error_redirect');
			exit();
		}*/
		//判断是否分组，若未分组分组
		$activity_turn=DB::table('activity_turn')
		->where('activity_id',$id)
		->where('turn',1)
		->first();
		if(!$activity_turn)
		{
			Template::assign('url', "/h5/member/activity/set?activity_id={$id}");
			Template::assign('error', '该阶段不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$team_match=DB::table('team_match')
		->where('activity_turn_id',$activity_turn->id)
		->get();
		if(!$team_match&&$activity_detail->specail_config&&count($team_count)==4)
		{
			$out=FourModel::group($activity_turn,$config,$team_count);
		}
		//队伍信息
		$out_team_group = ActivitySetShowModel::team_group(['activity_turn_id'=>$activity_turn->id]);
		$out_team_match = ActivitySetShowModel::team_match(['activity_turn_id'=>$activity_turn->id]);

		

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
		Template::assign('user_id', $user_id);
		Template::assign('user_admin', $user->is_admin);

		Template::render('h5/activity/detail');
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
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		//
		$id = $request->input('id');
		OrmActivity::destroy($id);
		return Redirect::to('/h5/member/activity');
	}
	public function join_auto(Request $request){
		$team_member=DB::table('team_member')
		->where('id',$request->input('team_member_id'))
		->where('token',$request->input('token'))
		->first();
		if(!$team_member){
			Template::assign('url', "/");
			Template::assign('error', '非法连接');
			Template::render('h5/common/error_redirect');
			exit();
		}
		DB::table('team_member')
		->where('id',$request->input('team_member_id'))
		->update(['is_valid'=>1]);
		Redirect::to("h5/activity/show/$request->input('activity_id')");
	}
	//join
	public function join(Request $request)
	{
		Template::assign('data_activity_id', $request->input('activity_id'));
		$user = Auth::user();
		//是否已经报过该活动
/* 		if ($user->user_team_member_id > 0) {
			$res = DB::table('team_member')
			->where('user_team_member_id', $user->user_team_member_id)
			->where('activity_id', $request->input('activity_id'))
			->first();
			if ($res) {
				Template::assign('url', '/h5/activity/show/' . $request->input('activity_id'));
				Template::assign('error', '已报名');
				Template::render('h5/common/error_redirect');
				exit();
			}
		} */

		//活动项目
		$activity_category = DB::table('activity_category')
		->where('activity_id', $request->input('activity_id'))
		->get();
		$apply_item_num = [
		11 => 1,
		12 => 1,
		21 => 2,
		22 => 2,
		23 => 2,
		10 => 1,
		20 => 2,
		];
		foreach ($activity_category as &$row) {
			$row->name = activity_item_tran($row->apply_item);
			$row->item = $row->apply_item;
			$row->number = 1;
			$row->people_number=0;
			$row->people_number=$apply_item_num[$row->apply_item];
			unset($row->apply_item);
		}
		unset($row);

		//我的队员
		$data_member_person = UserModel::person_list(true, $user->id,$request->input('activity_id'));
		//活动信息
		$activity = ActivityModel::detail($request->input('activity_id'));
		//我的信息
		$need_captaion =0;
		if($activity->specail_config)
		{
			$need_captaion=1;
		}
		$user_id = $user->id;
		Template::assign('data_activity', $activity);
		Template::assign('need_captaion', $need_captaion);
		Template::assign('data_activity_category', $activity_category);
		Template::assign('data_member_person', $data_member_person);
		Template::assign('data_user_id', $user_id);
		Template::render('h5/activity/join');
	}


	//joinPerson
	public function joinPerson(Request $request)
	{
		$user = Auth::user();
		$captain = isset($_COOKIE['join_team_captain']) ? $_COOKIE['join_team_captain'] : '';
		$common = isset($_COOKIE['join_team_common']) ? explode(',', $_COOKIE['join_team_common']) : [];
		$act_id = isset($_COOKIE['join_activity_id']) ? $_COOKIE['join_activity_id'] : [];

		$query =
		DB::table('user_team_member');
		if ($captain && $request->input('type') == 'common') {
			$query->where('id', '<>', $captain);
		}
		$query->where('mem_id', $user->id);
		$list = $query->get();
		$type = $request->input('type');
		$rule = DB::table('activity')
		->where('id', $act_id)
		->first();
		Template::assign('type', $type);
		Template::assign('list', $list);
		Template::assign('captain', $captain);
		Template::assign('common', $common);
		Template::assign('rule', $rule);
		Template::render('h5/activity/person');
	}


	//抽签
	public function chouqian(Request $request)
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
		Template::render('h5/activity/cqjieguo');
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

	public function create_specail(Request $request)
	{
		//
		$item = DB::table('activity_item')
		->get();

		$detail = [];
		if ($request->input('id')) {
			$detail = DB::table('activity')
			->where('id', $request->input('id'))
			->first();
		}
		$specail_game_system = DB::table('activity_specail_config')
		->get();
		$specail_game_system = tran_key($specail_game_system, 'type', true);

		Template::assign('specail_game_system', $specail_game_system);
		Template::assign('detail', $detail);
		Template::assign('item', $item);
		Template::assign('can_change', 1);
		Template::render('h5/member/activity/create_specail');
	}

	public function store_specail(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();
		// 验证
		$out = ActivityModel::save_specail($request->all());

		if ($out['code'] != 0) {
			return $out;
		}
		return $out;
	}

	public function edit_join(Request $request){

		Template::assign('team_id', $request->input('team_id'));
		$user = Auth::user();
		$can_change=1;
		//@todo 验证
		$url="/h5/member/activity/manager_team_list?activity_id={$request->input('activity_id')}";
		$team=DB::table('team')
		->where('id',$request->input('team_id'))
		->first();
		if($team->mem_id!=$user->id)
		{
			Template::assign('url', $url);
			Template::assign('error', '不是创建者，没有权限');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$activity_turn=DB::table('activity_turn')
		->where('activity_id',$request->input('activity_id'))
		->where('turn',1)
		->first();
		$team_match=DB::table('team_match')
		->where('activity_turn_id',$activity_turn->id)
		->count();
		if($team_match)
		{
			$can_change=0;
		}
		if(!$can_change)
		{
			Template::assign('url', $url);
			Template::assign('error', '已过修改期限');
			Template::render('h5/common/error_redirect');
			exit();
		}
		//活动项目
		$activity_category = DB::table('activity_category')
		->where('activity_id', $request->input('activity_id'))
		->get();
		$apply_item_num = [
		11 => 1,
		12 => 1,
		21 => 2,
		22 => 2,
		23 => 2,
		10 => 1,
		20 => 2,
		];
		foreach ($activity_category as &$row) {
			$row->name = activity_item_tran($row->apply_item);
			$row->item = $row->apply_item;
			$row->number = 1;
			$row->people_number=0;
			$row->people_number=$apply_item_num[$row->apply_item];
			unset($row->apply_item);
		}
		unset($row);

		//我的队员
		$data_member_person = UserModel::person_list(true, $user->id,$request->input('activity_id'));
		//活动信息
		$activity = ActivityModel::detail($request->input('activity_id'));
		//我的信息
		$user_id = $user->id;

		$cap=DB::table('team_member')
		->where('activity_id',$request->input('activity_id'))
		->where('team_id',$request->input('team_id'))
		->where('is_captain',1)
		->first();
		foreach($data_member_person as &$row){
			$row->team=$request->input('team_id');
			if($cap&&$cap->user_team_member_id==$row->id){
				$row->duizhang=1;
			}
		}
		unset($row);

		Template::assign('data_activity', $activity);
		Template::assign('data_activity_category', $activity_category);
		Template::assign('data_member_person', $data_member_person);
		Template::assign('data_user_id', $user_id);
		Template::assign('team', $team);
		Template::assign('can_change', $can_change);
		Template::assign('activity', $activity);
		Template::render('h5/activity/join_edit');
	}
	
	public function  pinglun2(Request $request){
		$activity_id=$request->input('activity_id');
		if ($activity_id<1) {
			Template::assign('url', "h5/activity/show/{$activity_id}");
			Template::assign('error', '改活动不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$comment=DB::table('activity_comment')->where('activity_id',$activity_id)->orderBy('id','desc')->get();

		$mem_ids=class_column($comment,'mem_id');
		$users=DB::table('users')->whereIn('id',$mem_ids)->get();
		$users=tran_key($users,'id',true);

		foreach ($comment as &$row){
			$row->mem_name=isset($users[$row->mem_id])?$users[$row->mem_id]->name:'';
			$row->mem_photo=isset($users[$row->mem_id])?$users[$row->mem_id]->cover_img:'';
		}
		unset($row);

		Template::assign('comment', $comment);
		Template::assign('activity_id', $activity_id);
		Template::render('h5/activity/plun');
	}
	public function  pinglun_post2(Request $request){
		$activity_id=$request->input('activity_id');
		$url="/h5/activity/pinglun?activity_id={$activity_id}";
		if ($activity_id<1) {
			Template::assign('url', $url);
			Template::assign('error', '改活动不存在');
			Template::render('h5/common/error_redirect');
			exit();
		}
		if ( !$request->input('content')) {
			Template::assign('url', $url);
			Template::assign('error', '内容不能为空');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$user=Auth::user();
		$comment_count=DB::table('activity_comment')->where('activity_id',$activity_id)
		->where('content',$request->input('content'))
		->where('mem_id',$user->id)->count();
		if ( $comment_count>0) {
			Template::assign('url', $url);
			Template::assign('error', '已评论相同内容');
			Template::render('h5/common/error_redirect');
			exit();
		}
		$insert=[];
		$insert['mem_id']=$user->id;
		$insert['activity_id']=$activity_id;
		$insert['content']=$request->input('content');
		$insert['create_time']=date('Y-m-d H-i-s',time());
		DB::table('activity_comment')->insert($insert);
		
		$comment=DB::table('activity_comment')->where('activity_id',$activity_id)->orderBy('id','desc')->get();

		$mem_ids=class_column($comment,'mem_id');
		$users=DB::table('users')->whereIn('id',$mem_ids)->get();
		$users=tran_key($users,'id',true);

		foreach ($comment as &$row){
			$row->mem_name=isset($users[$row->mem_id])?$users[$row->mem_id]->name:'';
			$row->mem_photo=isset($users[$row->mem_id])?$users[$row->mem_id]->cover_img:'';
		}
		unset($row);

		Template::assign('comment', $comment);
		Template::assign('activity_id', $request->input('activity_id'));
		Template::render('h5/activity/plun');
	}
	public function join_four(Request $request){
		$user=Auth::user();
		$activity_id=$request->input('activity_id',0);
		$club_member = DB::table('club_member')
		->where('mem_id',$user->id)
		->get();
		$user_ids_all=class_column($club_member,'user_team_member_id');
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
		$out_club_member=[];
		foreach ($club_member  as $key => $value) {
			if(in_array($value->user_team_member_id,$user_team_member_ids_on)){
				continue;
			}
			$out_club_member[]=$value;
		}
		$list=[];
		$uids=class_column($out_club_member,'user_team_member_id');
		$identity_cards_all=DB::table('user_team_member')
		->whereIn('id',$uids)
		->get();
		$identity_cards_all_tmp=tran_key($identity_cards_all,'id',true);
		foreach ($out_club_member as $key => $value) {
			if(isset($value->user_team_member_id)){
		$value->mem_name=$identity_cards_all_tmp[$value->user_team_member_id]->name;
				$value->mem_phone=$identity_cards_all_tmp[$value->user_team_member_id]->phone_number;
			}else{
				$value->mem_name='';
				$value->mem_phone='';
			}
			
		}
		$list=$out_club_member;
	
		$club_info=DB::table('club')->where('mem_id',$user->id)->first();

		Template::assign('club_info',$club_info);
		Template::assign('list',$list);
		Template::assign('activity_id',$activity_id);
		Template::render('h5/activity/join_four');
	}

	public function join_four_post(Request $request){

		$user=Auth::user();
		$activity_id=$request->input('activity_id',0);
		$person=$request->input('person');
		$url='/h5/activity/join_four?activity_id='.$activity_id;
		if($request->input('activity_id')<1){
			Template::assign('url', $url);
			Template::assign('error', '活动id错误');
			Template::render('h5/common/error_redirect');
			exit();
		}
		if(!$request->input('team_name')){
			Template::assign('url', $url);
			Template::assign('error', '名称不能为空');
			Template::render('h5/common/error_redirect');
			exit();	
		}
		if(count($request->input('person'))<8){
			Template::assign('url', $url);
			Template::assign('error', '人数小于8 ');
			Template::render('h5/common/error_redirect');
			exit();	
		}
		//if(count($request->input('person'))>10){
		//	Template::assign('url', $url);
		//	Template::assign('error', '人数大于10');
		//	Template::render('h5/common/error_redirect');
		//	exit();	
		//}
		$club_name=$request->input('club_name') ;
		$team_name=$request->input('team_name');
		$last_name=$club_name.'俱乐部--'.$team_name;
		$team_count=DB::table('team')->where('name',$last_name)->count();
		if($team_count){
			Template::assign('url', $url);
			Template::assign('error', '队伍已存在');
			Template::render('h5/common/error_redirect');
			exit();		
		}
		$data=[
		'name'=>$last_name,
		'activity_id'=>$activity_id,
		'mem_id'=>$user->id,
		];
		$insert_id=DB::table('team')
		->insertGetId($data);
		$team_list_first=array_slice($person, 0,8);
		$team_list_second=array_slice($person, 8);
		foreach ($person as $key => $val) {
			$data=[];
			$data=[
				'team_id'=>$insert_id,
				'activity_id'=>$activity_id,
				'team_name'=>$last_name,
				'mem_id'=>$user->id,
				'user_team_member_id'=>$val
			];
			DB::table('team_member')->insert($data);
		}
		foreach ($team_list_second as $key => $value) {
			$data=[];
			$data=[
				'team_id'=>$insert_id,
				'activity_id'=>$activity_id,
				'team_name'=>$last_name,
				'mem_id'=>$user->id,
				'user_team_member_id'=>$val
			];
			DB::table('team_member_back')->insert($data);
		}


		$team_member_inserts = [];
		$activity_category_member_inserts = [];

		$activity_category = DB::table('activity_category')
					->where('activity_id','=',$activity_id)
					->get();
		//$activity_category= tran_key($activity_category,'id');

		foreach ($person as $key => $val) {
			if($key%2!=0){
				$key=$key-1;
			}
		$x=$key/2;
		if(!isset($activity_category[$x])){
			break;
		}
		$activity_category_member_insert = [];
		$activity_category_member_insert['activity_category_id'] =$activity_category[$x]->id;
		$activity_category_member_insert['user_team_member_id'] = $val;
		$activity_category_member_insert['team_id'] = $insert_id;
		$activity_category_member_inserts[] = $activity_category_member_insert;
		
		}

		DB::table('activity_category_member')
		->insert($activity_category_member_inserts);


	header('Location:/h5/activity/show/'.$activity_id);die;
	}
}
