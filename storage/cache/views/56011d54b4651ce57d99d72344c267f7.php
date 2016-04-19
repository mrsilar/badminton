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
	</header>
	<!-- Menu -->
	<table
		class="am-table am-table-bordered am-table-radius am-table-striped">
		<thead>
			<tr>
				<th><?php echo isset($team_match->team_a_name) ? $team_match->team_a_name : ''; ?>&nbsp;&nbsp;<?php echo isset($team_match->team_b_name) ? $team_match->team_b_name : ''; ?></th>
			</tr>
		</thead>
		<tbody>

		<tr>
			<td></td>
			<?php foreach($team_item_b as $ki => $vi) { ?>
			<td>
			<?php foreach((array) $vi as $vio) { ?>
				<?php echo isset($vio->name) ? $vio->name : ''; ?>&nbsp;
				<?php echo isset($vio->sex) ? $vio->sex : ''; ?><br>
			<?php } ?>
				
			</td>
			<?php } ?>
		</tr>
			<?php foreach($team_item_a as $ka => $va) { ?>
			<tr>
				<td>
			<?php foreach((array) $va as $vio) { ?>
				<?php echo isset($vio->name) ? $vio->name : ''; ?>&nbsp;
				<?php echo isset($vio->sex) ? $vio->sex : ''; ?><br>
			<?php } ?>  
				</td>
				<?php foreach($team_item_b as $kb => $vb) { ?>
				<td>
				<?php if (isset($team_member_match[$ka][$kb])) { ?>
					<?php echo isset($team_member_match[$ka][$kb]->win_a_count) ? $team_member_match[$ka][$kb]->win_a_count : ''; ?>:<?php echo isset($team_member_match[$ka][$kb]->win_b_count) ? $team_member_match[$ka][$kb]->win_b_count : ''; ?>
				<?php } ?>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
		
	</script>
</body>
</html>
