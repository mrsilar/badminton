<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>
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
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>

    </div>
    <h1 class="am-header-title"><a href="#title-link">活动详情</a></h1>

    <div class="am-header-right am-header-nav">
        <div data-am-widget="navbar" id="">
            <ul style="float:left; margin:0px; padding:0px; list-style-type:none">
                <li data-am-navbar-share><a href="###" style="color:#fff"> <img src="/assets/images/share.png"> </a>
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
            <img src="/assets/images/xin.png" width="20"> <br>12<!--<?php echo isset($row->status) ? $row->status : ''; ?></div>-->
        <img src="<?php echo isset($detail->cover_img) ? $detail->cover_img : ''; ?>" width="100%" style="  height:250px;"/></div>
    <div class="am-g" style="width:100%; margin:0px; border:none;  text-align:center; padding:0px;">
        <div class="am-u-sm-12" style="width:100%; margin:0px; padding:0px;">
       <!--     <h3 class="am-gallery-title"
                style="margin: -25px 1px 0px; text-align:center; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff">
                <?php echo isset($detail->title) ? $detail->title : ''; ?><span class="quyuan"><?php echo isset($detail->city) ? $detail->city : ''; ?></span></h3>-->
				
				
				 <h3 class="am-gallery-title" style="margin: -50px 1px 0px; text-align:left; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff"><?php echo isset($detail->title) ? $detail->title : ''; ?>
		 <div style=" line-height:25px; padding-left:2px;text-align:left"><?php echo isset($detail->start_time) ? $detail->start_time : ''; ?><span class="quyuan"><?php echo isset($detail->city) ? $detail->city : ''; ?></span></div></h3>
				
				
				
				
				
        </div>
    </div>
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="timezhou">
        <tr>
            <td align="center"><p><?php echo date('m-d',strtotime($detail->apply_start_time)); ?></p>

                <div class="<?php echo strtotime($detail->apply_start_time)<time()?'fbtn':'fbtn-no'; ?>">报名</div>
            </td>
            <td align="center"><p><?php echo date('m-d',strtotime($detail->apply_end_time)); ?></p>

                <div class="<?php echo strtotime($detail->apply_end_time)<time()?'fbtn':'fbtn-no'; ?>">抽签</div>
            </td>
            <td align="center"><p><?php echo date('m-d',strtotime($detail->start_time)); ?></p>

                <div class="<?php echo strtotime($detail->start_time)<time()?'fbtn':'fbtn-no'; ?>">比赛</div>
            </td>
            <td align="center"><p><?php echo date('m-d',strtotime($detail->end_time)); ?></p>

                <p>

                <div class="<?php echo strtotime($detail->end_time)<time()?'fbtn':'fbtn-no'; ?>">成绩</div>
                </p>
            </td>
        </tr>
    </table>
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
    <div class="am-gallery-desc bms"><img src="/assets/images/rqi.png" width="20"><?php echo date('m-d',strtotime($detail->start_time)); ?>（周<?php echo isset($detail->date_x) ? $detail->date_x : ''; ?>）至<?php echo date('m-d',strtotime($detail->end_time)); ?>（周<?php echo isset($detail->date_y) ? $detail->date_y : ''; ?>）
        <!--<?php echo isset($detail->start_time) ? $detail->start_time : ''; ?>-<?php echo isset($detail->end_time) ? $detail->end_time : ''; ?>--></div>
    <?php if ($detail->postion) { ?>
    <div class="am-gallery-desc bms"><img src="/assets/images/didian.png" width="20"><?php echo isset($detail->postion) ? $detail->postion : ''; ?></div>
    <?php } ?>
</div>

<div class="grayline"></div>

<hr data-am-widget="divider" class="am-divider am-divider-dashed" style="margin:0px; padding:0px; margin-bottom:5px;"/>

<!--<div class="am-g" style=" padding:0px; border:none; margin:0px;">
    <div class="left-taolun">
        <p>即时讨论</p>

        <p class="jstlun"><?php echo isset($detail->join_count) ? $detail->join_count : ''; ?>人</p>
    </div>
    <div class="right-taolun" style=" font-size:90%; padding-top:10px;">

        <img src="/assets/images/defeat.jpg" width="35" height="35" class="am-img-thumbnail am-circle"> 进来和小伙伴们一起聊聊吧


    </div>
    <span style="float:right; text-align:right; line-height:60px; margin-right:10px; font-size:120%; font-weight:bold; color:#ccc">></span>

</div>


<div class="grayline"></div>
-->

<a href="/h5/activity/mingdangs?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>" data-rel="divider">
    <div class="am-g" style=" padding:0px; border:none; margin:0px; padding-top:5px;">
        <div class="left-taolun">
            <p style="line-height:50px; height:50px;">参赛名单</p>
        </div>
        <div class="right-taolun">

            <img src="/assets/images/defeat1.jpg" width="50" height="50" class="am-img-thumbnail am-circle"> 


        </div>
        <span style="float:right; text-align:right; line-height:60px; margin-right:10px; font-size:120%; font-weight:bold; color:#ccc">></span>

    </div>
</a>

<div class="grayline"></div>


<div class="am-g" style=" padding:0px; border:none; margin:0px; padding-top:5px;">
    <div class="left-taolun" style="border:none">
        <p><img src="/assets/images/defeat.jpg" width="50" height="50"></p>

        <p class="fabyren">发布人</p>
    </div>
    <div class="right-taolun3">

        <p class="fabutitle"> <?php echo isset($club->name) ? $club->name : ''; ?></p>

        <p><?php echo isset($club->summary) ? $club->summary : ''; ?></p>


    </div>
    <a href="tel:<?php echo isset($detail->link_phone) ? $detail->link_phone : ''; ?>">
        <span style="float:right; text-align:center; line-height:60px; margin-right:10px; font-size:120%; font-weight:bold; color:#999"><img
                src="/assets/images/dhuan.jpg" width="40"></span></a>

</div>

<div class="grayline"></div>


<div class="am-tabs" data-am-tabs>
    <ul class="am-tabs-nav am-nav am-nav-tabs">
        <li class="am-active"><a href="#tab1">活动介绍</a></li>
    </ul>

    <div class="am-tabs-bd" style="color:#666; font-size:90%">
        <div class="am-tab-panel am-fade am-in am-active" id="tab1">
            <?php echo isset($detail->introduction) ? $detail->introduction : ''; ?>
        </div>
    </div>
</div>


<div style="height:10px;"></div>
<!-- Footer -->
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default " id="">
    <ul class="am-navbar-nav am-cf am-avg-sm-4">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <?php if ($can_draw) { ?>
                <td width="25%" align="center" valign="top" style="border-right:1px solid #ddd">
                    <li>
                        <a href="javascript:void(0)"   id="chouqian"> 
						<span><img src="/assets/images/xinshare.png" width="20"></span> 
						<span class="am-navbar-label" style="padding-bottom:8px;">抽签 </span>
                        </a>
                    </li>
                </td>
                <?php } ?>
                <td width="25%" align="center" valign="top" style="border-right:1px solid #ddd">
                    <li>
                        <a href="/h5/activity/saikuang?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>"> <span><img
                                src="/assets/images/faxian.png"></span> <span class="am-navbar-label" style="padding-bottom:8px;">实时状况</span>
                        </a>
                    </li>
                </td>
                <td colspan="2" valign="top" style="width:100%; background:#3399CC; color:#fff">

                    <?php if (time()<strtotime ($detail->apply_start_time)) { ?>
                    <li class="bm">+预告 
                    </li>
                    <?php } elseif (time()>strtotime($detail->apply_start_time)&&time()<strtotime ($detail->apply_end_time)) { ?>
                    <li class="bm">
                    <?php if ($detail->specail_config) { ?>
                        <a href="/h5/activity/join_four?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>" style="color:#fff">
                    <?php } else { ?>
                    <a href="/h5/activity/join?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>" style="color:#fff">
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

<div class="lxwmsl" style="padding-bottom:100px;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="40">
  <tr>
    <td align="center" valign="middle"><img src="/assets/images/lxwm.png" width="25"> 
	
	
	<button
  type="button" style="border:none; background:none;color:#666"
  class="am-btn am-btn-primary"
  data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 280, height: 200}">
  联系
</button>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1" style="width:80%">
  <div class="am-modal-dialog">
    <div class="am-modal-hd" style="border-bottom:1px solid #ddd;  margin-bottom:15px;">联系方式
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd" style="text-align:left">
     <p>电话：<?php echo $detail->link_phone?:'暂无'; ?></p>
	 <p>E-Mail:<?php echo $detail->link_mail?:'暂无'; ?></p>　
    </div>
  </div>
</div>
	</td>
    <td align="center"><img src="/assets/images/gzmy.png" width="25">	<button
  id="fbtnidhh"  type="button" style="border:none; background:none;color:#666"
  class="am-btn am-btn-primary"
  data-am-modal="{target: '#doc-modal-2', closeViaDimmer: 0, width: 250, height: 150}">
  关注
</button>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-2" style="width:80%">
  <div class="am-modal-dialog">
    <div class="am-modal-hd" >
      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
    </div>
    <div class="am-modal-bd">
     <p  id="teeee"></p> 
    </div>
  </div>
</div> </td>
    <td align="center"><a href="/h5/activity/pinglun?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>"><img src="/assets/images/gzwm.png" width="25">评论</a></td>
  </tr>
</table>



</div>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script>

$(document).ready(function(){
  $("#chouqian").click(function(){
        $.post("/h5/activity/cqjieguo",
        {
          activity_id:<?php echo isset($detail->id) ? $detail->id : ''; ?>,
        },
        function(data,status){
                if(data.code==0){
                window.location.href='/h5/activity/cqjieguo?activity_id=<?php echo isset($detail->id) ? $detail->id : ''; ?>';
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
                        club_id: <?php echo isset($club->id) ? $club->id : ''; ?>
                    },

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
