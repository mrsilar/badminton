<?php

/*
 |--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
Route::get('/', 'H5\Home\IndexController@index');
Route::get('/Web', 'H5\Home\IndexController@index');
Route::get('/web', 'Web\Home\IndexController@index');
Route::group(['namespace' => 'Api'], function()
{
	Route::get('member/all', 'Home\IndexController@all');
	// Authentication routes.....
	Route::post('auth/login', 'Auth\AuthController@postLogin');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	Route::post('auth/sendCode', 'Auth\AuthController@sendCode');
	//activity
	Route::get('activity/show/{id}', 'Activity\ActivityController@edit');
	Route::post('activity/insert', 'Activity\ActivityController@store');
	Route::get('activity/list/{pageNum}', 'Activity\ActivityController@index');
	Route::post('activity/update', 'Activity\ActivityController@update');
	Route::get('activity/delete/{id}', 'Activity\ActivityController@destroy');
	Route::get('activity/labelList', 'Activity\ActivityController@labelList');
	//club
	Route::get('club/list/{pageNum}', 'Club\ClubController@index');
	Route::get('club/show/{id}', 'Club\ClubController@edit');
	Route::get('club/insert', 'Club\ClubController@store');
	Route::get('club/update', 'Club\ClubController@update');
	Route::get('club/delete/{id}', 'Club\ClubController@destroy');
	Route::get('club/item/{id}', 'Club\ClubController@item');
	Route::get('club/img/{id}', 'Club\ClubController@img');
	Route::get('club/notice/{id}', 'Club\ClubController@notice');
	Route::get('club/config/{id}', 'Club\ClubController@config');
	//club_img
	Route::get('clubImg/list', 'Club\ClubImgController@index');
	Route::get('clubImg/show/{id}', 'Club\ClubImgController@edit');
	Route::post('clubImg/insert', 'Club\ClubImgController@store');
	Route::post('clubImg/update', 'Club\ClubImgController@update');
	Route::get('clubImg/delete/{id}', 'Club\ClubImgController@destroy');
	//club_notice
	Route::get('clubNotice/list', 'Club\ClubNoticeController@index');
	Route::get('clubNotice/show/{id}', 'Club\ClubNoticeController@edit');
	Route::post('clubNotice/insert', 'Club\ClubNoticeController@store');
	Route::post('clubNotice/update', 'Club\ClubNoticeController@update');
	Route::get('clubNotice/delete/{id}', 'Club\ClubNoticeController@destroy');
	//team
	Route::get('team/list/{pageNum}', 'Team\TeamController@index');
	Route::get('team/show/{id}', 'Team\TeamController@edit');
	Route::post('team/insert', 'Team\TeamController@store');
	Route::post('team/update', 'Team\TeamController@update');
	Route::get('team/delete/{id}', 'Team\TeamController@destroy');
	//index
	Route::get('home/img', 'Home\IndexController@img');
	Route::get('home/count', 'Home\IndexController@count');
	//center
	Route::get('myTeamMember/list/{pageNum}', 'Center\MyTeamMember@index');
	Route::get('myTeamMember/show/{id}', 'Center\MyTeamMember@edit');
	Route::post('myTeamMember/insert', 'Center\MyTeamMember@store');
	Route::post('myTeamMember/update', 'Center\MyTeamMember@update');
	Route::get('myTeamMember/delete/{id}', 'Center\MyTeamMember@destroy');
	//article
	Route::get('article/list/{pageNum}', 'Article\ArticleController@index');
	Route::get('article/show/{id}', 'Article\ArticleController@edit');
	Route::post('article/insert', 'Article\ArticleController@store');
	Route::post('article/update', 'Article\ArticleController@update');
	Route::get('article/delete/{id}', 'Article\ArticleController@destroy');
	//test
	Route::any('test/method', function (Request $request) {
		return ['method'=>$request->method()];
	});
});



Route::group(['namespace' => 'H5'], function()
{
	//首页
	Route::get('h5/home/index', 'Home\IndexController@index');
	Route::get('h5/home/find', 'Home\IndexController@find');
	// Authentication routes...
	Route::get('h5/auth/login', 'Auth\AuthController@getLogin');
	Route::post('h5/auth/login', 'Auth\AuthController@postLogin');
	Route::get('h5/auth/logout', 'Center\MyController@logout');
	Route::get('h5/auth/register', 'Auth\AuthController@getRegister');
	Route::post('h5/auth/register', 'Auth\AuthController@postRegister');
	Route::post('h5/auth/sendCode', 'Auth\AuthController@sendCode');
	//activity
	Route::get('h5/activity/show/{id}', 'Activity\ActivityController@edit');
	//Route::post('h5/activity/insert', 'Activity\ActivityController@store');
	Route::get('h5/activity/list/{pageNum}', 'Activity\ActivityController@index');
	Route::post('h5/activity/update', 'Activity\ActivityController@update');
	Route::get('h5/activity/delete/{id}', 'Activity\ActivityController@destroy');
	Route::get('h5/activity/zhangcheng', 'Activity\ActivityController@zhangcheng');
	//比赛相关
	Route::get('h5/activity/mingdangs', 'Activity\ActivitySetShowController@mingdangs');
	Route::get('h5/activity/cqjieguo', 'Activity\ActivitySetShowController@cqjieguo');
	Route::get('h5/activity/group', 'Activity\ActivitySetShowController@getgroup');
	Route::get('h5/activity/saikuang', 'Activity\ActivitySetShowController@saikuanglist');
	Route::get('h5/activity/groupinfo', 'Activity\ActivitySetShowController@groupinfo');
	Route::get('h5/activity/jifen', 'Activity\ActivitySetShowController@jifen');
	Route::get('h5/activity/bsjieguo', 'Activity\ActivitySetShowController@bsjieguo');
	Route::get('h5/activity/score', 'Activity\ActivitySetShowController@score');
	Route::get('h5/activity/cqjieguo', 'Activity\ActivitySetShowController@cqjieguo');
	Route::get('h5/activity/resultlist', 'Activity\ActivitySetShowController@resultlist');
	Route::get('h5/activity/resultinfo', 'Activity\ActivitySetShowController@resultinfo');
	Route::get('h5/activity/resultsubinfo', 'Activity\Specail\FourController@score_sub_show');
	//club
	Route::get('h5/club/list/{pageNum}', 'Club\ClubController@index');
	Route::get('h5/club/show/{id}', 'Club\ClubController@edit');
	Route::get('h5/club/insert', 'Club\ClubController@store');
	Route::get('h5/club/update', 'Club\ClubController@update');
	Route::get('h5/club/delete/{id}', 'Club\ClubController@destroy');
	Route::get('h5/club/item/{id}', 'Club\ClubController@item');
	Route::get('h5/club/img/{id}', 'Club\ClubController@img');
	Route::get('h5/club/notice/{id}', 'Club\ClubController@notice');
	Route::get('h5/club/config/{id}', 'Club\ClubController@config');
	//club_img
	Route::get('h5/clubImg/list', 'Club\ClubImgController@index');
	Route::get('h5/clubImg/show/{id}', 'Club\ClubImgController@edit');
	Route::post('h5/clubImg/insert', 'Club\ClubImgController@store');
	Route::post('h5/clubImg/update', 'Club\ClubImgController@update');
	Route::get('h5/clubImg/delete/{id}', 'Club\ClubImgController@destroy');
	//club_notice
	Route::get('h5/clubNotice/list', 'Club\ClubNoticeController@index');
	Route::get('h5/clubNotice/show/{id}', 'Club\ClubNoticeController@edit');
	Route::post('h5/clubNotice/insert', 'Club\ClubNoticeController@store');
	Route::post('h5/clubNotice/update', 'Club\ClubNoticeController@update');
	Route::get('h5/clubNotice/delete/{id}', 'Club\ClubNoticeController@destroy');
	//team
	Route::get('h5/team/list/{pageNum}', 'Team\TeamController@index');
	Route::get('h5/team/show/{id}', 'Team\TeamController@edit');
	Route::post('h5/team/insert', 'Team\TeamController@store');
	Route::post('h5/team/update', 'Team\TeamController@update');
	Route::get('h5/team/delete/{id}', 'Team\TeamController@destroy');
	//index
	Route::get('h5/home/img', 'Home\IndexController@img');
	Route::get('h5/home/count', 'Home\IndexController@count');
	//center
	Route::get('h5/myTeamMember/list/{pageNum}', 'Center\MyTeamMember@index');
	Route::get('h5/myTeamMember/show/{id}', 'Center\MyTeamMember@edit');
	Route::post('h5/myTeamMember/insert', 'Center\MyTeamMember@store');
	Route::post('myTeamMember/update', 'Center\MyTeamMember@update');
	Route::get('h5/myTeamMember/delete/{id}', 'Center\MyTeamMember@destroy');
	//article
	Route::get('h5/article/list/{pageNum}', 'Article\ArticleController@index');
	Route::get('h5/article/show/{id}', 'Article\ArticleController@edit');
	Route::post('h5/article/insert', 'Article\ArticleController@store');
	Route::post('h5/article/update', 'Article\ArticleController@update');
	Route::get('h5/article/delete/{id}', 'Article\ArticleController@destroy');
	//test
	Route::get('h5/test/test', 'Test\TestController@test');
	//file
	Route::post('h5/common/upload', 'Common\FileController@upload');
	//check user
	Route::get('/ch', 'Auth\AuthController@auto_login');
});
Route::group(['namespace' => 'H5','middleware' => 'auth'], function()
{

	Route::get('h5/home/my', 'Home\IndexController@my');


	Route::get('h5/member/my/edit', 'Center\MyController@edit');
	Route::post('h5/member/my/edit', 'Center\MyController@store');

	//pinlun
	Route::get('h5/activity/pinglun', 'Activity\ActivityController@pinglun2');  
	Route::post('h5/activity/pinglun', 'Activity\ActivityController@pinglun_post2');  

	Route::get('h5/member/four/chang_table', 'Activity\Specail\FourController@chang_table');
	Route::get('h5/member/activity', 'Center\MyController@myActivityList');
	Route::get('h5/member/activity/create', 'Activity\ActivityController@create');
	Route::get('h5/member/activity/delete', 'Activity\ActivityController@destroy');
	Route::post('h5/member/activity/create', 'Activity\ActivityController@store');
	Route::post('h5/member/activity/update', 'Activity\ActivityController@update');
	Route::post('h5/member/activity/update_specail', 'Activity\ActivityController@update');
	Route::get('h5/member/activity/group', 'Activity\ActivityController@group');
	Route::get('h5/member/activity/add_team_match', 'Activity\ActivityController@add_team_match');
	Route::get('h5/member/activity/edit_join', 'Activity\ActivityController@edit_join');
	Route::post('h5/member/activity/group', 'Activity\ActivitySetController@postgroup');
	//specail
	Route::get('h5/member/activity/create_specail', 'Activity\ActivityController@create_specail');
	Route::post('h5/member/activity/create_specail', 'Activity\ActivityController@store_specail');
	Route::get('/h5/member/activity/specail/four/score', 'Activity\Specail\FourController@score');
	Route::get('/h5/member/activity/specail/four/score_sub', 'Activity\Specail\FourController@score_sub');
	Route::get('/h5/member/activity/specail/four/score_sub_show', 'Activity\Specail\FourController@score_sub_show');
	Route::get('/h5/member/activity/specail/four/score_team_member_match_id', 'Activity\Specail\FourController@score_team_member_match');
	Route::get('/h5/member/activity/specail/four/rank', 'Activity\Specail\FourController@rank');
	Route::get('/h5/member/activity/specail/four/change_member','Activity\Specail\FourController@change_member');
	Route::get('/h5/member/activity/specail/four/change_member_small','Activity\Specail\FourController@change_member_small');
	Route::get('/h5/member/activity/specail/four/change_member_last','Activity\Specail\FourController@change_member_last');
	Route::post('/h5/member/activity/specail/four/change_member_last','Activity\Specail\FourController@change_member_last_post');
	Route::get('/h5/member/activity/specail/four/chang_team','Activity\Specail\FourController@chang_team');
	Route::post('/h5/member/activity/specail/four/add_member','Activity\Specail\FourController@add_member');
	//设置
	Route::get('h5/member/activity/set', 'Activity\ActivitySetController@setlist');
	Route::get('h5/member/activity/set/select', 'Activity\ActivitySetController@set_select');
	Route::get('h5/member/activity/set/rank', 'Activity\ActivitySetController@set_rank');
	Route::post('h5/member/activity/set/rank', 'Activity\ActivitySetController@post_set_rank');
	Route::get('/h5/member/activity/set/group', 'Activity\ActivitySetController@set_group');
	Route::get('/h5/member/activity/set/score', 'Activity\ActivitySetController@set_score');
	Route::get('/h5/member/activity/set/score_sub', 'Activity\Specail\FourController@score_sub');
	Route::get('/h5/member/activity/set/score_sub_tao', 'Activity\ActivitySetController@set_score_tao');
	Route::get('h5/member/activity/set/go', 'Activity\ActivitySetController@set_go');
	Route::post('h5/activity/score', 'Activity\ActivitySetController@postscore');
	Route::post('/h5/member/activity/set/jinji', 'Activity\ActivitySetController@jinji');
	Route::get('/h5/member/activity/set/change_member', 'Activity\ActivitySetController@change_member');
	Route::get('/h5/member/activity/manager_team_list', 'Activity\ActivitySetController@manager_team_list');
	Route::get('/h5/member/activity/chang_table', 'Activity\ActivitySetShowController@change_table');
	Route::get('/h5/activity/join_more', 'Activity\ActivitySetShowController@join_more');
	Route::post('/h5/activity/join_more', 'Activity\ActivitySetShowController@join_more_post');

	Route::get('/h5/activity/join_four', 'Activity\ActivityController@join_four');
	Route::post('/h5/activity/join_four', 'Activity\ActivityController@join_four_post');

	Route::get('h5/member/club', 'Center\MyController@myClubList');
	Route::get('h5/member/club/create', 'Club\ClubController@create');
	Route::post('h5/member/club/create', 'Club\ClubController@store');

	Route::get('h5/member/person', 'Center\MyController@myPersonList');
	Route::get('h5/member/person/create', 'Team\TeamMemberController@create');
	Route::post('h5/member/person/create', 'Team\TeamMemberController@store');
	Route::post('h5/member/person/import', 'Team\TeamMemberController@import');
	Route::get('h5/member/person/delete', 'Team\TeamMemberController@destroy');

	Route::get('h5/member/rank',
		'Center\MyController@rank');
	
	Route::get('h5/member/score', 'Center\MyController@myScore');
	Route::post('h5/member/score', 'Center\MyController@postscore');

	Route::get('h5/activity/join', 'Activity\ActivityController@join');
	Route::get('h5/activity/edit_join', 'Activity\ActivityController@edit_join');
	Route::post('h5/activity/cqjieguo', 'Activity\ActivityController@postchouqian');
	Route::post('h5/activity/join_activity', 'Team\TeamController@joinActivity');
	//club
	Route::post('h5/member/club/join', 'Club\ClubController@join');
	Route::get('h5/club/person', 'Club\ClubController@person_list');
	Route::post('h5/club/person', 'Club\ClubController@person_insert');
	
	Route::get('h5/member/team', 'Center\MyController@myTeamList');
	Route::get('h5/member/team/delete', 'Team\TeamController@destroy');


});



Route::group(['namespace' => 'Web'], function()
{
	//首页
	Route::get('web/home/index', 'Home\IndexController@index');
	Route::get('web/home/find', 'Home\IndexController@find');
	// Authentication routes...
	Route::get('web/auth/login', 'Auth\AuthController@getLogin');
	Route::post('web/auth/login', 'Auth\AuthController@postLogin');
	Route::get('web/auth/logout', 'Center\MyController@logout');
	Route::get('web/auth/register', 'Auth\AuthController@getRegister');
	Route::post('web/auth/register', 'Auth\AuthController@postRegister');
	Route::post('web/auth/sendCode', 'Auth\AuthController@sendCode');
	//activity
	Route::get('web/activity/show/{id}', 'Activity\ActivityController@edit');
	//Route::post('web/activity/insert', 'Activity\ActivityController@store');
	Route::get('web/activity/list/{pageNum}', 'Activity\ActivityController@index');
	Route::post('web/activity/update', 'Activity\ActivityController@update');
	Route::get('web/activity/delete/{id}', 'Activity\ActivityController@destroy');
	Route::get('web/activity/zhangcheng', 'Activity\ActivityController@zhangcheng');
	//比赛相关
	Route::get('web/activity/mingdangs', 'Activity\ActivitySetShowController@mingdangs');
	Route::get('web/activity/cqjieguo', 'Activity\ActivitySetShowController@cqjieguo');
	Route::get('web/activity/group', 'Activity\ActivitySetShowController@getgroup');
	Route::get('web/activity/saikuang', 'Activity\ActivitySetShowController@saikuanglist');
	Route::get('web/activity/groupinfo', 'Activity\ActivitySetShowController@groupinfo');
	Route::get('web/activity/jifen', 'Activity\ActivitySetShowController@jifen');
	Route::get('web/activity/bsjieguo', 'Activity\ActivitySetShowController@bsjieguo');
	Route::get('web/activity/score', 'Activity\ActivitySetShowController@score');
	Route::get('web/activity/cqjieguo', 'Activity\ActivitySetShowController@cqjieguo');
	Route::get('web/activity/resultlist', 'Activity\ActivitySetShowController@resultlist');
	Route::get('web/activity/resultinfo', 'Activity\ActivitySetShowController@resultinfo');
	Route::get('web/activity/resultsubinfo', 'Activity\Specail\FourController@score_sub_show');
	//club
	Route::get('web/club/list/{pageNum}', 'Club\ClubController@index');
	Route::get('web/club/show/{id}', 'Club\ClubController@edit');
	Route::get('web/club/insert', 'Club\ClubController@store');
	Route::get('web/club/update', 'Club\ClubController@update');
	Route::get('web/club/delete/{id}', 'Club\ClubController@destroy');
	Route::get('web/club/item/{id}', 'Club\ClubController@item');
	Route::get('web/club/img/{id}', 'Club\ClubController@img');
	Route::get('web/club/notice/{id}', 'Club\ClubController@notice');
	Route::get('web/club/config/{id}', 'Club\ClubController@config');
	//club_img
	Route::get('web/clubImg/list', 'Club\ClubImgController@index');
	Route::get('web/clubImg/show/{id}', 'Club\ClubImgController@edit');
	Route::post('web/clubImg/insert', 'Club\ClubImgController@store');
	Route::post('web/clubImg/update', 'Club\ClubImgController@update');
	Route::get('web/clubImg/delete/{id}', 'Club\ClubImgController@destroy');
	//club_notice
	Route::get('web/clubNotice/list', 'Club\ClubNoticeController@index');
	Route::get('web/clubNotice/show/{id}', 'Club\ClubNoticeController@edit');
	Route::post('web/clubNotice/insert', 'Club\ClubNoticeController@store');
	Route::post('web/clubNotice/update', 'Club\ClubNoticeController@update');
	Route::get('web/clubNotice/delete/{id}', 'Club\ClubNoticeController@destroy');
	//team
	Route::get('web/team/list/{pageNum}', 'Team\TeamController@index');
	Route::get('web/team/show/{id}', 'Team\TeamController@edit');
	Route::post('web/team/insert', 'Team\TeamController@store');
	Route::post('web/team/update', 'Team\TeamController@update');
	Route::get('web/team/delete/{id}', 'Team\TeamController@destroy');
	//index
	Route::get('web/home/img', 'Home\IndexController@img');
	Route::get('web/home/count', 'Home\IndexController@count');
	//center
	Route::get('web/myTeamMember/list/{pageNum}', 'Center\MyTeamMember@index');
	Route::get('web/myTeamMember/show/{id}', 'Center\MyTeamMember@edit');
	Route::post('web/myTeamMember/insert', 'Center\MyTeamMember@store');
	Route::post('myTeamMember/update', 'Center\MyTeamMember@update');
	Route::get('web/myTeamMember/delete/{id}', 'Center\MyTeamMember@destroy');
	//article
	Route::get('web/article/list/{pageNum}', 'Article\ArticleController@index');
	Route::get('web/article/show/{id}', 'Article\ArticleController@edit');
	Route::post('web/article/insert', 'Article\ArticleController@store');
	Route::post('web/article/update', 'Article\ArticleController@update');
	Route::get('web/article/delete/{id}', 'Article\ArticleController@destroy');
	//test
	Route::get('web/test/test', 'Test\TestController@test');
	//file
	Route::post('web/common/upload', 'Common\FileController@upload');
	//check user
	Route::get('/ch', 'Auth\AuthController@auto_login');
});
Route::group(['namespace' => 'Web','middleware' => 'auth'], function()
{

	Route::get('web/home/my', 'Home\IndexController@my');


	Route::get('web/member/my/edit', 'Center\MyController@edit');
	Route::post('web/member/my/edit', 'Center\MyController@store');

	//pinlun
	Route::get('web/activity/pinglun', 'Activity\ActivityController@pinglun2');  
	Route::post('web/activity/pinglun', 'Activity\ActivityController@pinglun_post2');  

	Route::get('web/member/four/chang_table', 'Activity\Specail\FourController@chang_table');
	Route::get('web/member/activity', 'Center\MyController@myActivityList');
	Route::get('web/member/activity/create', 'Activity\ActivityController@create');
	Route::get('web/member/activity/delete', 'Activity\ActivityController@destroy');
	Route::post('web/member/activity/create', 'Activity\ActivityController@store');
	Route::post('web/member/activity/update', 'Activity\ActivityController@update');
	Route::post('web/member/activity/update_specail', 'Activity\ActivityController@update');
	Route::get('web/member/activity/group', 'Activity\ActivityController@group');
	Route::get('web/member/activity/add_team_match', 'Activity\ActivityController@add_team_match');
	Route::get('web/member/activity/edit_join', 'Activity\ActivityController@edit_join');
	Route::post('web/member/activity/group', 'Activity\ActivitySetController@postgroup');
	//specail
	Route::get('web/member/activity/create_specail', 'Activity\ActivityController@create_specail');
	Route::post('web/member/activity/create_specail', 'Activity\ActivityController@store_specail');
	Route::get('/web/member/activity/specail/four/score', 'Activity\Specail\FourController@score');
	Route::get('/web/member/activity/specail/four/score_sub', 'Activity\Specail\FourController@score_sub');
	Route::get('/web/member/activity/specail/four/score_sub_show', 'Activity\Specail\FourController@score_sub_show');
	Route::get('/web/member/activity/specail/four/score_team_member_match_id', 'Activity\Specail\FourController@score_team_member_match');
	Route::get('/web/member/activity/specail/four/rank', 'Activity\Specail\FourController@rank');
	Route::get('/web/member/activity/specail/four/change_member','Activity\Specail\FourController@change_member');
	Route::get('/web/member/activity/specail/four/change_member_small','Activity\Specail\FourController@change_member_small');
	Route::get('/web/member/activity/specail/four/change_member_last','Activity\Specail\FourController@change_member_last');
	Route::post('/web/member/activity/specail/four/change_member_last','Activity\Specail\FourController@change_member_last_post');
	Route::get('/web/member/activity/specail/four/chang_team','Activity\Specail\FourController@chang_team'); 
	//设置
	Route::get('web/member/activity/set', 'Activity\ActivitySetController@setlist');
	Route::get('web/member/activity/set/select', 'Activity\ActivitySetController@set_select');
	Route::get('web/member/activity/set/rank', 'Activity\ActivitySetController@set_rank');
	Route::post('web/member/activity/set/rank', 'Activity\ActivitySetController@post_set_rank');
	Route::get('/web/member/activity/set/group', 'Activity\ActivitySetController@set_group');
	Route::get('/web/member/activity/set/score', 'Activity\ActivitySetController@set_score');
	Route::get('/web/member/activity/set/score_sub', 'Activity\Specail\FourController@score_sub');
	Route::get('web/member/activity/set/go', 'Activity\ActivitySetController@set_go');
	Route::post('web/activity/score', 'Activity\ActivitySetController@postscore');
	Route::post('/web/member/activity/set/jinji', 'Activity\ActivitySetController@jinji');
	Route::get('/web/member/activity/set/change_member', 'Activity\ActivitySetController@change_member');
	Route::get('/web/member/activity/manager_team_list', 'Activity\ActivitySetController@manager_team_list');

	Route::get('web/member/club', 'Center\MyController@myClubList');
	Route::get('web/member/club/create', 'Club\ClubController@create');
	Route::post('web/member/club/create', 'Club\ClubController@store');

	Route::get('web/member/person', 'Center\MyController@myPersonList');
	Route::get('web/member/person/create', 'Team\TeamMemberController@create');
	Route::post('web/member/person/create', 'Team\TeamMemberController@store');
	Route::get('web/member/person/delete', 'Team\TeamMemberController@destroy');

	Route::get('web/member/score', 'Center\MyController@myScore');
	Route::post('web/member/score', 'Center\MyController@postscore');

	Route::get('web/activity/join', 'Activity\ActivityController@join');
	Route::get('web/activity/edit_join', 'Activity\ActivityController@edit_join');
	Route::post('web/activity/cqjieguo', 'Activity\ActivityController@postchouqian');
	Route::post('web/activity/join_activity', 'Team\TeamController@joinActivity');
	//club
	Route::post('web/member/club/join', 'Club\ClubController@join');

	Route::get('web/member/team', 'Center\MyController@myTeamList');
	Route::get('web/member/team/delete', 'Team\TeamController@destroy');

});

Route::group(['namespace' => 'Admin'], function()
{

	// Authentication routes...
	Route::get('admin/auth/login', 'Auth\AuthController@getLogin');
	Route::post('admin/auth/login', 'Auth\AuthController@postLogin');

});

Route::group(['namespace' => 'Admin','middleware' => 'auth'], function()
{
	Route::get('admin/home/index', 'Home\IndexController@index');
	Route::post('admin/club/check', 'Club\ClubController@check');
});

