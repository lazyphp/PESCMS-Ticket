<?php include THEME_PATH.'/header.php'; ?>
<?php include THEME_PATH.'/Topbar.php'; ?>
<div class="am-g jump-page">
    <div class="am-u-sm-12 am-u-lg-8  am-u-lg-centered">
        <div class="am-text-center">
            <h1><?= $message; ?></h1>
            <h2>页面自动 <a href="<?= $jumpUrl; ?>">跳转</a> 等待时间： <span id="wait"><?= $waitSecond; ?></span></h2>
            <a href="<?= $jumpUrl; ?>" id="href" class="am-btn am-btn-white am-radius " style="width: 25rem">确认</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    (function () {
        var wait = document.getElementById('wait'), href = document.getElementById('href').href;
        var interval = setInterval(function () {
            var time = --wait.innerHTML;
            if (time <= 0) {
                location.href = href;
                clearInterval(interval);
            }
            ;
        }, 1000);
    })();
</script>
<?php include THEME_PATH.'/footer.php'; ?>
<!--请勿删除页脚这部分代码，否则会导致程序异常-->
