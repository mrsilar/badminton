<?php
namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\ApiController;
use DB;
use Illuminate\Http\Request;
use Validator;
use Template;
class TestController extends ApiController
{    
        public function __construct()
        {
                parent::__construct();
        Template::setViewDirectory(base_path().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views');
        Template::setCompiledDirectory(base_path() . DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'views');
        Template::setTemplateEnabled(true);
        Template::setTemplateDebugEnabled(true);
        Template::setFileSuffix('blade.html');
        }

	public function test(){

        Template::setViewDirectory(base_path().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views');
        Template::setCompiledDirectory(base_path() . DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'views');
        Template::setTemplateEnabled(true);
        Template::setTemplateDebugEnabled(true);
        Template::setFileSuffix('blade.html');

        $array=[1,2,3,4];
        Template::assign('data','test');
        Template::assign('array',$array);
        Template::render('test');
	}


}