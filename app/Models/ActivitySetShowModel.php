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
use App\Models\ActivityModel;

class ActivitySetShowModel extends BaseModel
{


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
        if (!empty($team_member_match->score_count) && $team_member_match->score_count > 2) {
            $out['code'] = 1;
            $out['msg'] = '已打分三次';
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

        $insert_data = [];
        $insert_data['win_a_count'] = $request['scoreA'];
        $insert_data['win_b_count'] = $request['scoreB'];
        $insert_data['score_count'] = $team_member_match->score_count + 1;
        $insert_result = DB::table('team_member_match')
            ->where('id', $request['memberMatchId'])
            ->update($insert_data);
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

    //group_match
    public static function group_match($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 不存在';
            return $out;
        }
        //获取name
        $group_math = DB::table('group_match')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->get();
        if (!$group_math) {
            $out['code'] = 2;
            $out['msg'] = 'group_match 不存在';
            return $out;
        }
        $out['data'] = $group_math;
        return $out;
    }

    public static function team_match($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 不存在';
            return $out;
        }
        //获取name
        $team_math = DB::table('team_match')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->get();
        if (!$team_math) {
            $out['code'] = 2;
            $out['msg'] = 'team_match 不存在';
            return $out;
        }


        $team_math_a_ids = class_column($team_math, 'team_a');
        $team_math_b_ids = class_column($team_math, 'team_b');
        $team_math_ids = array_merge($team_math_a_ids, $team_math_b_ids);
        $teams = DB::table('team')
            ->whereIn('id', $team_math_ids)
            ->get();
        $new_teams = [];
        foreach ($teams as $key => $row) {
            $new_teams[$row->id] = $row;
        }

        foreach ($team_math as $key => &$row) {
            $row->team_a_name = $new_teams[$row->team_a]->name;
            $row->team_a_draw_id = $new_teams[$row->team_a]->draw_id;
            $row->team_b_name = $new_teams[$row->team_b]->name;
            $row->team_b_draw_id = $new_teams[$row->team_b]->draw_id;
			
			$row->team_a_mem_id = $new_teams[$row->team_a]->mem_id;
			$row->team_b_mem_id = $new_teams[$row->team_b]->mem_id;
        }
        unset($row);

        $out['data'] = $team_math;
        return $out;
    }

    public static function team_match_by_one_id($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['team_match_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'team_match_id 不存在';
            return $out;
        }
        //获取name
        $team_math = DB::table('team_match')
            ->where('id', $request['team_match_id'])
            ->first();
        if (!$team_math) {
            $out['code'] = 2;
            $out['msg'] = 'team_match 不存在';
            return $out;
        }

        //获取队伍
        $teams = DB::table('team')
            ->whereIn('id', [$team_math->team_a, $team_math->team_b])
            ->get();
        $new_teams = tran_key($teams, 'id', true);
        //转化
        $team_math->team_a_name = $new_teams[$team_math->team_a]->name;
        $team_math->team_a_draw_id = $new_teams[$team_math->team_a]->draw_id;
        $team_math->team_b_name = $new_teams[$team_math->team_b]->name;
        $team_math->team_b_draw_id = $new_teams[$team_math->team_b]->draw_id;

        $out['data'] = $team_math;
        return $out;
    }

    public static function team_group($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();

        if (!isset($request['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 不存在';
            return $out;
        }
        $team_group = DB::table('team_group')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->orderBy('rank', 'ASC')
            ->get();
        if (!$team_group) {
            $out['code'] = 2;
            $out['msg'] = 'team_group 不存在';
            return $out;
        }
        $team_math_b_ids = class_column($team_group, 'team_id');
        $teams = DB::table('team')
            ->whereIn('id', $team_math_b_ids)
            ->get();
        $new_teams = [];
        foreach ($teams as $key => $row) {
            $new_teams[$row->id] = $row;
        }
        foreach ($team_group as $row) {
            $row->team_name = $new_teams[$row->team_id]->name;
            $row->team_draw_id = $new_teams[$row->team_id]->draw_id;
        }
        unset($row);
        $out['data'] = $team_group;
        return $out;
    }

    public static function team_member_match($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['team_match_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'team_match_id 不存在';
            return $out;
        }
        $team_match_id = $request['team_match_id'];
        //基础信息
        $team_match = DB::table('team_match')
            ->where('id', $team_match_id)
            ->first();
        if (!$team_match) {
            $out['code'] = 2;
            $out['msg'] = 'team_match 不存在';
            return $out;
        }
        //项目
        $team_member_match = DB::table('team_member_match')
            ->where('team_match_id', $team_match_id)
            ->get();
        $team_member_match_ids = class_column($team_member_match, 'id');
        //项目对应的队员
        $team_member_match_category_member = DB::table('team_member_match_category_member')
            ->whereIn('team_member_match_id', $team_member_match_ids)
            ->get();

        $user_team_member_ids = [];
        foreach ($team_member_match_category_member as $row) {
            if (!in_array($row->user_team_member_id_a, $user_team_member_ids)) {
                $user_team_member_ids[] = $row->user_team_member_id_a;
            }
            if (!in_array($row->user_team_member_id_b, $user_team_member_ids)) {
                $user_team_member_ids[] = $row->user_team_member_id_b;
            }

        }

        $user_team_member = DB::table('user_team_member')
            ->whereIn('id', $user_team_member_ids)
            ->get();
        foreach ($user_team_member as &$row) {
            $row->sex = $row->sex == 1 ? '男' : '女';
        }
        unset($row);
        //转化
        $user_team_member_tmp = tran_key($user_team_member, 'id', true);

        $activity_category_member_tmp = [];

        foreach ($team_member_match_category_member as &$row) {
            $row->user_a = $user_team_member_tmp[$row->user_team_member_id_a];
            $row->user_b = $user_team_member_tmp[$row->user_team_member_id_b];
            $row->team_member_match_category_member_id = $row->id;
        }
        unset($row);

        $team_member_match_category_member = tran_key($team_member_match_category_member, 'team_member_match_id');

        //last
        $team_member_match = DB::table('team_member_match')
            ->where('team_match_id', $team_match_id)
            ->get();


        foreach ($team_member_match as &$row) {
            $a=[];
            $b=[];
            foreach($team_member_match_category_member[$row->id] as $val){
                $a_tmp=new \stdClass();
                $b_tmp=new \stdClass();

                $a_tmp->team_member_match_category_member_id=$val->team_member_match_category_member_id;
                $a_tmp->name=$val->user_a->name;
                $a_tmp->sex=$val->user_a->sex;
                $a_tmp->id=$val->user_a->id;
                $a[]=$a_tmp;

                $b_tmp->team_member_match_category_member_id=$val->team_member_match_category_member_id;
                $b_tmp->name=$val->user_b->name;
                $b_tmp->sex=$val->user_b->sex;
                $b_tmp->id=$val->user_b->id;
                $b[]=$b_tmp;
            }
            unset($val);
            $row->category_a_list = $a;
            $row->category_b_list = $b;
        }
        unset($row);

        $out['data'] = $team_member_match;

        return $out;
    }


    public static function team_item($request, $activity_id)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!$request) {
            $out['code'] = 1;
            $out['msg'] = 'team_ids 不存在';
            return $out;
        }
        if ($activity_id < 1) {
            $out['code'] = 1;
            $out['msg'] = 'activity_id 不存在';
            return $out;
        }
        $activity_category = DB::table('activity_category')
            ->where('activity_id', $activity_id)
            ->get();
        $activity_category_id = class_column($activity_category, 'id');
        //项目对应的队员
        $activity_category_member = DB::table('activity_category_member')
            ->whereIn('team_id', $request)
            ->whereIn('activity_category_id', $activity_category_id)
            ->get();

        $user_team_member_ids = class_column($activity_category_member, 'user_team_member_id');
        $user_team_member = DB::table('user_team_member')
            ->whereIn('id', $user_team_member_ids)
            ->get();
        //转化
        $user_team_member_tmp = tran_key($user_team_member, 'id', true);
        foreach ($activity_category_member as $val) {
            $val->user_team_member_name = $user_team_member_tmp[$val->user_team_member_id]->name;
            $val->user_team_member_sex = $user_team_member_tmp[$val->user_team_member_id]->sex == 1 ? '男' : '女';
        }
        unset($val);

        $activity_category_member_tmp = [];
        foreach ($activity_category_member as $row) {
            $activity_category_member_tmp[$row->team_id][$row->activity_category_id][] = $row;
        }
        $out['data'] = $activity_category_member_tmp;
        return $out;
    }

    //计算外循环排名
    public static function rank_group($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 不存在';
            return $out;
        }
        $team_group = DB::table('team_group')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->get();
        //计算胜次
        $team_member_match = DB::table('team_member_match')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->get();
        foreach ($team_member_match as $row) {
            foreach ($team_group as $val) {

            }
        }
        //计算积分
        //看两个人的结果
    }

    //计算tao排名
    public static function rank_tao($request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($request['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 不存在';
            return $out;
        }
        $can_rank = ActivityModel::next_exit($request);

        if (!$can_rank) {
            $out['code'] = 1;
            $out['msg'] = 'ranked!';
            return $out;
        }
        $team_group = DB::table('team_group')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->get();

        $team_match = DB::table('team_match')
            ->where('activity_turn_id', $request['activity_turn_id'])
            ->get();
        $team_match_tmp = [];
        foreach ($team_match as $key => $value) {
            $team_match_tmp[$value->team_a] = $value->win_a - $value->win_b;
            $team_match_tmp[$value->team_b] = $value->win_b - $value->win_a;
        }

        foreach ($team_group as $key => $value) {
            $up = [];
            if (!isset($team_match_tmp[$value->team_id])) {
                $up['rank'] = 1;
            } else {
                $up['rank'] = $team_match_tmp[$value->team_id] > 0 ? 1 : 2;
            }
            DB::table('team_group')
                ->where('id', $value->id)
                ->update($up);
        }

        return $out;
    }
}