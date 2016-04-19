<!doctype html>
<html class="no-js">
<head>
    <?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
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
    <h1 class="am-header-title"> <?php echo isset($detail['team_info']->name) ? $detail['team_info']->name : ''; ?> </h1>
    <div class="am-header-right am-header-nav"> <img src="/assets/images/search-vector.png" > </div>
</header>
<!-- Menu --><div class="am-container" style="padding-top:30px;">
<?php foreach((array) $detail['list'] as $row) { ?>
<?php echo isset($row->user_team_member_info->name) ? $row->user_team_member_info->name : ''; ?>&nbsp;&nbsp;<?php echo $row->user_team_member_info->sex==1?'男':'女'; ?>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
<?php } ?> </div>
<!-- Footer -->
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<style>
    li.sle a img{ width:80px; height:40px;}
</style>
</body>
</html>
