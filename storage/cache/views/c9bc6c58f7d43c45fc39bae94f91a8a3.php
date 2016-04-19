<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>抽签结果</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="icon" type="image/png" href="assets/i/favicon.png">
<link rel="stylesheet" href="/assets/css/amazeui.min.css">
<link rel="stylesheet" href="/assets/css/app.css">
<link rel="stylesheet" href="http://s.amazeui.org/assets/2.x/css/amaze.min.css?v=ifp65slu">
</head>
<body>
<div align="center">
  <!-- Header -->
</div>
<header data-am-widget="header"
          class="am-header am-header-default">
  <div class="am-header-left am-header-nav">
    <div align="center"><a href="javascript:history.go(-1)" class=""> <img  src="/assets/images/jtou.png"/> </a> </div>
  </div>
  <h1 class="am-header-title"> 抽签结果 </h1>
  <div class="am-header-right am-header-nav"> <img src="/assets/images/search-vector.png" > </div>
</header>
<!-- Menu -->
<div class="am-g">
  <div class="am-u-sm-8 lineleft " style="line-height:40px;">队伍名称</div>
  <div class="am-u-sm-4 lineright" style="line-height:40px;">排序</div> 
<?php foreach((array) $list as $row) { ?>
  <a href="/h5/team/show/<?php echo isset($row->id) ? $row->id : ''; ?>"><div class="am-u-sm-8 lineleft" style="line-height:60px;"> <img src="/assets/images/qun-icon.png" style="margin-right:5px" class="am-img-thumbnail am-circle" width="40" height="40"><?php echo isset($row->name) ? $row->name : ''; ?></div></a>
  <div class="am-u-sm-4 lineright" style="height:61px;line-height:60px;"><?php if ($row->draw_id) { ?><?php echo isset($row->draw_id) ? $row->draw_id : ''; ?> <?php } else { ?>未抽签 <?php } ?><span style="padding-right:5px; color:#999; float:right; text-align:right; font-size:120%">></span></div>
 

<?php } ?>

</div>
<!-- Footer -->
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default "
     id="">
  <ul class="am-navbar-nav am-cf am-avg-sm-4">
    <li> <a href="lequan.html"> <span><img src="/assets/images/saiyouquan.png"></span> <span class="am-navbar-label">乐圈 </span> </a> </li>
    <li> <a href="faxian.html"> <span ><img src="/assets/images/faxian.png"></span> <span class="am-navbar-label">发现</span> </a> </li>
    <li class="sle"> <a href="index.html"><img src="/assets/images/yuesai.png" width="80" border="0"></a> </li>
    <li> <a href="xiaoxi.html"> <span><img src="/assets/images/ems.png"></span> <span class="am-navbar-label">消息</span> </a> </li>
    <li> <a href="login.html"> <span><img src="/assets/images/my.png"></span> <span class="am-navbar-label">我的</span> </a> </li>
  </ul>
</div>
<script src="http://wx.haijiayou.com/me/public/assets/js/jquery.min.js"></script>
<script src="http://wx.haijiayou.com/me/public/assets/js/amazeui.min.js"></script>
<style>
li.sle a img{ width:80px; height:40px;}
</style>
</body>
</html>
