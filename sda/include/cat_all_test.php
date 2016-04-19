<?php

/**
 * ECSHOP 分类聚合页
 * ============================================================================
 * * 版权所有 2005-2012 琪琦网购商城，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liuhui $
 * $Id: index.php 15013 2010-03-25 09:31:42Z liuhui $
 */

define('IN_ECTOUCH', true);

require(dirname(__FILE__) . '/include/init.php');
$pcat_array = get_categories_tree();

    $all_childs=[];
    foreach ($pcat_array as $key => $pcat_data) {
        if ($pcat_data['cat_id']) {
            foreach ($pcat_data['cat_id'] as $k => $v) {
            	$all_childs[]=$v;
            }
        }
    }
        $pcat_array[0]=[];
        $pcat_array[0]['id']=0;
        $pcat_array[0]["name"]=" 全部分类 ";
        $pcat_array[0]["url"]="category.php";
        $pcat_array[0]["ico"]="";
        $pcat_array[0]["cat_id"]=$all_childs;
        ksort($pcat_array);

$cat_id=0;
$smarty->assign('pcat_array', $pcat_array);
if($_GET['tem']=='a')
{
$smarty->display("frame_a.dwt");
}elseif($_GET['tem']=='b'){
      $smarty->assign('cat_id', $cat_id);
$smarty->display("frame_b.dwt");
}elseif($_GET['tem']=='top'){
$smarty->display("frame_top.dwt");
}elseif(isset($_GET['cat_id'])){
    $smarty->assign('cat_id', $_GET['cat_id']);
    $smarty->display("frame_b.dwt");
}
else{
$smarty->display("category_allbak.dwt");
}
?>