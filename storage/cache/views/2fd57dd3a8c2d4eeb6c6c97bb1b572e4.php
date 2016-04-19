<ul data-am-widget="pagination" class="am-pagination am-pagination-default">
    <li class="am-pagination-prev ">
        <a href="<?php echo isset($page['prevUrl']) ? $page['prevUrl'] : ''; ?>" class="">上一页</a>
    </li>
    <?php for($i=1;$i<=$page['totalPage'];$i++){?>
    <li class="">
        <a href="<?php echo $page['url'].$i; ?>" <?php if ($i==$page['nowPage']) {?> class="am-active" style="color:#0064FF"<?php }?> ><?php echo isset($i) ? $i : ''; ?></a>
    </li>
    <?php }?>
    <li class="am-pagination-next ">
        <a href="<?php echo isset($page['nextUrl']) ? $page['nextUrl'] : ''; ?>" class="">下一页</a>
    </li>
</ul>
