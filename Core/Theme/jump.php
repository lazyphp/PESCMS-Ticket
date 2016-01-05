<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <title>提示信息</title>
        <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css"/>
    </head>
    <body class="p-background-color-fbfbfb">
        <div class="am-vertical-align" style="height: 500px">
            <div class="am-g am-vertical-align-middle">
                <div class="am-u-sm-10 am-u-sm-centered am-text-sm">
                    <div class="am-panel am-panel-default">
                        <div class="am-panel-hd">系统提示</div>
                        <div class="am-panel-bd am-text-xs">
                            <div class="am-padding-left-lg">
                                <p><?= $message; ?></p>
                                <p>页面自动 <a href="<?= $jumpUrl; ?>">跳转</a> 等待时间： <span id="wait"><?= $waitSecond; ?></span></p>
                                <a href="<?= $jumpUrl; ?>" id="href" class="am-btn am-btn-default am-btn-xs">确认</a>
                            </div>
                        </div>
                    </div>
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
    </body>
</html>