<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/11/21
 * Time: 9:53
 */

namespace App\Models;

use App\Orms\Activity as OrmActivity;
use DB;
use Auth;

class ActivityModel extends BaseModel
{

    public static function detail($id)
    {
        return DB::table('activity')
            ->where('id', $id)
            ->first();
    }

    /**
     * 保存
     * @param $request
     * @return array
     */
    public static function save($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $request['title'] = isset($request['title']) ? $request['title'] : '';
        $request['start_time'] = isset($request['start_time']) ? $request['start_time'] : '';
        $request['end_time'] = isset($request['end_time']) ? $request['end_time'] : '';
        $request['apply_start_time'] = isset($request['apply_start_time']) ? $request['apply_start_time'] : '';
        $request['apply_end_time'] = isset($request['apply_end_time']) ? $request['apply_end_time'] : '';
        $request['start_time'] = isset($request['start_time']) ? $request['start_time'] : '';
        $request['end_time'] = isset($request['end_time']) ? $request['end_time'] : '';
        $request['apply_item'] = isset($request['apply_item']) ? $request['apply_item'] : '';
        $request['team_count'] = isset($request['team_count']) ? $request['team_count'] : '';
        $request['score_system'] = isset($request['score_system']) ? $request['score_system'] : '';
        $request['game_system'] = isset($request['game_system']) ? $request['game_system'] : '';
        $request['cover_img'] = isset($request['cover_img']) ? $request['cover_img'] : '';
        $request['postion'] = isset($request['postion']) ? $request['postion'] : '';
        $request['introduction'] = isset($request['introduction']) ? $request['introduction'] : '';
        $request['rule'] = isset($request['rule']) ? $request['rule'] : '';
        $request['reward'] = isset($request['reward']) ? $request['reward'] : '';
        $request['points'] = isset($request['points']) ? $request['points'] : '';
        $request['link_man'] = isset($request['link_man']) ? $request['link_man'] : '';
        $request['link_mail'] = isset($request['link_mail']) ? $request['link_mail'] : '';
        $request['link_phone'] = isset($request['link_phone']) ? $request['link_phone'] : '';
        $request['link_qq'] = isset($request['link_qq']) ? $request['link_qq'] : '';
        $request['team_count'] = isset($request['team_count']) ? $request['team_count'] : '';
        $request['item_id'] = isset($request['item_id']) ? $request['item_id'] : '';
        $request['province'] = isset($request['province']) ? $request['province'] : '';
        $request['city'] = isset($request['city']) ? $request['city'] : '';
        $request['apply_type'] = isset($request['apply_type']) ? $request['apply_type'] : '';
        $request['how_win'] = isset($request['how_win']) ? $request['how_win'] : 1;
        if (!$request['title']) {
            $out['code'] = 1;
            $out['msg'] = '标题不能为空';
            return $out;
        }
        if (!$request['introduction']) {
            $out['code'] = 1;
            $out['msg'] = '活动介绍不能为空';
            return $out;
        }
        if (!$request['start_time']) {
            $out['code'] = 4;
            $out['msg'] = '开始时间不能为空';
            return $out;
        }
        if (!$request['end_time']) {
            $out['code'] = 5;
            $out['msg'] = '截止时间不能为空';
            return $out;
        }
        if (!$request['apply_start_time']) {
            $out['code'] = 6;
            $out['msg'] = '申请开始时间不能为空';
            return $out;
        }
        if (!$request['apply_end_time']) {
            $out['code'] = 7;
            $out['msg'] = '申请结束时间不能为空';
            return $out;
        }

        if ($request['start_time'] > $request['end_time']) {
            $out['code'] = 9;
            $out['msg'] = '开始时间不能大于截止时间';
            return $out;
        }
        if ($request['apply_start_time'] > $request['apply_end_time']) {
            $out['code'] = 10;
            $out['msg'] = '申请开始时间不能大于申请截止时间';
            return $out;
        }
        if ($request['start_time'] < $request['apply_end_time']) {
            $out['code'] = 10;
            $out['msg'] = '开始时间不能小于申请截止时间';
            return $out;
        }
        if (!$request['apply_type']) {
            $out['code'] = 10;
            $out['msg'] = '报名类型不能为空';
            return $out;
        }
        if (!$request['apply_item']) {
            $out['code'] = 10;
            $out['msg'] = '项目不能为空';
            return $out;
        }
        foreach ($request['apply_number'] as $key => $value) {
            if ($value < 1) {
                $out['code'] = 10;
                $out['msg'] = '项目数量不能小于1';
                return $out;
            }

        }
        if (($apply_items = $request['apply_item']) && ($apply_numbers = $request['apply_number'])) {
            if ($request['apply_type'] != 1) {
                $sum_count = 0;
                $sum_count = sum_activity_people_count($apply_items, $apply_numbers);
                if ($request['team_count'] < $sum_count) {
                    $out['code'] = 11;
                    $out['msg'] = '队伍最大人数太小';
                    return $out;
                }
            }

        }

        if (!in_array($request['score_system'], [0, 11, 15, 21])) {
            $out['code'] = 12;
            $out['msg'] = '比赛分制不能为空';
            return $out;
        }
        if (!in_array($request['game_system'], [0, 1, 2])) {
            $out['code'] = 13;
            $out['msg'] = '第一轮赛制不能为空';
            return $out;
        }
        $ormActivity = new OrmActivity();
        if ($request['cover_img']) {
            $ormActivity->cover_img = $request['cover_img'];
        }
        $activity_count = DB::table('activity')
            ->where('title', $request['title'])
            ->count();
        if ($activity_count > 0) {
            $out['code'] = 14;
            $out['msg'] = '活动名已存在';
            return $out;
        }
        $ormActivity->title = $request['title'];
        //  $ormActivity->game_system = $request['game_system'];
        $ormActivity->score_system = $request['score_system'];
        $ormActivity->start_time = $request['start_time'];
        $ormActivity->apply_start_time = $request['apply_start_time'];
        $ormActivity->apply_end_time = $request['apply_end_time'];
        $ormActivity->end_time = $request['end_time'];
        $ormActivity->how_win = $request['how_win'];
        if ($request['apply_type']) {
            $ormActivity->apply_type = $request['apply_type'];
        }
        if ($request['cost']) {
            $ormActivity->cost = $request['cost'];
        }

        if ($request['postion']) {
            $ormActivity->postion = $request['postion'];
        }
        if ($request['introduction']) {
            $ormActivity->introduction = $request['introduction'];
        }

        if ($request['rule']) {
            $ormActivity->rule = $request['rule'];
        }

        if ($request['reward']) {
            $ormActivity->reward = $request['reward'];
        }

        if ($request['points']) {
            $ormActivity->points = $request['points'];
        }

        if ($request['link_man']) {
            $ormActivity->link_man = $request['link_man'];
        }

        if ($request['link_mail']) {
            $ormActivity->link_mail = $request['link_mail'];
        }

        if ($request['link_phone']) {
            $ormActivity->link_phone = $request['link_phone'];
        }

        if ($request['link_qq']) {
            $ormActivity->link_qq = $request['link_qq'];
        }
        if ($request['team_count']) {
            $ormActivity->team_count = $request['team_count'];
        }
        if ($request['item_id']) {
            $ormActivity->item_id = $request['item_id'];
        }
        if ($request['province'] && $request['province'] != '请选择') {
            $ormActivity->province = $request['province'];
        }
        if ($request['city'] && $request['city'] != '请选择') {
            $ormActivity->city = $request['city'];
        }

        $user = Auth::user();

        $club = DB::table('club')
            ->where('mem_id',  $user->id)
            ->orderBy('id','ASC')
            ->first();

        if (!isset($club->status )||$club->status != 1) {
            $out['code'] = 2;
            $out['msg'] = '俱乐部审核未通过，不能发布活动';
            return $out;
        }

        $ormActivity->club_id = $club->id;
        $ormActivity->mem_id = $user->id;
        $ormActivity->save();
        $inser_d = $ormActivity->getAttributes();
        //activity_turn 1
        $lun = [];
        $lun['activity_id'] = $inser_d['id'];
        $lun['turn'] = 1;
        $lun['game_system'] = $request['game_system'];
        DB::table('activity_turn')
            ->insert($lun);

        if ($apply_items && $apply_numbers) {
            //保存活动的报名项
            $activity_cats = [];
            foreach ($apply_numbers as $key => $value) {
                for ($i = 0; $i < $value; $i++) {

                    $activity_cats[] = [
                        'activity_id' => $inser_d['id'],
                        'apply_item' => $apply_items[$key],
                    ];

                }

            }
            DB::table('activity_category')
                ->insert($activity_cats);
        }
        return $out;
    }

    //抽签
    public static function draw($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $user = Auth::user();
        //报名活动截止
        $detail = self::detail($request['activity_id']);
        if (time() < strtotime($detail->apply_end_time)) {
            $out['code'] = 1;
            $out['msg'] = '未到抽签时间';
            return $out;
        }
        //抽签
        $count = DB::table('team')
            ->where('activity_id', $request['activity_id'])
            ->count();

        $team = DB::table('team')
            ->where('mem_id', $user->id)
            ->where('activity_id', $request['activity_id'])
            ->first();
        if (!$team) {
            $out['code'] = 3;
            $out['msg'] = '队伍不存在';
            return $out;
        }
        if ($team->draw_id > 0) {
            $out['code'] = 2;
            $out['msg'] = '已经抽过了';
            return $out;
        }

        self::draw_base($request['activity_id'], $team->id, $count);
        return $out;
    }

    //抽签
    public static function draw_all($activity_id)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $user = Auth::user();

        $detail = self::detail($activity_id);
        $team = DB::table('team')
            ->where('activity_id', $activity_id)
            ->get();
        if (!$team) {
            $out['code'] = 3;
            $out['msg'] = '队伍不存在';
            return $out;
        }
        $count = count($team);
        //是否已经抽过
        $is_draw = true;
        foreach ($team as $row) {
            if ($row->draw_id < 1) {
                $is_draw = false;
                break;
            }
        }
        if ($is_draw) {
            return $out;
        }

        foreach ($team as $row) {
            self::draw_base($activity_id, $row->id, $count);
        }

        return $out;
    }

    /**
     * 基础抽签类
     * @param $activity_id
     * @param $team_id
     * @param $count
     */
    public static function draw_base($activity_id, $team_id, $count)
    {
        $draw_id = 0;
        $draw_count = [];
        for ($i = 0; $i < $count; $i++) {
            $draw_count[] = $i + 1;
        }

        //已抽的id
        $team_tmp_all = DB::table('team')
            ->where('activity_id', $activity_id)
            ->get();

        $team_tmp_all_ids = class_column($team_tmp_all, 'draw_id');
        $no_ids = array_diff($draw_count, $team_tmp_all_ids);//未抽的id
        $no_ids_tmp = array_values($no_ids);

        $no_count = count($no_ids_tmp);
        $no_count = $no_count - 1;
        $draw_id_key = mt_rand(0, $no_count);


        $draw_id = $no_ids_tmp[$draw_id_key];

        $team = DB::table('team')
            ->where('id', $team_id)
            ->update(['draw_id' => $draw_id]);
    }

    public static function my_join_activity_list()
    {
        $out = [];
        $user = Auth::user();
        $res = DB::table('team_member')
            ->where('mem_id', $user->id)
            ->get();
        if (!$res) {
            return [];
        }
        $activity_ids = class_column($res, 'activity_id');
        $activitys = DB::table('activity')
            ->whereIn('id', $activity_ids)
            ->get();
        $out = $activitys;
        return $out;
    }

    public static function add_activity_turn($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $count = DB::table('activity_turn')
            ->where('activity_id', $request['activity_id'])
            ->where('turn', $request['turn'] - 1)
            ->count();
        if ($count < 1) {
            $out['code'] = 1;
            $out['msg'] = 'shangyilunbucunzai';
            return $out;
        }
        $count = DB::table('activity_turn')
            ->where('activity_id', $request['activity_id'])
            ->where('turn', $request['turn'])
            ->count();
        if ($count > 0) {
            $out['code'] = 2;
            $out['msg'] = 'yicunzai';
            return $out;
        }
        $data['activity_id'] = $request['activity_id'];
        $data['turn'] = $request['turn'];
        $data['game_system'] = $request['game_system'];
        if (in_array($request['game_system'], [1, 2])) {
            $data['group_count'] = $request['group_count'];
        }

        DB::insert($data);
        return $out;
    }

    public static function group($request)
    {


    }

    public static function add_team_match($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $activity_turn_id = $request['activity_turn_id'];
        $activity_turn = DB::table('activity_turn')
            ->where('id', $activity_turn_id)
            ->first();

        if (!$activity_turn) {
            $out['code'] = 3;
            $out['msg'] = 'activity_turn   不存在';
            return $out;
        }
        $act_detail = self::detail($activity_turn->activity_id);
        if (!$act_detail) {
            $out['code'] = 1;
            $out['msg'] = 'activity 不存在';
            return $out;
        }
        $team_group = DB::table('team_group')
            ->where('activity_turn_id', $activity_turn_id)
            ->get();
        if (!$team_group) {
            $out['code'] = 4;
            $out['msg'] = 'team_group 不存在';
            return $out;
        }
        $team_match = DB::table('team_match')
            ->where('activity_turn_id', $activity_turn_id)
            ->get();
        if ($team_match) {
            $out['code'] = 5;
            $out['msg'] = 'team_match   已存在';
            return $out;
        }
        if ($activity_turn->game_system == 0) {
            self::add_team_match_tao($activity_turn, $team_group);
        }
        if ($activity_turn->game_system == 1)//wai
        {
            self::add_team_match_wai($activity_turn, $team_group);
        }
        if ($activity_turn->game_system == 2)//nei
        {
            self::add_team_match_nei($activity_turn, $team_group);
        }
        return $out;
    }

    public static function team_group_insert($data)
    {
        return DB::table('team_group')
            ->insert($data);
    }


    public static function add_team_member_match($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $team_match_id = $request['team_match_id'];

        $res = DB::table('team_match')
            ->where('id', $team_match_id)
            ->first();
        if (!$res) {
            $out['code'] = 1;
            $out['msg'] = 'team_match不存在';
            return $out;
        }
        $activity_turn = DB::table('activity_turn')
            ->where('id', $res->activity_turn_id)
            ->first();
        if (!$activity_turn) {
            $out['code'] = 2;
            $out['msg'] = 'activity_turn不存在';
            return $out;
        }

        $activity_category = DB::table('activity_category')
            ->where('activity_id', $activity_turn->activity_id)
            ->get();

        if (!$activity_category) {
            $out['code'] = 2;
            $out['msg'] = 'activity_category不存在';
            return $out;
        }

        //所有项目都相同时循环打
        $one = false;
        foreach ($activity_category as $row) {
            if (!isset($tmp_row)) {
                $tmp_row = $row->apply_item;
            }
            if ($row->apply_item != $tmp_row) {
                $one = true;
                break;
            }
        }

        $team_member_match_count = DB::table('team_member_match')
            ->where('team_match_id', $res->id)
            ->count();
        if ($team_member_match_count > 0) {
            $out['code'] = 3;
            $out['msg'] = 'team_member_match已存在';
            return $out;
        }
        //去除队长
        $team_a = DB::table('team_member')
            ->where('team_id', $res->team_a)
            ->get();
        foreach ($team_a as $key => $row) {
            if ($row->is_captain == 1) {
                unset($team_a[$key]);
            }
        }

        $team_b = DB::table('team_member')
            ->where('team_id', $res->team_b)
            ->get();
        foreach ($team_b as $key => $row) {
            if ($row->is_captain == 1) {
                unset($team_b[$key]);
            }
        }

        //分成项目取a  b
        $team_as = [];
        $team_bs = [];
        $team_asl = [];
        $team_bsl = [];
        foreach ($team_a as $row) {
            if (!in_array($row->category_id, $team_as)) {
                $team_as[] = $row->category_id;
                $team_asl[] = $row;
            }
        }
        foreach ($team_b as $row) {
            if (!in_array($row->category_id, $team_bs)) {
                $team_bs[] = $row->category_id;
                $team_bsl[] = $row;
            }
        }
        //多次打
        if (!$one) {
            $ins = [];
            foreach ($team_asl as $key => $value) {
                foreach ($team_bsl as $k => $v) {
                    $in = [];
                    $in['team_match_id'] = $res->id;
                    $in['category_a_id'] = $value->category_id;
                    $in['category_b_id'] = $v->category_id;
                    $ins[] = $in;
                }
            }
            if (!$ins) {
                return $out;
            }
            $is = DB::table('team_member_match')
                ->insert($ins);
            return $out;
        }


        //一次打
        $ins = [];
        foreach ($team_asl as $key => $value) {
            foreach ($team_bsl as $k => $v) {
                if ($value->category_id == $v->category_id) {
                    unset($team_bsl[$k]);
                    $in = [];
                    $in['team_match_id'] = $res->id;
                    $in['category_a_id'] = $value->category_id;
                    $in['category_b_id'] = $v->category_id;
                    $ins[] = $in;
                    break;
                }

            }
        }
        if (!$ins) {
            return $out;
        }
        $is = DB::table('team_member_match')
            ->insert($ins);
        return $out;


    }

    //@todo
    public function delete_team_member_match($activity_id, $turn)
    {

    }

    //打分
    public static function postscore($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['memberMatchId'])) {
            $out['code'] = 2;
            $out['msg'] = 'memberMatchId为空';
            return $out;
        }
        $team_member_match = DB::table('team_member_match')
            ->where('id', $request['memberMatchId'])
            ->first();
        if (!$team_member_match) {
            $out['code'] = 3;
            $out['msg'] = 'team_member_match 不存在';
            return $out;
        }



        if (!isset($request['scoreA'])) {
            $out['code'] = 3;
            $out['msg'] = 'a的分数为空';
            return $out;
        }
        if (!isset($request['scoreB'])) {
            $out['code'] = 4;
            $out['msg'] = 'b的分数为空';
            return $out;
        }
        if ($request['scoreB'] < 0) {
            $out['code'] = 4;
            $out['msg'] = '分数不能小于0';
            return $out;
        }
        if ($request['scoreA'] < 0) {
            $out['code'] = 4;
            $out['msg'] = '分数不能小于0';
            return $out;
        }
        if ($request['scoreA'] ==$request['scoreB']) {
        	$out['code'] = 6;
        	$out['msg'] = '分数不能相等';
        	return $out;
        }
        if (!isset($request['activityId'])) {
            $out['code'] = 4;
            $out['msg'] = 'activityId为空';
            return $out;
        }
        $detail = self::detail($request['activityId']);
        if (!$detail) {
            $out['code'] = 4;
            $out['msg'] = '改活动不存在';
            return $out;
        }

        if ($detail->score_system > 0) {
            if ($request['scoreB'] > $detail->score_system) {
                $out['code'] = 6;
                $out['msg'] = '分数大于最大分数';
                return $out;
            }
            if ($request['scoreA'] > $detail->score_system) {
                $out['code'] = 6;
                $out['msg'] = '分数大于最大分数';
                return $out;
            }
            if (  $request['scoreA']!= $detail->score_system&&$request['scoreB']!=$detail->score_system) {
                $out['code'] = 7;
                $out['msg'] = '提交的分数不符合分制！';
                return $out;
            }
        }
        //开启事务
        DB::beginTransaction();
        try {
            $team_match = DB::table('team_match')
                ->where('id', $team_member_match->team_match_id)
                ->first();

            $insert_data = [];
            $insert_data['win_a_count'] = $request['scoreA'];
            $insert_data['win_b_count'] = $request['scoreB'];
            $insert_data['score_count'] = $team_member_match->score_count + 1;

       				 DB::table('team_member_match')
                ->where('id', $request['memberMatchId'])
                ->update($insert_data);
            //更新队伍比分(通过计算打分前后的对比计算出最终的打分结果)
       				 $team_member_match_sc=DB::table('team_member_match')
       				 ->where('team_match_id', $team_match->id)
       				 ->get();
       				 $up_win_a=0;
       				 $up_win_b=0;
       				 foreach ($team_member_match_sc as $row){
       				 	if($row->win_a_count>$row->win_b_count){
       				 		$up_win_a++;
       				 	}elseif($row->win_a_count<$row->win_b_count){
       				 		$up_win_b++;
       				 	}
       				 }
       			
                    $up = [
                        'win_a' => $up_win_a,
                        'win_b' => $up_win_b
                    ];		

            DB::table('team_match')->where('id', $team_match->id)->update($up);
            //team_group打分
           
            //DB::table('team_group')->where('id', $team_match->id)->update($up);
            if($team_match->group_match_id){
            	
            }else{
            $team_match_all=DB::table('team_match')->where('activity_turn_id',$team_match->activity_turn_id)
            ->where('team_group_num',$team_match->team_group_num)
            ->get();   
         
            	$tmp=[];
            	foreach ($team_match_all as $row){
            			$win_sum=$row->win_a-$row->win_b;
            		
            			if(!isset($tmp[$row->team_a]['win_count'])){
            				$tmp[$row->team_a]['win_count']=0;
            			}
            				if($win_sum!=0){
            					$tmp[$row->team_a]['win_count']+=$win_sum>0?1:0;
            				}
            		
            			if(!isset(	$tmp[$row->team_a]['win_count_all'])){
            					$tmp[$row->team_a]['win_count_all']=0;
            			}
            				if($win_sum!=0){
            					$tmp[$row->team_a]['win_count_all']+=$win_sum;
            				}
            		
            			if(!isset($tmp[$row->team_b]['win_count'])){
            				$tmp[$row->team_b]['win_count']=0;
            			}
            				if($win_sum!=0){
            					$tmp[$row->team_b]['win_count']+=$win_sum<0?1:0;
            				}
            		
            			if(!isset($tmp[$row->team_b]['win_count_all'])){
            				$tmp[$row->team_b]['win_count_all']=0;
            			}
            			
            				if($win_sum!=0){
            					$tmp[$row->team_b]['win_count_all']-=$win_sum;
            				}
            	}
            
            	foreach ($tmp    as $k=>$v){
            		$up=[];
            		$up['win_count']=$v['win_count'];
            		$up['win_count_all']=$v['win_count_all'];
            		DB::table('team_group')->
            	where('activity_turn_id',$team_match->activity_turn_id)
            ->where('group_num',$team_match->team_group_num)
            ->where('team_id',$k)
            		->update($up);
            	}
            	
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
    

    //setting
    public function set($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $activity_turn = DB::table('activity_turn')
            ->where('activity_id', $request['activity_id'])
            ->where('turn', $request['activity_id'])
            ->get();
        if ($activity_turn) {
            $out['code'] = 1;
            $out['msg'] = '已经设置过了';
        }
        $insert = [];
        $insert['activity_id'] = $request['activity_id'];
        $insert['turn'] = $request['turn'];
        $insert['game_system'] = $request['game_system'];
        if (isset($insert['group_count'])) {
            $insert['group_count'] = $request['group_count'];
        }
        DB::table('activity_turn')
            ->insert($insert);
        return $out;
    }


    public static function can_score($activity_id, $user)
    {
        $can_score = 0;//是否能够打分
        $activity = self::detail($activity_id);

        if ($user->id == $activity->mem_id) {
            $can_score = 1;
        }

        return $can_score;
    }

    public static function prev_exit($request)
    {
        $can_rank = 1;
        $activity_turn = DB::table('activity_turn')
            ->where('id', $request['activity_turn_id'])
            ->first();
        if ($activity_turn->turn > 1) {
            $activity_turn_prev = DB::table('activity_turn')
                ->where('activity_id', $activity_turn->activity_id)
                ->where('turn', $activity_turn->turn - 1)
                ->first();
            $team_group_count = DB::table('team_group')
                ->where('activity_turn_id', $activity_turn_prev->id)
                ->count();
            if ($team_group_count > 0) {
                $can_rank = 0;
            }
            return $can_rank;
        }
    }

    public static function next_exit($request)
    {
        $can_rank = 1;
        $activity_turn = DB::table('activity_turn')
            ->where('id', $request['activity_turn_id'])
            ->first();

        $activity_turn_next = DB::table('activity_turn')
            ->where('activity_id', $activity_turn->activity_id)
            ->where('turn', $activity_turn->turn + 1)
            ->first();
        if (!$activity_turn_next) return $can_rank;
        $team_group_count = DB::table('team_group')
            ->where('activity_turn_id', $activity_turn_next->id)
            ->count();
        if ($team_group_count > 0) {
            $can_rank = 0;
        }
        return $can_rank;
    }

    /**
     * 保存
     * @param $request
     * @return array
     */
    public static function save_specail($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $user = Auth::user();

        $user_club = DB::table('user_club')
            ->where('mem_id', $user->id)
            ->first();

        $club = DB::table('club')
            ->where('mem_id', $user->id)
            ->first();

        $zhsh_id = DB::table('activity')
                            ->where('specail_config','>',0)
                            ->count();

        $activity_count = DB::table('activity')
            ->where('club_id', $club->id)
            ->count();

        $request['title'] =   '纵横四海'.$request['city'].($zhsh_id+1).' 举办方:'.$club->name.'-'.($activity_count+1);
        $request['start_time'] = isset($request['start_time']) ? $request['start_time'] : '';
        $request['end_time'] = isset($request['end_time']) ? $request['end_time'] : '';
        $request['apply_start_time'] = isset($request['apply_start_time']) ? $request['apply_start_time'] : '';
        $request['apply_end_time'] = isset($request['apply_end_time']) ? $request['apply_end_time'] : '';
        $request['start_time'] = isset($request['start_time']) ? $request['start_time'] : '';
        $request['end_time'] = isset($request['end_time']) ? $request['end_time'] : '';
        $request['apply_item'] = isset($request['apply_item']) ? $request['apply_item'] : '';
        $request['team_count'] = isset($request['team_count']) ? $request['team_count'] : '';
        $request['score_system'] = isset($request['score_system']) ? $request['score_system'] : '';
        $request['game_system'] = isset($request['game_system']) ? $request['game_system'] : '';
        $request['cover_img'] = isset($request['cover_img']) ? $request['cover_img'] : '';
        $request['postion'] = isset($request['postion']) ? $request['postion'] : '';
        $request['introduction'] = isset($request['introduction']) ? $request['introduction'] : '';
        $request['rule'] = isset($request['rule']) ? $request['rule'] : '';
        $request['reward'] = isset($request['reward']) ? $request['reward'] : '';
        $request['points'] = isset($request['points']) ? $request['points'] : '';
        $request['link_man'] = isset($request['link_man']) ? $request['link_man'] : '';
        $request['link_mail'] = isset($request['link_mail']) ? $request['link_mail'] : '';
        $request['link_phone'] = isset($request['link_phone']) ? $request['link_phone'] : '';
        $request['link_qq'] = isset($request['link_qq']) ? $request['link_qq'] : '';
        $request['team_count'] = isset($request['team_count']) ? $request['team_count'] : '';
        $request['item_id'] = isset($request['item_id']) ? $request['item_id'] : '';
        $request['province'] = isset($request['province']) ? $request['province'] : '';
        $request['city'] = isset($request['city']) ? $request['city'] : '';
        $request['apply_type'] = isset($request['apply_type']) ? $request['apply_type'] : '';
        if (!$request['title']) {
            $out['code'] = 1;
            $out['msg'] = '标题不能为空';
            return $out;
        }

        if (!$request['start_time']) {
            $out['code'] = 4;
            $out['msg'] = '开始时间不能为空';
            return $out;
        }
        if (!$request['end_time']) {
            $out['code'] = 5;
            $out['msg'] = '截止时间不能为空';
            return $out;
        }
        if (!$request['apply_start_time']) {
            $out['code'] = 6;
            $out['msg'] = '申请开始时间不能为空';
            return $out;
        }
        if (!$request['apply_end_time']) {
            $out['code'] = 7;
            $out['msg'] = '申请结束时间不能为空';
            return $out;
        }
        if (!$request['position']) {
            $out['code'] = 7;
            $out['msg'] = '地点不能为空';
            return $out;
        }
        if (!$request['game_system']) {
            $out['code'] = 7;
            $out['msg'] = '赛制不能为空';
            return $out;
        }
        if ($request['start_time'] > $request['end_time']) {
            $out['code'] = 9;
            $out['msg'] = '开始时间不能大于截止时间';
            return $out;
        }
        if ($request['apply_start_time'] > $request['apply_end_time']) {
            $out['code'] = 10;
            $out['msg'] = '申请开始时间不能大于申请截止时间';
            return $out;
        }
        if ($request['start_time'] < $request['apply_end_time']) {
            $out['code'] = 10;
            $out['msg'] = '开始时间不能小于申请截止时间';
            return $out;
        }

        if (!in_array($request['score_system'], [0, 11, 15, 21])) {
            $out['code'] = 12;
            $out['msg'] = '比赛分制不能为空';
            return $out;
        }

        $ormActivity = new OrmActivity();
        if ($request['cover_img']) {
            $ormActivity->cover_img = $request['cover_img'];
        }
        $activity_count = DB::table('activity')
            ->where('title', $request['title'])
            ->count();
        if ($activity_count > 0) {
            $out['code'] = 14;
            $out['msg'] = '活动名已存在';
            return $out;
        }
        $activity_specail_config = DB::table('activity_specail_config')
            ->where('type', $request['game_system'])
            ->where('turn', 1)
            ->first();
        if (!$activity_specail_config) {
            $out['code'] = 14;
            $out['msg'] = '赛制不存在';
            return $out;
        }
        $ormActivity->title = $request['title'];
        $ormActivity->score_system = $request['score_system'];
        $ormActivity->start_time = $request['start_time'];
        $ormActivity->apply_start_time = $request['apply_start_time'];
        $ormActivity->apply_end_time = $request['apply_end_time'];
        $ormActivity->end_time = $request['end_time'];

        if ($request['apply_type']) {
            $ormActivity->apply_type = $request['apply_type'];
        }
        if ($request['cost']) {
            $ormActivity->cost = $request['cost'];
        }

        if ($request['postion']) {
            $ormActivity->postion = $request['postion'];
        }
        if ($request['introduction']) {
            $ormActivity->introduction = $request['introduction'];
        }

        if ($request['rule']) {
            $ormActivity->rule = $request['rule'];
        }

        if ($request['reward']) {
            $ormActivity->reward = $request['reward'];
        }

        if ($request['points']) {
            $ormActivity->points = $request['points'];
        }

        if ($request['link_man']) {
            $ormActivity->link_man = $request['link_man'];
        }

        if ($request['link_mail']) {
            $ormActivity->link_mail = $request['link_mail'];
        }

        if ($request['link_phone']) {
            $ormActivity->link_phone = $request['link_phone'];
        }

        if ($request['link_qq']) {
            $ormActivity->link_qq = $request['link_qq'];
        }
        if ($request['team_count']) {
            $ormActivity->team_count = $request['team_count'];
        }
        if ($request['item_id']) {
            $ormActivity->item_id = $request['item_id'];
        }
        if ($request['province'] && $request['province'] != '请选择') {
            $ormActivity->province = $request['province'];
        }
        if ($request['city'] && $request['city'] != '请选择') {
            $ormActivity->city = $request['city'];
        }


			
        if (!isset($club->status)){
		    $out['code'] = 2;
            $out['msg'] = '俱乐部审核未通过，不能发布活动';
            return $out;	
		}
			if($club->status != 1) {
            $out['code'] = 2;
            $out['msg'] = '俱乐部审核未通过，不能发布活动';
            return $out;
        }

        $ormActivity->club_id = $club->id;
        $ormActivity->mem_id = $user->id;
        $ormActivity->specail_config = $activity_specail_config->id;
        $ormActivity->apply_type = $activity_specail_config->apply_type;
        //开启事务
        DB::beginTransaction();
        try {
            $ormActivity->save();
            $inser_d = $ormActivity->getAttributes();
            //根据配置生成
            //activity_turn 1
            $lun = [];
            $lun['activity_id'] = $inser_d['id'];
            $lun['turn'] = 1;
            $lun['game_system'] = $activity_specail_config->game_system;
            DB::table('activity_turn')
                ->insert($lun);
            //
            $activity_specail_config_category = DB::table('activity_specail_config_category')
                ->where('activity_specail_config_id', $activity_specail_config->id)
                ->get();
            $activity_categorys = [];
            foreach ($activity_specail_config_category as $row) {
                for ($i = 0; $i < $row->apply_num; $i++) {
                    $activity_category = [];
                    $activity_category['activity_id'] = $inser_d['id'];
                    $activity_category['apply_item'] = $row->apply_item;
                    $activity_categorys[] = $activity_category;
                }

            }
            DB::table('activity_category')
                ->insert($activity_categorys);
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
}