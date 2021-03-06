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
        <h1 align="center" class="am-header-title"> 队员列表 </h1>
    </header>
    <div class="am-container">
        <a href="/h5/member/person/create">
            <div class="am-form-group">
                <div class="am-u-sm-4 am-u-sm-offset-8">
                    <button type="submit" class="am-btn am-btn-default" style="width:100%; border:none; height:40px; margin-top:15px;">新增队员</button>
                </div>
            </div>
    </div>
    </a>
    <div class="grayline2"></div>
    <div data-am-widget="list_news" class="am-list-news am-list-news-default">
        <div class="am-list-news-bd">
            <ul class="am-list" style="border-top:none">
                <?php foreach((array) $list as $row) { ?>
                <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left" style="width:100%">
                    <div class="rightlist">
                        <h3 class="am-list-item-hd"><?php echo isset($row->name) ? $row->name : ''; ?>.<?php echo $row->sex==1?'男':'女'; ?></h3>
                        <div class="am-list-item-text">电话：<?php echo isset($row->phone_number) ? $row->phone_number : ''; ?></div>
                        <div class="am-list-item-text">身份证：<?php echo isset($row->identity_card) ? $row->identity_card : ''; ?></div>
                    </div>
                    <div class="rightlistw">
                        <a href="/h5/member/person/create?id=<?php echo isset($row->id) ? $row->id : ''; ?>">编辑</a>
                        <a href="/h5/member/person/delete?id=<?php echo isset($row->id) ? $row->id : ''; ?>">删除</a>
                    </div>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
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
