<!doctype html>
<html class="no-js">

<head><?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>

<body>
	<!-- Header -->
	<header data-am-widget="header" class="am-header am-header-default">
		<h1 class="am-header-title">俱乐部详情</h1>
		<div class="am-header-right am-header-nav">
		<a   href="javascript:void(0)"  id="fbtnid"	>
			 <img  src="/assets/images/upload/2016/01/05/1451924990.png">
			</a>
		</div>
	</header>
	<div class="am-comment"
		style="border: 1px solid #ccc; margin-bottom: 10px;">
		<div class="am-gallery-item">
			<img src="<?php echo isset($detail->cover_img) ? $detail->cover_img : ''; ?>" width="100%" height="120"
				style="margin-bottom: 5px;" />
		</div>
		<div class="am-g"
			style="margin: 0px; border: none; text-align: center; padding: 0px;">
			<div class="am-u-sm-12">
				<h3 class="am-gallery-title"
					style="line-height: 35px; font-size: 18px;"><?php echo isset($detail->name) ? $detail->name : ''; ?></h3>
			</div>
		</div>
	</div>
	<div class="am-container">
		<div class="am-gallery-desc bms">所属区县：上海全区</div>
		<div class="am-gallery-desc bms">创建时间：<?php echo isset($detail->created_at) ? $detail->created_at : ''; ?></div>
	</div>
	<div class="grayline1"></div>
	<div data-am-widget="tabs" class="am-tabs am-tabs-default"
		style="font-size: 85%">
		<ul class="am-tabs-nav am-cf">
			<li class="am-active"><a href="[data-tab-panel-0]">简介</a></li>
			<li class=""><a href="[data-tab-panel-1]">发布的活动</a></li>
			<li class=""><a href="[data-tab-panel-3]">成员</a></li>
		</ul>
		<div class="am-tabs-bd" style="border-bottom: none">
			<div data-tab-panel-0 class="am-tab-panel am-active">
				<?php echo isset($detail->summary) ? $detail->summary : ''; ?></div>
			<div data-tab-panel-1 class="am-tab-panel ">
				<?php foreach((array) $activity as $v) { ?> <a href="/h5/activity/show/<?php echo isset($v->id) ? $v->id : ''; ?>"><img
					class="am-round" alt="140*140" src="<?php echo isset($v->cover_img) ? $v->cover_img : ''; ?>" width="200"
					height="120" /> </a> <?php } ?>
			</div>
			<div data-tab-panel-3 class="am-tab-panel ">
				<?php foreach((array) $mem_list as $v) { ?> <?php echo isset($v->name) ? $v->name : ''; ?> <br><?php } ?>
			</div>
		</div>
	</div>
	<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/amazeui.min.js"></script>
	<style>
li.sle a img {
	width: 80px;
	height: 40px;
}
</style>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        $("#fbtnid").click(function () {
            var $this = $(this);
            $.post("/h5/member/club/join",
                    {
                        club_id: <?php echo isset($detail->id) ? $detail->id : ''; ?>
                    },

                    function (data, status) {
                        if (data.code == 0) {
						alert('加入俱乐部成功');
                        } else {
                            alert(data.msg);
                        }

                    });
        });
    });
</script>
</html>
