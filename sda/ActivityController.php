<?php

namespace App\Http\Controllers\H5\Activity;

use App\Http\Controllers\H5Controller;
use App\Orms\Activity as OrmActivity;
use Auth;
use DB;
use Illuminate\Http\Request;
use Template;
use Validator;
use Redirect;
use View;
use Cookie;
use App\Models\ActivityModel;
use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\ActivityGroupModel;

class ActivityController extends H5Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageNum, Request $request)
    {

        //######分页start
        $pageNum = $pageNum < 1 ? 1 : $pageNum;
        $pageSize = 5;
        $offset = ($pageNum - 1) * $pageSize;
        $count = DB::table('activity')
            ->count();
        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $prev = ($pageNum - 1) < 1 ? 1 : ($pageNum - 1);
        $next = ($pageNum + 1) > $page['totalPage'] ? $page['totalPage'] : $pageNum + 1;
        $page['prevUrl'] = "/h5/activity/list/{$prev}";
        $page['nextUrl'] = "/h5/activity/list/{$next}";
        $page['url'] = "/h5/activity/list/";
        //######分页end
        $item_id = $request->input('item');
        $province = $request->input('province');
        $city = $request->input('city');
        $status = $request->input('status');

        $te = DB::table('activity')
            ->skip($offset)//offset  10
            ->take($pageSize);//limit 5;

        if ($item_id) {
            $te->where('item_id', $item_id);
        }

        if ($province) {
            $te->where('province', $province);
        }
        if ($city) {
            $te->where('city', $city);
        }

        if ($status) {

            if ($status == 'enlist') {
                $te->where('apply_end_time', '<', date('Y-m-d H-i-s', time()));
            } elseif ($status == 'draw') {
                $te->where('apply_end_time', '<', date('Y-m-d H-i-s', time()));
                $te->where('start_time', '>', date('Y-m-d H-i-s', time()));
            } elseif ($status == 'match') {
                $te->where('end_time', '>', date('Y-m-d H-i-s', time()));
                $te->where('start_time', '<', date('Y-m-d H-i-s', time()));
            } elseif ($status == 'result') {
                $te->where('end_time', '<', date('Y-m-d H-i-s', time()));
            }


        }

        $res = $te->get();

        $activity_ids = [];
        //状态转化enlist 报名中  draw抽签   match比赛 result成绩 end结束
        $status = [
            'enlist' => '报名中',
            'draw' => '抽签',
            'match' => '比赛',
            'result' => '成绩',
        ];
        //
        $item = DB::table('activity_item')
            ->get();
        Template::assign('status', $status);
        Template::assign('item', $item);
        Template::assign('list', $res);
        Template::assign('page', $page);
        Template::render('h5/activity/list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function labelList(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data']['list'] = array();
        $out['data']['page'] = [];
        //
        $pageNum = $request->input('pageNum') < 1 ? 1 : $request->input('pageNum');
        $label = $request->input('label');
        $pageSize = 20;
        $offset = ($pageNum - 1) * $pageSize;

        $count = DB::table('activity')
            ->count();

        $page['nowPage'] = $pageNum;
        $page['totalPage'] = ceil($count / $pageSize);
        $page['totalSize'] = $count;
        $out['data']['page'] = $page;
        $res = DB::table('activity')
            ->where('label', '=', $label)
            ->orderBy('id', 'DESC')
            ->skip($offset)//offset  10
            ->take($pageSize)//limit 5
            ->get();
        if ($res) {
            $out['data']['list'] = $res;
        }

        Template::assign('list', $res);
        Template::assign('page', $page);
        Template::render('h5/index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $item = DB::table('activity_item')
            ->get();

        $detail = [];
        if ($request->input('id')) {
            $detail = DB::table('activity')
                ->where('id', $request->input('id'))
                ->first();
        }
        Template::assign('detail', $detail);
        Template::assign('item', $item);
        Template::assign('can_change', 1);
        Template::render('h5/member/activity/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        // 验证

        $out = ActivityModel::save($request->all());
        return $out;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $user = Auth::user();
        //
        $res = ActivityModel::detail($id);
        //活动状态
        $res->status = get_activity_status($res);
        //星期几转化
        $res->date_x = date_week($res->start_time);
        $res->date_y = date_week($res->end_time);
        //报名人数
        $count = DB::table('team_member')
            ->where('activity_id', $id)
            ->count();
        $team_count = DB::table('team')
            ->where('activity_id', $id)
            ->count();
        //发布俱乐部
        $club = [];
        $club_user = DB::table('user_club')
            ->where('mem_id', $res->mem_id)
            ->first();
        $club = DB::table('club')
            ->where('id', $club_user->club_id)
            ->first();
        //是否能够抽签
        $can_draw = 0;
        if ($user) {
            if (time() > strtotime($res->apply_end_time) && time() < strtotime($res->start_time)) {
                $team = DB::table('team')
                    ->where('mem_id', $user->id)
                    ->where('activity_id', $id)
                    ->first();
                if ($team) {
                    $can_draw = 1;
                }
            }
        }

        Template::assign('team_count', $team_count);
        Template::assign('count', $count);
        Template::assign('club', $club);
        Template::assign('detail', $res);
        Template::assign('can_draw', $can_draw);

        Template::render('h5/activity/detail');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        //
        $ormActivity = new OrmActivity();

        $ormActivity = $ormActivity->find($request->input('id'));
        if (!$ormActivity) {
            $out['code'] = 1;
            $out['msg'] = '不存在';
            return $out;
        }
        if ($request->input('cover_img')) {
            $ormActivity->cover_img = $request->input('cover_img');
        }
        if ($request->input('title')) {
            $ormActivity->title = $request->input('title');
        }

        if ($request->input('people_count')) {
            $ormActivity->people_count = $request->input('people_count');
        }

        if ($request->input('postion')) {
            $ormActivity->postion = $request->input('postion');
        }

        if ($request->input('start_time')) {
            $ormActivity->start_time = $request->input('start_time');
        }

        if ($request->input('cost')) {
            $ormActivity->cost = $request->input('cost');
        }

        if ($request->input('apply_start_time')) {
            $ormActivity->apply_start_time = $request->input('apply_start_time');
        }

        if ($request->input('apply_end_time')) {
            $ormActivity->apply_end_time = $request->input('apply_end_time');
        }

        if ($request->input('end_time')) {
            $ormActivity->end_time = $request->input('end_time');
        }

        if ($request->input('apply_type')) {
            $ormActivity->apply_type = $request->input('apply_type');
        }

        if ($request->input('min_male_count')) {
            $ormActivity->min_male_count = $request->input('min_male_count');
        }

        if ($request->input('min_female_count')) {
            $ormActivity->min_female_count = $request->input('min_female_count');
        }

        if ($request->input('introduction')) {
            $ormActivity->introduction = $request->input('introduction');
        }

        if ($request->input('rule')) {
            $ormActivity->rule = $request->input('rule');
        }

        if ($request->input('reward')) {
            $ormActivity->reward = $request->input('reward');
        }

        if ($request->input('points')) {
            $ormActivity->points = $request->input('points');
        }

        if ($request->input('link_man')) {
            $ormActivity->link_man = $request->input('link_man');
        }

        if ($request->input('link_mail')) {
            $ormActivity->link_mail = $request->input('link_mail');
        }

        if ($request->input('link_phone')) {
            $ormActivity->link_phone = $request->input('link_phone');
        }

        if ($request->input('link_qq')) {
            $ormActivity->link_qq = $request->input('link_qq');
        }

        $ormActivity->save();

        return $out;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->input('id');
        OrmActivity::destroy($id);
        return Redirect::to('/h5/member/activity');
    }

    //join
    public function join(Request $request)
    {
        Template::assign('data_activity_id', $request->input('activity_id'));
        $user = Auth::user();
        //是否已经报过该活动
        if ($user->user_team_member_id > 0) {
            $res = DB::table('team_member')
                ->where('user_team_member_id', $user->user_team_member_id)
                ->where('activity_id', $request->input('activity_id'))
                ->first();
            if ($res) {
                Template::assign('url', '/h5/activity/show/' . $request->input('activity_id'));
                Template::assign('error', '已报名');
                Template::render('h5/common/error_redirect');
                exit();
            }
        }

        //活动项目
        $activity_category = DB::table('activity_category')
            ->where('activity_id', $request->input('activity_id'))
            ->get();

        foreach ($activity_category as &$row) {
            $row->name = activity_item_tran($row->apply_item);
            $row->item = $row->apply_item;
            $row->number = 1;
            unset($row->apply_item);
        }
        unset($row);

        //我的队员
        $data_member_person = UserModel::person_list(true, $user->id);
        //活动信息
        $activity = ActivityModel::detail($request->input('activity_id'));
        //我的信息
        $user_id = $user->id;
        Template::assign('data_activity', $activity);
        Template::assign('data_activity_category', $activity_category);
        Template::assign('data_member_person', $data_member_person);
        Template::assign('data_user_id', $user_id);
        Template::render('h5/activity/join');
    }


    //joinPerson
    public function joinPerson(Request $request)
    {
        $user = Auth::user();
        $captain = isset($_COOKIE['join_team_captain']) ? $_COOKIE['join_team_captain'] : '';
        $common = isset($_COOKIE['join_team_common']) ? explode(',', $_COOKIE['join_team_common']) : [];
        $act_id = isset($_COOKIE['join_activity_id']) ? $_COOKIE['join_activity_id'] : [];

        $query =
            DB::table('user_team_member');
        if ($captain && $request->input('type') == 'common') {
            $query->where('id', '<>', $captain);
        }
        $query->where('mem_id', $user->id);
        $list = $query->get();
        $type = $request->input('type');
        $rule = DB::table('activity')
            ->where('id', $act_id)
            ->first();
        Template::assign('type', $type);
        Template::assign('list', $list);
        Template::assign('captain', $captain);
        Template::assign('common', $common);
        Template::assign('rule', $rule);
        Template::render('h5/activity/person');
    }


    //抽签
    public function chouqian(Request $request)
    {
        if (!$request->input('activity_id')) {

            Template::assign('list', []);
            Template::render('h5/activity/cqjieguo');
            exit;
        }
        $res = DB::table('team')
            ->where('activity_id', $request->input('activity_id'))
            ->get();

        Template::assign('list', $res);
        Template::render('h5/activity/cqjieguo');
    }

    //抽签
    public function postchouqian(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $out = ActivityModel::draw($request->all());
        return $out;
    }


    //选择进行的炒作类型
    public function set_select(Request $request)
    {
        $out['code'] = 0;
        $out['msg'] = 'ok';
        $out['data'] = array();
        $activity_turn = DB::table('activity_turn')
            ->where('id', $request->input('activity_turn_id'))
            ->first();
        Template::assign('turn', $activity_turn);
        Template::assign('activity_id', $request->input('activity_id'));
        Template::render('h5/member/activity/set/select');
    }


}
