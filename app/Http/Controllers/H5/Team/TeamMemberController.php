<?php

namespace App\Http\Controllers\H5\Team;

use App\Http\Controllers\H5Controller;
use App\Models\TeamModel;
use App\Orms\Team as OrmTeam;
use App\Orms\TeamMember as OrmTeamMember;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;
use Redirect;
use App\Models\TeamMemberModel;
class TeamMemberController extends H5Controller
{
	public function create(Request $request)
	{
		//
		$detail=[];
		if($request->input('id'))
		{
			$detail=DB::table('user_team_member')
			->where('id',$request->input('id'))
			->first();
		}
		Template::assign('detail',$detail);

		Template::render('h5/member/person/create');
	}
	
	public function import(Request $request)
	{
		$import=$_FILES['import'];
		
		if($import['error'] === 0){
			$file=$import['tmp_name'];
			require __DIR__.'/Excel/reader.php';
			$data = new Excel\Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8');
			$data->read($file);
			$valid = true;
			if($data->sheets[0]['numCols'] != 4){
				echo '模板数据错误,请重新提交...';
			}else{
				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
				
					$name = isset($data->sheets[0]['cells'][$i][1])?$data->sheets[0]['cells'][$i][1]:'';
					$phone = isset($data->sheets[0]['cells'][$i][2])?$data->sheets[0]['cells'][$i][2]:'';
					$id = isset($data->sheets[0]['cells'][$i][3])?$data->sheets[0]['cells'][$i][3]:'';
					$sex = isset($data->sheets[0]['cells'][$i][4])?$data->sheets[0]['cells'][$i][4]:1;
					
					if($name == '' || $phone == ''){
						echo '导入数据有误,(名称和手机号不能为空),请重新提交...';
						$valid = false;
						break;
					}
					if($id && !preg_match('/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/', $id)){
						echo '导入数据有误,(身份证号有误),请重新提交...';
						$valid = false;
						break;
					}
					if(!in_array($sex,array(1,2))){
						echo '导入数据有误,(性别请用数字表示:1代表男,2代表女),请重新提交...';
						$valid = false;
						break;
					}
				}
			
				if($valid){
					for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
						$name = $data->sheets[0]['cells'][$i][1];
						$phone = $data->sheets[0]['cells'][$i][2];
						$id = isset($data->sheets[0]['cells'][$i][3])?$data->sheets[0]['cells'][$i][3]:'';
						$sex = isset($data->sheets[0]['cells'][$i][4])?$data->sheets[0]['cells'][$i][4]:1;
						
						$insert['name'] = $name;
						$insert['phone_number'] = $phone;
						$insert['identity_card'] = $id;
						$insert['sex'] = $sex;
						$insert['created_at'] = date('Y-m-d H:i:s');
						$insert['updated_at'] = date('Y-m-d H:i:s');
						
						$user = Auth::user();
						$insert['mem_id'] = $user->id;

						$newID = DB::table('user_team_member')
						->insertGetId($insert);

						$cnt = DB::table('user_team_member')
							->where('name',$insert['name'])
							->count();

						$up['name'] = $insert['name'].'-'.$newID;

						if ($cnt > 1) {
							DB::table('user_team_member')
								->where('id',$newID)
								->update($up);
						}
					}
					echo '导入成功,正在跳转...';
					
				}
			}
		}else{
		echo '上传文件错误,请重新提交...';
		}
		echo '<script>setTimeout(\'location.href="/h5/member/person"\',1000);</script>';
		//return Redirect::to('/h5/member/person');
	}
	
	//创建队员
	public function store(Request $request)
	{
		$out['code'] = 0;
		$out['msg'] = 'ok';
		$out['data'] = array();

		$out=TeamMemberModel::save($request);
		return $out;
	}

	public function destroy(Request $request)
	{
		$id= $request->input('id');
		DB::table('user_team_member')->delete($id);
		DB::table('club_member')
			->where('user_team_member_id',$id)
			->delete();
		return Redirect::to('/h5/member/person');
	}
}