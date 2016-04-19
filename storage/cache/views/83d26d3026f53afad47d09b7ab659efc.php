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
    <h1 align="center" class="am-header-title"> 第<?php echo isset($turn) ? $turn : ''; ?>阶段比赛晋级</h1>
</header>

<div data-am-widget="tabs" class="am-tabs am-tabs-default">
    <?php foreach($rank as $key => $row) { ?>
    <table class="am-table am-table-bordered am-table-radius am-table-striped">
        <tbody>
        <?php foreach((array) $row as $r) { ?>
        <tr>
            <td>
                <?php echo isset($r->team_a_name) ? $r->team_a_name : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo isset($r->status_a) ? $r->status_a : ''; ?>
            <td>~</td>
            <td><?php echo isset($r->team_b_name) ? $r->team_b_name : ''; ?> &nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo isset($r->status_b) ? $r->status_b : ''; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>


</div>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
</body>
</html>