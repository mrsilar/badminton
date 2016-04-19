<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
    <style>img {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        max-width: 100%;
        vertical-align: middle;
        border: 0;
    }
	.am-parent{ line-height:30px;}
	
	</style>
</head>

<body>
<!-- Header -->
<header data-am-widget="header" class="am-header am-header-default">
    <h1 class="am-header-title"><a href="#title-link">活动列表</a></h1>
    <nav data-am-widget="menu" class="am-menu  am-menu-dropdown1" data-am-menu-collapse>
        <a href="javascript: void(0)" class="am-menu-toggle">
            <img src="/assets/images/fabu.png">
        </a>
        <ul class="am-menu-nav am-avg-sm-1 am-collapse">
            <li>
                <a href="/h5/member/activity/create" class="">发布通用活动</a></li>
            <li>
                <a href="/h5/member/activity/create_specail" class="">发布特色活动</a></li>
            <li>
                <a href="/h5/member/club/create" class="">创建俱乐部</a>
            </li>
        </ul>
    </nav>
</header>
<!-- Menu -->
<nav data-am-widget="menu" class="am-menu  am-menu-default">
    <a href="javascript: void(0)" class="am-menu-toggle">
        <i class="am-menu-toggle-icon am-icon-bars"></i>
    </a>
    <ul class="am-menu-nav am-avg-sm-3" style="line-height:30px;">
        <li class="am-parent">
            <a href="##" class="rightline">分类</a>
            <ul class="am-menu-sub am-collapse  am-avg-sm-2 ">
                <?php foreach((array) $item as $row) { ?>
                <li class="">
                    <a href="?item=<?php echo isset($row->id) ? $row->id : ''; ?>" class=""><?php echo isset($row->name) ? $row->name : ''; ?></a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <li class="am-parent">
            <a href="##" class="rightline">区域</a>
            <ul class="am-menu-sub am-collapse  am-avg-sm-4 ">
                省：<select id="Select1"></select>
                市：<select id="Select2"></select>
            </ul>
        </li>
        <li class="am-parent">
            <a href="##" class="">状态</a>
            <ul class="am-menu-sub am-collapse  am-avg-sm-4 ">
                <?php foreach($status as $key => $row) { ?>
                <li class="">
                    <a href="?status=<?php echo isset($key) ? $key : ''; ?>" class=""><?php echo isset($row) ? $row : ''; ?></a>
                </li>
                <?php } ?>
            </ul>
        </li>
    </ul>
</nav>
<div style=" height:10px; float:left; background:#f0efed; width:100%;border-top:1px solid #ddd8ce; border-bottom:1px solid #ddd8ce; margin-bottom:10px;"></div>
<div class="am-tabs am-tabs-default" style="background:#ddd">
    <?php foreach((array) $list as $row) { ?>
    <div class="am-comment"
         style="padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-bottom: 10px;">
        <a href="/h5/activity/show/<?php echo isset($row->id) ? $row->id : ''; ?>">
            <div class="am-gallery-item">
                <img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" width="100%" style="height: 200px;"/>
        </a>
    </div>
    <div class="am-g" style="width:100%; margin:0px; border:none; text-align:center; padding:0px;">
        <div class="am-u-sm-12" style="width:100%; margin:0px;padding:0px;">
            <h3 class="am-gallery-title"
                style="margin: -50px 1px 0px; text-align:left; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff">
                <?php echo isset($row->title) ? $row->title : ''; ?>
                <div style=" line-height:25px; padding-left:2px;text-align:left"> <?php echo isset($row->status) ? $row->status : ''; ?><span class="quyuan"><?php echo isset($row->city) ? $row->city : ''; ?></span>
                </div>
            </h3>
        </div>
    </div>
    </a></div>
</div>
<?php } ?>
</div>
</div>
<!-- Gallery -->
<!-- 防止底部遮盖 -->
<div style="width:100%;height:49px"></div>
<!-- Footer -->
<!-- Footer -->
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/page'); ?>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script src="/assets/js/jsAddressless.js" type="text/javascript"></script>
<script>
    addressInit('Select1', 'Select2');
    $(document).ready(function () {
        $('#Select2').change(function () {
            var p2 = $(this).children('option:selected').val();
            var p1 = $('#Select1').children('option:selected').val();
            window.location.href = "?province=" + p1 + "&city=" + p2 + "";
        })
    })
</script>

<style>
    li.sle a img {
        width: 80px;
        height: 40px;
    }

    .am-comment {
        background: #fff;
    }
</style>
</body>

</html>
