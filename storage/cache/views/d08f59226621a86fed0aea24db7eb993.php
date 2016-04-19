<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
</head>
<body>
	<style>
.am-form select,.am-form textarea,.am-form input[type="text"],.am-form input[type="password"],.am-form input[type="datetime"],.am-form input[type="datetime-local"],.am-form input[type="date"],.am-form input[type="month"],.am-form input[type="time"],.am-form input[type="week"],.am-form input[type="number"],.am-form input[type="email"],.am-form input[type="url"],.am-form input[type="search"],.am-form input[type="tel"],.am-form input[type="color"],.am-form-field
	{
	display: block;
	width: 100%;
	padding: 1em;
}

.activeww {
	line-height: 80px;
	border: 1px solid #ccc;
}

.cj1 ul {
	margin: 0px;
	padding: 0px;
	float: left;
	list-style-type: none;
	width: 100%;
}

.cj1 ul li {
	float: left;
	width: 100%;
	line-height: 40px;
	border-bottom: 1px solid #ddd
}

.cj {
	float: left;
	width: 100%;
	text-align: center;
	line-height: 40px;
	height: 40px;
	margin-bottom: 5px;
	background: #f6f6f6;
	border-bottom: 1px solid #ccc;
	color: #000;
}

.bgt {
	width: 100%;
	float: right;
	height: 40px;
	text-align: center;
	line-height: 20px;
	background: #0099CC;
	color: #fff;
	-moz-border-radius: 5px;
	font-size: 110%; /* Gecko browsers */
	-webkit-border-radius: 5px; /* Webkit browsers */
	border-radius: 5px;
	border: none; /* W3C syntax */
}

.ama {
	margin-top: 8px;
	margin-bottom: 5px;
	width: 90%;
	float: left;
	height: 40px;
	text-align: center;
	line-height: 40px;
	background: #27c7c9;
	color: #333;
	-moz-border-radius: 8px;
	font-size: 110%; /* Gecko browsers */
	-webkit-border-radius: 8px; /* Webkit browsers */
	border-radius: 15px;
	border: none; /* W3C syntax */
}

input {
	background: none
}

.sd {
	background: #C4ECF9;
	float: left;
	padding: 0px;
	margin: 0px;
	width: 100%;
}

.lsdk {
	float: left;
	width: 90%;
	padding: 5%;
}

.seo p {
	margin: 0px;
	padding: 0px;
	line-height: 30px;
	color: #fff
}

.seo p a {
	color: #fff
}

.plluns {
	margin: auto;
	width: 96%;
}

p {
	margin: 0px;
	padding: 0px;
}

.title-plun {
	font-size: 95%;
	margin-bottom: 20px;
	float: left;
	width: 100%;
}

.nrlei {
	padding-top: 10px;
	font-size: 98%;
}

.plunliset {
	float: left;
	width: 100%;
	margin-top: 20px;
}

.wbkuang {
	float: left;
	width: 100%;
}
</style>

	<div align="center">
		<!-- Header -->
	</div>
	<header data-am-widget="header" class="am-header am-header-default">
		<div class="am-header-left am-header-nav">
			<div align="center">
				<a href="javascript:history.go(-1)" class=""> <img
					src="/assets/images/jtou.png" />
				</a>
			</div>

		</div>
		<h1 class="am-header-title">
			<a href="#title-link">活动详情</a>
		</h1>

		<div class="am-header-right am-header-nav">
			<div data-am-widget="navbar" id="">
				<ul
					style="float: left; margin: 0px; padding: 0px; list-style-type: none">
					<li data-am-navbar-share><a href="###" style="color: #fff">
							<img src="/assets/images/share.png">
					</a></li>
				</ul>
			</div>
		</div>
	</header>
	<!-- Menu -->
	<div class="am-comment"
		style="border: 1px solid #ccc; margin-bottom: 10px;">

		<div class="lsdk">
			<div class="title-plun">
				评论<span style="float: right"> <!-- <span class="sz"><img
						src="http://v.haijiayou.com/financing/jsp/user/assets/images/zan.png"
						width="40" onclick="praise()"></span><span class="dianzan1"
					style="display: none; float: left"><img
						src="http://v.haijiayou.com/financing/jsp/user/assets/images/zan1.png"
						width="40"></span>(<span id="praise_count">96</span>)
				</span> -->
			</div>
			<script>
				function dianzan() {
					$(".dianzan1").css("display", "block")
					$(".sz").css("display", "none");
				}
			</script>
			<div class="wbkuang" id="comment_list">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<form method="post" action="/h5/activity/pinglun">
							<td align="left"><input type="text" id="content"
								class="am-form-field am-radius" name="content"
								placeholder="我也说两句"
								style="margin: 0px; padding-left: 10px; padding: 0px; font-size: 95%; border: none; background: #fff; line-height: 35px; width: 100%"></td>
							<td align="left"><input type="hidden" name="activity_id"
								value="<?php echo isset($activity_id) ? $activity_id : ''; ?>">
								<button type="submit" class="am-btn am-btn-primary am-radius"
									style="width: 60px; margin: 0px; padding: 0px; color: #fff; border: none; background: #369; line-height: 35px;">发送</button>
								</form></td>
						</tr>
					</tbody>
				</table>



				<?php if ($comment) { ?>
				<table width="96%" align="center" border="0" cellspacing="0"
					cellpadding="0" class="plunliset">
					<tbody>
						<tr>
							<td valign="top" width="50"><img
								src="<?php echo isset($comment[0]->mem_photo) ? $comment[0]->mem_photo : ''; ?>"
								class="am-circle" width="30"></td>
							<td style="padding-left: 10px;" valign="top"><p
									style="color: #999;">
									<small><?php echo isset($comment[0]->mem_name) ? $comment[0]->mem_name : ''; ?></small><span style="float: right"><small><?php echo isset($comment[0]->create_time) ? $comment[0]->create_time : ''; ?></small></span>
								</p>
								<div class="nrlei"><?php echo isset($comment[0]->content) ? $comment[0]->content : ''; ?></div> <a href="javascript:void(0);"
								style="float: right; color: #999" onclick="huifu(10)"><small></small></a>
								<table width="96%" border="0" cellspacing="0" cellpadding="0"
									style="margin-top: 5px;">
									<tbody>
									<?php foreach($comment as $k => $v) { ?>
									<?php if ($k>0) { ?>
										<tr>
											<td valign="top"><img
												src="<?php echo isset($v->mem_photo) ? $v->mem_photo : ''; ?>"
												class="am-circle" width="30"></td>
											<td style="padding-left: 10px;" valign="top"><p
													style="color: #999;">
													<small><?php echo isset($v->mem_name) ? $v->mem_name : ''; ?></small><span style="float: right"><small><?php echo isset($v->create_time) ? $v->create_time : ''; ?></small></span>
												</p>
												<div class="nrlei"><?php echo isset($v->content) ? $v->content : ''; ?></div></td>
										</tr>
										<?php } ?>
										<?php } ?>
									</tbody>
								</table></td>
						</tr>
					</tbody>
				</table>
				<?php } ?>
			</div>
		</div>

	</div>
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
</body>
</html>
