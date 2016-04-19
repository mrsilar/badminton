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
    <h1 align="center" class="am-header-title"> 比赛排名 </h1>
</header>
<div>

    <table class="am-table">
        <thead>
        <tr>
            <th>队伍名称</th>
            <th>名次</th>
            <?php if ($rank_is==1) { ?>
            <th>修改</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach((array) $rank as $r) { ?>
        <tr>
            <td><?php echo isset($r->team_name) ? $r->team_name : ''; ?></td>
            <td>
                <?php if ($rank_is == 1) { ?>
                <input value="<?php echo $r->rank==10000?'暂无':$r->rank; ?>" class="rankclass">
                <input type="hidden" value="<?php echo isset($r->id) ? $r->id : ''; ?>" class="idclass">
                <?php } else { ?>
                <?php echo $r->rank==10000?'暂无':$r->rank; ?>
                <?php } ?>
            </td>
            <?php if ($rank_is==1) { ?>
            <td>
                <button class="fbtnid">确认</button>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>

        <?php foreach((array) $rank_no as $r2) { ?>
        <tr>
            <td><?php echo isset($r2->team_name) ? $r2->team_name : ''; ?></td>
            <td>
                <?php if ($rank_is==1) { ?>
                <input value="<?php echo $r->rank==10000?'暂无':$r->rank; ?>" class="rankclass">
                <input type="hidden" value="<?php echo isset($r->id) ? $r->id : ''; ?>" class="idclass">
                <?php } else { ?>
                <?php echo $r->rank==10000?'暂无':$r->rank; ?>
                <?php } ?>
            </td>
            <?php if ($rank_is==1) { ?>
            <td>
                <button class="fbtnid">确认</button>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/set/rank?activity_turn_id=<?php echo isset($activity_turn_id) ? $activity_turn_id : ''; ?>&rank=0">自动排名</a>

    <a type="button" class="am-btn am-btn-warning" href="/h5/member/activity/set/rank?activity_turn_id=<?php echo isset($activity_turn_id) ? $activity_turn_id : ''; ?>&rank=1">手动排名</a>
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