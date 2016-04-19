<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="http://s.amazeui.org/assets/2.x/css/amaze.min.css?v=ifp65slu">
    <style>
        li.sle a img{ width:80px; height:40px;}
        .z-game{border-bottom:1px solid #ddd;text-align:center;width:100%;}
        .z-game-info{background:#66CCFF; font-size:12px;}
        .z-game-info .fbtn{margin:auto;}
    </style>
</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="/h5/member/activity" class=""> <img  src="/assets/images/jtou.png"/> </a> </div>
    </div>
    <h1 align="center" class="am-header-title"> 比赛名称 </h1>
</header>

<form class="am-form s-form" method="post" action="/h5/member/activity/group">
    <fieldset>
        <legend><h1>第<?php echo isset($row->turn) ? $row->turn : ''; ?>轮</h1></legend>
        <?php if ($row->can_change) { ?>
        <?php if ($row_prev&&$row_prev->game_system==0) { ?><?php } else { ?>
        <div class="am-form-group nid"  id="nid">
            <label for="doc-ipt-email-1">分组数</label>
            <select data-am-selected name="group_count">
                <option value="0">请选择</option>
                <?php foreach((array) $team_count_list as $val) { ?>
                <option value="<?php echo isset($val) ? $val : ''; ?>"><?php echo isset($val) ? $val : ''; ?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
        <?php } ?>

        <fieldset   <?php if (!$row->can_change) { ?> disabled <?php } ?>>

            <div class="am-form-group">
                    <?php if ($row_prev&&$row_prev->game_system==0) { ?>
                    <label class="am-radio-inline">
                        <input type="radio" name="game_system" class="noids"  checked        name="docInlineRadio" id="ddf"  value="0"> 淘汰赛
                    </label>
                    <?php } else { ?>
                    <label class="am-radio-inline">
                        <input type="radio" name="game_system" class="noids" <?php if ($row->game_system==0) { ?> checked <?php } ?>       name="docInlineRadio" id="ddf"  value="0"> 淘汰赛
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="game_system" class="yesids" <?php if ($row->game_system==2) { ?>checked<?php } ?>   name="docInlineRadio"  value="2"> 内循环　
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio"  name="game_system"  class="yesids" <?php if ($row->game_system==1) { ?>checked<?php } ?>   name="docInlineRadio"  value="1"> 外循环　　
                    </label>
                    <?php } ?>
            </div>
        </fieldset>
        <?php if ($row->can_change) { ?>
        <p><button type="submit" class="am-btn am-btn-default">分组</button></p>
        <?php } ?>
        <?php if (!$row->can_change) { ?>
        <a href="/h5/activity/groupinfo?activity_turn_id=<?php echo isset($row->id) ? $row->id : ''; ?>">查看结果</a>
        <?php } ?>
    </fieldset>
    <input type="hidden"  name="activity_id"  value="<?php echo isset($row->activity_id) ? $row->activity_id : ''; ?>">
    <input type="hidden"  name="activity_turn_id"  value="<?php echo isset($row->id) ? $row->id : ''; ?>">
    <input type="hidden"  name="turn"  value="<?php echo isset($row->turn) ? $row->turn : ''; ?>">
</form>
<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">
    $(function(){
        $(".s-form").each(function(){
            var $this=$(this);
            var $yesids=$this.find(".yesids");
            var $noids=$this.find(".noids");
            var $nid=$this.find(".nid");

            if($noids.attr("checked")) $nid.hide();
            else $nid.show();

            $noids.click(function(){
                $nid.slideUp();
            });
            $yesids.click(function(){
                $nid.slideDown();
            });
        });
    });
</script>
</body>
</html>
