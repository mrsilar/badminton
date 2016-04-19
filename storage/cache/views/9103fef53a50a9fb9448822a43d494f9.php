<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>赛况</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="http://s.amazeui.org/assets/2.x/css/amaze.min.css?v=ifp65slu">
    <style>
        li.sle a img {
            width: 80px;
            height: 40px;
        }

        .z-game {
            border-bottom: 1px solid #ddd;
            text-align: center;
            width: 100%;
        }

        .z-game-info {
            background: #66CCFF;
            font-size: 12px;
        }

        .z-game-info .fbtn {
            margin: auto;
        }
    </style>
</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 第<?php echo isset($turn) ? $turn : ''; ?>轮比赛结果 </h1>
</header>
<div data-am-widget="tabs" class="am-tabs am-tabs-default">
    <ul class="am-tabs-nav am-cf">
        <li class="am-active"><a href="[data-tab-panel-0]">排名</a></li>
        <li class=""><a href="[data-tab-panel-1]">比分</a></li>
    </ul>
    <div class="am-tabs-bd">
        <div data-tab-panel-0 class="am-tab-panel am-active">
                <?php foreach($rank as $key => $row) { ?>
            <table class="am-table">
                <thead>
                <tr>
                    <th>第<?php echo isset($key) ? $key : ''; ?>组</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach((array) $row as $r) { ?>
                <tr>
                    <td><?php echo isset($r->team_name) ? $r->team_name : ''; ?></td>
                    <td><?php echo $r->rank==1?'晋级':'淘汰'; ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
                 <?php } ?>
        </div>
        <div data-tab-panel-1 class="am-tab-panel ">
            <?php foreach($team_group as $key => $row) { ?>
            <table class="am-table">
                <thead>
                <tr>
                    <th>第<?php echo isset($key) ? $key : ''; ?> 组</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach((array) $row as $r) { ?>
                <tr>
                    <td><?php echo isset($r->team_a_name) ? $r->team_a_name : ''; ?>
                        VS
                        <?php echo isset($r->team_b_name) ? $r->team_b_name : ''; ?>
                    </td>

                    <td><?php echo $r->win_a?:0; ?>
                        :
                        <?php echo $r->win_b?:0; ?>
                    </td>
                    <td><a href="/h5/activity/resultsubinfo?team_match_id=<?php echo isset($r->id) ? $r->id : ''; ?>">详细信息</a></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>