<?php

namespace App\Http\Controllers\H5\Article;

use App\Http\Controllers\H5Controller;
use App\Orms\Club as OrmClub;
use DB;
use Illuminate\Http\Request;
use Validator;
use Template;
class ArticleController extends H5Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNum)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $out['data']['page'] = [];
        //
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize = 2;
        $offset = ($pageNum - 1) * $pageSize;

        $count = DB::table('article')
            ->count();

        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $out['data']['page'] = $page;

        $res = DB::table('article')
            ->skip($offset) //offset  10
            ->take($pageSize) //limit 5
            ->get();
        if ($res) {
            $out['data']['list'] = $res;
        }

       	Template::assign('list',$res);
        Template::assign('page',$page);
        Template::render('h5/article/list'); 
		
		 //return $out;
	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        // 验证
        /*        $v = $this->validator($request);
        if ($v->fails()) {
        $out['code'] = 1;
        $out['msg'] = $v->errors();
        return $out;
        }*/
        $req = $request->all();
        if (isset($req['title'])) {
            $data['title'] = $req['title'];
        }

        if (isset($req['desc'])) {
            $data['desc'] = $req['desc'];
        }

        if (isset($req['cover_img'])) {
            $data['cover_img'] = $req['cover_img'];
        }

        if (isset($req['content'])) {
            $data['content'] = $req['content'];
        }

        DB::table('article')
            ->insert($data);
        return $out;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $res = OrmClub::where('id', $id)
            ->first();
        if ($res) {
            $out['data'] = $res;
        }
	   Template::assign('detail',$res);
        Template::render('h5/article/detail'); 
       // return $out;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        // 验证
        /*        $v = $this->validator($request);
        if ($v->fails()) {
        $out['code'] = 1;
        $out['msg'] = $v->errors();
        return $out;
        }*/
        $req = $request->all();
        if (isset($req['title'])) {
            $data['title'] = $req['title'];
        }

        if (isset($req['desc'])) {
            $data['desc'] = $req['desc'];
        }

        if (isset($req['cover_img'])) {
            $data['cover_img'] = $req['cover_img'];
        }

        if (isset($req['content'])) {
            $data['content'] = $req['content'];
        }

        DB::table('article')
            ->where('id', $req['id'])
            ->update($data);
        return $out;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        DB::table('article')
            ->where('id', $id)
            ->delete();
        return $out;
    }
}
