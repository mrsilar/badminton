<!doctype html>
<html class="no-js">
<head>
    <?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/header'); ?>
</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
    <h1 align="center" class="am-header-title"> 第二阶段计分信息 </h1>
</header>
<a class="am-btn am-btn-success"   href="/h5/member/activity/chang_table?activity_turn_id=<?php echo isset($activity_turn_id) ? $activity_turn_id : ''; ?>">人员调整</a>
<?php foreach($team_group as $key => $row) { ?>

<table class="am-table am-table-bordered am-table-radius am-table-striped">
    <thead>
    <tr>
        <th>第<?php echo isset($rank_from_to[$key][0]) ? $rank_from_to[$key][0] : ''; ?>~<?php echo isset($rank_from_to[$key][1]) ? $rank_from_to[$key][1] : ''; ?>名</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <?php foreach($row as $ke => $va) { ?>
        <td>
            <?php echo isset($va->team_name) ? $va->team_name : ''; ?>
        </td>
        <?php } ?>
    </tr>
    <?php foreach($row as $ka => $va) { ?>
    <tr>
        <td>
            <?php echo isset($va->team_name) ? $va->team_name : ''; ?>
        </td>
        <?php foreach($row as $kb => $vb) { ?>
        <td>
            <?php if ($va->team_id!=$vb->team_id) { ?>
            <?php if (isset($team_match[$key][$va->team_id][$vb->team_id])) { ?>
            <a style="color: #52b2ff" href="/h5/activity/resultsubinfo?team_match_id=<?php echo isset($team_match[$key][$va->team_id][$vb->team_id]->id) ? $team_match[$key][$va->team_id][$vb->team_id]->id : ''; ?>">
                <?php echo isset($team_match[$key][$va->team_id][$vb->team_id]->win_a) ? $team_match[$key][$va->team_id][$vb->team_id]->win_a : ''; ?>
                :
                <?php echo isset($team_match[$key][$va->team_id][$vb->team_id]->win_b) ? $team_match[$key][$va->team_id][$vb->team_id]->win_b : ''; ?>
            </a>
            <?php } else { ?>
            <a style="color: #52b2ff" href="/h5/activity/resultsubinfo?team_match_id=<?php echo isset($team_match[$key][$vb->team_id][$va->team_id]->id) ? $team_match[$key][$vb->team_id][$va->team_id]->id : ''; ?>">
                <?php echo isset($team_match[$key][$vb->team_id][$va->team_id]->win_b) ? $team_match[$key][$vb->team_id][$va->team_id]->win_b : ''; ?>
                :
                <?php echo isset($team_match[$key][$vb->team_id][$va->team_id]->win_a) ? $team_match[$key][$vb->team_id][$va->team_id]->win_a : ''; ?>
            </a>
            <?php } ?>
            <?php } ?>
        </td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
</table>
<?php } ?>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">
</script>
</body>
</html>