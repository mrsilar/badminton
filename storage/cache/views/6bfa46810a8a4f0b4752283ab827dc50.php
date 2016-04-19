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
</header>
<!-- Menu -->
<ul class="am-list am-list-static am-list-border">
    <li ><a href="/h5/member/activity/specail/four/score?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>"> 计分</a></li>
    <li ><a href="/h5/member/activity/specail/four/rank?activity_turn_id=<?php echo isset($turn->id) ? $turn->id : ''; ?>&activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>"> 排名</a></li>
</ul>
<?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
