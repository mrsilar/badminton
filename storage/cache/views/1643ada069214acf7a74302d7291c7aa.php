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
    <h1 align="center" class="am-header-title"> 第<?php echo isset($turn) ? $turn : ''; ?>阶段比赛排名 </h1>
</header>
<div>
    <?php foreach($rank as $key => $row) { ?>
    <h1>第<?php echo isset($key) ? $key : ''; ?>组(第<?php echo isset($row['from']) ? $row['from'] : ''; ?>~<?php echo isset($row['to']) ? $row['to'] : ''; ?>名)</h1>

    <table class="am-table">
        <thead>
        <tr>
            <th>队伍名称</th>
            <th>名次</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach((array) $row['data'] as $r) { ?>
        <tr>
            <td><?php echo isset($r->team_name) ? $r->team_name : ''; ?></td>
            <td>
                <?php echo $r->rank==10000?'暂无':$r->rank; ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</div>
<?php PHPTemplate\TemplateManager::get('fb63d470854b1bdc7e9d5f85bf7d68cd')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $(".fbtnid").click(function () {
            var $this = $(this);
            var now = $this.parent().parent();
            console.log(now);
            $.post("/h5/member/activity/set/rank",
                    {
                        rank: now.find(".rankclass").val(),
                        id: now.find(".idclass").val(),
                    },

                    function (data, status) {
                        if (data.code == 0) {

                        } else {
                            alert(data.msg);
                        }

                    });
        });
    });
</script>
</body>
</html>