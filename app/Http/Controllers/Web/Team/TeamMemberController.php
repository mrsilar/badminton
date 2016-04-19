<?php

namespace App\Http\Controllers\Web\Team;

use App\Http\Controllers\WebController;
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
class TeamMemberController extends WebController
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
		//
		$id= $request->input('id');
		DB::table('user_team_member')->delete($id);
		return Redirect::to('/h5/member/person');
	}
}