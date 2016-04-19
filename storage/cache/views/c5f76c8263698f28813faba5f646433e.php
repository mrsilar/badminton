<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
    <style>
    .am-list {
        margin-bottom: 0rem;
        padding-left: 0px;
    }
    
    .am-list>li {
        position: relative;
        display: block;
        margin-bottom: -1px;
        background-color: #fff;
        border-bottom: 1px solid #dedede;
    }
    </style>
</head>

<body>
    <div align="center">
        <!-- Header -->
    </div>
    <header data-am-widget="header" class="am-header am-header-default">
        <div class="am-header-left am-header-nav">
            <div align="center">
                <a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png" /> </a>
            </div>
        </div>
        <h1 align="center" class="am-header-title"> 队伍列表 </h1>
    </header>
    <div class="am-panel-group" id="accordion"> <?php foreach($list as $key => $row) { ?>
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd">
                <h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-<?php echo$key?>'}"> <?php echo isset($row['info']->team_name) ? $row['info']->team_name : ''; ?><!--<a href="/h5/member/team/delete?id=<?php echo isset($row['info']->team_id) ? $row['info']->team_id : ''; ?>">删除</a>--><span style="float:right; color:#999; font-size:14px;">成员&nbsp;></span></h4>
            </div>
            <div id="do-not-say-<?php echo$key?>" class="am-panel-collapse am-collapse">
                <div class="am-panel-bd">
                    <div class="am-g">
                        <?php foreach((array) $row['list'] as $r) { ?>
                                <div class="am-u-sm-4 lineright"><?php echo $row['info']->is_captain==1?'队长':'队员'; ?></div>
                                <div class="am-u-sm-8 lineleft">
                                    <?php echo isset($r->name) ? $r->name : ''; ?>，
                                    <?php echo $r->sex==1?'男':'女'; ?>
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?> </div>
    <?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
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
