<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>赛况</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="http://s.amazeui.org/assets/2.x/css/amaze.min.css?v=ifp65slu">
    <style>
        li.sle a img {
            width: 80px;
            height: 40px;
        }

        .z-game {
            border-bottom: 1px solid #ddd;
            text-align: center;
            width: 100%;
        }

        .z-game-info {
            background: #66CCFF;
            font-size: 12px;
        }

        .z-game-info .fbtn {
            margin: auto;
        }
    </style>
</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 赛况 </h1>
</header>
<!-- Menu -->
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <!--列表标题-->
    
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">
  <tr>
    <td width="50%" align="left" valign="middle"><a href="/h5/activity/cqjieguo?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class=""><img src="/assets/images/chouqiujieguo.png" width="98%"></a></td>
    <td width="50%" align="right" valign="middle"><a href="/h5/activity/group?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class=""><img src="/assets/images/feizu.png" width="98%"></a></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle" style="padding-top:10px;"><a href="/h5/activity/resultlist?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class=""><img src="/assets/images/vsicon.png" width="100%"></a></td>
    </tr>
</table>

	
	<!--
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:80px;">
  <tr>
    <td width="33%" align="center" valign="middle"><a href="/h5/activity/cqjieguo?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class=""><img src="/assets/images/chouq.png" width="90" height="90"><br>抽签结果</a>
</td>
    <td width="33%" align="center" valign="middle"> <a href="/h5/activity/group?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class=""><img src="/assets/images/qunzu.png" width="90" height="90"><br>
分组结果</a></td>
    <td width="33%" align="center" valign="middle"><a href="/h5/activity/resultlist?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class=""><img src="/assets/images/vs.png" width="90"><br>
比赛结果</a></td>
  </tr>
</table>
-->
	
	
	
	
	
	
	
	
	
	
	<!--<a href="/h5/activity/cqjieguo?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class="">
        <div class="am-list-news-hd am-cf">
            <!--带更多链接-->

           <!-- <h2>抽签结果</h2>
            <span class="am-list-news-more am-fr"> &raquo;</span>

        </div>
    </a>
    <hr>
    <a href="/h5/activity/group?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class="">
        <div class="am-list-news-hd am-cf">
            <!--带更多链接-->

           <!-- <h2>分组结果</h2>
            <span class="am-list-news-more am-fr"> &raquo;</span>
        </div>
    </a>
    <hr>
    <a href="/h5/activity/resultlist?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>" class="">
        <div class="am-list-news-hd am-cf">--> 
            <!--带更多链接-->
            <!--<h2>比赛结果</h2>
            <span class="am-list-news-more am-fr"> &raquo;</span>
        </div>
    </a>-->
</div>


<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
