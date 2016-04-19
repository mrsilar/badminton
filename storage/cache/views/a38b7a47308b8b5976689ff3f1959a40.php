<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
    <style>
    .am-form select,
    .am-form textarea,
    .am-form input[type="text"],
    .am-form input[type="password"],
    .am-form input[type="datetime"],
    .am-form input[type="datetime-local"],
    .am-form input[type="date"],
    .am-form input[type="month"],
    .am-form input[type="time"],
    .am-form input[type="week"],
    .am-form input[type="number"],
    .am-form input[type="email"],
    .am-form input[type="url"],
    .am-form input[type="search"],
    .am-form input[type="tel"],
    .am-form input[type="color"],
    .am-form-field {
        display: block;
        width: 100%;
        padding: 1em;
    }
    </style>
</head>

<body style="background:#f6f6f6">
    <div align="center">
        <!-- Header -->
    </div>
    <header data-am-widget="header" class="am-header am-header-default">
        <div class="am-header-left am-header-nav">
            <div align="center">
                <a href="javascript:history.go(-1)" class=""> <img class="am-header-icon-custom" src="data:image/svg+xml;charset=utf-8,&lt;svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 12 20&quot;&gt;&lt;path d=&quot;M10,0l2,2l-8,8l8,8l-2,2L0,10L10,0z&quot; fill=&quot;%23fff&quot;/&gt;&lt;/svg&gt;" alt="" /> </a>
            </div>
        </div>
        <h1 align="center" class="am-header-title"> 登录 </h1>
    </header>
    <!-- Menu -->
    <div class="am-g" style="margin-top:20px; border:none">
        <div class="am-u-md-12 am-u-sm-centered">
            <form class="am-form" >
                <fieldset class="am-form-set">
                    <input type="text" id="phondeid" class="ama" required placeholder="请输入用户名">
                    <input type="password" id="password" class="ama" required placeholder="请输入密码">
                </fieldset>
                <button type="button" id="doc-vld-msg" class="am-btn am-btn-primary am-btn-block">登录</button>
            </form>
        </div>
    </div>
    <div class="rightdl"><span style="float:left; padding-left:10%; text-align:left"><a href="/h5/auth/register">免费注册</a></span><!--<a href="#">忘记密码?</a>--></div>
<!--    <img src="/assets/images/qita.png">
    <table width="100%" border="0" cellspacing="10" cellpadding="10">
        <tr>
            <td height="100" align="center" valign="middle" bgcolor="#fff"><img src="/assets/images/qq.png" width="80" height="80"></td>
            <td height="100" align="center" valign="middle" bgcolor="#fff"><img src="/assets/images/weixin.png" width="80" height="80"></td>
            <td height="100" align="center" valign="middle" bgcolor="#fff"><img src="/assets/images/sina.png" width="80" height="80"></td>
        </tr>
    </table>-->
    <!-- Footer -->
        <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer-my'); ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/amazeui.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#doc-vld-msg").click(function() {
            $.post("/h5/auth/login", {
                    phoneNumber: $("#phondeid").val(),
                    password: $("#password").val(),
                },

                function(data, status) {
                    if (data.code == 0) {
                        window.history.back(-1);
                        return;
                    } else {
                        alert(data.msg);
                        return;
                    }

                });
        });

    });
    </script>
    <style>
    li.sle a img {
        width: 80px;
        height: 40px;
    }
    </style>
</body>

</html>
