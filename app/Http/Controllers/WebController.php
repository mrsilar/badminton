<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Template;
class WebController extends Controller
{    
        public function __construct()
        {
       	Template::setViewDirectory(base_path().DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views');
        Template::setCompiledDirectory(base_path() . DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'views');
        Template::setTemplateEnabled(true);
        Template::setTemplateDebugEnabled(true);
        Template::setFileSuffix('html');
        }
}