<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
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
        <h1 class="am-header-title"> 创建俱乐部 </h1>
    </header>
    <form action="" class="am-form" data-am-validator>
        <fieldset>
            <div class="am-form-group">
                <label for="doc-vld-name-2">俱乐部名称：</label>
                <input type="text" minlength="3" value="<?php echo isset($detail->name) ? $detail->name : ''; ?>" placeholder="输入俱乐部名称（至少 3 个字符）" id="name" required/>
            </div>

            <div class="am-form-group">
                <label for="doc-select-1">俱乐部标志</label>
                <img id="cover_img" width="50%" src="<?php echo isset($detail->cover_img) ? $detail->cover_img : ''; ?>">
                <button name="" id="fileuploader" type="button" >上传</button>
                <span class="am-form-caret"></span> </div>
            <div class="am-form-group">
                <label for="doc-vld-ta-2">俱乐部简介：</label>
                <textarea  minlength="10" maxlength="100" id="summary"><?php echo isset($detail->summary) ? $detail->summary : ''; ?></textarea>
            </div>
            <div class="am-form-group">
                <label for="doc-vld-ta-2">区域:</label>
                <div >
                    省：<select id="Select1" ></select>
                    市：<select id="Select2"></select>
                </div>
            </div>
            <div class="am-form-group">
                <label for="doc-vld-name-2">地址：</label>
                <input type="text" id="postion" minlength="3" placeholder="输入地址" value="<?php echo isset($detail->postion) ? $detail->postion : ''; ?>" required/>
            </div>
            <input type="hidden" id="club_id"  value="<?php echo isset($club_id) ? $club_id : ''; ?>" />
            <button class="am-btn am-btn-secondary" style="width:90%; margin-left:5%;" type="button" id="fabuid">提交</button>
        </fieldset>
    </form>
    <!-- Footer -->
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer'); ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/amazeui.min.js"></script>
    <script src="/assets/js/jquery.uploadfile.min.js" type="text/javascript"></script>
    <script src="/assets/js/jsAddressless.js" type="text/javascript"></script>
    <script>
        addressInit('Select1', 'Select2');
    </script>
    <script>
    $(document).ready(function() {
        $("#fileuploader").uploadFile({
            url: "/h5/common/upload",
            onSuccess: function(files, response, xhr, pd) {
                $("#cover_img").attr('src', response.data.path);
            },
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#fabuid").click(function() {
            $.post("/h5/member/club/create", {
                        club_id: $("#club_id").val(),
                    name: $("#name").val(),
                    summary: $("#summary").val(),
                    postion: $("#postion").val(),
                    cover_img: $("#cover_img")[0].src,
                        province:$('#Select1').children('option:selected').val(),//比赛区域
                        city:$('#Select2').children('option:selected').val(),//比赛区域
                },

                function(data, status) {
                    if (data.code == 0) {
                        window.location.href = '/h5/member/club';
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
