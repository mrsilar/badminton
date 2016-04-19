<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
</head>

<body>
    <!-- Header -->
    <header data-am-widget="header" class="am-header am-header-default">
        <h1 class="am-header-title"> 俱乐部列表 </h1>
          <nav data-am-widget="menu" class="am-menu  am-menu-dropdown1"   data-am-menu-collapse> 
    <a href="javascript: void(0)" class="am-menu-toggle">
           <img src="/assets/images/fabu.png">
    </a>


      <ul class="am-menu-nav am-avg-sm-1 am-collapse">
          <li >
            <a href="http://wx.haijiayou.com/h5/member/activity/create" class="" >发布活动</a>        </li>
          <li>
            <a href="http://wx.haijiayou.com/h5/member/club/create" class="" >创建俱乐部</a>  
          </li>
         
      </ul>

  </nav>
    </header>
    <div data-am-widget="list_news" class="am-list-news am-list-news-default">
        <div class="am-list-news-bd">
            <ul class="am-list" style="border-top:none">
                <?php foreach((array) $list as $row) { ?>
                <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left" style="width:100%">
                    <a href="/h5/club/show/<?php echo isset($row->id) ? $row->id : ''; ?>">
                        <div class="leftlist"><img src="<?php echo isset($row->cover_img) ? $row->cover_img : ''; ?>" alt="<?php echo isset($row->summary) ? $row->summary : ''; ?>" /> </div>
                        <div class="rightlist">
                            <h3 class="am-list-item-hd"><span class="quyu">浦东新区</span><?php echo isset($row->name) ? $row->name : ''; ?></h3>
                            <div class="am-list-item-text">活动数量：0人 </div>
                            <div class="am-list-item-text">创建时间:<?php echo isset($row->created_at) ? $row->created_at : ''; ?></div>
                        </div>
                        <div class="rightlistw"> <span class="guanzhu">+关注</span> </div>
                    </a>
                </li>
                </a> <?php } ?>
            </ul>
        </div>
    </div>
    <!-- 防止底部遮盖 -->
    <div style="width:100%;height:49px"></div>
    <!-- Footer -->
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/page'); ?>
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
