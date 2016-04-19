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
    <h1 align="center" class="am-header-title"> 第2阶段分组信息 </h1>
</header>
<div class="am-tabs-bd">
           <?php foreach($list as $key2 => $row2) { ?>
           <h1>第<?php echo isset($key2) ? $key2 : ''; ?>大组</h1>
    <div >
       <?php foreach($row2 as $key => $row) { ?>
<table class="am-table am-table-bordered am-table-radius am-table-striped">
    <thead>
    <tr>
        <th>第<?php echo isset($row->group_a) ? $row->group_a : ''; ?>组&nbsp;&nbsp;&nbsp;&nbsp;第<?php echo isset($row->group_b) ? $row->group_b : ''; ?>组</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <?php foreach($team_group_list[$key2][$row->group_b] as $ki => $vi) { ?>
        <td>
            <?php echo isset($vi->team_name) ? $vi->team_name : ''; ?>
        </td>
        <?php } ?>
    </tr>
    <?php foreach($team_group_list[$key2][$row->group_a] as $kii => $vii) { ?>
    <tr>
        <td>
            <?php echo isset($vii->team_name) ? $vii->team_name : ''; ?>
        </td>
        <?php foreach($team_group_list[$key2][$row->group_b] as $kib => $vib) { ?>
        <td>
            <?php if (isset($team_match[$row->id][$vii->team_id][$vib->team_id])) { ?>
            <a style="color: #52b2ff" href="/h5/activity/resultsubinfo?team_match_id=<?php echo isset($team_match[$row->id][$vii->team_id][$vib->team_id]->id) ? $team_match[$row->id][$vii->team_id][$vib->team_id]->id : ''; ?>">
                <?php echo isset($team_match[$row->id][$vii->team_id][$vib->team_id]->win_a) ? $team_match[$row->id][$vii->team_id][$vib->team_id]->win_a : ''; ?>
                :
                <?php echo isset($team_match[$row->id][$vii->team_id][$vib->team_id]->win_b) ? $team_match[$row->id][$vii->team_id][$vib->team_id]->win_b : ''; ?>
            </a>
            <?php } ?>
        </td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
</table>
<?php } ?>
<?php } ?>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
