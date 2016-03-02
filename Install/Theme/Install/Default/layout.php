<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="icon" type="image/png" href="/favicon.ico">
        <link rel="stylesheet" href="<?=str_replace("/Install", "", DOCUMENT_ROOT)?>/Theme/assets/css/amazeui.min.css"/>
        <!--[if (gte IE 9)|!(IE)]><!-->
        <script src="<?=str_replace("/Install", "", DOCUMENT_ROOT)?>/Theme/assets/js/jquery.min.js"></script>
        <script src="<?=str_replace("/Install", "", DOCUMENT_ROOT)?>/Theme/assets/js/amazeui.min.js"></script>
        <!--<![endif]-->
        <style>
            .header {
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
        </style>
    </head>
    <body>
        <div class="header">
            <div class="am-g">
                <h1><?= $title ?></h1>
                <?php if (ACTION == 'index'): ?>
                    <p>一款开源且简单得客服工单系统<br />The open source ticket system</p>
                <?php elseif (ACTION == 'config'): ?>
                    <p>进行常规检查，看看我们是否合适。</p>
                <?php elseif (ACTION == 'option'): ?>
                    <p>还差一点，我们就能见面了!</p>
                <?php endif; ?>
            </div>
            <hr />
        </div>
        <?php include $file; ?>

    </body>
</html>