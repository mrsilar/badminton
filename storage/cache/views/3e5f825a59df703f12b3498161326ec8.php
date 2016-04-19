
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
		<h1 align="center" class="am-header-title">人员调整</h1>
	</header>
	<div>

		<?php foreach((array) $team_match as $r) { ?> 
		<a style="color: #52b2ff" href="/h5/member/activity/specail/four/chang_team?team_match_id=<?php echo isset($r->id) ? $r->id : ''; ?>"> 
			<?php echo isset($r->team_a_name) ? $r->team_a_name : ''; ?>~ <?php echo isset($r->team_b_name) ? $r->team_b_name : ''; ?>
			</a>
		<hr data-am-widget="divider" style=""
			class="am-divider am-divider-default" />
		<?php } ?> <?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
		<script src="/assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
		<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>