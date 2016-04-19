
<!doctype html>
<html class="no-js">
<head><meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>活动报名</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1, user-scalable=no,minimal-ui">
    <meta name="renderer" content="webkit">
    <meta name="apple-mobile-web-app-title" content="">
    <meta name="full-screen" content="yes">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="http://tiyu.haijiayou.com/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="http://tiyu.haijiayou.com/assets/css/app.css"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
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
            <div align="center"><a href="/h5/activity/show/<?php echo isset($activity_id) ? $activity_id : ''; ?>"> <img src="http://tiyu.haijiayou.com/assets/images/jtou.png"/> </a>
            </div>

        </div>
        <h1 class="am-header-title"><a href="#title-link">活动报名</a></h1>

       
</header>
<!-- Menu -->
      
<div style=" margin:auto; width:98%">
<form action="/h5/activity/join_four" method="post">
	<br>队伍名称:<?php echo isset($club_info->name) ? $club_info->name : ''; ?><br>
 俱乐部-
<input type="text" name="team_name"  value=""/><br>
	出场队员(至少提交8名队员):<br><br>
<div class="nle">
<ul >
<?php foreach((array) $list as $v) { ?>
<li> <?php echo isset($v->mem_name) ? $v->mem_name : ''; ?><input name="person[]" type="checkbox" value="<?php echo isset($v->user_team_member_id) ? $v->user_team_member_id : ''; ?>"   ></li>
<?php } ?>
</ul>
</div>
<input type="hidden" name="activity_id"  value="<?php echo isset($activity_id) ? $activity_id : ''; ?>"/>
<input type="hidden" name="club_name"  value="<?php echo isset($club_info->name) ? $club_info->name : ''; ?>"/><br>
  <input type="submit" value="提交"  style="border-radius:8px; width:80%; line-height:35px; background:#09F; border:1px solid #09C; float:left; margin-left:10%; margin-top:15px; color:#fff"/>
</form></div>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<style>
.nle ul{ float:left; width:100%; margin:0px; padding:0px; list-style-type:none}
.nle ul li{ float:left; width:24%; border-bottom:1px solid #ddd; line-height:30px;}
</style>

</body>
</html>
