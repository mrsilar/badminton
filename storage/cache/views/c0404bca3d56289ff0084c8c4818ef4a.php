<!doctype html>
<html class="no-js">
<head>
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 报名队伍修改 </h1>
</header>
<ul class="am-list am-list-static am-list-border">
    <?php foreach((array) $team_list as $row) { ?>
    <li><a style="color: #52b2ff" href="/h5/activity/edit_join?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>&team_id=<?php echo isset($row->id) ? $row->id : ''; ?>"> <?php echo isset($row->name) ? $row->name : ''; ?></a>
    </li>
    <?php } ?>
</ul>
<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
</body>
</html>