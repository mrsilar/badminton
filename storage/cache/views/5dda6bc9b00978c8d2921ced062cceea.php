<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
</head>
<body>
	<header data-am-widget="header" class="am-header am-header-default">
		<div class="am-header-left am-header-nav">
			<div align="center">
				<a href="javascript:history.go(-1)" class=""> <img
					src="/assets/images/jtou.png" />
				</a>
			</div>
		</div>
		<h1 align="center" class="am-header-title">第2阶段比赛结果</h1>
	</header>

	<table class="am-table">

		<thead>
			<tr>
				<th>队伍名称</th>
				<th>名次</th>
				<th>胜次</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach((array) $rank as $r) { ?>
			<tr>
				<td><?php echo isset($r->team_name) ? $r->team_name : ''; ?></td>
				<td><?php echo $r->rank==10000?'暂无':$r->rank; ?></td>
				<td><?php echo $r->win_count?:'暂无'; ?></td>
			</tr>
		</tbody>
		<?php } ?>
	</table>

	<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
		
	</script>
</body>
</html>