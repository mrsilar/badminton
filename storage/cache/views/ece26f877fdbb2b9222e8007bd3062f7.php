<!doctype html>
<html class="no-js">

<head> <style>
 	.am-u-sm-3 {
    display: inline-block;
    margin-bottom: 5px;
    font-weight:normal;}
    </style>
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
    <link rel="stylesheet" href="/assets/css/uploadfile.css">
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
        <h1 class="am-header-title"> 用户中心-修改 </h1>
        <div class="am-header-right am-header-nav"> <img src="/assets/images/search-vector.png"> </div>
    </header>
    <!-- Menu -->
    <div class="am-container" style=" width:100%; padding:0px; margin:0px;">
        <style>
		input{ border:none}
        input.noborder {
            border: none
        }.am-form select, .am-form textarea, .am-form input[type="text"], .am-form input[type="password"], .am-form input[type="datetime"], .am-form input[type="datetime-local"], .am-form input[type="date"], .am-form input[type="month"], .am-form input[type="time"], .am-form input[type="week"], .am-form input[type="number"], .am-form input[type="email"], .am-form input[type="url"], .am-form input[type="search"], .am-form input[type="tel"], .am-form input[type="color"], .am-form-field { border:none}
        </style>
        <form class="am-form am-form-horizontal">
            <div class="am-form-group bottomline">
                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">头像</label>
                <div class="am-u-sm-9" style=" text-align:center">
                    <img src="<?php echo isset($mem->cover_img) ? $mem->cover_img : ''; ?>" width="60" id="cover_img" height="60" class="am-circle">
                    <button type="button" id="fileuploader" style="display:inline-block;width:60px; height:60px; border:none; background:none; overflow:hidden; margin:0px; padding:0px; background:none; margin-left:-60px" >修改图片</button>
                </div>
            </div>
            <div class="am-form-group bottomline">
                <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">姓名</label>
                <div class="am-u-sm-9">
                    <input type="text" id="name" class="noborder" value="<?php echo isset($mem->name) ? $mem->name : ''; ?>" placeholder="输入你的姓名">
                </div>
            </div>
            <div class="am-form-group bottomline">
                <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">手机号</label>
                <div class="am-u-sm-9 noborder">
                    <input type="text" id="phone_number" value="<?php echo isset($mem->phone_number) ? $mem->phone_number : ''; ?>" disabled placeholder="18918163480">
                </div>
            </div>
            <div class="am-form-group bottomline">
                <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">身份证</label>
                <div class="am-u-sm-9">
                    <input type="text"  id="identity_card" class="noborder" value="<?php echo isset($mem->identity_card) ? $mem->identity_card : ''; ?>" placeholder="输入你的身份证 ">
                </div>
            </div>
            <div class="am-form-group">
                <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">性别</label>
                <label class="am-radio-inline">

                    <input type="radio" value="1" <?php if (isset($mem->sex)&&$mem->sex==1) { ?> checked<?php } ?>   name="docInlineRadio"> 男

                </label>
                <label class="am-radio-inline">

                    <input type="radio" value="2" <?php if (isset($mem->sex)&&$mem->sex==2) { ?> checked<?php } ?>  name="docInlineRadio">女

                </label>
            </div>
            <div class="am-form-group">
                <div class="am-u-sm-10 am-u-sm-offset-1">
                    <button type="button" class="am-btn am-btn-primary am-round" style="width:100%;margin:auto%" id="fabuid">修改</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Footer -->
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.uploadfile.min.js" type="text/javascript"></script>
    <script src="/assets/js/amazeui.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#fileuploader").uploadFile({
                url: "/h5/common/upload",
                onSuccess: function (files, response, xhr, pd) {
                    $("#cover_img").attr('src',response.data.path);
                },
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        $("#fabuid").click(function() {
            $.post("/h5/member/my/edit", {
                    name: $("#name").val(),
                    phone_number: $("#phone_number").val(),
                    identity_card: $("#identity_card").val(),
                        cover_img: $("#cover_img")[0].src,
                        sex: $("input[name='docInlineRadio']:checked").val(),
                },

                function(data, status) {
                    if (data.code == 0) {
                        window.location.href = '/h5/home/my';
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
