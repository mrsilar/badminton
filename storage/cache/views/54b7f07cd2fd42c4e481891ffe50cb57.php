<!doctype html>
<html class="no-js">
<head>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
</head>
<header data-am-widget="header" class="am-header am-header-default">
<div class="am-header-left am-header-nav">
<div align="center"><a href="javascript:history.go(-1)" class="">
<img src="/assets/images/jtou.png" /> </a></div>
</div>
<h1 align="center" class="am-header-title">队员调整</h1>
</header>
<?php if ($c_a) { ?> 
<?php echo isset($team_match->team_a_name) ? $team_match->team_a_name : ''; ?>
<hr data-am-widget="divider" style=""class="am-divider am-divider-default" />
<?php foreach((array) $c_a as $v) { ?> 
<?php foreach((array) $v['category_list'] as $vv) { ?>
<a style="color: #52b2ff"  href="/h5/member/activity/specail/four/change_member_last?type=a&mem_id=<?php echo isset($vv->id) ? $vv->id : ''; ?>&team_match_id=<?php echo isset($team_match->id) ? $team_match->id : ''; ?>"><?php echo isset($vv->name) ? $vv->name : ''; ?></a>
<br>
<?php } ?> 
 <?php } ?>
 <?php } ?> 
<?php if ($c_b) { ?>
<br>
<br>
 <?php echo isset($team_match->team_b_name) ? $team_match->team_b_name : ''; ?>
<hr data-am-widget="divider" style=""class="am-divider am-divider-default" />
<?php foreach((array) $c_b as $vi) { ?>
 <?php foreach((array) $vi['category_list'] as $vivi) { ?>
<a style="color: #52b2ff" href="/h5/member/activity/specail/four/change_member_last?type=b&mem_id=<?php echo isset($vv->id) ? $vv->id : ''; ?>&team_match_id=<?php echo isset($team_match->id) ? $team_match->id : ''; ?>"><?php echo isset($vivi->name) ? $vivi->name : ''; ?></a>  
<br>
<?php } ?> 
<?php } ?> 
<?php } ?> 
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>
