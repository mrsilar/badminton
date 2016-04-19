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
    <h1 align="center" class="am-header-title"> 计分 </h1>
</header>
<?php foreach((array) $group_match_team_match as $row) { ?>

        <table class="am-table am-table-bordered am-table-radius am-table-striped">
            <thead>
            <tr>
                <th>第<?php echo isset($row->group_a) ? $row->group_a : ''; ?>组&nbsp;&nbsp;&nbsp;第<?php echo isset($row->group_b) ? $row->group_b : ''; ?>组</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <?php foreach($team_group[$row->group_b] as $key => $val) { ?>
                <td>
                 <?php echo isset($val->team_name) ? $val->team_name : ''; ?>
                </td>
                <?php } ?>
            </tr>
            <?php foreach($team_group[$row->group_a] as $ka => $va) { ?>
            <tr>
                <td>
                    <?php echo isset($va->team_name) ? $va->team_name : ''; ?>
                </td>
                <?php foreach($team_group[$row->group_b] as $kb => $vb) { ?>
                <td>
                    <a style="color: #52b2ff" href="/h5/member/activity/set/score_sub?team_match_id=<?php echo isset($team_match[$row->id][$va->team_id][$vb->team_id]->id) ? $team_match[$row->id][$va->team_id][$vb->team_id]->id : ''; ?>">
                        <?php echo isset($team_match[$row->id][$va->team_id][$vb->team_id]->win_a) ? $team_match[$row->id][$va->team_id][$vb->team_id]->win_a : ''; ?>
                        :
                        <?php echo isset($team_match[$row->id][$va->team_id][$vb->team_id]->win_b) ? $team_match[$row->id][$va->team_id][$vb->team_id]->win_b : ''; ?>
                    </a>

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