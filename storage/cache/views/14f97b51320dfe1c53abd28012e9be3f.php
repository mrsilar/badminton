<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
</head>
<body>
<a href="/h5/activity/show/<?php echo isset($activity_id) ? $activity_id : ''; ?>">返回</a>   
<br>
<form action="/h5/activity/join_more" method="post">
<?php foreach((array) $person as $v) { ?>
 <?php echo isset($v->name) ? $v->name : ''; ?><input name="person[]" type="checkbox" value="<?php echo isset($v->id) ? $v->id : ''; ?>"   >
<?php } ?>
<input type="hidden" name="team_id"  value="<?php echo isset($team_id) ? $team_id : ''; ?>"/>
<input type="hidden" name="activity_id"  value="<?php echo isset($activity_id) ? $activity_id : ''; ?>"/><br>
  <input type="submit" value="添加" />
</form>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>
