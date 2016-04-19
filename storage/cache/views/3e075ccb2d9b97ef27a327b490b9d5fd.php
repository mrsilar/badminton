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
        border: none
    }
	
	label{ font-weight:normal}
	.noborder{ font-size:90%;}
	legend{     border-bottom: 1px solid #fff;}
    </style>
</head>

<body>
    <div align="center">
        <!-- Header -->
    </div>
    <header data-am-widget="header" class="am-header am-header-default">
        <div class="am-header-left am-header-nav">
            <div align="center">
                <a href="javascript:history.go(-1)" class="">
                    <img src="/assets/images/jtou.png" /> </a>
            </div>
        </div>
        <h1 align="center" class="am-header-title"> 队员 </h1>

    </header>
    <!-- Menu -->
    <form class="am-form am-form-horizontal">
        <legend class="textcenter"></legend>
        <div class="am-form-group bottomline">
            <label for="doc-ipt-3" class="am-u-sm-3 am-form-label">姓名</label>
            <div class="am-u-sm-9">
                <input type="text" id="name" class="noborder" value="<?php echo isset($detail->name) ? $detail->name : ''; ?>" placeholder="输入你的姓名">
            </div>
        </div>
        <div class="am-form-group bottomline">
            <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">手机号</label>
            <div class="am-u-sm-9">
                <input type="text" id="phone_number" class="noborder" value="<?php echo isset($detail->phone_number) ? $detail->phone_number : ''; ?>" placeholder="输入你的手机号码">
            </div>
        </div>
        <div class="am-form-group bottomline">
            <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">身份证</label>
            <div class="am-u-sm-9">
                <input type="text" id="identity_card" class="noborder"  value="<?php echo isset($detail->identity_card) ? $detail->identity_card : ''; ?>"  placeholder="输入你的身份证 ">
            </div>
        </div>
        <div class="am-form-group bottomline">
            <label for="doc-ipt-pwd-2" class="am-u-sm-3 am-form-label">性别</label>
            <div class="am-u-sm-9"> <label class="am-radio-inline">
                <input type="radio" value="1" <?php if (isset($detail->sex)&&$detail->sex==1) { ?> checked<?php } ?>   name="sex"> 男
            </label>
            <label class="am-radio-inline">
                <input type="radio" value="2" <?php if (isset($detail->sex)&&$detail->sex==2) { ?> checked<?php } ?>   name="sex">女
            </label> </div>
        </div> 

        <div class="am-form-group"  style="margin-top:20px;">
            <div class="am-u-sm-10 am-u-sm-offset-1">
                <button type="button" class="bm1" style="width:100%;margin:auto " id="doc-vld-msg">保存</button>
            </div>
        </div>
    </form>
    <!-- Footer -->
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer'); ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/amazeui.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#doc-vld-msg").click(function() {
            $.post("/h5/member/person/create", {
                    name: $("#name").val(),
                    phone_number: $("#phone_number").val(),
                    identity_card: $("#identity_card").val(),
                    sex: $("input[name='sex']:checked").val(),
                },

                function(data, status) {
                    if (data.code == 0) {
                        window.location.href = '/h5/member/person';
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
