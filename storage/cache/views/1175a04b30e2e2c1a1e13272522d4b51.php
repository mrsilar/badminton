<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
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
				<th>人员调整</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td> 
				<?php foreach($team_group as $ki => $vi) { ?>
				<td><?php echo isset($vi->team_name) ? $vi->team_name : ''; ?></td> 
				<?php } ?>
			</tr>
			<?php foreach($team_group as $key => $val) { ?>
			<tr>
				<td><?php echo isset($val->team_name) ? $val->team_name : ''; ?></td>
				 <?php foreach($team_group as $kii => $vii) { ?>
				<td>
				<?php if ($val->team_id==$vii->team_id) { ?>
				 <?php } else { ?>
						<?php if (isset($team_match[$val->team_id][$vii->team_id]) ) { ?>
						<?php if ($team_match[$val->team_id][$vii->team_id]->win_a+$team_match[$val->team_id][$vii->team_id]->win_b==0 ) { ?>
							 <a style="color: #52b2ff" href="/h5/member/activity/specail/four/chang_team?team_match_id=<?php echo isset($team_match[$val->team_id][$vii->team_id]->id) ? $team_match[$val->team_id][$vii->team_id]->id : ''; ?>">
						 <?php } ?>   
						    <?php echo isset($team_match[$val->team_id][$vii->team_id]->win_a) ? $team_match[$val->team_id][$vii->team_id]->win_a : ''; ?> :	<?php echo isset($team_match[$val->team_id][$vii->team_id]->win_b) ? $team_match[$val->team_id][$vii->team_id]->win_b : ''; ?>
						  	<?php if ($team_match[$val->team_id][$vii->team_id]->win_a+$team_match[$val->team_id][$vii->team_id]->win_b==0 ) { ?>
						    </a>
						    	<?php } ?>
						 <?php } else { ?>
						 
						 	<?php if ($team_match[$vii->team_id][$val->team_id]->win_b+$team_match[$vii->team_id][$val->team_id]->win_a==0 ) { ?>
						 	 <a style="color: #52b2ff" href="/h5/member/activity/specail/four/chang_team?team_match_id=<?php echo isset($team_match[$vii->team_id][$val->team_id]->id) ? $team_match[$vii->team_id][$val->team_id]->id : ''; ?>">
						      	<?php } ?>
						      <?php echo isset($team_match[$vii->team_id][$val->team_id]->win_b) ? $team_match[$vii->team_id][$val->team_id]->win_b : ''; ?> :	<?php echo isset($team_match[$vii->team_id][$val->team_id]->win_a) ? $team_match[$vii->team_id][$val->team_id]->win_a : ''; ?>
						       	<?php if ($team_match[$vii->team_id][$val->team_id]->win_b+$team_match[$vii->team_id][$val->team_id]->win_a==0 ) { ?>
						      </a>
						      	<?php } ?>
						<?php } ?>
					</a>
				 <?php } ?>
					</td> 
					<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
		
	</script>
</body>
</html>
