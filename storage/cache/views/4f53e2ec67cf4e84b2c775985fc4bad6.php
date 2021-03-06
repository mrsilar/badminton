<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
</head>
<body>
<div align="center">
    <!-- Header -->
</div>
<header data-am-widget="header" class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 class="am-header-title"> 用户中心 </h1>

    <div class="am-header-right am-header-nav"></div>
</header>
<!-- Menu -->
<a href="/h5/member/my/edit">
    <table width="100%" border="0" cellspacing="0" cellpadding="0"
           style="height:100px;background:#fffddc;  color:#666; text-align:center; padding-top:10px">

        <tr>
            <td><img src="<?php echo isset($mem->cover_img) ? $mem->cover_img : ''; ?>" class="am-img-thumbnail am-circle" width="60" height="60"></td>
            <td align="left" valign="top">
                <div class="listuser"><?php echo isset($mem->phone_number) ? $mem->phone_number : ''; ?>&nbsp;<span style=" font-size:80%"> </span></div>
   
            <td align="right" valign="middle" style=" padding-right:20px;">></td>
        </tr>

    </table>
</a>

<div class="grayline4"></div>
<ul class="am-list am-list-border" style="margin:0px; padding:0px;">
    <li><a href="/h5/member/activity"> <i><img src="/assets/images/icon-user3.png" width="40"
                                               style="padding-right:8px;"></i> 我的活动<span
            style="float:right; color:#999; font-size:14px;">></span></a> </a> </li>
    <li><a href="/h5/member/club"><i><img src="/assets/images/icon-user.png" width="40" style="padding-right:8px;"></i>我的俱乐部<span
            style="float:right; color:#999; font-size:14px;">></span></a></a> </li>
    <li><a href="/h5/member/person"><i><img src="/assets/images/icon-user1.png" width="40"
                                            style="padding-right:8px;"></i>队员管理<span
            style="float:right; color:#999; font-size:14px;">></span></a></a> </li>
    <li><a href="/h5/member/team"><i><img src="/assets/images/icon-user1.png" width="40" style="padding-right:8px;"></i>我的队伍<span
            style="float:right; color:#999; font-size:14px;">></span></a></a> </li>
    <li><a href="#"><i><img src="/assets/images/icon-user2.png" width="40" style="padding-right:8px;"></i>活动成绩<span
            style="float:right; color:#999; font-size:14px;">></span></a></a> </li>
    <li><a href="#"><i><img src="/assets/images/icon-user5.png" width="40" style="padding-right:8px;"></i>关于益乐赛<span
            style="float:right; color:#999; font-size:14px;">></span></a></a> </li>
</ul>
<div style="margin:auto; padding-top:20px; width:90%"><a href="/h5/auth/logout">
    <button type="button" class="am-btn am-btn-secondary am-round" style="margin:auto; width:90%">退出</button>
</a></div>
<!-- Footer -->
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer-my'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<style> li.sle a img {
    width: 80px;
    height: 40px;
} </style>
</body>
</html>
