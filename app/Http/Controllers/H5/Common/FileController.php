<?php

namespace App\Http\Controllers\H5\Common;

use App\Http\Controllers\H5Controller;
use DB;
use Template;
use Illuminate\Http\Request;
use Auth;
class FileController extends H5Controller
{
	public function upload(Request $request)
	{

        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] =[];
		if (!$request->hasFile('file'))
		{
			$out['code'] = 1;
			$out['msg'] = '非法的文件';
			return $out;
		}
		if (!$request->file('file')->isValid())
		{
		    $out['code'] = 1;
        	$out['msg'] = '非法的文件';
        	return $out;
		}
		$date=date('Y-m-d',time());
		$date=explode('-', $date);
		$outpath=DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR.$date[0].DIRECTORY_SEPARATOR.$date[1].DIRECTORY_SEPARATOR.$date[2];
		$destinationPath=base_path().DIRECTORY_SEPARATOR.'public'.$outpath;


		$fileName=time().'.'.$request->file('file')->getClientOriginalExtension();
		$file= $request->file('file')->move($destinationPath, $fileName);
		$out['data'] =['path'=>$outpath.DIRECTORY_SEPARATOR.$fileName];
		return $out;	
	}
}