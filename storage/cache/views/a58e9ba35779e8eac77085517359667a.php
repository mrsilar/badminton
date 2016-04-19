<!doctype html>
<html class="no-js">
<head><?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>

</head>
<body>
<header data-am-widget="header"
        class="am-header am-header-default">
    <div class="am-header-left am-header-nav">
        <div align="center"><a href="javascript:history.go(-1)" class=""> <img src="/assets/images/jtou.png"/> </a>
        </div>
    </div>
</header>
<!-- Menu -->
<form class="am-form" method="post" action="/h5/member/activity/specail/four/change_member_last">
    <fieldset>
        <legend>请选择替换人员</legend>
        <div class="am-form-group">
            <label for="doc-select-2"></label>
            <input type="hidden"  name="team_match_id" value="<?php echo isset($team_match_id) ? $team_match_id : ''; ?>">
			<input type="hidden" name="category_member_id" value="<?php echo isset($category_member_id) ? $category_member_id : ''; ?>">
            <input type="hidden"  name="type" value="<?php echo isset($type) ? $type : ''; ?>">
            <input type="hidden"  name="mem_id" value="<?php echo isset($mem_id) ? $mem_id : ''; ?>">
			<input type="radio"  name="person_id" value="<?php echo isset($mem_id) ? $mem_id : ''; ?>" checked style="display:none">
                <?php foreach((array) $person_list as $row) { ?>
           <div style="float:left; width:25%; margin-top:10px; margin-bottom:10px;"> <input type="radio"  name="person_id" value="<?php echo isset($row->id) ? $row->id : ''; ?>"><?php echo isset($row->name) ? $row->name : ''; ?> </div>
                <?php } ?>
        </div>
        <p><button type="submit" style="border-radius:10px; background:#09C; color:#fff; margin-top:20px; margin-bottom:20px; width:80%; margin-left:10%;" class="am-btn am-btn-default">提交</button></p>
    </fieldset>
</form>
<?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
<script src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
<script src="/assets/js/amazeui.min.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
