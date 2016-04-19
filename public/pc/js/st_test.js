/**
 * Created by Administrator on 2015/10/17 0017.
 */
$(function ($) {
    $(".hide_price").val($(".price:eq(0)").data("price"))
    var priceClass = $(".signUpBody .price[class *=active]").data('priceclass');
    $(".total").text(priceClass + "" + (parseInt($(".hide_price").val()) * parseInt($("#priceNumber").val())))
    $(".headNav").parent(".navSpeak").height($(".headNav").height())
    if ($.browser.msie && ($.browser.version <= "8.0")) {
        var nav_offset = $(".navBody").offset();
        $(window).scroll(function () {
            $(".barQrcodeHide").hide()
            var body_scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
            if (body_scrollTop > nav_offset.top) {
                $(".navBody").css({top: body_scrollTop});
            } else if (body_scrollTop < nav_offset.top) {
                $(".navBody").removeAttr("style");
            }
        });
    } else {
        var nav_offset = $(".navBody").offset();
        $(window).scroll(function () {
            $(".barQrcodeHide").hide()
            var body_scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
            if (body_scrollTop > nav_offset.top) {
                $(".navBody").css({position: "fixed", top: "0px"})
				$(".hdx-header").css({display:"none"})
            } else if (body_scrollTop < nav_offset.top) {
                $(".navBody").removeAttr("style")
				$(".hdx-header").removeAttr("style")
            }
        });
    }
    $(".headNav li").on('click', function () {
        var s = $("#" + $(this).data("plne")).offset().top - $(".headNav").height();
        $("html,body").animate({scrollTop: s})
    })
    //$(".signUpBody .price").on('click', function () {
    //    $(this).addClass("active").siblings().removeClass("active")
    //    $(".hide_price").val($(this).data("price"))
    //    $("#priceNumber").val(1)
    //    $(".total").text($(this).data('priceclass') + "" + $(this).data("price"))
    //    $(".priceExplain" + ($(this).index() + 1)).addClass("active").siblings().removeClass("active")
    //})
    //$(".ticketNumber .fa").on('click', function () {
    //    if ($(this).hasClass("fa-minus")) {
    //        if ($("#priceNumber").val() != 0) {
    //            $("#priceNumber").val($("#priceNumber").val() - 1)
    //        }
    //    } else {
    //        $("#priceNumber").val($("#priceNumber").val() - (-1))
    //    }
    //    $(".order-number").val($("#priceNumber").val());
    //    $(".total").text(priceClass + "" + (parseInt($(".hide_price").val()) * parseInt($("#priceNumber").val())))
    //})
    $("#sideNavigationBar .barBarkTop").on('click', function () {
        $("html,body").animate({scrollTop: "0px"})
    })
    $("#sideNavigationBar .barQrcode").hover(function () {
        var pos = $(this).offset();
        $(".barQrcodeHide").css({top: pos.top + 10, left: pos.left - 193}).show()
    }, function () {
        $(".barQrcodeHide").hide()
    })
    $("#sideNavigationBar .collection").one('click', function () {
        $.ajax({
            url:"/usercenter/collect/",
            type:"get",
            data:{old_event_id:$(this).data("id")},
            success: function (data) {
                var s=eval("("+data+")")
                if(s.code == "1"){
                    swal("收藏成功");
                    $("#sideNavigationBar .collection").addClass("collections").html(" <span></span>已收藏").removeClass("collection")
                }else if(s.code == "2"){
                    swal("已收藏");
                }
            }
        })
    })
    $("#sideNavigationBar .barShopping").on("click", function () {
        if($(".signUp1 a").attr("href")){
            window.location.href = $(".signUp1").find("a").attr("href")
        }else{
            var s = $("#signUp").offset().top - $(".headNav").height();
            $("html,body").animate({scrollTop: s})
        }
    })
    $('#shartQrcode').qrcode({width: 180, height: 180, text: window.location.href});
    $("#sideNavigationBar .barShare").hover(function () {
        var pos = $(this).offset();
        $(".barShareHide").css({top: pos.top + 10, left: pos.left - 200}).show()
    }, function () {
        $(".barShareHide").hide()
    })
    $(".priceMore").on('click', function () {
        $(".price").show()
        $(this).hide()
    })
    $("#invoice").on('click', function () {
        if ($(this).is(":checked")) {
            $(".Invoice_div").show()
        } else {
            $(".Invoice_div").hide()
        }
    })
    $("#mobilphone").on('blur', function () {
        if($.trim($("#customer_name").val()).length == 0&&(/^1[3-8]+\d{9}$/).test($('#mobilphone').val())){
            $.get('/countsubmit/',{tel:$("#mobilphone").val(),times:new Date().getTime()})
        }
    })
    // $(".orderFormSubmit button").submit(function () {
    $("#captcha").on('blur', function () {
        var csrf = document.getElementsByName('csrfmiddlewaretoken')[0];
        var captcha = $("#captcha").val();
        var submitflag = true;
        $.ajax({
            url: "/verify_captcha/",
            dataType: "json",
            type: "post",
            async: false,
            data: {
                csrfmiddlewaretoken: csrf.value,
                captcha: captcha
            },
            success: function (data) {
                if (data.flag == 'false') {
                    $("#captcha").attr({"data-captchaflag":false})
                    $("#cap_img").click()
                }else{
                    $("#captcha").attr({"data-captchaflag":true})
                }
            }
        });
    })
    $(".submitForm").submit(function () {
        setTimeout(function () {
            $(".submitForm input[type=text]").popover('destroy')
        }, 1000)
        var filter = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
        var option = {
            placement: "top",
            animation: "true",
            container: "body",
        }
        if ($.trim($("#customer_name").val()).length == 0) {
            option.content = "姓名不能为空"
            $("#customer_name").popover(option).popover('show')
            return false;
        } else {
            if (!(/^[\u4e00-\u9fa5 ]{2,20}|[a-zA-Z\/ ]{2,20}$/).test($.trim($("#customer_name").val()))) {
                option.content = "请输入正确的姓名"
                $("#customer_name").popover(option).popover('show')
                return false;
            }
        }
        if ($.trim($("#mobilphone").val()).length == 0) {
            option.content = "手机不能为空"
            $("#mobilphone").popover(option).popover('show')
            return false;
        } else {
            if (!(/^1[3-8]+\d{9}$/).test($('#mobilphone').val())) {
                option.content = "请输入正确的手机号"
                $("#mobilphone").popover(option).popover('show')
                return false;
            }
        }
        if ($.trim($("#captcha").val()).length == 0) {
            option.content = "验证码不能为空"
            $("#captcha").popover(option).popover('show')
            return false;
        } else {
            if($("#captcha").attr("data-captchaflag") == 'false'){
            option.content = "验证码错误"
            $("#captcha").popover(option).popover('show')
            return false;
            }
        }
        if ($.trim($("#email").val()).length == 0) {
            option.content = "邮箱不能为空"
            $("#email").popover(option).popover('show')
            return false;
        } else {
            if (!filter.test($('#email').val())) {
                option.content = "请输入正确的邮箱"
                $("#email").popover(option).popover('show')
                return false;
            }
            if($("#number").val()<=0){
                alert("请选择票价")
                return false;
            }else{
                $("#loading").show()
            }

        }
    })
    $(".orderForm .post_daiding").on('click', function () {
        setTimeout(function () {
            $(".orderForm input[type=text]").popover('destroy')
        }, 1000)
        var filter = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
        var option = {
            placement: "top",
            animation: "true",
            container: "body",
        }
        if ($.trim($("#customer_name").val()).length == 0) {
            option.content = "姓名不能为空"
            $("#customer_name").popover(option).popover('show')
            return false;
        } else {
            if (!(/^[\u4e00-\u9fa5 ]{2,20}|[a-zA-Z\/ ]{2,20}$/).test($.trim($("#customer_name").val()))) {
                option.content = "请输入正确的姓名"
                $("#customer_name").popover(option).popover('show')
                return false;
            }
        }
        if ($.trim($("#mobilphone").val()).length == 0) {
            option.content = "手机不能为空"
            $("#mobilphone").popover(option).popover('show')
            return false;
        } else {
            if (!(/^1[3-8]+\d{9}$/).test($('#mobilphone').val())) {
                option.content = "请输入正确的手机号"
                $("#mobilphone").popover(option).popover('show')
                return false;
            }
        }
        if ($.trim($("#captcha").val()).length == 0) {
            option.content = "验证码不能为空"
            $("#captcha").popover(option).popover('show')
            return false;
        } else {
            if($("#captcha").attr("data-captchaflag") == 'false'){
                option.content = "验证码错误"
                $("#captcha").popover(option).popover('show')
                return false;
            }
        }
        if ($.trim($("#email").val()).length == 0) {
            option.content = "邮箱不能为空"
            $("#email").popover(option).popover('show')
            return false;
        } else {
            if (!filter.test($('#email').val())) {
                option.content = "请输入正确的邮箱"
                $("#email").popover(option).popover('show')
                return false;
            }
        }
            var csrf = document.getElementsByName('csrfmiddlewaretoken')[0];
            $("#loading").show()
            $.ajax({
                url: "/post_message_json/",
                dataType: "json",
                type: "post",
                data: {
                    csrfmiddlewaretoken: csrf.value,
                    name: $("#customer_name").val(),
                    email: $("#email").val(),
                    phone: $(" #mobilphone").val(),
                    event_id: $("#event_id_for_submit").val(),
                    event_name: $("#event_name").val(),
                },
                success: function (data) {
                    $("#loading").hide()
                    if (data.code == 1) {
                        swal('提交成功，费用信息有更新我们会及时联系您。');
                    }
                }
            })

    })
});
for(var i=0;i<11;i++){
    $(".quantitys").append("<option value='"+i+"'>"+i+"</option>")
}
$(".mess_table tr").on('click', function () {
    var $this = $(this)
    $this.find("input[type='radio']").prop("checked",true);
    $this.find("select option[value=0]").remove();
    if($this.find("select option[value=0]").length==0){
        $this.siblings().find("select").append("<option value='0'>0</option>")
    }
    $this.siblings().find("select").val("0");
    var sum_nums = $this.find("select").val();
    var thisPrice = $this.find(".price1").data("price");
    var thisPriceType =$this.find(".price1").data("sign");
    var returnPrice = $this.find(".price_return").data("return");
    if($.trim($this.find(".new_tooltip p").html()).length!=0){
        $(".price_intro").html("说明:"+$(this).find(".new_tooltip p").html())
    }
    $(".returnPrice span:eq(1)").text(thisPriceType+""+(sum_nums*returnPrice).toFixed(2))
    $(".priceNumber").text(sum_nums)
    $(".priceZhongji").text(thisPriceType+""+(sum_nums*thisPrice).toFixed(2))
    if(returnPrice){
        $(".total_return_num").show()
    }
    $(".total_price").show()
    $("#number").attr("value",sum_nums)
    $("#money").attr("value",sum_nums*thisPrice)
})
$(".show_note").hover(function () {
    var s = $(this).position()
    $(".show_note_font").css({left:s.left,top: s.top}).show()
}, function () {
    $(".show_note_font").hide()
})
//免费报名
$(".freeApply").click(function(){
    var option = {
        placement: "top",
        animation: "true",
        container: "body",
    }
    var name=$("input[name='username']").val();
    var company=$("input[name='company']").val();
    var position=$("input[name='position']").val();
    var phone=$("input[name='phone']").val();
    var mail=$("input[name='mail']").val();
    var csrf = document.getElementsByName('csrfmiddlewaretoken')[0].value;
    if($.trim(name)!=""){
        if($.trim(company)!=""){
            if($.trim(position)!=""){
                if($.trim(phone).match(/0?(13|14|15|18|17)[0-9]{9}/)){
                    if($.trim(mail).match(/\w+((-w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+/)){
                        $.ajax({
                            url:"/leavemsg/{{event_id}}/",
                            dataType:"json",
                            type:"post",
                            async:false,
                            data:{
                                csrfmiddlewaretoken: csrf,
                                name:name,
                                company:company,
                                job:position,
                                phone:phone,
                                email:mail
                            },
                            success: function(data){
                                console.log(data);
                                if(data.code==1){
                                    //$(".tanchuang div").show(300)
                                }
                            }
                        });
                    }else{
                        alert("请填写正确的邮箱")
                    }
                }else{
                    alert("请填写正确的手机号码")
                }
            }else{
                alert("请填写职务名称")
            }
        }else{
            alert("请填写公司名称")
        }
    }else{
        console.log("11")
        option.content = "姓名不能为空"
    }
})