<!doctype html>
<html class="no-js">

<head>
    <?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/header'); ?>
    <style>
	body{position:relative;}
	.noborder{ border:1px solid #ddd}
	.am-form select,.am-form textarea,.am-form input[type="text"],.am-form input[type="password"],.am-form input[type="datetime"],.am-form input[type="datetime-local"],.am-form input[type="date"],.am-form input[type="month"],.am-form input[type="time"],.am-form input[type="week"],.am-form input[type="number"],.am-form input[type="email"],.am-form input[type="url"],.am-form input[type="search"],.am-form input[type="tel"],.am-form input[type="color"],.am-form-field {border: none;font-size: 90%;line-height: 30px;}
    .am-g { border: none;border-bottom: 1px solid #ddd;padding-bottom: 5px;margin-top: 20px;}
	.am-form-group {border-bottom: 1px solid #ddd; width: 100%;}
    .am-form-group label {font-weight: normal; padding-bottom: 8px;}

	/*zz*/
	.mask{z-index:10;position:fixed;width:100%;height:100%;top:0;left:0;background-color:white;display:none;font-size:1.5em;padding-top:2em;overflow-y:scroll;padding-bottom:100px;}
	.mask-content{}
	.mask-item{display:block;width:100%;height:2em; font-size:70%; color:#666;line-height:2em;border-bottom:1px solid #e0e0e0;padding-left:20px;}
	.mask-item:last-child{border:none;}
	.z-add{position:fixed;top:0;left:0;display:block;background-color:#0e90d2;color:white;}
	.z-add a,.z-add span{display:inline-block;height:100%;position:absolute;top:0;}
	.z-add a,.z-add a:hover{color:white;}
	.z-add a{right:20px;}
	.z-add span{left:20px;}
	.z-panel{padding:25px 18px; background:#f6f6f6; margin-bottom:10px;}
	.z-activity{padding-left:18px;background-color:#0e90d2;color:white;}
	.fn-red{color:red;}
	label {
    display: inline-block;
    margin-bottom: 5px;
    font-weight:normal;} 
    </style>
</head>

<body>

<script type="text/javascript">
DATA_APPLY_TYPE="<?php echo isset($activity->apply_type) ? $activity->apply_type : ''; ?>";
DATA_ACTIVITY_CATEGORY=<?php echo json_encode($data_activity_category); ?>;
DATA_ACTIVITY_ID="<?php echo isset($activity->id) ? $activity->id : ''; ?>";
DATA_PEOPLE=<?php echo json_encode($data_member_person); ?>;
DATA_CAN_CHANGE=<?php echo isset($can_change) ? $can_change : ''; ?>;
DATA_TEAM=<?php echo json_encode($team); ?>;
</script>
<div align="center">
    <!-- Header -->
</div>
<header data-am-widget="header" class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center">
            <a href="javascript:history.go(-1)" class="">
                <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 报名 </h1>

    
</header>
<div class="mask s-mask">
	<div class="mask-item z-add">
		<span class="s-choose-sure">确定</span>
		<a href="/h5/member/person/create">+ 增加队员</a>
	</div>
	<div class="mask-content s-mask-content">

	</div>
</div>
<div class="am-container">
    <form class="am-form am-form-horizontal">
		<div class="s-title-panel">
			<div class="am-form-group" style=" border-bottom:none"> 
				<div class="am-u-sm-12" style="padding-top:25px;">创建队伍
					<input type="text" id="team_name_id" style="border:1px solid #ddd" placeholder="输入你的队伍名称">
				</div>
			</div>
		</div>
		<!--zz start-->
		<div class="s-duizhang-panel">
			<div class="am-form-group"> 
				<div class="am-u-sm-12">选择队长:
					<input class="s-choose s-choose-duizhang" type="button" value="选择">
				</div>
			</div>
			<div class="z-panel s-panel s-duizhang">队长：<br/>
				
			</div>
		</div>
		<div class="s-duiyuan-panel">
			<div class="am-form-group">
				<div class="am-u-sm-12">
                   选择队员: 
				</div>
			</div>			
		</div>
		<div class="am-form-group s-submit" style="border:none; margin-top:40px;">
			<div class="am-u-sm-8 am-u-sm-offset-2">
				<button type="button" id="nextid" class="am-btn am-btn-primary am-round" style="width:100%;margin:auto">
						提交
				</button>
			</div>
		</div>
		<!--zz end-->
	</form>
</div>
<?php PHPTemplate\TemplateManager::get('ba7a160e4f3fbb4d2e6358e6ed1da5a1')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<!--ZZ start-->
<script type="text/javascript">
$(function(){
	if($.cookie('join_team_name'))
    {
        $("#team_name_id").val($.cookie('join_team_name'));
    }
    var admin_activity_id = '33';//<?php echo isset($data_activity_id) ? $data_activity_id : ''; ?>;
    var date = new Date();
    date.setTime(date.getTime() + (60 * 60 * 1000));
    $.cookie('join_activity_id', admin_activity_id, {
        expires: date,
        path: '/'
    });

/*--------------先根据报名类型以及项目数量控制页面内容 S----------------*/
//获取数据
var canChange=DATA_CAN_CHANGE;
var activityId=DATA_ACTIVITY_ID;
var applyType=DATA_APPLY_TYPE;
var activityCategory=DATA_ACTIVITY_CATEGORY;
var memberList=DATA_PEOPLE;
var team=DATA_TEAM;

var memberNumber=memberList.length;
var duizhangIndex = -1;
var currentGroup = -1;
var $duiyuanPanel=$(".s-duiyuan-panel");
var $sure=$(".s-choose-sure");
if(!canChange){
	$("#team_name_id").attr("disabled","disabled");
	$(".s-choose").hide();
	$("#nextid").hide();
}
$("#team_name_id").val(team.name);
/*---------------------人员列表 S-------------------*/
	var $content=$(".s-mask-content");
	//初始化人员列表
	for(var i=0;i<memberNumber;i++){
		if(memberList[i].sex=="1") memberList[i].gender="男";
		else memberList[i].gender="女";
		var htmlString="<label class='mask-item s-item' item-sex='"+memberList[i].sex+"' item-number="+i+">"
							+"<input type='checkbox' class='s-checkbox'>&nbsp;"+memberList[i].name+"，"+memberList[i].gender
						+"</label>";
		$(htmlString).appendTo($content);
	}
/*---------------------人员列表 E-------------------*/
if(applyType=="1"){
	$(".s-duizhang-panel").hide();
	//如果只有个人报名，且只有一个项目，则直接点击报名
	if(activityCategory.length==1 && activityCategory[0].item=="1"){
		$(".s-title-panel").hide();
		$(".s-duiyuan-panel").hide();
		$(".s-submit").find("button").html("报名");
	}else{
		var groupIndex = 0;
		for(var i=0;i<activityCategory.length;i++,groupIndex++){
			var itemId=activityCategory[i].id;
			var item=activityCategory[i].item;
			var name=activityCategory[i].name;
			var peopleNumber=parseInt(item);
			var peopleString="";
			for(var j=0;j<memberNumber;j++){
				if(memberList[j].team==itemId){
					peopleString+="<div class='s-choose-peoson' item-number="+peopleNumber+" groupIndex="+groupIndex+">" 
								  +memberList[j].name+"，"+memberList[j].gender
							  +"</div>"
				}
			}
			var htmlString="<div class='am-for-group'>"
						+"<div class='z-activity s-choose' activity-item-id='"+itemId+"' activity-item='"+item+"'people-number=" + peopleNumber + " groupIndex=" + groupIndex + ">"+name+" (点击选择队员)</div>"
						+"<div class='z-panel s-panel'>队员:"+peopleString
						+"</div>"
					+"</div>";
			$(htmlString).appendTo($duiyuanPanel);
			
		}
		
	}
}else{
	var groupIndex = 0;
	//先把队长填进去
	for(var i=0;i<memberNumber;i++){
		if(memberList[i].duizhang){
			var duizhangString="<div class='s-choose-person' item-id="+memberList[i].id+" item-number=1>"
									+memberList[i].name+"，"+memberList[i].gender
								+"</div>";
			$(duizhangString).appendTo($(".s-duizhang"));
		}
	}
	//开始填各个队伍以及队员
	for(var i=0;i<activityCategory.length;i++,groupIndex++){
		var itemId=activityCategory[i].id;
		var item=activityCategory[i].item;
		var name=activityCategory[i].name;
		var manNumber=0;
		var womanNumber=0;
		if(item=="11"){
			manNumber=1;
			womanNumber=0;
		}
		else if (item=="12")
		{
			manNumber=0;
			womanNumber=1;
		}
		else if (item=="21")
		{
			manNumber=2;
			womanNumber=0;
		}
		else if (item=="22")
		{
			manNumber=0;
			womanNumber=2;
		}
		else{
			manNumber=1;
			womanNumber=1;
		}
		var peopleString="";
		for(var j=0;j<memberNumber;j++){
			if(memberList[j].team==itemId){
				peopleString+="<div class='s-choose-peoson' item-number="+(manNumber+womanNumber)+" groupIndex="+groupIndex+">" 
								  +memberList[j].name+"，"+memberList[j].gender
							  +"</div>"
			}
		}
		var htmlString="<div class='am-for-group'>"
					+"<div class='z-activity s-choose' activity-item-id='"+itemId+"' activity-item='"+item+"'man-number="+manNumber+" woman-number="+womanNumber+" groupIndex=" + groupIndex + ">"+name+" (点击选择队员)</div>"
					+"<div class='z-panel s-panel'>队员:"+peopleString
					+"</div>"
				+"</div>";
			$(htmlString).appendTo($duiyuanPanel);
			
	}
}

/*--------------先根据报名类型以及项目数量控制页面内容 E----------------*/

/*------------------选择队员或队长 S-------------------*/
	$(".s-choose").click(function(){
		var $this=$(this);
		var $item=$content.find(".s-item");
		var displayData = [];
		$(".s-panel").removeClass("current");
		//判断是否是选择队长
		if ($this.hasClass("s-choose-duizhang"))
		{
			$sure.attr("choose","duizhang");
			//绑定显示面板
			$(".s-duizhang").addClass("current");
			$(".current").html("队长<br/>");
			for (var i = 0; i<memberList.length; ++i) {
				displayData[i] = true;
			}
			currentGroup = -1;
		}else{
			var curr = parseInt($this.attr("groupIndex"));
			$sure.attr("choose","duiyuan");
			$this.siblings(".s-panel").addClass("current");
			$(".current").html("队员<br/>");
			for (var i = 0; i<memberList.length; ++i) {
				if (memberList[i].groupIndex == null || memberList[i].groupIndex == curr) {
					displayData[i] = true;
				}
			}
			currentGroup = curr;
		}
		//判断需要选择的人数
		if(applyType=="1")
		{
			$sure.attr("people-number",$this.attr("people-number"));
		}
		else{
			$sure.attr("man-number",$this.attr("man-number"));
			$sure.attr("woman-number",$this.attr("woman-number"));
		}
		//人员列表已经选择的人员做隐藏
		for(var i=0;i<memberList.length;i++){
			$($item[i]).find(".s-checkbox").prop("checked",false);
			if(displayData[i]){
				$($item[i]).show();
			} else {
				$($item[i]).hide();
			}
		}
		$(".s-mask").show();
	});

//选择的人员数组以及男性女性数量
var people=[];
var man=woman=total=0;
	$sure.click(function(){
		var $this=$(this);
		var $allItems=$content.find(".s-item");
		var selection = [];
		var selectedCount = 0;
		var manCount = 0;
		var womanCount = 0;
		for (var i=0;i<memberList.length;i++) {
			if ($($allItems[i]).find(".s-checkbox").prop("checked")) {
				selection[i] = true;
				++ selectedCount;
				if ($($allItems[i]).attr("item-sex")=="1") {
					++ manCount;
				} else {
					++ womanCount;
				}
			}
		}
		
		if (currentGroup == -1) {
			if (selectedCount != 1) {
				alert("队长只能选1人!");
				return;
			}
		} else if (applyType=="1"){
			var number=parseInt($this.attr("people-number"));
			if (number != selectedCount) {
				alert("该项目要选"+number+"人");
				return;
			}
		} else {
			var manNumber=parseInt($this.attr("man-number"));
			var womanNumber=parseInt($this.attr("woman-number"));
			if (manCount != manNumber || womanCount != womanNumber) {
				alert("该项目需要选"+manNumber+"个男性和"+womanNumber+"个女性");
				return;
			}
		}
		
		$(".s-mask").hide();
		for (var i = 0; i<memberList.length; ++i) {
			if (selection[i]) {
				if (currentGroup != -1) {
					memberList[i].groupIndex = currentGroup;
				}
				var htmlString = "<div class='s-choose-person' item-id='"+memberList[i].id+"' item-number="+selectedCount+">"
										+memberList[i].name+"，"+memberList[i].gender
									+"</div>";
				$(htmlString).appendTo($(".current"));
			}else{
				if (memberList[i].groupIndex == currentGroup) {
					memberList[i].groupIndex = null;
				}
			}
		}
		
	});
/*------------------选择队员或队长 E-------------------*/
	//ajax提交表单
    $('#nextid').click(function () {
		//写cookie
		var date = new Date();
        date.setTime(date.getTime() + (60 * 60 * 1000));
        $.cookie('join_team_name', $('#team_name_id').val(), {
            expires: date,
            path: '/'
        });
		//创建提交数据
		var postJson={
			id:activityId,
			team_id:team.id
		};
	    if(!(activityCategory.length==1 && activityCategory[0].item=="1" && activityCategory[0].number=="1")){
			if(!$("#team_name_id").val()) {
                alert("队伍名称不能为空");
				return false;
            }
			//每个项目以及相关人员信息添加到提交变量
			postJson.team_name=$("#team_name_id").val();
			var applyItem=[];
			for(var i=0;i<$(".s-choose").length;i++){
				var $choose=$($(".s-choose")[i]);
				if(!$choose.hasClass("s-choose-duizhang")){
					var item=$choose.attr("activity-item");
					var itemId=$choose.attr("activity-item-id");
					var people=[];
					var $persons=$choose.siblings(".s-panel").find(".s-choose-person");
					for(var j=0;j<$persons.length;j++){
						people.push($($persons[j]).attr("item-id"));
					}
					applyItem.push({itemId:itemId,item:item,people:people});
				}
				postJson.apply_item=applyItem;
			}
			//如果是团队报名，则需要队长信息
			if(applyType=="2"){
				postJson.duizhang=$($(".s-duizhang").find(".s-choose-person")[0]).attr("item-id");
			}
		}
		console.log(postJson);
		//提交表单
		$.post("/h5/activity/join_activity",postJson,function(data, status) {
            if (data.code == 0) {  
                window.location.href = '/h5/activity/mingdangs?activity_id=<?php echo isset($data_activity_id) ? $data_activity_id : ''; ?>';
                return;
            } else {
                alert(data.msg);
                return;
            }

        });
    });
});
</script>
<!--ZZ end-->
<style>
    li.sle a img {
        width: 80px;
        height: 40px;
    }
</style>
</body>

</html>
