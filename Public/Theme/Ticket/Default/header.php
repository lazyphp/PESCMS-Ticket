<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="PESCMS,PESCMS Ticket,开源的工单系统,工单系统,工单客服系统,客服工单系统,GPL工单,GPL客服系统,GPL工单客服系统">
    <meta name="keywords" content="PESCMS Ticket是一款以GPLv2协议发布的开源工单客服系统">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-pjax-version" content="v123">

    <title><?= !empty($title) ? "{$title} - " : '' ?>PESCMS Ticket</title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <link rel="icon" type="image/png" href="<?= DOCUMENT_ROOT ?>/favicon.ico?v=<?= $system['version'] ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/amazeui.min.css?v=<?= $system['version'] ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/app.css?v=<?= $system['version'] ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/ticket.css?v=<?= $system['version'] ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/ui-dialog.css?v=<?= $system['version'] ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/amazeui.datetimepicker.css?v=<?= $system['version'] ?>">
    <script>
        var PESCMS_URL = 'https://www.pescms.com';
        var PESCMS_PATH = '<?= DOCUMENT_ROOT; ?>';
    </script>
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/jquery.min.js?v=<?= $system['version'] ?>"></script>
    <!--<![endif]-->
    <!--[if lte IE 8 ]>
    <script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js?v=<?= $system['version'] ?>"></script>
    <script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.ie8polyfill.min.js"></script>
    <![endif]-->
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.min.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/dialog-min.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/dialog-plus-min.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.datetimepicker.min.js?v=<?= $system['version'] ?>"></script>


    <script>var path = '<?= DOCUMENT_ROOT; ?>';</script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/ueditor_ticket.config.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/ueditor.all.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/lang/zh-cn/zh-cn.js?v=<?= $system['version'] ?>"></script>



    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.js?v=<?= $system['version'] ?>"></script>
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/spectrum.css?v=<?= $system['version'] ?>"/>


    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/app.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/ticket.js?v=<?= $system['version'] ?>"></script>


    <!--百度上传控件-->
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/webuploader.css?v=<?= $system['version'] ?>"/>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/webuploader.js?v=<?= $system['version'] ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/AMUIwebuploader.js?v=<?= $system['version'] ?>"></script>
    <script>
        $(function(){
            $.webuploaderConfig({
                server:'<?=$label->url('Upload-ueditor', ['method' => 'POST', 'action' => 'uploadimage'])?>'
            });
        })
    </script>
    <!--百度上传控件-->

</head>
<body>