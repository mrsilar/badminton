<!doctype html>
<html class="no-js">
<head><title>参赛名单</title>
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
</head>
<body>
<div align="center">
    <!-- Header -->
</div>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 class="am-header-title"> 参赛名单 </h1>

    <div class="am-header-right am-header-nav"><a href="/h5/activity/join?activity_id=<?php echo isset($activity_id) ? $activity_id : ''; ?>">继续报名</a></div>
</header>
<!-- Menu -->
<?php if (!$data) { ?>
<img src="https://ss1.bdstatic.com/kvoZeXSm1A5BphGlnYG/skin_zoom/474.jpg?2">
<?php } else { ?>
<div class="am-panel-group" id="accordion">

    <?php foreach((array) $data as $row) { ?>
    <?php $i++?>
    <div class="am-panel am-panel-default">
        <div class="am-panel-hd">
            <h4 class="am-panel-title"
                data-am-collapse="{parent: '#accordion', target: '#do-not-say-<?php echo $i ?>'}"><img
                    src="/assets/images/qun-icon.png" style="margin-right:5px" class="am-img-thumbnail am-circle"
                    width="40" height="40"><span
                    style="font-size:110%; color:#000"><?php echo isset($row['team_info']->name) ? $row['team_info']->name : ''; ?></span><a href="/h5/activity/join_more?activity_id=<?php echo isset($row['team_info']->activity_id) ? $row['team_info']->activity_id : ''; ?>&team_id=<?php echo isset($row['team_info']->id) ? $row['team_info']->id : ''; ?>">添加替补队员</a><span
                    style="float:right; color:#999;padding-top:10px; font-size:90%;">成员&nbsp;></span></h4>
        </div>
        <div id="do-not-say-<?php echo isset($i) ? $i : ''; ?>" class="am-panel-collapse am-collapse" style="margin:0px; padding:0px;">
            <div class="am-panel-bd" style="margin: 0px; padding: 0px; ">
                <div class="am-g" style="margin:0px; padding:0px;background:#f9f9f9">
 				<?php if ($row['team_info']->has_captain) { ?>
                    <div class="lingdui">领队</div>
                    <div class="duiyuan">
                        <ul>
                            <?php foreach((array) $row['list'] as $r) { ?>
                            <?php if ($r->user_team_member_info&&$r->is_captain==1) { ?>
                            <li><?php echo isset($r->user_team_member_info->name) ? $r->user_team_member_info->name : ''; ?>，<?php echo $r->user_team_member_info->sex==1?'男':'女'; ?></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                    <div class="lingdui">队员</div>
                    <div class="duiyuan">
                        <ul>
                            <?php foreach((array) $row['list'] as $r) { ?>
                            <?php if ($r->user_team_member_info&&$r->is_captain!=1) { ?>
                            <li><?php echo isset($r->user_team_member_info->name) ? $r->user_team_member_info->name : ''; ?>，<?php echo $r->user_team_member_info->sex==1?'男':'女'; ?></li>
                            <?php } ?>
                            <?php } ?>


                        </ul>
                    </div>

                </div>
            </div>


            <style>
                .lingdui {
                    float: left;
                    color: #6699CC;
                    width: 100%;
                    background: #DFDFDF;
                    padding-left: 20px;
                    margin-top: 3px;
                    margin-bottom: 3px;
                    line-height: 30px;
                    list-style-type: none
                }

                .duiyuan {
                    float: left;
                    width: 100%;
                }

                .duiyuan ul {
                    float: left;
                    width: 90%;
                    margin-left: 5%;
                    margin-right: 5%;
                    margin-top: 10px;
                    margin-bottom: 10px;
                    padding: 0px;
                    list-style-type: none
                }

                .duiyuan ul li {
                    line-height: 35px;
                    color: #666
                }

            </style>


        </div>
    </div>
</div>
<?php } ?>

</div>
<?php } ?>
<!-- Footer -->
<?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer'); ?>
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
