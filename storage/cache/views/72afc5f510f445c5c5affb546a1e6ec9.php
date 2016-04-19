<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1><?php echo isset($error) ? $error : ''; ?></h1>
<p class="jump">
<a id="href" href="<?php echo isset($url) ? $url : ''; ?>"></a> 等待时间： <b id="wait"><?php echo isset($time)?$time:1?></b>
</p>
</body>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</html>