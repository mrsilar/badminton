<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>
<body>
<!-- Header -->
<header data-am-widget="header" class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 class="am-header-title"> 我的活动 </h1>
    <nav data-am-widget="menu" class="am-menu  am-menu-dropdown1" data-am-menu-collapse>
        <a href="javascript: void(0)" class="am-menu-toggle"> <img src="/assets/images/fabu.png"> </a>
        <ul class="am-menu-nav am-avg-sm-1 am-collapse">
            <li><a href="/h5/member/activity/create" class="">双鹿鏖战</a></li>
            <li><a href="/h5/member/activity/create_specail" class="">纵横四海</a></li>
        </ul>
    </nav>
</header>
<div data-am-widget="tabs" class="am-tabs am-tabs-d2" style="width:100%">
    <ul class="am-tabs-nav am-cf">
        <li class=""><a href="[data-tab-panel-0]">我参加的活动</a></li>
        <li class="am-active"><a href="[data-tab-panel-1]">我发布的活动</a></li>
    </ul>
    <div class="am-tabs-bd">
        <div data-tab-panel-0 class="am-tab-panel">


            <div class="am-comment"
                 style="padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-bottom: 10px;">
                <?php foreach((array) $join as $row) { ?>

                <div class="am-gallery-item">
                    <a href="/h5/activity/show/<?php echo isset($row->id) ? $row->id : ''; ?>">
                        <div class="bmbtn"
                             style="position: absolute;z-index: 1;background: rgba(126, 126, 126, 0.6) none repeat scroll 0% 0%;right: 5%;margin-top: 5px;border-radius: 5px;width: 45px;height: 45px;">
                            <img src="/assets/images/xin.png" width="20"> <br>12<!--<?php echo isset($row->status) ? $row->status : ''; ?>--></div>
                        <img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" width="100%" style="height: 270px;"/></a>
                </div>
                <div class="am-g" style="width:100%; margin:0px; border:none; text-align:center; padding:0px;">
                    <div class="am-u-sm-12" style="width:100%; margin:0px;padding:0px;">
                        <h3 class="am-gallery-title"
                            style="margin: -50px 1px 0px; text-align:left; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff">
                            <?php echo isset($row->title) ? $row->title : ''; ?>
                            <div style=" line-height:25px; padding-left:2px;text-align:left"><?php echo isset($row->start_time) ? $row->start_time : ''; ?><span
                                    class="quyuan"><?php echo isset($row->city) ? $row->city : ''; ?></span></div>
                        </h3>
                    </div>
                </div>
                <a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/manager_team_list?activity_id=<?php echo isset($row->id) ? $row->id : ''; ?>">队伍管理</a>
                <div class="grayline"></div>
                <?php } ?>
            </div>
        </div>
        <div data-tab-panel-1 class="am-tab-panel  am-active">


            <div class="am-comment"
                 style="padding: 10px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-bottom: 10px;">
                <?php foreach((array) $create as $row) { ?>


                <div class="am-gallery-item">
                    <a href="/h5/activity/show/<?php echo isset($row->id) ? $row->id : ''; ?>">
                        <div class="bmbtn"
                             style="position: absolute;z-index: 1;background: rgba(126, 126, 126, 0.6) none repeat scroll 0% 0%;right: 5%;margin-top: 5px;border-radius: 5px;width: 45px;height: 45px;">
                            <img src="/assets/images/xin.png" width="20"> <br>12<!--<?php echo isset($row->status) ? $row->status : ''; ?>--></div>
                        <img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" width="100%" style="height: 270px;"/></a>
                </div>
                <div class="am-g" style="width:100%; margin:0px; border:none; text-align:center; padding:0px;">
                    <div class="am-u-sm-12" style="width:100%; margin:0px;padding:0px;">
                        <h3 class="am-gallery-title"
                            style="margin: -50px 1px 0px; text-align:left; padding-left:8px; line-height:25px; background: rgba(0,0,0,0.5);opacity: 0.85; font-size:98%;color:#fff">
                            <?php echo isset($row->title) ? $row->title : ''; ?>
                            <div style=" line-height:25px; padding-left:2px;text-align:left"><?php echo isset($row->start_time) ? $row->start_time : ''; ?><span
                                    class="quyuan"><?php echo isset($row->city) ? $row->city : ''; ?></span></div>
                        </h3>
                    </div>
                </div>

                <a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/set?activity_id=<?php echo isset($row->id) ? $row->id : ''; ?>">设置</a>
                <a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/create?id=<?php echo isset($row->id) ? $row->id : ''; ?>">编辑</a>
                <a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/delete?id=<?php echo isset($row->id) ? $row->id : ''; ?>">删除</a>

                <div class="grayline"></div>
                <div class="grayline"></div>
                <?php } ?>
            </div>
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
</html>
