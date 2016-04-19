<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
</head>
<body>
<a href="/h5/activity/show/<?php echo isset($activity_id) ? $activity_id : ''; ?>">返回(只能选着8-10人)</a>   
<br>
<form action="/h5/activity/join_four" method="post">
	<br>队伍名称:<?php echo isset($club_info->name) ? $club_info->name : ''; ?> 俱乐部--
<input type="text" name="team_name"  value=""/><br>
	队员:<br>
<?php foreach((array) $list as $v) { ?>
 <?php echo isset($v->mem_name) ? $v->mem_name : ''; ?><input name="person[]" type="checkbox" value="<?php echo isset($v->user_team_member_id) ? $v->user_team_member_id : ''; ?>"   >
<?php } ?>

<input type="hidden" name="activity_id"  value="<?php echo isset($activity_id) ? $activity_id : ''; ?>"/>
<input type="hidden" name="club_name"  value="<?php echo isset($club_info->name) ? $club_info->name : ''; ?>"/><br>
  <input type="submit" value="提交" />
</form>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>
