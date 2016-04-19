<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>赛况</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="icon" type="image/png" href="assets/i/favicon.png">
<link rel="stylesheet" href="/assets/css/amazeui.min.css">
<link rel="stylesheet" href="/assets/css/app.css">
<link rel="stylesheet"
	href="http://s.amazeui.org/assets/2.x/css/amaze.min.css?v=ifp65slu">
<style>
li.sle a img {
	width: 80px;
	height: 40px;
}

.z-game {
	border-bottom: 1px solid #ddd;
	text-align: center;
	width: 100%;
}

.z-game-info {
	background: #66CCFF;
	font-size: 12px;
}

.z-game-info .fbtn {
	margin: auto;
}
</style>
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
		<h1 align="center" class="am-header-title">比赛结果</h1>
	</header>
	<div>
		<table class="am-table">
			<thead>
				<tr>
					<th>队伍名称</th>
					<th>名次</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach((array) $rank as $r) { ?>
				<tr>
	            <td><?php echo isset($r->team_name) ? $r->team_name : ''; ?></td>
	            <td>
	                <?php if ($rank_is == 0) { ?>
	                <input value="<?php echo $r->rank==10000?'暂无':$r->rank; ?>" class="rankclass">
	                <input type="hidden" value="<?php echo isset($r->id) ? $r->id : ''; ?>" class="idclass">
	                <?php } else { ?>
	                <?php echo $r->rank==10000?'暂无':$r->rank; ?>
	                <?php } ?>
	            </td>
	            <?php if ($rank_is==0) { ?>
	            <td>
	                <button class="fbtnid">确认</button>
	            </td>
	            <?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
			<a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/specail/four/rank?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>&activity_turn_id=<?php echo isset($activity_turn_id) ? $activity_turn_id : ''; ?>&rank=1">自动排名</a>
			<a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/specail/four/rank?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>&activity_turn_id=<?php echo isset($activity_turn_id) ? $activity_turn_id : ''; ?>&rank=０">手动排名</a>
	</div>
	<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".fbtnid").click(function() {
				var $this = $(this);
				var now = $this.parent().parent();
				console.log(now);
				$.post("/h5/member/activity/set/rank", {
					rank : now.find(".rankclass").val(),
					id : now.find(".idclass").val(),
				},

				function(data, status) {
					if (data.code == 0) {

					} else {
						alert(data.msg);
					}

				});
			});
		});
	</script>
</body>
</html>