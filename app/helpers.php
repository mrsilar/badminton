<?php
/**
 * Created by PhpStorm.
 * User: byz
 * Date: 2015/11/15
 * Time: 15:17
 */
//activity
if (!function_exists('test_me')) {
	function test_me()
	{
		echo 'test_me';
	}
}


//转化活动
if (!function_exists('get_activity_status')) {
	function get_activity_status($res)
	{

		$res->status = '预告';
		if (time() < strtotime($res->apply_start_time)) {
			$res->status = '预告';
		} elseif (time() < strtotime($res->apply_end_time)) {
			$res->status = '报名中';
		} elseif (time() < strtotime($res->start_time)) {
			$res->status = '抽签';
		} elseif (time() < strtotime($res->end_time)) {
			$res->status = '比赛';
		} elseif (time() > strtotime($res->end_time)) {
			$res->status = '结束';
		}
		return $res->status;
	}
}

if (!function_exists('dump')) {
	function dump($data)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}

//计算人数
if (!function_exists('sum_activity_people_count')) {
	function sum_activity_people_count($apply_item, $apply_numbers)
	{
		$count = 0;
		//   男单 11，女单12，男双21，女双22，混双23  10单打  20  双打
		$apply_item_num = [
		11 => 1,
		12 => 1,
		21 => 2,
		22 => 2,
		23 => 2,
		10 => 1,
		20 => 2,
		];
		foreach ($apply_item as $key => $val) {
			$count += $apply_item_num[$val] * $apply_numbers[$key];
		}
		return 1;
	}
}
//转化项目类型
if (!function_exists('activity_item_tran')) {
	function activity_item_tran($apply_item)
	{
		//   男单 11，女单12，男双21，女双22，混双23  10单打  20  双打
		$apply_item_num = [
		11 => '男单',
		12 => '女单',
		21 => '男双',
		22 => '女双',
		23 => '混双',
		10 => '单打',
		20 => '双打',
		];
		if (!isset($apply_item_num[$apply_item]))
			return '';
		return $apply_item_num[$apply_item];
	}
}
//转化对象到数组

if (!function_exists('class_column')) {
	function class_column($obj, $str)
	{
		if (!$obj) {
			return [];
		}
		if (!$str) {
			return [];
		}
		$out = [];
		foreach ($obj as $key => $row) {
			if (!isset($row->$str)) {
				continue;
			}
			$out [] = $row->$str;
		}
		return $out;
	}
}

//分组函数
if (!function_exists('team_group')) {
	function team_group($team_count, $gruop_count)
	{
		//每组人数
		$out = 0;
		if ($team_count < 3) {
			return $out;
		}
		if ($gruop_count < 2) {
			return $gruop_count;
		}
		$team_count_yu = $team_count % 2;
		$team_count_2 = ($team_count_yu == 0) ? $team_count : ($team_count + 1);

		if ($team_count_2 % $gruop_count > 0) {
			return $out;
		}
		$out = $team_count_2 / $gruop_count;
		return $out;
	}
}
//可以分的组数
if (!function_exists('team_group_list')) {
	function team_group_list($team_count)
	{
		$out = [];
		if ($team_count < 3) {
			return $out;
		}
		$team_count_yu = $team_count % 2;
		$team_count_2 = ($team_count_yu == 0) ? $team_count : ($team_count + 1);
		for ($i = 1; $i <= $team_count_2; $i++) {

			if ($i == 1 || $i == $team_count_2) {
				continue;
			}


			if ($team_count_2 % $i == 0) {
				$out[] = $i;
			}
		}
		return $out;
	}
}
//日期到星期
if (!function_exists('date_week')) {
	function date_week($date, $timestamp = false)
	{
		//星期几转化
		$arr = [
		0 => '日',
		1 => '一',
		2 => '二',
		3 => '三',
		4 => '四',
		5 => '五',
		6 => '六',
		];
		if ($timestamp) {
			$x = $date;
		} else {
			$x = date('w', strtotime($date));
		}

		return $arr[$x];
	}

}
//手机号过滤
if (!function_exists('phone_filter')) {
	function phone_filter($phone_number)
	{
		return preg_match('/^1[3|4|5|7|8]\d{9}$/', $phone_number);
	}
}
//转化key
if (!function_exists('tran_key')) {
	function tran_key($data, $key = 'id', $one = false, $is_obj = true)
	{
		if (!$data) return $data;
		//数组
		if (!$is_obj) {
			$new_data = [];
			foreach ($data as $row) {
				if (!isset($row[$key])) {
					break;
				}
				if ($row[$key] === null || $row[$key] === '') {
					continue;
				}
				if ($one) {
					$new_data[$row[$key]] = $row;
				} else {
					$new_data[$row[$key]][] = $row;
				}

			}
			return $new_data;
		}
		//对象
		foreach ($data as $row) {
			if (!isset($row->$key)) {
				break;
			}
			if ($row->$key === null || $row->$key === '') {
				continue;
			}
			if ($one) {
				$new_data[$row->$key] = $row;
			} else {
				$new_data[$row->$key][] = $row;
			}

		}
		return $new_data;
	}
}
//获取项目对应的人数
if (!function_exists('get_people_num')) {
	function get_people_num($item)
	{
		$count = 0;
		//   男单 11，女单12，男双21，女双22，混双23  10单打  20  双打
		$apply_item_num = [
		11 => 1,
		12 => 1,
		21 => 2,
		22 => 2,
		23 => 2,
		10 => 1,
		20 => 2,
		];
		if (!array_key_exists($item, $apply_item_num)) {
			return $count;
		}
		return $apply_item_num[$item];
	}
}
//123 c3_2分法
if (!function_exists('c_3_2')) {
	function c_3_2($num = [])
	{

		$out = [];
		foreach ($num as $row1) {
			foreach ($num as $row2) {
				if ($row1 != $row2) {
					if (!in_set([$row1, $row2], $out)) {
						$out[] = [$row1, $row2];
					}
				}

			}
		}
		return $out;
	}
}
if (!function_exists('in_set')) {
	function in_set($in = [], $set = [])
	{
		$out = false;
		if (!$set) {
			return $out;
		}
		foreach ($set as $row) {

			if (!array_diff($in, $row)) {
				$out = true;
				break;
			}

		}
		return $out;
	}
}
if (!function_exists('simple_rank')) {
	function simple_rank($data)
	{
		if (!$data) {
			return $data;
		}
		$newdata = [];
		foreach ($data as $key => $value) {
			$newdata[$value][] = $key;
		}
		krsort($newdata);
		$i = 0;
		$rank = [];
		foreach ($newdata as $value) {
			$i++;
			foreach ($value as $val) {
				$rank[$val] = $i;
			}
		}
		return $rank;
	}
}
//逆时针排序
if(!function_exists('rsort_circle'))
{
	function rsort_circle($data=[]){
		$data_count=count($data);
		if($data_count<2)
		{
			return [];
		}
		if($data_count<3)
		{
			return [[$data]];
		}
		$icount=$data_count%2==0?$data_count:$data_count+1;
		$out=[];
		for ($i=$icount-1;$i>0;$i--)
		{
			$count_1=$icount-1;
			$ou=[];
			$ou[]=0;
			for ($j=0;$j<$icount-1;$j++)
			{
				$ij=$i+$j;
				$ou[]=$ij%$count_1==0?$ij:($ij%$count_1);
			}
			$out[]=$ou;
		}

		$duis=[];
		foreach ($out as $rows)
		{
			$dui=[];
			$d=[];
			foreach ($rows  as $row){
				if(count($d)<2){
					$d[]=$row;
				}else{
					$d=[];
					$d[]=$row;
				}
				if(count($d)==2)
				{
					$dui[]=$d;//
				}
			}
			$duis[]=$dui;
		}
		$newout=[];
		foreach ($duis  as $row)
		{
			$newouti=[];
			foreach ($row as &$val){
				if(isset($data[$val[0]])&&isset($data[$val[1]])){
					$newouti[]=[$data[$val[0]],$data[$val[1]]];
				}
			}
			$newout[]=$newouti;
		}
		return $newout;
	}

}
if(!function_exists('check_id')){
	 function check_id($str = '')
	{
		$test = new 		\App\Models\IdModel();
		return $test ->checkIdentity($str);
	

	//	return preg_match('/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/', $str);
	}
}