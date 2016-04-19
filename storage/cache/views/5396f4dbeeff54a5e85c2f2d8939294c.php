
<!doctype html>
<html class="no-js">
<head><meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>益乐赛</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1, user-scalable=no,minimal-ui">
    <meta name="renderer" content="webkit">
    <meta name="apple-mobile-web-app-title" content="易乐赛">
    <meta name="full-screen" content="yes">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="http://www.yilesai.com/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="http://www.yilesai.com/assets/css/app.css"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <body>
        <style>
        .am-list, .m-widget-list ul li {
            line-height: 20px;
            margin: 0px;
            padding: 0px;
        }

        .am-circle {
            margin-left: 2px;
            margin-right: 2px;
        }

        .am-nav-tabs > li.am-active > a, .am-nav-tabs > li.am-active > a:hover, .am-nav-tabs > li.am-active > a:focus {
            color: #17b4eb;
            text-align: center;
            background-color: #FFF;
            border-width: 0px;
            border-style: solid;
            border-color: #DDD #DDD transparent;
            -moz-border-top-colors: none;
            -moz-border-right-colors: none;
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            border-image: none;
            cursor: default;
            border-bottom: 2px solid #17b4eb;
        }

        .am-nav-tabs > li > a {
            text-align: center;
            margin-right: 5px;
            ` line-height: 1.6;
            border: 1px solid transparent;
            border-radius: 0px;
            color: #666;
        }
        </style>
        <div align="center">
            <!-- Header -->
        </div>
        <header data-am-widget="header"
        class="am-header am-header-default">
        <div class="am-header-left am-header-nav">
            <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="http://www.yilesai.com/assets/images/jtou.png"/> </a>
            </div>

        </div>
        <h1 class="am-header-title"><a href="#title-link">活动详情</a></h1>

        <div class="am-header-right am-header-nav">
            <div data-am-widget="navbar" id="">
                <ul style="float:left; margin:0px; padding:0px; list-style-type:none">
                    <li data-am-navbar-share><a href="###" style="color:#fff"> <img src="http://www.yilesai.com/assets/images/share.png"> </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- Menu -->
    <div class="am-comment" style="border:1px solid #ccc; margin-bottom:10px;">
        <div class="am-gallery-item">
        <!--<div class="bmbtn" style=" position:absolute; right:5px; z-index:1;">{$detail->
        status}</div>
    -->
        <!--<div class="bmbtn"
             style="position: absolute;z-index: 1;background: rgba(126, 126, 126, 0.6) none repeat scroll 0% 0%;right: 5%;margin-top: 5px;border-radius: 5px;width: 45px;height: 45px;">
             <img src="http://www.yilesai.com/assets/images/xin.png" width="20"> <br>12<!--</div>-->
             <img src="<?php echo isset($detail->cover_img) ? $detail->cover_img : ''; ?>" width="100%" style="  height:250px;"/></div>
             <div class="am-g" style="width:100%; margin:0px; border:none;  text-align:center; padding:0px;">
                <div class="am-u-sm-12" style="width:100%; margin:0px; padding:0px;">
       <!--     <h3 class="am-gallery-title"
                style="margin: -25px 1px 0px; text-align:center; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff">
                纵横四海1.30<span class="quyuan">全部</span></h3>-->


                <h3 class="am-gallery-title" style="margin: -50px 1px 0px; text-align:left; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff"><?php echo isset($detail->title) ? $detail->title : ''; ?>		 <div style=" line-height:25px; padding-left:2px;text-align:left"><?php echo isset($detail->start_time) ? $detail->start_time : ''; ?><span class="quyuan"><?php echo isset($detail->city) ? $detail->city : ''; ?></span></div></h3>





            </div>
        </div>

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"
        style="font-size:80%; border-top:1px solid #ddd">
        <tr>
            <td align="center" width="33%">已报名<br>
                 <?php echo isset($count) ? $count : ''; ?>人
            </td>
            <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;" width="33%">队伍数<br>
                 <?php echo isset($team_count) ? $team_count : ''; ?>支
            </td>
            <td align="center" width="33%">倒计时<br>

                <div class="time"><span id="t_d">00天</span> <span id="t_h">00时</span> <span
                    id="t_m">00分</span>
                </div>
                <script>
                function GetRTime() {
                    var EndTime = new Date("<?php echo isset($detail->start_time) ? $detail->start_time : ''; ?>");
                    var NowTime = new Date();
                    var t = EndTime.getTime() - NowTime.getTime();
                    var d = 0;
                    var h = 0;
                    var m = 0;
                    var s = 0;
                    if (t >= 0) {
                        d = Math.floor(t / 1000 / 60 / 60 / 24);
                        h = Math.floor(t / 1000 / 60 / 60 % 24);
                        m = Math.floor(t / 1000 / 60 % 60);
                    }


                    document.getElementById("t_d").innerHTML = d + "天";
                    document.getElementById("t_h").innerHTML = h + "时";
                    document.getElementById("t_m").innerHTML = m + "分";
                }
                setInterval(GetRTime, 0);
                </script>
            </td>
        </tr>
    </table>
</div>
</div>
<div class="am-g" style="border:none; width:100%; padding:0px; margin:0px;">
    <div class="am-gallery-desc bms"><img src="http://www.yilesai.com/assets/images/rqi.png" width="20"><?php echo date('m-d',strtotime($detail->start_time)); ?>（周<?php echo isset($detail->date_x) ? $detail->date_x : ''; ?>）至<?php echo date('m-d',strtotime($detail->end_time)); ?>（周<?php echo isset($detail->date_y) ? $detail->date_y : ''; ?>）
        <!--2016-02-14 10:23:00-2016-02-29 10:23:00--></div>
    </div>

    <div class="grayline"></div>
    <?php if ($detail->postion) { ?>
    <div class="am-gallery-desc bms"><img src="http://www.yilesai.com/assets/images/adress.png" width="20"><?php echo isset($detail->postion) ? $detail->postion : ''; ?>
        <?php } ?>
        <!--2016-02-14 10:23:00-2016-02-29 10:23:00--></div>
    </div>

    <div class="grayline"></div>

    <hr data-am-widget="divider" class="am-divider am-divider-dashed" style="margin:0px; padding:0px; margin-bottom:5px;"/>





    <!-- 代码部分begin -->
    <div class="wrap">
        <div class="tabs">
            <a href="#" hidefocus="true" class="active">报名</a>
            <a href="#" hidefocus="true">比赛</a>

            <a href="#" hidefocus="true">成绩</a>
            <a href="#" hidefocus="true">评论</a>      

        </div>    
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                 <div class="content-slide">
                     
                        <?php foreach((array) $team_data as $row) { ?>
                            <?php $i++?>
                    <div class="am-panel am-panel-default">
                        <div class="am-panel-hd">
                            <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-<?php echo $i ?>'}"><img src="http://www.yilesai.com/assets/images/qun-icon.png" style="margin-right:5px" class="am-img-thumbnail am-circle" width="40" height="40"><span style="font-size:110%; color:#000"><?php echo isset($row['team_info']->name) ? $row['team_info']->name : ''; ?></span> <span style="float:right; color:#999;padding-top:10px; font-size:90%;">成员&nbsp;&gt;</span></h4>
                        </div>
                        <div id="do-not-say-<?php echo $i ?>" class="am-panel-collapse am-collapse" style="margin:0px; padding:0px;">
                            <div class="am-panel-bd" style="margin: 0px; padding: 0px; ">
                                <div class="am-g" style="margin:0px; padding:0px;background:#f9f9f9">
                                    <?php if ($row['team_info']->has_captain) { ?>
                                   <div class="lingdui">领队</div>
                                   <div class="duiyuan">
                                    <ul>
                                        <?php foreach((array) $row['list'] as $r) { ?>
                                        <?php if ($r->user_team_member_info&&$r->is_captain==1) { ?>
                                        <li><?php echo isset($r->user_team_member_info->name) ? $r->user_team_member_info->name : ''; ?>，<?php echo $r->user_team_member_info->sex==1?'男':'女'; ?></li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>
                                <div class="lingdui">队员</div>
                                <div class="duiyuan">
                                    <ul>
                                    <?php foreach((array) $row['list'] as $r) { ?>
                            <?php if ($r->user_team_member_info&&$r->is_captain!=1) { ?>
                            <li><?php echo isset($r->user_team_member_info->name) ? $r->user_team_member_info->name : ''; ?>，<?php echo $r->user_team_member_info->sex==1?'男':'女'; ?></li>
                            <?php } ?>
                            <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <style>
                        .lingdui {
                            float: left;
                            color: #6699CC;
                            width: 100%;
                            background: #DFDFDF;
                            padding-left: 20px;
                            margin-top: 3px;
                            margin-bottom: 3px;
                            line-height: 30px;
                            list-style-type: none
                        }
                        .duiyuan {
                            float: left;
                            width: 100%;
                        }
                        .duiyuan ul {
                            float: left;
                            width: 90%;
                            margin-left: 5%;
                            margin-right: 5%;
                            margin-top: 10px;
                            margin-bottom: 10px;
                            padding: 0px;
                            list-style-type: none
                        }
                        .duiyuan ul li {
                            line-height: 35px;
                            color: #666
                        }
                        </style>
                    </div>
                </div>	
                <?php } ?>
    <style>.am-panel-default>.am-panel-hd {
        color: #444;
        background-color: #fff;
        border-color:#fff}
        .am-panel-hd{ padding:0px;}
        .am-panel{ margin-bottom:10px;}

        </style>














    </div>
</div>



   <div class="swiper-slide">
     <div class="content-slide">
        <?php if ($team_match_data ) { ?>
        <table class="am-table">
            <thead>
                <tr>
                    <th>第一轮</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach($team_match_data as $k => $v) { ?>
    <?php if ($k==0||$k==1) { ?>
        <tr>
            <td><?php echo isset($v->team_a_name) ? $v->team_a_name : ''; ?></td>
            <td>vs</td>
            <td><?php echo isset($v->team_b_name) ? $v->team_b_name : ''; ?></td>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <td>
        <a href="/h5/member/activity/specail/four/score_sub?team_match_id=<?php echo isset($v->id) ? $v->id : ''; ?>">查看详情</a>
         </td>
            </tr>
    <?php } ?>
        <?php } ?>
        </tbody>
    </table>


    <table class="am-table">
      <thead>
          <tr>
             <th>第二轮</th>
         </tr>
     </thead>
     <tbody>
    <?php foreach($team_match_data as $k => $v) { ?>
        <?php if ($k==2||$k==3) { ?>
        <tr>
            <td><?php echo isset($v->team_a_name) ? $v->team_a_name : ''; ?></td>
            <td>vs</td>
            <td><?php echo isset($v->team_b_name) ? $v->team_b_name : ''; ?></td>

            &nbsp;&nbsp;&nbsp;&nbsp;
       
                     <td>
        <a href="/h5/member/activity/specail/four/score_sub?team_match_id=<?php echo isset($v->id) ? $v->id : ''; ?>">查看详情</a>
         </td>
            </tr>
             <?php } ?>
        <?php } ?>
 </tbody>
</table><table class="am-table">
<thead>
  <tr>
     <th>第三轮</th>
 </tr>
</thead>
<tbody>
        <?php foreach($team_match_data as $k => $v) { ?>
        <?php if ($k==4||$k==5) { ?>
        <tr>
            <td><?php echo isset($v->team_a_name) ? $v->team_a_name : ''; ?></td>
            <td>vs</td>
            <td><?php echo isset($v->team_b_name) ? $v->team_b_name : ''; ?></td>
     
             &nbsp;&nbsp;&nbsp;&nbsp;
     
                     <td>
        <a href="/h5/member/activity/specail/four/score_sub?team_match_id=<?php echo isset($v->id) ? $v->id : ''; ?>">查看详情</a>
         </td>
            </tr>     
            <?php } ?>
        <?php } ?>
</tbody>
</table>
<?php } ?>
</div>
    </div>

<div class="swiper-slide">

    <div class="content-slide">
            <?php if ($team_group ) { ?>
        <a class="am-btn am-btn-success"   href="/h5/member/four/chang_table?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>">人员调整</a>
    <table
        class="am-table am-table-bordered am-table-radius am-table-striped">
        <thead>
            <tr>
                <th>总表</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td> 
                <?php foreach($team_group as $ki => $vi) { ?>
                <td><?php echo isset($vi->team_name) ? $vi->team_name : ''; ?></td> 
                <?php } ?>
                <td>胜次</td>
                <td>净胜</td>
                <td>名次</td>
            </tr>
            <?php foreach($team_group as $key => $val) { ?>
            <tr>
                <td><?php echo isset($val->team_name) ? $val->team_name : ''; ?></td>
                 <?php foreach($team_group as $kii => $vii) { ?>
                <td>
                <?php if ($val->team_id==$vii->team_id) { ?>
                 <?php } else { ?>
                        <?php if (isset($team_match[$val->team_id][$vii->team_id]) ) { ?>
                        <?php if ($team_match[$val->team_id][$vii->team_id]->win_a+$team_match[$val->team_id][$vii->team_id]->win_b>0 ) { ?>
                             <a style="color: #52b2ff" href="/h5/member/activity/specail/four/score_sub_show?team_match_id=<?php echo isset($team_match[$val->team_id][$vii->team_id]->id) ? $team_match[$val->team_id][$vii->team_id]->id : ''; ?>">
                         <?php } ?>   
                            <?php echo isset($team_match[$val->team_id][$vii->team_id]->win_a) ? $team_match[$val->team_id][$vii->team_id]->win_a : ''; ?> :    <?php echo isset($team_match[$val->team_id][$vii->team_id]->win_b) ? $team_match[$val->team_id][$vii->team_id]->win_b : ''; ?>
                            <?php if ($team_match[$val->team_id][$vii->team_id]->win_a+$team_match[$val->team_id][$vii->team_id]->win_b>0 ) { ?>
                            </a>
                                <?php } ?>
                         <?php } else { ?>
                         
                            <?php if ($team_match[$vii->team_id][$val->team_id]->win_b+$team_match[$vii->team_id][$val->team_id]->win_a>0 ) { ?>
                             <a style="color: #52b2ff" href="/h5/member/activity/specail/four/score_sub_show?team_match_id=<?php echo isset($team_match[$vii->team_id][$val->team_id]->id) ? $team_match[$vii->team_id][$val->team_id]->id : ''; ?>">
                                <?php } ?>
                              <?php echo isset($team_match[$vii->team_id][$val->team_id]->win_b) ? $team_match[$vii->team_id][$val->team_id]->win_b : ''; ?> :  <?php echo isset($team_match[$vii->team_id][$val->team_id]->win_a) ? $team_match[$vii->team_id][$val->team_id]->win_a : ''; ?>
                                <?php if ($team_match[$vii->team_id][$val->team_id]->win_b+$team_match[$vii->team_id][$val->team_id]->win_a>0 ) { ?>
                              </a>
                                <?php } ?>
                        <?php } ?>
                    </a>
                 <?php } ?>
                    </td> 
                    <?php } ?>

                <td><?php echo isset($val->win_count) ? $val->win_count : ''; ?></td>
                <td><?php echo isset($val->win_count_all) ? $val->win_count_all : ''; ?></td>
                <td><?php echo $val->rank==10000?'':$val->rank; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
       </div>
   </div>



<div class="swiper-slide">
 <div class="content-slide">

  <textarea cols="" rows="" style="width:90%; float:left; margin-left:5%; border:1px solid #ddd; height:80px;">我也说两句</textarea>
  <div style="width:90%; float:left; margin-left:5%; margin-top:15px; text-align:right"><input type="button" value="评论">
  </div>



</div>
</div>









</div>
</div>
</div>
<style>/*表格斑马线*/
.table-striped tr {

}
.table-striped tr:nth-child(2n) {

}
.table-striped tr {
    background-color: expression((this.sectionRowIndex % 2 == 0) ? "#fff" : "#f3f3f3" );
}
.tuanduil a{ color:#333}
.wrap{margin:10px auto 0 auto;}
.tabs{height:32px;font-size:16px; border-bottom:1px solid #ddd;  }
.tabs a{display:block;float:left;width:24%;color:#333;text-align:center; line-height:30px;font-size:18px;text-decoration:none;}
.tabs a.active{color:#fff; border-bottom:2px solid #016BD8; font-size:18px; color:#016BD8;border-radius:5px 5px 0px 0px;}
.swiper-container{ color:#333; border-radius:0 0 5px 5px;width:100%; margin:0px; padding:0px;border-top:0;}
.swiper-slide{ width:100%;background:none;color:#333;font-size:12px;}
.content-slide{padding:15px;}
.content-slide p{text-indent:2em;line-height:1.9;}
.swiper-container {margin:0 auto;overflow:hidden;-webkit-backface-visibility:hidden;-moz-backface-visibility:hidden;-ms-backface-visibility:hidden;-o-backface-visibility:hidden;backface-visibility:hidden;/* Fix of Webkit flickering */	z-index:1;}
.swiper-wrapper {width:100%;
	-webkit-transition-property:-webkit-transform, left, top;
	-webkit-transition-duration:0s;
	-webkit-transform:translate3d(0px,0,0);
	-webkit-transition-timing-function:ease;
	
	-moz-transition-property:-moz-transform, left, top;
	-moz-transition-duration:0s;
	-moz-transform:translate3d(0px,0,0);
	-moz-transition-timing-function:ease;
	
	-o-transition-property:-o-transform, left, top;
	-o-transition-duration:0s;
	-o-transform:translate3d(0px,0,0);
	-o-transition-timing-function:ease;
	-o-transform:translate(0px,0px);
	
	-ms-transition-property:-ms-transform, left, top;
	-ms-transition-duration:0s;
	-ms-transform:translate3d(0px,0,0);
	-ms-transition-timing-function:ease;
	
	transition-property:transform, left, top;
	transition-duration:0s;
	transform:translate3d(0px,0,0);
	transition-timing-function:ease;

	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
}
.swiper-free-mode > .swiper-wrapper {
	-webkit-transition-timing-function: ease-out;
	-moz-transition-timing-function: ease-out;
	-ms-transition-timing-function: ease-out;
	-o-transition-timing-function: ease-out;
	transition-timing-function: ease-out;
	margin: 0 auto;
}
.swiper-slide {
	float: left;
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
    }</style>
    <script src="http://www.lanrenzhijia.com/ajaxjs/jquery-1.10.1.min.js"></script> 
    <script src="http://www.lanrenzhijia.com/ajaxjs/idangerous.swiper.min.js"></script> 
    <script>
    var tabsSwiper = new Swiper('.swiper-container',{
       speed:500,
       onSlideChangeStart: function(){
          $(".tabs .active").removeClass('active');
          $(".tabs a").eq(tabsSwiper.activeIndex).addClass('active');
      }
  });

    $(".tabs a").on('touchstart mousedown',function(e){
       e.preventDefault()
       $(".tabs .active").removeClass('active');
       $(this).addClass('active');
       tabsSwiper.swipeTo($(this).index());
   });

    $(".tabs a").click(function(e){
       e.preventDefault();
   });
    </script>
    <!-- 代码部分end -->
























<!--<div class="am-g" style=" padding:0px; border:none; margin:0px;">
    <div class="left-taolun">
        <p>即时讨论</p>

        <p class="jstlun">人</p>
    </div>
    <div class="right-taolun" style=" font-size:90%; padding-top:10px;">

        <img src="http://www.yilesai.com/assets/images/defeat.jpg" width="35" height="35" class="am-img-thumbnail am-circle"> 进来和小伙伴们一起聊聊吧


    </div>
    <span style="float:right; text-align:right; line-height:60px; margin-right:10px; font-size:120%; font-weight:bold; color:#ccc">></span>

</div>


<div class="grayline"></div>
-->









<div style="height:10px;"></div>
<!-- Footer -->
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default " id="">
    <ul class="am-navbar-nav am-cf am-avg-sm-4">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>

                <td colspan="2" valign="top" style="width:100%; background:#3399CC; color:#fff">

                                      <?php if (time()<strtotime ($detail->apply_start_time)) { ?>
                    <li class="bm">+预告 
                    </li>
                    <?php } elseif (time()>strtotime($detail->apply_start_time)&&time()<strtotime ($detail->apply_end_time)) { ?>
                    <li class="bm">
                        <?php if (count($team_data)>3) { ?>
                        <a href="#" style="color:#fff">队伍已满 </a>
                        <?php } else { ?>
                    <?php if ($detail->specail_config) { ?>
                        <a href="/h5/activity/join_four?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>" style="color:#fff">
                    <?php } else { ?>
                    <a href="/h5/activity/join?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>" style="color:#fff">
                    <?php } ?>
                        <?php } ?>

                    +报名 </a>
                    </li>
                    <?php } else { ?>
                    <li class="am-btn am-btn-default"><a href="#" style="color:#fff">报名已结束 </a></li>
                    <?php } ?>
                </td>
            </tr>
        </table>


    </ul>
</div>


<script src="http://www.yilesai.com/assets/js/jquery.min.js"></script>
<script src="http://www.yilesai.com/assets/js/amazeui.min.js"></script>
<script>

$(document).ready(function(){
  $("#chouqian").click(function(){
    $.post("/h5/activity/cqjieguo",
    {
      activity_id:209,
  },
  function(data,status){
    if(data.code==0){
        window.location.href='/h5/activity/cqjieguo?activity_id=209';
    }else{
        alert(data.msg);
    }
}
);
});
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    $("#fbtnidhh").click(function () {
        var $this = $(this);
        $.post("/h5/member/club/join",
        {
            club_id: 54                    },

            function (data, status) {
                if (data.code == 0) {
                    $("#teeee").text(data.msg);
                } else {
                   $("#teeee").text(data.msg);
               }

           });
    });
});
</script>
<style>
li.sle a img {
    width: 80px;
    height: 40px;
}
</style>
</body>
</html>
