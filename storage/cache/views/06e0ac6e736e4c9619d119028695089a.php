<!doctype html>
<html class="no-js">
<head>
<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>
<header data-am-widget="header" class="am-header am-header-default">
<div class="am-header-left am-header-nav">
<div align="center"><a href="javascript:history.go(-1)" class="">
<img src="/assets/images/jtou.png" /> </a></div>
</div>
<h1 align="center" class="am-header-title">队员调整</h1>
</header>
<?php if ($c_a && $team_match->team_a_mem_id == $user_id) { ?> 
<?php echo isset($team_match->team_a_name) ? $team_match->team_a_name : ''; ?>
<hr data-am-widget="divider" style=""class="am-divider am-divider-default" />
<?php foreach((array) $c_a as $v) { ?> 
<?php foreach((array) $v['category_list'] as $vv) { ?>
<div style="float:left;width:50%; border-bottom:1px solid #ddd; text-align:center"><a style="color: #52b2ff" href="/h5/member/activity/specail/four/change_member_last?category_member_id=<?php echo isset($vv->team_member_match_category_member_id) ? $vv->team_member_match_category_member_id : ''; ?>&type=a&mem_id=<?php echo isset($vv->id) ? $vv->id : ''; ?>&team_match_id=<?php echo isset($team_match->id) ? $team_match->id : ''; ?>"><?php echo isset($vv->name) ? $vv->name : ''; ?></a></div>
 
<?php } ?> 
 <?php } ?>
 <?php } ?> 
<?php if ($c_b && $team_match->team_b_mem_id == $user_id) { ?>
<br>
<br>
 <?php echo isset($team_match->team_b_name) ? $team_match->team_b_name : ''; ?>
<hr data-am-widget="divider" style=""class="am-divider am-divider-default" />
<?php foreach((array) $c_b as $vi) { ?>
 <?php foreach((array) $vi['category_list'] as $vivi) { ?>
<div style="float:left;width:50%; border-bottom:1px solid #ddd; text-align:center"><a style="color: #52b2ff" href="/h5/member/activity/specail/four/change_member_last?category_member_id=<?php echo isset($vivi->team_member_match_category_member_id) ? $vivi->team_member_match_category_member_id : ''; ?>&type=b&mem_id=<?php echo isset($vivi->id) ? $vivi->id : ''; ?>&team_match_id=<?php echo isset($team_match->id) ? $team_match->id : ''; ?>"><?php echo isset($vivi->name) ? $vivi->name : ''; ?></a>  
</div>
<?php } ?> 
<?php } ?> 
<?php } ?> 
<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>
