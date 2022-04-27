<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= $system['siteDescription'] ?>">
    <meta name="keywords" content="<?= $system['siteKeywords'] ?>">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-pjax-version" content="v123">

    <title><?= !empty($title) ? "{$title} - " : '' ?><?= $authorize_type == 0 ? 'PESCMS Ticket' : $system['siteTitle'] ?></title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <link rel="icon" type="image/png" href="<?= DOCUMENT_ROOT ?>/favicon.ico?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/amazeui.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/app.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/ticket.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/ui-dialog.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/amazeui.datetimepicker.css?v=<?= $resources ?>">
    <script>
        var PESCMS_URL = '<?= PESCMS_URL ?>';
        var PESCMS_PATH = '<?= DOCUMENT_ROOT; ?>';
        var SITE_URL = '<?= $system['domain']; ?>';
        var SITE_LOGO = '<?= $system['siteLogo']; ?>';

        let BROWSER_MSG = '<?= self::session()->get('ticket')['user_browser_msg'] == 1 ? 1 : 0; ?>';
        let BROWSER_MSG_TIME = '<?= empty(self::session()->get('ticket')['user_browser_msg_time'] ) ? 6000 : self::session()->get('ticket')['user_browser_msg_time'] * 63000; ?>';

    </script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/jquery.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/dialog-min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/dialog-plus-min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.datetimepicker.min.js?v=<?= $resources ?>"></script>


    <script>var path = '<?= DOCUMENT_ROOT; ?>';</script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/ueditor_ticket.config.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/ueditor.all.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/lang/zh-cn/zh-cn.min.js?v=<?= $resources ?>"></script>


    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.min.js?v=<?= $resources ?>"></script>
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/spectrum.min.css?v=<?= $resources ?>"/>

    <!--图片放大器-->
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/jquery.fancybox.min.js?v=<?=$resources?>"></script>
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/jquery.fancybox.min.css?v=<?=$resources?>"/>
    <!--图片放大器-->


    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/app.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/ticket.min.js?v=<?= $resources ?>"></script>


    <!--百度上传控件-->
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/webuploader.min.css?v=<?= $resources ?>"/>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/webuploader.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/AMUIwebuploader.min.js?v=<?= $resources ?>"></script>
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