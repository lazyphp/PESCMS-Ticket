<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/css/amazeui.min.css"/>
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/js/jquery.min.js"></script>
    <script src="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/js/amazeui.min.js"></script>
    <!--<![endif]-->
    <style>
        html, body {
            -moz-background-size: 100% 100%;
            background-size: cover;
            background: url('<?=str_replace("/Install", "", DOCUMENT_ROOT)?>/Theme/assets/i/lattice.png');
        }

        .header {
            margin-top: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }

        .header p {
            font-size: 14px;
        }
        .am-panel-hd{
            color: #444;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            margin: 20px 0;
            text-align: center;
        }
        label{
            margin: 0;
        }
    </style>
</head>
<body>
<div class="am-g am-padding-top">
    <div class="am-u-lg-8 am-u-md-8 am-u-sm-centered">
        <div class="am-panel am-panel-default am-text-sm">
            <div class="am-panel-bd">
                <div class="pesad"></div>
                <script>
                    $(function () {
                        $.getJSON('https://www.pescms.com/pesad/2', function (data) {
                            if (data.status == 200) {
                                for (var i = 0; i < data.data.length; i++) {
                                    $('.pesad').append(data.data[i]);
                                }
                            } else {
                                $('.pesad').append('<a href="https://www.pescms.com/Page/ad.html" style="color: #fff;"><div class="am-vertical-align" style="background: #61cff9;height: 70px;text-align: center;"><div class="am-vertical-align-middle am-text-xxxl">广告投放</div></div></a>');
                            }
                        })
                    })
                </script>

                <div class="header">
                    <h1 class="am-margin-top-0"><?= $title ?>
                        <small class="am-text-xs">v<?= $version ?></small>
                    </h1>
                    <p>一款开源且简单得客服工单系统<br/>The open source ticket system</p>
                    <hr/>
                </div>
                <?php include $file; ?>

            </div>
            <form class="am-form am-form-horizontal" data-am-validator>
                <?php require 'Index/Index_config.php' ?>
                <?php require 'Index/Index_option.php' ?>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        var progress = $.AMUI.progress;

        $.ajax({
            url:'https://www.pescms.com/UserProtocol',
            dataType:'JSON',
            beforeSend:function(){
                progress.start();
            },
            success:function(data){
                $(".agree").html(data.data.replace(/\{program\}/g, "<?= $program ?>"));
                progress.done();
            },
            error:function(){
                $(".agree").html('拉取用户协议失败，请点击<a href="https://www.pescms.com/article/view/-1.html" target="_blank">https://www.pescms.com/article/view/-1.html</a>查阅用户协议')
                progress.done();
            }
        })

        var data = {
            id: 3,
            type: 1,
            version : '<?= $version ?>',
            sessionid : '<?= $this->session()->getId() ?>'
        };
//        $.post('https://www.pescms.com/?g=Api&m=Statistics&a=action', data, function (data) {
//        }, 'JSON')
    })
</script>
</body>
</html>