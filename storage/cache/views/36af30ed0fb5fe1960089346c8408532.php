<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>

</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="/h5/member/activity" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 选择阶段 </h1>
</header>
<!-- Menu -->
<ul class="am-list am-list-static am-list-border">
    <?php foreach((array) $turn as $ro) { ?>
    <li ><a href="/h5/member/activity/set/select?activity_turn_id=<?php echo isset($ro->id) ? $ro->id : ''; ?>"> 第<?php echo isset($ro->turn) ? $ro->turn : ''; ?>阶段</a></li>
    <?php } ?>
</ul>
<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
