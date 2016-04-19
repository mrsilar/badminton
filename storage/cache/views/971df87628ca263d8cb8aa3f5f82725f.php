<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>

<body>
    <!-- Header -->
    <header data-am-widget="header" class="am-header am-header-default">
        <div class="am-header-left am-header-nav">
            <div align="center">
                <a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png" /> </a>
            </div>
        </div>
        <h1 class="am-header-title"> 我的俱乐部 </h1>
        <nav data-am-widget="menu" class="am-menu  am-menu-dropdown1" data-am-menu-collapse>
            <a href="javascript: void(0)" class="am-menu-toggle">
                <img src="/assets/images/fabu.png">
            </a>
            <ul class="am-menu-nav am-avg-sm-1 am-collapse">
                <li>
                    <a href="/h5/member/club/create" class="">创建俱乐部</a>
                </li>
            </ul>
        </nav>
    </header>
    <div data-am-widget="tabs" class="am-tabs am-tabs-d2" style="width:100%;">
        <ul class="am-tabs-nav am-cf">
            <li class="am-active"><a href="[data-tab-panel-0]">我参加的俱乐部</a></li>
            <li class=""><a href="[data-tab-panel-1]">我发布俱乐部</a></li>
        </ul>
        <div class="am-tabs-bd">
            <div data-tab-panel-0 class="am-tab-panel am-active">
                <div data-am-widget="list_news" class="am-list-news am-list-news-default">
                    <div class="am-list-news-bd">
                        <ul class="am-list" style="border-top:none">
                            <?php foreach((array) $join as $row) { ?>
                            <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left" style="width:100%">
                                <div class="leftlist">
                                    <a href="/h5/club/show/<?php echo isset($row->id) ? $row->id : ''; ?>" class=""> <img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" alt="<?php echo isset($row->summary) ? $row->summary : ''; ?>" /> </a>
                                </div>
                                <div class="rightlist">
                                    <h3 class="am-list-item-hd"><span class="quyu"><?php echo isset($row->province) ? $row->province : ''; ?><?php echo isset($row->city) ? $row->city : ''; ?></span><?php echo isset($row->name) ? $row->name : ''; ?></h3>
                                    <div class="am-list-item-text">创建时间：<?php echo isset($row->created_at) ? $row->created_at : ''; ?></div>
                                </div>
                                <div class="rightlistw">
                                    <br>
                                    </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div data-tab-panel-1 class="am-tab-panel ">
                <div data-am-widget="list_news" class="am-list-news am-list-news-default">
                    <div class="am-list-news-bd">
                        <ul class="am-list" style="border-top:none">
                            <?php foreach((array) $create as $row) { ?>
                            <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left" style="width:100%">
                                <div class="leftlist">
                                    <a href="/h5/club/show/<?php echo isset($row->id) ? $row->id : ''; ?>" class=""> <img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" alt="<?php echo isset($row->summary) ? $row->summary : ''; ?>" /> </a>
                                </div>
                                <div class="rightlist">
                                    <h3 class="am-list-item-hd"><span class="quyu"><?php echo isset($row->province) ? $row->province : ''; ?><?php echo isset($row->city) ? $row->city : ''; ?></span><?php echo isset($row->name) ? $row->name : ''; ?></h3>
                                    <div class="am-list-item-text">活动数量：<?php echo isset($activity_count) ? $activity_count : ''; ?> </div>
                                    <div class="am-list-item-text">创建时间：<?php echo isset($row->created_at) ? $row->created_at : ''; ?></div>
                                </div>
                                <div class="rightlistw">
                                    <a href="/h5/member/club/create?id=<?php echo isset($row->id) ? $row->id : ''; ?>"><span class="guanzhu">编辑</span></a>
                                      <a href="/h5/club/person?club_id=<?php echo isset($row->id) ? $row->id : ''; ?>"><span class="guanzhu">添加人员</span></a>     
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
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
