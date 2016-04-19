<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\AdminController;
use DB;
use Template;
use Illuminate\Http\Request;
use Auth;

class IndexController extends AdminController
{
    //首页
    public function index(Request $request)
    {
        return view('admin/home/index');
    }



}
