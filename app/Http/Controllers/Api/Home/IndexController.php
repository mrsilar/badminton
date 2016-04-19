<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\ApiController;
use DB;
use Template;
class IndexController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function img()
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']= array();
        //
        $img = DB::table('img')
            ->where('type', 22) //轮播
            ->get();
        $out['data']=$img;
        return $out;
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']= array();
        //
      $out['data']['time']=rand(2000,20000000);
      $out['data']['register']=rand(2000,20000000);
      $out['data']['activity']=rand(2000,20000000);
        return $out;
    }

    public function all()
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $res=[
            [
             'name'=>'我的活动',
                'url'=>'#'
            ],


        ];

        $out['data']['list'] = $res;
        return $out;
    }
}
