<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
<style>
.z-mask{display:none;z-index:10;position:fixed;width:100%;height:100%;top:0;left:0;background-color:white;padding-top:2em;overflow-y:scroll;padding-bottom:100px;}
.z-team{border-bottom:1px solid #ddd;text-align:center;width:100%;}
.z-team td{border:1px solid #ddd;}
h2 {margin-top:10px !important;}
input{display:inline-block;width:60px !important;}
</style>
</head>
<body>
	<header data-am-widget="header" class="am-header am-header-default">
		<div class="am-header-left am-header-nav">
			<div align="center">
				<a href="/h5/member/activity" class=""> <img
					src="/assets/images/jtou.png" />
				</a>
			</div>
		</div>
	</header>
	<!--弹出层-->
	<div class="z-mask s-mask">
		<div>

			<div>
				<table class="z-team" cellpadding="0" cellspacing="0">
					<tr>
						<td class="s-name-a"></td>
						<td class="s-name-b"></td>
					</tr>
					<tr>
						<td class="s-score-a"></td>
						<td class="s-score-b"></td>
					</tr>
				</table>
				<div class="am-u-sm-12" style="padding-top:20px;"> 
					<div class="am-u-sm-6">
						<input value=0 type="text" class="a"  onfocus="value =''" >
					</div>
					<div class="am-u-sm-6">
						<input value=0 type="text" class="b"  onfocus="value =''" >
					</div>
				</div>

				<div class="am-u-sm-12" style="padding-top:20px; text-align:right;">
				<?php if ($activity->score_system>0) { ?>(<?php echo isset($activity->score_system) ? $activity->score_system : ''; ?>分制)<?php } ?><br>
					<button type="button" class="am-btn am-btn-primary s-cancel">取消</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="button" class="am-btn am-btn-primary s-submit">提交比分</button>	
				</div>
			</div>
		</div>
	</div>
	<!-- Menu -->
	<table
		class="am-table am-table-bordered am-table-radius am-table-striped">
		<thead>
			<tr>
				<th><?php echo isset($team_match->team_a_name) ? $team_match->team_a_name : ''; ?>&nbsp;<?php echo isset($team_match->team_b_name) ? $team_match->team_b_name : ''; ?></th>
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
						<td style="color: #52b2ff"  class="s-item"
				name-a="<?php foreach((array) $va as $vio) { ?><?php echo isset($vio->name) ? $vio->name : ''; ?>&nbsp;&nbsp;<?php echo isset($vio->sex) ? $vio->sex : ''; ?>&nbsp;&nbsp;<?php } ?>  "
				 name-b="<?php foreach((array) $vb as $vio) { ?><?php echo isset($vio->name) ? $vio->name : ''; ?>&nbsp;&nbsp;	<?php echo isset($vio->sex) ? $vio->sex : ''; ?>&nbsp;&nbsp;	<?php } ?>  "
				 match-id="<?php echo isset($team_member_match[$ka][$kb]->id) ? $team_member_match[$ka][$kb]->id : ''; ?>"
				 score-a="<?php echo isset($team_member_match[$ka][$kb]->win_a_count) ? $team_member_match[$ka][$kb]->win_a_count : ''; ?>"
				 score-b="<?php echo isset($team_member_match[$ka][$kb]->win_b_count) ? $team_member_match[$ka][$kb]->win_b_count : ''; ?>"
				  score-time="1"
				  >
			<?php if (isset($team_member_match[$ka][$kb])) { ?>
				    <?php echo isset($team_member_match[$ka][$kb]->win_a_count) ? $team_member_match[$ka][$kb]->win_a_count : ''; ?>:
					<?php echo isset($team_member_match[$ka][$kb]->win_b_count) ? $team_member_match[$ka][$kb]->win_b_count : ''; ?>
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
	var actId=<?php echo isset($activity_id) ? $activity_id : ''; ?>;
		$(function(){
			//获取要编辑的对象
			var $mask=$(".z-mask");
			var $title=$(".s-title");
			var $nameA=$(".s-name-a");
			var $nameB=$(".s-name-b");
			var $scoreA=$(".s-score-a");
			var $scoreB=$(".s-score-b");
			var $matchId=$(".s-match-id");
			var $activityId=$(".s-activity-id");
			var $inputA=$(".a");
			var $inputB=$(".b");
			var $scoreTime=$(".s-score-time");
			//数据变量
			var DATA_INFO={
					scoreAi:$inputA,
					scoreBi:$inputB,
					matchId:$matchId,
					activityId:$activityId
			};
			var DATA_SCORE={};
			var current_match=null;
			//填充弹出层数据
			function addData(data){
				DATA_SCORE=data;
				$title.html(DATA_SCORE.nameA+" VS "+DATA_SCORE.nameB);
				$nameA.html(DATA_SCORE.nameA);
				$nameB.html(DATA_SCORE.nameB);
				$scoreA.html(DATA_SCORE.scoreA);
				$scoreB.html(DATA_SCORE.scoreB);
				$inputA.val(<?php echo isset($activity->score_system) ? $activity->score_system : ''; ?>);
				$inputB.val(<?php echo isset($activity->score_system) ? $activity->score_system : ''; ?>);
				$scoreTime.html("已打分 "+DATA_SCORE.scoreTime+" 次,共3次机会");
			}
			//点击编辑项
			$(".s-item").each(function(){
				var $this=$(this);
				var thisData={
						matchId:$this.attr("activity-id"),
					matchId:$this.attr("match-id"),
					nameA:$this.attr("name-a"),
					nameB:$this.attr("name-b"),
					scoreA:parseInt($this.attr("score-a")),
					scoreB:parseInt($this.attr("score-b")),
					scoreTime:parseInt($this.attr("score-time"))
				};			
				$this.click(function(){
					current_match=thisData.matchId;
					addData(thisData);
					$mask.show();
				});
			});
			//取消
			$(".s-cancel").click(function(){
				current_match=null;
				addData({});
				$mask.hide();
			});
			//提交
			$(".s-submit").click(function(){
					var postJson={
						scoreA:$inputA.val(),
						scoreB:$inputB.val(),
						memberMatchId:current_match,
						activityId:actId
					};
					//console.log(postJson);
					
					$.post("/h5/activity/score", postJson, function (data, status) {
						if (data.code == 0) {
							window.location.reload();
							return;
						} else {
							alert(data.msg);
							return;
						}
				
					});
			});
		});
	</script>
</body>
</html>
