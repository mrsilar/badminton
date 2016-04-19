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

class ActivityRankModel extends BaseModel
{


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 队伍跟队伍的输赢
     * @param array $req
     */
    public static function team_team($req = [])
    {
        //过滤
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();

        if (!isset($req['team_match_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'team_match_id 为空！';
            return $out;
        }
        //比较 先比胜次 再比积分
        //胜次
        $out = self::team_team_win_count($req);
        if ($out['data'] != 0) {
            return $out;
        }
        //积分
        $out = self::team_team_win_all_count($req);
        if ($out['data'] != 0) {
            return $out;
        }
        return $out;

    }

    /**
     * 胜次
     * @param array $req
     * @return mixed
     */
    public static function team_team_win_count($req = [], $all = false)
    {
        //过滤
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $team_member_match = DB::table('team_member_match')
            ->where('team_match_id', $req['team_match_id'])
            ->get();
        if (!$team_member_match) {
            $out['code'] = 2;
            $out['msg'] = 'team_member_match 不存在！';
            return $out;
        }
        //胜次
        $team_a_win_count = 0;
        $team_b_win_count = 0;
        foreach ($team_member_match as $row) {
            if ($row->win_a_count > $row->win_b_count) {
                $team_a_win_count++;
            } else {
                $team_b_win_count++;
            }
        }

        if ($all) {
            $out['data'] = [$team_a_win_count, $team_b_win_count];
        } else {
            $out['data'] = $team_a_win_count - $team_b_win_count;
        }
        return $out;


    }

    /**
     * 省的积分
     * @param array $req
     * @return mixed
     */
    public static function team_team_win_all_count($req = [], $all = false)
    {
        //过滤
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $team_member_match = DB::table('team_member_match')
            ->where('team_match_id', $req['team_match_id'])
            ->get();
        if (!$team_member_match) {
            $out['code'] = 2;
            $out['msg'] = 'team_member_match 不存在！';
            return $out;
        }
        //积分
        $team_a_win_all_count = 0;
        $team_b_win_all_count = 0;
        foreach ($team_member_match as $row) {
            $team_a_win_all_count += $row->win_a_count;
            $team_b_win_all_count += $row->win_b_count;
        }

        if ($all) {
            $out['data'] = [$team_a_win_all_count, $team_b_win_all_count];
        } else {
            $out['data'] = $team_a_win_all_count - $team_b_win_all_count;
        }

        return $out;

    }

    /**
     * 第一轮外循环
     * @param array $req
     */
    public static function wai($req = [])
    {
        //过滤
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if (!isset($req['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 为空！';
            return $out;
        }
        $team_match = DB::table('team_match')
            ->where('activity_turn_id', $req['activity_turn_id'])
            ->get();
        //先看胜次，再看比分
        $team_win_count = [];
        foreach ($team_match as $row) {
            if (!isset($team_win_count[$row->team_a])) {
                $team_win_count[$row->team_a] = 0;
            }
            if (!isset($team_win_count[$row->team_b])) {
                $team_win_count[$row->team_b] = 0;
            }
            $win = $row->win_a - $row->win_b;
            if ($win > 0) {
                $team_win_count[$row->team_a]++;
            } elseif ($win < 0) {
                $team_win_count[$row->team_b]++;
            } else {
                $win_tmp = self::team_team_win_all_count(['team_match_id' => $row->id]);
                if ($win_tmp['code'] != 0) {
                    return $win_tmp;
                }
                if ($win_tmp['data'] > 0) {
                    $team_win_count[$row->team_a]++;
                } elseif ($win_tmp['data'] < 0) {
                    $team_win_count[$row->team_b]++;
                }
            }
        }
        //计算排名
        $team_rank_sort = simple_rank($team_win_count);
        //开启事务
        DB::beginTransaction();
        try {
            foreach ($team_rank_sort as $key => $row) {
                $up = [];
                $up['rank'] = $row < 1 ? 10000 : $row;
                $up['win_count'] = $team_win_count[$key];
                DB::table('team_group')
                    ->where('team_id', $key)
                    ->update($up);
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

    //第一轮内循环
    public static function nei($req = [])
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //过滤

        if (!isset($req['activity_turn_id'])) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id 为空！';
            return $out;
        }
        $team_group = DB::table('team_group')
            ->where('activity_turn_id', $req['activity_turn_id'])
            ->get();
        $team_group_tmp = tran_key($team_group, 'group_num');

        foreach ($team_group_tmp as $key => $rows) {
            //对每一组排名
            //先看胜次，再看比分
            $team_match = DB::table('team_match')
                ->where('team_group_num', $key)
                ->where('activity_turn_id', $req['activity_turn_id'])
                ->get();

            $team_win_count = [];
            foreach ($team_match as $row) {
                if (!isset($team_win_count[$row->team_a])) {
                    $team_win_count[$row->team_a] = 0;
                }
                if (!isset($team_win_count[$row->team_b])) {
                    $team_win_count[$row->team_b] = 0;
                }
                $win = $row->win_a - $row->win_b;
                if ($win > 0) {
                    $team_win_count[$row->team_a]++;
                } elseif ($win < 0) {
                    $team_win_count[$row->team_b]++;
                } else {
                    $win_tmp = self::team_team_win_all_count(['team_match_id' => $row->id]);
                    if ($win_tmp['code'] != 0) {
                        return $win_tmp;
                    }

                    if ($win_tmp['data'] > 0) {
                        $team_win_count[$row->team_a]++;
                    } elseif ($win_tmp['data'] < 0) {
                        $team_win_count[$row->team_b]++;
                    }
                }
            }
            //计算排名
            if (array_sum($team_win_count) < 1) {
                return $out;
            }


            $team_rank_sort = simple_rank($team_win_count);
            //开启事务
            DB::beginTransaction();
            try {
                foreach ($team_rank_sort as $key => $row) {
                    $up = [];
                    $up['rank'] = $row < 1 ? 10000 : $row;
                    $up['win_count'] = $team_win_count[$key];
                    DB::table('team_group')
                        ->where('team_id', $key)
                        ->update($up);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $out['code'] = $e->getCode();
                $out['msg'] = $e->getMessage();
                return $out;
            }
        }
        return $out;
    }
    //先比较胜次，两个队伍胜次相同，比胜负，
    //三个队伍胜次相同，比小分，然后如果有两个相同的比较胜负
    public static function rank_four($activity_turn_id)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        if ($activity_turn_id < 1) {
            $out['code'] = 1;
            $out['msg'] = 'activity_turn_id不存在';
            return $out;
        }


        $team_match = DB::table('team_match')
            ->where('activity_turn_id', $activity_turn_id)
            ->get();

        if (!$team_match) {
            $out['code'] = 2;
            $out['msg'] = 'team_match不存在';
            return $out;
        }
        $win = 0;
        foreach ($team_match as $row) {
            $win += $row->win_a;
            $win += $row->win_b;
        }
        if ($win != 96) {
            $out['code'] = 3;
            $out['msg'] = '打分未打完，不能排名';
            return $out;
        }


        $team_group = DB::table('team_group')
            ->where('activity_turn_id', $activity_turn_id)
            ->get();

        $rank_tmp = tran_key($team_group, 'win_count');
        krsort($rank_tmp);
        $new_tmp = [];
        foreach ($rank_tmp as $key => $row) {
            if ($key == 0) {
                $new_tmp[0] = $row;
            } else {
                $new_tmp[$key] = $row;
            }
        }
     

        $rank = [];
        foreach ($new_tmp as $key => $row) {
            if (count($row) == 3) {
                $rank_tmp_mid = tran_key($row, 'win_count_all');
                ksort($rank_tmp_mid);
                foreach ($rank_tmp_mid as $k => $r) {
                    if (count($r) == 3) { //三个完全相等
                        $rank[$key] = [$r[0]->team_id, $r[1]->team_id, $r[2]->team_id];
                        shuffle($rank[$key]);
                    } elseif (count($r) == 2) {//两个完全相等
                        $r3_2 = self::rank_2($r);
                        foreach ($r3_2 as $row_ii) {
                            $rank[$key][] = $row_ii;
                        }
                    } else {//三个不等
                        $rank[$key][] = $r[0]->team_id;
                    }
                }
            } elseif (count($row) == 2) {
                $rank[$key] = self::rank_2($row);
            } else {
                $rank[$key] = [$row[0]->team_id];
            }

        }


        $last = [];
        foreach ($rank as $row) {
            foreach ($row as $r) {
                $last[] = $r;
            }
        }

        if (count($last) < 4) {
            $out['code'] = 4;
            $out['msg'] = '排名失败,请人工打分！';
            return $out;
        }
        $out['data'] = $last;
        return $out;
    }

    //两个队伍比较胜负
    public static function rank_2($row)
    {
        //比较胜负
        $rank = [];
        $activity_turn_id = 0;
        foreach ($row as $v) {
            $activity_turn_id = $v->activity_turn_id;
            $team_ids[] = $v->team_id;
        }
        $team_match = DB::table('team_match')
            ->where('activity_turn_id', $activity_turn_id)
            ->whereIn('team_a', $team_ids)
            ->whereIn('team_b', $team_ids)
            ->first();
        if ($team_match->win_a == $team_match->win_b) {
            $rank[] = [$team_match->team_a, $team_match->team_b];
            shuffle($rank);//随机
        } else {
            if ($team_match->win_a > $team_match->win_b) {
                $rank = [$team_match->team_a, $team_match->team_b];
            } else {
                $rank = [$team_match->team_b, $team_match->team_a];
            }
        }
        return $rank;
    }
}