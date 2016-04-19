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
		<h1 align="center" class="am-header-title">分组</h1>
	</header>
	<div>
		<table class="am-table">
			<thead>

			</thead>
			<tbody>
				<?php foreach($all_team_match as $ka => $va) { ?>
				<tr>
					<td>第<?php echo isset($ka) ? $ka : ''; ?>阶段</td> <?php foreach($va as $kb => $vb) { ?>
					<td><?php echo isset($vb->team_a_name) ? $vb->team_a_name : ''; ?><br><?php echo isset($vb->team_b_name) ? $vb->team_b_name : ''; ?>
					</td> <?php } ?>
				</tr>
				<?php } ?>
			</tbody>

		</table>
	</div>
	<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>