<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>

</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 选择操作 </h1>
</header>
<!-- Menu -->
<ul class="am-list am-list-static am-list-border">
    <li ><a href="/h5/member/activity/set/group?activity_turn_id=<?php echo isset($turn->id) ? $turn->id : ''; ?>"> 分组</a></li>
    <li ><a href="/h5/member/activity/chang_table?activity_turn_id=<?php echo isset($turn->id) ? $turn->id : ''; ?>"> 人员调整</a></li>
    <li ><a href="/h5/member/activity/set/score?activity_turn_id=<?php echo isset($turn->id) ? $turn->id : ''; ?>"> 计分</a></li>
    <li ><a href="/h5/member/activity/set/rank?activity_turn_id=<?php echo isset($turn->id) ? $turn->id : ''; ?>"> 排名</a></li>
</ul>
<?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
