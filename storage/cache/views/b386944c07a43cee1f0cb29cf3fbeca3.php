<!doctype html>
<html class="no-js">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>发布活动</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link rel="icon" type="image/png" href="assets/i/favicon.png">
	<link rel="stylesheet" href="/assets/css/amazeui.min.css">
	<link rel="stylesheet" href="/assets/css/mobiscroll.custom-2.6.2.min.css">
	<link rel="stylesheet" href="/assets/css/app.css">
	<link rel="stylesheet" href="/assets/css/uploadfile.css">
	<link rel="stylesheet" href="/assets/css/amazeui.min.css?v=ifp65slu">
	<script src="/assets/js/jquery.min.js?v=ifp65slu"></script>
	<script src="/assets/js/handlebars.min.js?v=ifp65slu"></script>
	<script src="/assets/js/amazeui.min.js?v=ifp65slu"></script>
	<style>
		/*防止移动端点击导致整个元素处于被选中的状态*/
		html{-webkit-tap-highlight-color:rgba(0,0,0,0);-webkit-tap-highlight:rgba(0,0,0,0);}
		html,body{width:100%;overflow-x:hidden;}
		.am-btn-default{ color:#333;}
		.mytt1,.mytt2{display:none;}
		select{display:inline-block;}
		.s-event-number{display:none;}
		.z-event-wrapper{padding:5px 0;}
		/*..ajax-upload-dragdrop{ border: 2px dotted none;opacity:0; }*/
		/*.ajax-file-upload {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-weight: bold;
        padding: 15px 20px;
        cursor: pointer;
        line-height: 20px;
        height: 25px;
        margin: 0 10px 10px 0;
        display: inline-block;
        background:none;
        color: #888;
         opacity:0;
        text-decoration: none;
         -webkit-border-radius: 3px;
         -webkit-box-shadow: 0 2px 0 0 #e8e8e8;
         box-shadow: 0 2px 0 0 #e8e8e8;
         padding: 6px 10px 4px 10px;
         color: #fff;
         background: #2f8ab9;
        border: none; }*/
	</style>
</head>

<body style="background:#fff">
<div align="center">
	<!-- Header -->
</div>
<header data-am-widget="header" class="am-header am-header-default">
	<div class="am-header-left am-header-nav">
		<div align="center">
			<a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png" /> </a>
		</div>
	</div>
	<h1 align="center" class="am-header-title"> 发布活动 </h1>
	<form class="am-form am-form-horizontal">
		<div class="am-header-right am-header-nav">

		</div>
</header>
<!-- Menu -->
<style>
	.am-g {
		border-bottom: 1px solid #ddd;
		border-top: none
	}
	.am-u-sm-12 input placeholder{  color:#333}
	.ajax-file-upload-statusbar{ display:none}
</style>

<div class="am-g margins">   <div class="am-u-sm-4">活动图片:</div>
	<div class="am-u-sm-8">
		<img id="cover_img" style="display:inline-block; background:url(http://wx.haijiayou.com/assets/images/defeat.png) left; background-size:100%;width:150px;height:100px;" src="<?php echo isset($detail->cover_img) ? $detail->cover_img : ''; ?>">
		<button type="button" style="display:inline-block;width:150px; height:100px; border:none; background:none; overflow:hidden; margin:0px; padding:0px; background:none; margin-left:-150px" class="am-btn am-btn-default am-round" id="fileuploader">上传图片</button>
	</div>
</div>s


<input type="hidden" value="这里写相关活动" id="related_activity"/>
<p>
	<input type="text" class="am-form-field am-radius" style="border:none; border-bottom:1px solid #dedede" value="<?php echo isset($detail->title) ? $detail->title : ''; ?>" id="title" placeholder="请输入活动名称" required/>
</p>

<div class="am-g " style="padding-top:10px;">
	<div class="am-u-sm-4 ">项目类型:</div>
	<div class="am-u-sm-8">
		<div class="am-form-group">
			<select id="doc-select-1" class="item_id">
				<?php foreach((array) $item as $row) { ?>
				<option value="<?php echo isset($row->id) ? $row->id : ''; ?>"  <?php if (isset($detail->item_id)&&$row->id==$detail->item_id) { ?>selected<?php } ?>><?php echo isset($row->name) ? $row->name : ''; ?></option>
				<?php } ?>
			</select>
			<span class="am-form-caret"></span> </div>
	</div>
</div>
<div class="am-g" style="padding-top:10px; padding-bottom:10px;">
	<div class="am-u-sm-4"></div>
	<div class="am-u-sm-8">
		省/市:<select id="Select1" ></select>
		区/县:<select id="Select2"></select>
	</div>
</div>
<div class="grayline1"></div>
<div class="am-form-group">
	<span style="margin-left:15px;">比赛类型：</span>
	<label class="am-radio-inline">
		<input type="radio" value="1" <?php if (isset($detail->apply_type)&&$detail->apply_type==1) { ?> checked<?php } ?> name="apply_type"> 个人
	</label>
	<label class="am-radio-inline">
		<input type="radio"  value="2" <?php if (isset($detail->apply_type)&&$detail->apply_type==2) { ?> checked<?php } ?> name="apply_type"> 团体
	</label>
</div>
<div class="am-g mytt1" style="padding-top:10px; padding-bottom:10px;">
	<div class="am-u-sm-4">比赛项目:</div>
	<div class="am-u-sm-8">
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="personal_event_1" value="10"/>
			<label for="personal_event_1">单打</label>
			<select class="s-event-number s-event-number-1">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="personal_event_2" value="20"/>
			<label for="personal_event_2">双打</label>
			<select class="s-event-number s-event-number-2">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
	</div>
</div>
<div class="am-g mytt2" style="padding-top:10px; padding-bottom:10px;">
	<div class="am-u-sm-4">比赛项目:</div>
	<div class="am-u-sm-8">
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="team_event_1" value="11"/>
			<label for="team_event_1">男子单打</label>
			<select class="s-event-number s-event-number-1">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="team_event_2" value="12"/>
			<label for="team_event_2">女子单打</label>
			<select class="s-event-number s-event-number-2">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="team_event_3" value="21"/>
			<label for="team_event_3">男子双打</label>
			<select class="s-event-number s-event-number-3">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="team_event_4" value="22"/>
			<label for="team_event_4">女子双打</label>
			<select class="s-event-number s-event-number-4">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="z-event-wrapper">
			<input class="s-event" type="checkbox" id="team_event_5" value="23"/>
			<label for="team_event_5">混合双打</label>
			<select class="s-event-number s-event-number-5">
				<option value="0">项目数量</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
	</div>
</div>
<div class="am-g" style="padding-top:10px; padding-bottom:10px;">
	<div class="am-u-sm-4">比赛分制:</div>
	<div class="am-u-sm-8">
		<select id="score_system">
			<option value="21" <?php if (isset($detail->score_system)&&$detail->score_system==21) { ?>selected<?php } ?> >21分制</option>
			<option value="15" <?php if (isset($detail->score_system)&&$detail->score_system==15) { ?>selected<?php } ?>>15分制</option>
			<option value="11" <?php if (isset($detail->score_system)&&$detail->score_system==11) { ?>selected<?php } ?>>11分制</option>
		</select>
	</div>
</div>

<div class="am-g" style="padding-top:10px; padding-bottom:10px;">
	<div class="am-u-sm-4">比赛赛制:</div>
	<div class="am-u-sm-8">
		<select id="game_system">
			<option value="0" <?php if (isset($detail->how_win)&&$detail->how_win==0) { ?>selected<?php } ?>>淘汰赛</option>
			<option value="1" <?php if (isset($detail->how_win)&&$detail->how_win==1) { ?>selected<?php } ?>>外循环</option>
			<option value="2" <?php if (isset($detail->how_win)&&$detail->how_win==2) { ?>selected<?php } ?>>内循环</option>

		</select>
	</div>
</div>
<div class="grayline1"></div>
<div class="am-g">
	<div class="am-u-sm-12" style=" border-bottom:1px solid #ddd;  margin:0px; padding:0px;margin-bottom:8px;">
		<input type="text" required class="am-btn am-btn-default am-margin-right selsei" style="background:none; color:#333;text-align:left;border:none" id="apply_start_time" value="<?php echo isset($detail->apply_start_time) ? $detail->apply_start_time : ''; ?>" placeholder="活动报名开始日期">
	</div>
	<div class="am-u-sm-12" style=" border-bottom:1px solid #ddd; margin:0px; padding:0px;  color:#333; margin-bottom:8px;">
		<input type="text" required class="am-btn am-btn-default am-margin-right selsei" style="background:none; text-align:left;border:none" id="apply_end_time" id="apply_start_time" value="<?php echo isset($detail->apply_end_time) ? $detail->apply_end_time : ''; ?>"  placeholder="活动报名截止日期">
	</div>
</div>
<div class="am-g">
	<div class="am-u-sm-12" style=" border-bottom:1px solid #ddd; margin:0px; padding:0px; color:#333；margin-bottom:8px;">
		<input type="text"required  class="am-btn am-btn-default am-margin-right selsei" style="background:none;text-align:left;border:none"  id="start_time"  value="<?php echo isset($detail->start_time) ? $detail->start_time : ''; ?>"  placeholder="活动开始日期">
	</div>
	<div class="am-u-sm-12" style=" border-bottom:1px solid #ddd;  margin:0px; padding:0px; color:#333；margin-bottom:8px;">
		<input type="text" required class="am-btn am-btn-default am-margin-right selsei" style="background:none;text-align:left;border:none" id="end_time" value="<?php echo isset($detail->end_time) ? $detail->end_time : ''; ?>"  placeholder="活动截止日期">
	</div>
</div>
<div class="am-input-group jfline">
	<span class="am-input-group-label" style="background:none; border:none">地点</span>
	<input style="background:none; text-align:right; border:none" type="text" placeholder="请输入活动地址" class="am-form-field" id="position" value="<?php echo isset($detail->postion) ? $detail->postion : ''; ?>">
</div>
<div class="am-input-group jfline">
	<span class="am-input-group-label" style="background:none; border:none">费用</span>
	<input style="background:none; text-align:right; border:none" type="text" placeholder="请输入活动费用" class="am-form-field" id="cost" value="<?php echo isset($detail->cost) ? $detail->cost : ''; ?>">
</div>

<div class="am-input-group jfline mytt2 am-g">
	<div class="am-u-sm-4">队伍最大人数</div>
	<div class="am-u-sm-8">
		<input id="team_count" value="<?php echo isset($detail->team_count) ? $detail->team_count : ''; ?>" type="text">
	</div>
</div>
<div class="am-panel-group" id="accordion">
	<div class="am-panel am-panel-default">
		<div class="am-panel-hd">
			<h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-1'}"> 活动介绍<span style="float:right; color:#999; font-size:14px;">添加内容&nbsp;></span></h4>
		</div>
		<div id="do-not-say-1" class="am-panel-collapse am-collapse">
			<div class="am-form-group" style="margin-left:5%; margin-top:10px; width:90%">
				<textarea class="" rows="5" id="introduction"  required><?php echo isset($detail->introduction) ? $detail->introduction : ''; ?></textarea>
			</div>
		</div>
		<div class="am-panel am-panel-default">
			<div class="am-panel-hd">
				<h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-2'}"> 活动规则<span style="float:right; color:#999; font-size:14px;">添加内容&nbsp;></span></h4>
			</div>
			<div id="do-not-say-2" class="am-panel-collapse am-collapse">
				<div class="am-form-group">
					<textarea class="" rows="5" id="rule" ><?php echo isset($detail->rule) ? $detail->rule : ''; ?></textarea>
				</div>
			</div>
			<div class="am-panel am-panel-default">
				<div class="am-panel-hd">
					<h4 class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-3'}"> 奖励办法<span style="float:right; color:#999; font-size:14px;">添加内容&nbsp;></span></h4>
				</div>
				<div id="do-not-say-3" class="am-panel-collapse am-collapse">
					<div class="am-form-group">
						<textarea class="" rows="5" id="reward" ><?php echo isset($detail->reward) ? $detail->reward : ''; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="grayline1"></div>
		<p style="text-align:center; border-bottom:1px solid #ddd">在线咨询</p>
		<div class="am-input-group jfline"> <span class="am-input-group-label" style="background:none; border:none">联系人</span>
			<input style="background:none; text-align:right; margin-bottom:-15px; border:none" type="text" placeholder="请输入联系人" id="link_man" value="<?php echo isset($detail->link_man) ? $detail->link_man : ''; ?>" class="am-form-field"> </div>
		<div class="am-input-group jfline"> <span class="am-input-group-label" style="background:none; border:none">邮箱</span>
			<input style="background:none; text-align:right; border:none" id="link_mail" value="<?php echo isset($detail->link_mail) ? $detail->link_mail : ''; ?>"  type="text" placeholder="请输入邮箱" class="am-form-field">
		</div>
		<div class="am-input-group jfline"> <span class="am-input-group-label" style="background:none; border:none">手机</span>
			<input style="background:none; text-align:right; border:none" type="text" placeholder="请输入手机" class="am-form-field" id="link_phone" value="<?php echo isset($detail->link_phone) ? $detail->link_phone : ''; ?>"  >
		</div>
		<div class="am-input-group "> <span class="am-input-group-label" style="background:none; border:none">QQ</span>
			<input style="background:none; text-align:right; border:none" type="text" placeholder="请输入QQ" class="am-form-field" id="link_qq" value="<?php echo isset($detail->link_qq) ? $detail->link_qq : ''; ?>">
		</div>
		<div class="am-form-group" style="margin-top:20px;">
			<div class="am-u-sm-10 am-u-sm-offset-1">
				<button type="button" id="fabuid" class="am-btn am-btn-primary am-round" style="width:100%;margin:auto%">确定发布</button>
			</div>
		</div>
</body>
<script src="/assets/js/jquery.uploadfile.min.js" type="text/javascript"></script>
<script src="/assets/js/mobiscroll.custom-2.6.2.min.js" type="text/javascript"></script>
<script src="/assets/js/jsAddressless.js" type="text/javascript"></script>
<script>
	addressInit('Select1', 'Select2');
</script>
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
	var edit = "<?php echo isset($_GET['id'])?'update':'create';?>";
	$(document).ready(function() {
		var change=0;
		if(<?php echo isset($can_change) ? $can_change : ''; ?>) change=<?php echo isset($can_change) ? $can_change : ''; ?>;
		var detail=JSON.parse('<?php echo json_encode($detail); ?>');
		if(!change){
			$("#doc-select-1").attr("disabled","disabled");
			$("#game_system").attr("disabled","disabled");
			$("input[name='apply_type']").attr("disabled","disabled");
		}
		$("#fabuid").click(function() {
			//提交数据json串
			var postJson={
				id: <?php echo isset($_GET['id'])?$_GET['id']:0;?>,
			related_activity:$("#related_activity").val(),//相关活动
					title: $("#title").val(),//活动名称
					cover_img: $("#cover_img")[0].src,//封面图片
					item_id:$("#doc-select-1").children('option:selected').val(),//项目类型
					province:$('#Select1').children('option:selected').val(),//比赛区域
					city:$('#Select2').children('option:selected').val(),//比赛区域
					score_system:$("#score_system").val(),//分制
					how_win:$("#how_win").val(),//分制
					game_system:$("#game_system").val(),//赛制
					start_time: $("#start_time").val(),//开始时间
					end_time: $("#end_time").val(),//结束时间
					apply_start_time: $("#apply_start_time").val(),//报名开始时间
					apply_end_time: $("#apply_end_time").val(),//报名结束时间
					position: $("#position").val(),//比赛地点
					cost: $("#cost").val(),//比赛开销
					introduction:$("#introduction").val(),//活动介绍
					rule:$("#rule").val(),//活动规则
					reward:$("#reward").val(),//奖励办法
					link_man:$("#link_man").val(),//联系人姓名
					link_mail:$("#link_mail").val(),//联系人邮箱
					link_phone:$("#link_phone").val(),//联系人手机号
					link_qq:$("#link_qq").val()//联系人QQ
		};
		//根据报名类型选择比赛项目以及项目的数量
		var apply_type= $("input[name='apply_type']:checked").val();
		postJson.apply_type=apply_type;
		var apply_item=[];
		var apply_number=[];
		postJson.apply_item=[];
		postJson.apply_number=[];
		var mytt=".mytt"+apply_type;
		var $event=$(mytt).find(".s-event");
		for(var i=0;i<$event.length;i++){
			if($($event.get(i)).prop("checked")){
				apply_item.push($($event.get(i)).val());
				apply_number.push($($event.get(i)).siblings(".s-event-number").children('option:selected').val());
			}
		}
		postJson.apply_item=apply_item;
		postJson.apply_number=apply_number;
		//如果是团体报名，还要加一个最大人数
		if(apply_type=="2"){
			minNumber=0;
			for(var i=0;i<apply_item.length;i++){
				minNumber+=parseInt(parseInt(apply_item[i])/10)*parseInt(apply_number[i]);
			}
			var team_count=parseInt($("#team_count").val());
			if(team_count<minNumber){
				alert("最大报名人数不能少于"+minNumber+"人");
				return false;
			}
			else{
				postJson.team_count=team_count;
			}
		}
		//console.log(postJson);
		$.post("/h5/member/activity/"+edit,postJson,function(data, status) {
			if (data.code == 0) {
				window.location.href = '/h5/member/activity';
				return;
			} else {
				alert(data.msg);
				return;
			}

		});
	});

	});
</script>
<script type="text/javascript">
	$(function(){
		$("input[name='apply_type']").each(function(){
			var $this=$(this);
			var type=$this.val();
			if($this.attr("checked")){
				$(".mytt1").hide();
				$(".mytt2").hide();
				$(".mytt"+type).show();
			}
		});
		//个人报名和团体报名面板切换
		$(":radio").click(function(){
			if($(this).val()==1){
				$(".mytt2").hide();
				$(".mytt1").show();
			}else
			{
				$(".mytt2").show();
				$(".mytt1").hide();
			}
		});
		//报名时间和活动时间
		var startTime=null;
		var endTime=null;
		var applyStartTime=null;
		var applyEndTime=null;

		var dateConfig={
			display:'bottom',
			lang:'zh',
			dateOrder:'yymmdd',
			dateFormat:'yy/mm/dd',
			minDate:new Date('2015-11-11'),
			maxDate:new Date('2020-11-11'),
			onSelect:function(valueText,inst){
				startTime=(new Date($("#start_time").val())).getTime();
				endTime=(new Date($("#end_time").val())).getTime();
				applyStartTime=(new Date($('#apply_start_time').val())).getTime();
				applyEndTime=(new Date($('#apply_end_time').val())).getTime();
				if(applyEndTime<applyStartTime){
					alert("报名结束时间应大于报名开始时间,请重新选择");
					$("#apply_end_time").val("")

				}
				else if(startTime<applyStartTime){
					alert("活动开始时间应大于报名开始时间,请重新选择");
					$('#start_time').val("");
				}
				else if(endTime<startTime){
					alert("活动结束时间应大于活动开始时间,请重新选择");
					$('#end_time').val("")

				}

			}
		};
		var $startTime=$('#start_time').mobiscroll().datetime(dateConfig);
		var $endTime=$('#end_time').mobiscroll().datetime(dateConfig);
		var $applyStartTime=$('#apply_start_time').mobiscroll().datetime(dateConfig);
		var $applyEndTime=$('#apply_end_time').mobiscroll().datetime(dateConfig);

		//选择比赛项目
		$(".s-event").each(function(){
			var $this=$(this);
			$this.on("change",function(){
				if($this.prop("checked")){
					$this.siblings(".s-event-number").show();
					if($this.attr("id")=="personal_event_1"){
						$("#personal_event_2").parent().hide();
					}
					else if($this.attr("id")=="personal_event_2"){
						$("#personal_event_1").parent().hide();
					}
				}
				else{
					$this.siblings(".s-event-number").hide();
					if($this.attr("id")=="personal_event_1"){
						$("#personal_event_2").parent().show();
					}
					else if($this.attr("id")=="personal_event_2"){
						$("#personal_event_1").parent().show();
					}
				}
			});
		});
	});
</script>

</html>
