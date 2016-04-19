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
		<h1 align="center" class="am-header-title">第<?php echo isset($turn) ? $turn : ''; ?>阶段计分</h1>
	</header>
	<div data-am-widget="tabs" class="am-tabs am-tabs-default">
		<div class="am-tabs-bd">

			<div data-tab-panel-1 class="am-tab-panel ">
				<?php foreach($team_group as $key => $row) { ?>
				<table
					class="am-table am-table-bordered am-table-radius am-table-striped">
					
					<tbody>
						<?php foreach((array) $row as $r) { ?>
						<tr>
							<td><?php echo isset($r->team_a_name) ? $r->team_a_name : ''; ?> ～<?php echo isset($r->team_b_name) ? $r->team_b_name : ''; ?></td>
							<td><a  style="color: #52b2ff" 
								href="/h5/member/activity/set/score_sub?team_match_id=<?php echo isset($r->id) ? $r->id : ''; ?>"><?php echo $r->win_a?:0; ?> : <?php echo $r->win_b?:0; ?></a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>

			</div>

		</div>


	</div>
	<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
		
	</script>
</body>
</html>
