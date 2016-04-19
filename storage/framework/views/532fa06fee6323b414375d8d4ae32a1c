
<!doctype html>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>益乐赛</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">    <style>
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
    <h1 align="center" class="am-header-title"> 审核俱乐部 </h1>
</header>
<!-- Menu -->
<div class="am-g" style="margin-top:20px; border:none">
    <div class="am-u-md-12 am-u-sm-centered">
        <form class="am-form" >
            <fieldset class="am-form-set">
                <input type="text" id="phondeid" class="ama" required placeholder="请输入俱乐部的id">
            </fieldset>
            <button type="button" id="doc-vld-msg" class="am-btn am-btn-primary am-btn-block">审核通过</button>
        </form>
    </div>
</div>
<div class="am-g" style="margin-top:20px; border:none">
    <div class="am-u-md-12 am-u-sm-centered">
        <form class="am-form" >
            <fieldset class="am-form-set">
                <input type="text" id="phondeid2" class="ama" required placeholder="请输入俱乐部的id">
            </fieldset>
            <button type="button" id="doc-vld-msg2" class="am-btn am-btn-primary am-btn-block">审核不通过</button>
        </form>
    </div>
</div>
<!-- Footer -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script>
    $(document).ready(function() {
        $("#doc-vld-msg").click(function() {
            $.post("/admin/club/check", {
                        id: $("#phondeid").val(),
                        type: 1,
                    },

                    function(data, status) {
                        if (data.code == 0) {
                            return;
                        } else {
                            alert(data.msg);
                            return;
                        }

                    });
        });

    });
</script>
<script>
    $(document).ready(function() {
        $("#doc-vld-msg2").click(function() {
            $.post("/admin/club/check", {
                        id: $("#phondeid2").val(),
                        type:0
                    },

                    function(data, status) {
                        if (data.code == 0) {
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
