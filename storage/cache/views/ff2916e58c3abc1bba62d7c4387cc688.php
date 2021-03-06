<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
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
        <h1 align="center" class="am-header-title"> 注册 </h1>
        <div class="am-header-right am-header-nav"><a href="/h5/auth/login">登录</a></div>
    </header>
    <!-- Menu -->
    <form action="" class="am-form" id="doc-vld-msg" style="margin-left:-10px;">
        <fieldset>
            <div class="am-form-group">
                <table width="95%" style="border-bottom:1px solid #ddd; background:#FFFFFF" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding-left:10px;">手机号:</td>
                        <td>
                            <input type="text" style="border:none" id="doc-vld-name-2-1" minlength="3" placeholder="输入手机号" required/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="am-form-group">
                <table width="95%" border="0" style="float:left; width:95%; background:#fff; line-height:50px; border-bottom:1px solid #ddd" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="width:60px;padding-left:10px;">验证码</td>
                        <td>
                            <input type="text" style="float:left; border:none" id="doc-vld-email-2-1" placeholder="短信验证码" required/>
                        </td>
                        <td style="border:none; border-left:1px solid #ddd; background:f6f6f6">
                            <input name="" style="width:80px; background:none; border:none " onclick="sendSms()" value="发送" id="codeid" type="button"> </td>
                    </tr>
                </table>
            </div>
            <div class="am-form-group">
                <table width="95%" style="border-bottom:1px solid #ddd;line-height:50px; background:#FFFFFF" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding-left:10px;"> 密码：</td>
                        <td>
                            <input style="  border:none" type="password" id="doc-vld-url-2-1" placeholder="输入密码" required/>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="background:#f6f6f6; float:left; width:95%; margin-top:10px;">
                <button type="button" class="bm1" id="doc-vld-msgid">免费注册</button>
            </div>
        </fieldset>
    </form>
    <p align="center"><a href="/h5/auth/login">已注册,点击这里登录</a></p>
        <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer-my'); ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/amazeui.min.js"></script>
    <script>
		var step

		function settime(){
		   step=59;
            //$('#btn').val('重新发送60');
            var _res = setInterval(function()
            {   
                $("#codeid").attr("onclick", '');//设置disabled属性
                $("#codeid").attr('value',step+'s');
                step-=1;
                if(step <= 0){
                $("#codeid").attr("onclick", "sendSms()"); //移除disabled属性
                $("#codeid").attr('value','重新发送');
                clearInterval(_res);//清除setInterval
			
				return ;
                }
            },1000)
		
			}
			function sendSms(){
			$("#codeid").attr("onclick", '');
			if($("#doc-vld-name-2-1").val()==''){
			alert('请填写手机号')}else{
			
			
		
            $.post("/h5/auth/sendCode", {
                    phoneNumber: $("#doc-vld-name-2-1").val(),
                },
                function(data, status) {
                    if (data.code == 0) {	settime();alert('发送成功！请查收');
                    } else {
                        alert(data.msg);
						 $("#codeid").attr("onclick", "sendSms()");
                    }
				
                });
				
					
       }}
    $(document).ready(function() {

        $("#doc-vld-msgid").click(function() {
            $.post("/h5/auth/register", {
                    phoneNumber: $("#doc-vld-name-2-1").val(),
                    code: $("#doc-vld-email-2-1").val(),
                    password: $("#doc-vld-url-2-1").val(),
                },

                function(data, status) {
                    if (data.code == 0) {
                        window.history.back(-1);
                    } else {
                        alert(data.msg);
                    }

                });
        });

    });
    </script>
    <!-- Footer -->
    <style>
    .am-form-group {
        width: 110%;
    }
    </style>
    <style>
    li.sle a img {
        width: 80px;
        height: 40px;
    }
    </style>
</body>

</html>
