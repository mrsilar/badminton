<!doctype html>
<html class="no-js">
<head>
<title>益乐空间</title>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
</head>
<body>
<style>.am-gallery-item img {height: 200px;}</style>
<!-- Header -->
<header data-am-widget="header" class="am-header am-header-default">
    <h1 class="am-header-title"><a href="#title-link">益乐空间</a></h1>
		
    <nav data-am-widget="menu" class="am-menu  am-menu-dropdown1" data-am-menu-collapse>
        <a href="javascript: void(0)" class="am-menu-toggle">
            <img src="/assets/images/fabu.png">
        </a>

 <ul class="am-menu-nav am-avg-sm-1 am-collapse">
            <li>
                <a href="/h5/member/activity/create" class="">发布通用活动</a></li>
            <li>
                <a href="/h5/member/activity/create_specail" class="">发布特色活动</a></li>
            <li>
                <a href="/h5/member/club/create" class="">创建俱乐部</a>
            </li>

        </ul> 
		
		  
    </nav>

</header>
<!-- Menu -->
<!-- Slider -->


<!--<div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{"directionNav":false}'>
  <!--<ul class="am-slides">
        <!--    <?php foreach((array) $img as $row) { ?>
            <li> <img src="<?php echo isset($row->img) ? $row->img : ''; ?>"><!-- <?php echo isset($row->title) ? $row->title : ''; ?> </li>
            <?php } ?>
 </ul>  <ul class="am-slides">
      <li>  <img src="/assets/images/fl01.jpg">
           
      </li>
      <li>
            <img src="/assets/images/fl02.jpg"> 
      </li>
      <li>
            <img src="/assets/images/fl03.jpg"> 
      </li>
  </ul>

</div>-->
<p style="margin:0px; padding:0px;"><img src="/assets/images/yundong.jpg" width="100%"></p>
<div style=" height:13px; float:left; background:#f0efed; width:100%;border-top:1px solid #ddd8ce; border-bottom:1px solid #ddd8ce"></div>
<p  style="margin:0px; padding:0px;"><img src="/assets/images/shouyeads.jpg" width="100%"></p>

<div style=" height:13px; float:left; background:#f0efed; width:100%;border-top:1px solid #ddd8ce;"></div>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2" style="background:#f9f9f9">
  <tr>
    <td rowspan="2" width="40%" style="border-right:10px solid #f0efed; background:#fff"><img src="/assets/images/wlin1.png" width="100%"></td>
    <td align="center" width="60%" style=" border-bottom:10px solid #f0efed"><img src="/assets/images/jkang.png" width="100%"> </td>
  </tr>
  <tr >
    <td align="center" bgcolor="#FFFFFF"><img src="/assets/images/saishi1.png" width="100%"></td>
  </tr>
</table>

<div style=" height:10px; float:left; background:#f0efed; width:100%;border-top:1px solid #ddd8ce; border-bottom:1px solid #ddd8ce"></div>
<!-- <div data-am-widget="tabs" class="am-tabs am-tabs-default">
    <ul class="am-tabs-nav am-cf">
        <li class="am-active"><a href="[data-tab-panel-0]">推荐活动 </a></li>
        <li class=""><a href="[data-tab-panel-1]">热门活动</a></li>
        <li class=""><a href="[data-tab-panel-2]">预告活动</a></li>
    </ul>
	<div style=" height:10px; float:left; background:#f0efed; width:100%;border-top:1px solid #ddd8ce;"></div>
    <div class="am-tabs-bd"
         style="border-width: medium 0px 0px;background:rgb(210,210,210) none repeat scroll 0% 0%;margin-bottom: -18px;">
        <?php foreach($list as $key => $r) { ?>
        <div data-tab-panel-{$key-1} class="am-tab-panel am-active" style="padding:0px">
            <?php foreach((array) $r as $row) { ?>
            <div class="am-comment"
                 style="padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-bottom: 10px;">
                <div class="am-gallery-item">
                    <a href="/h5/activity/show/<?php echo isset($row->id) ? $row->id : ''; ?>">
                        <!--        <div class="bmbtn" style="position: absolute;z-index: 1;background: rgba(126, 126, 126, 0.6) none repeat scroll 0% 0%;right: 5%;margin-top: 5px;border-radius: 5px;width: 45px;height: 45px;"><img src="/assets/images/xin.png" width="20"> <br>12<!--<?php echo isset($row->status) ? $row->status : ''; ?> </div>-->
                        <img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" width="100%" height="200"/></a>
                </div>
                <div class="am-g" style="width:100%; margin:0px; border:none; text-align:center; padding:0px;">
                    <div class="am-u-sm-12" style="width:100%; margin:0px;padding:0px;">
                        <h3 class="am-gallery-title"
                            style="margin: -50px 1px 0px; text-align:left; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff">
                            <?php echo isset($row->title) ? $row->title : ''; ?>
                            <div style=" line-height:25px; padding-left:2px;text-align:left"><?php echo isset($row->start_time) ? $row->start_time : ''; ?><span
                                    class="quyuan"><?php echo isset($row->city) ? $row->city : ''; ?></span></div>
                        </h3>
                    </div>
                </div>

            </div>
            <?php } ?>

        </div>
        <?php } ?>

    </div>
</div>
--> 
<!-- Gallery -->
<!-- Footer -->
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer-home'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<style>
    li.sle a img {
        width: 80px;
        height: 40px;
    }

    .am-comment {
        background: #fff;
    }
</style>


<!--<div style="width: 104%; height: 8px; background: rgba(167, 167, 167, 0.77) none repeat scroll 0% 0%; margin: 5px -10px;"></div>
                <!--<div class="am-g" style="border:none; width:100%; padding:0px; margin:0px;">
                    <div class="am-gallery-desc bms">
                        <a href="/h5/activity/show/<?php echo isset($row->id) ? $row->id : ''; ?>"> <img src="/assets/images/time.png" width="18"><?php echo isset($row->start_time) ? $row->start_time : ''; ?>-<?php echo isset($row->end_time) ? $row->end_time : ''; ?></a>
                    </div>
                    <div class="am-gallery-desc bms">
                        <a href="/h5/activity/show/<?php echo isset($row->id) ? $row->id : ''; ?>"><img src="/assets/images/dizhi.png" width="18"><?php echo isset($row->postion) ? $row->postion : ''; ?></a>
                    </div>
                    <?php if ($row->status=='报名中') { ?>
                    <a href="/h5/activity/join?activity_id=<?php echo isset($row->id) ? $row->id : ''; ?>">
                        <div class="bming">报名</div>
                    </a>
                    <?php } ?>
                </div>
                <div class="grayline5"></div>-->
<!--<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:80%">
    <tr>
        <td align="center" width="33%">已报名
            <br> <?php echo isset($row->join_count) ? $row->join_count : ''; ?>人
        </td>
        <td align="center" style="border-left:1px solid #ddd;border-right:1px solid #ddd;" width="33%">总人数
            <br> <?php echo isset($row->people_count) ? $row->people_count : ''; ?>人
        </td>
        <td align="center" width="33%">倒计时
            <br>
            <div class="time"> <span id="t_d<?php echo isset($row->id) ? $row->id : ''; ?>">00天</span> <span id="t_h<?php echo isset($row->id) ? $row->id : ''; ?>">00时</span> <span id="t_m<?php echo isset($row->id) ? $row->id : ''; ?>">00分</span> <!--<span id="t_s<?php echo isset($row->id) ? $row->id : ''; ?>">00秒</span></div>
            <script>
            function GetRTime() {
                var EndTime = new Date("<?php echo isset($row->start_time) ? $row->start_time : ''; ?>");
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
                    s = Math.floor(t / 1000 % 60);
                }


                document.getElementById("t_d<?php echo isset($row->id) ? $row->id : ''; ?>").innerHTML = d + "天";
                document.getElementById("t_h<?php echo isset($row->id) ? $row->id : ''; ?>").innerHTML = h + "时";
                document.getElementById("t_m<?php echo isset($row->id) ? $row->id : ''; ?>").innerHTML = m + "分";
                document.getElementById("t_s<?php echo isset($row->id) ? $row->id : ''; ?>").innerHTML = s + "秒";
            }
            setInterval(GetRTime, 0);
            </script>
        </td>
    </tr>
</table>-->
</body>

</html>
