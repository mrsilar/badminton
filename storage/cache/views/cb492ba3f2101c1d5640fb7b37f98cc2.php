<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>

</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 选择阶段 </h1>
</header>
<!-- Menu -->
   	<div id="widget-list"><ul class="am-list m-widget-list" > 
    <?php foreach((array) $turn as $ro) { ?>
        <li ><a href="/h5/activity/groupinfo?activity_turn_id=<?php echo isset($ro->id) ? $ro->id : ''; ?>"> 第<?php echo isset($ro->turn) ? $ro->turn : ''; ?>阶段<span style="float:right; text-align:right; font-size:110%; padding-right:10px; color:#999">></span></a></li>
    <?php } ?>
    </ul> </div>
	
	
	
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
