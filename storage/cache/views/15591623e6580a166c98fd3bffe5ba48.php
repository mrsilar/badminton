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
	<a class="am-btn am-btn-success"   href="/h5/member/four/chang_table?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>">人员调整</a>
	<table
		class="am-table am-table-bordered am-table-radius am-table-striped">
		<thead>
			<tr>
				<th>总表</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td> 
				<?php foreach($team_group as $ki => $vi) { ?>
				<td><?php echo isset($vi->team_name) ? $vi->team_name : ''; ?></td> 
				<?php } ?>
				<td>胜次</td>
				<td>净胜</td>
				<td>名次</td>
			</tr>
			<?php foreach($team_group as $key => $val) { ?>
			<tr>
				<td><?php echo isset($val->team_name) ? $val->team_name : ''; ?></td>
				 <?php foreach($team_group as $kii => $vii) { ?>
				<td>
				<?php if ($val->team_id==$vii->team_id) { ?>
				 <?php } else { ?>
						<?php if (isset($team_match[$val->team_id][$vii->team_id]) ) { ?>
						<?php if ($team_match[$val->team_id][$vii->team_id]->win_a+$team_match[$val->team_id][$vii->team_id]->win_b>0 ) { ?>
							 <a style="color: #52b2ff" href="/h5/member/activity/specail/four/score_sub_show?team_match_id=<?php echo isset($team_match[$val->team_id][$vii->team_id]->id) ? $team_match[$val->team_id][$vii->team_id]->id : ''; ?>">
						 <?php } ?>   
						    <?php echo isset($team_match[$val->team_id][$vii->team_id]->win_a) ? $team_match[$val->team_id][$vii->team_id]->win_a : ''; ?> :	<?php echo isset($team_match[$val->team_id][$vii->team_id]->win_b) ? $team_match[$val->team_id][$vii->team_id]->win_b : ''; ?>
						  	<?php if ($team_match[$val->team_id][$vii->team_id]->win_a+$team_match[$val->team_id][$vii->team_id]->win_b>0 ) { ?>
						    </a>
						    	<?php } ?>
						 <?php } else { ?>
						 
						 	<?php if ($team_match[$vii->team_id][$val->team_id]->win_b+$team_match[$vii->team_id][$val->team_id]->win_a>0 ) { ?>
						 	 <a style="color: #52b2ff" href="/h5/member/activity/specail/four/score_sub_show?team_match_id=<?php echo isset($team_match[$vii->team_id][$val->team_id]->id) ? $team_match[$vii->team_id][$val->team_id]->id : ''; ?>">
						      	<?php } ?>
						      <?php echo isset($team_match[$vii->team_id][$val->team_id]->win_b) ? $team_match[$vii->team_id][$val->team_id]->win_b : ''; ?> :	<?php echo isset($team_match[$vii->team_id][$val->team_id]->win_a) ? $team_match[$vii->team_id][$val->team_id]->win_a : ''; ?>
						       	<?php if ($team_match[$vii->team_id][$val->team_id]->win_b+$team_match[$vii->team_id][$val->team_id]->win_a>0 ) { ?>
						      </a>
						      	<?php } ?>
						<?php } ?>
					</a>
				 <?php } ?>
					</td> 
					<?php } ?>

				<td><?php echo isset($val->win_count) ? $val->win_count : ''; ?></td>
				<td><?php echo isset($val->win_count_all) ? $val->win_count_all : ''; ?></td>
				<td><?php echo $val->rank==10000?'':$val->rank; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<table class="am-table">
    <thead>
        <tr>
            <th>第一轮</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($team_match_data as $k => $v) { ?>
	<?php if ($k==0||$k==1) { ?>
        <tr>
            <td><?php echo isset($v->team_a_name) ? $v->team_a_name : ''; ?></td>
            <td>vs</td>
            <td><?php echo isset($v->team_b_name) ? $v->team_b_name : ''; ?></td>
        </tr>
	<?php } ?>
        <?php } ?>
    </tbody>
</table>
	<table class="am-table">
		<thead>
		<tr>
			<th>第二轮</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($team_match_data as $k => $v) { ?>
		<?php if ($k==2||$k==3) { ?>
		<tr>
			<td><?php echo isset($v->team_a_name) ? $v->team_a_name : ''; ?></td>
			<td>vs</td>
			<td><?php echo isset($v->team_b_name) ? $v->team_b_name : ''; ?></td>
		</tr>
		<?php } ?>
		<?php } ?>
		</tbody>
	</table>
	<table class="am-table">
		<thead>
		<tr>
			<th>第三轮</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($team_match_data as $k => $v) { ?>
		<?php if ($k==4||$k==5) { ?>
		<tr>
			<td><?php echo isset($v->team_a_name) ? $v->team_a_name : ''; ?></td>
			<td>vs</td>
			<td><?php echo isset($v->team_b_name) ? $v->team_b_name : ''; ?></td>
		</tr>
		<?php } ?>
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
