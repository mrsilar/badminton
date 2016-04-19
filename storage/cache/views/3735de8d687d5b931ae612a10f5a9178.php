<!doctype html>
<html class="no-js">
<head>
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/header'); ?>
</head>
<body>
  <form  method="post" action="/h5/club/person">
   <?php foreach((array) $list as $row) { ?>
  <p> <input  type="checkbox"  name="person_list[]"  value="<?php echo isset($row->id) ? $row->id : ''; ?>"     checked="checked"   /><?php echo isset($row->name) ? $row->name : ''; ?></p>
   <?php } ?>
   <input type="hidden"  name="club_id"  value="<?php echo isset($club_id) ? $club_id : ''; ?>"/>
   <button  type="submit" >确认</button>
   </form>
    </div>
    <?php PHPTemplate\TemplateManager::get('10f0926914da3a840bf2b3c5e22b47f0')->render('h5/common/footer'); ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/amazeui.min.js"></script>
    <style>
    li.sle a img {
        width: 80px;
        height: 40px;
    }
    </style>
</body>

</html>
