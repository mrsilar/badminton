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
class ClubModel extends BaseModel
{

    /**
     * 列表
     * @param $request
     * @return array
     */
    public static function lists($pageNum)
    {

        $out['list'] = array();
        $out['page'] = [];

        //######分页start
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize = 5;
        $offset = ($pageNum - 1) * $pageSize;
        $count = DB::table('club')
            ->count();
        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $prev=($pageNum-1)<1?1:($pageNum-1);
        $next=($pageNum+1)> $page['totalPage']?$page['totalPage']:$pageNum+1;
        $page['prevUrl'] = "/h5/club/list/{$prev}";
        $page['nextUrl'] = "/h5/club/list/{$next}";
        $page['url'] = "/h5/club/list/";
        //######分页end
        $out['page']=$page;

        $res = DB::table('club')
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();

        for($i=0; $i<sizeof($res);$i++){
            $res[$i]->activity_count = DB::table('activity')
                ->where('club_id', $res[$i]->id)
                ->count();
        }



        if ($res) {
            $out['list'] = $res;
        }
        return $out;
    }
}
