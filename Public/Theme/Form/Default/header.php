<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= $system['siteDescription'] ?>">
    <meta name="keywords" content="<?= $system['siteKeywords'] ?>">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= empty($title) ? '' : "{$title} - " ?><?= $system['siteTitle'] ?></title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link rel="icon" type="image/png" href="<?= DOCUMENT_ROOT ?>/favicon.ico?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/amazeui.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/app.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/index.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/ui-dialog.min.css?v=<?= $resources ?>">
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/amazeui.datetimepicker.css?v=<?= $resources ?>">
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/jquery.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.min.js?v=<?= $resources ?>"></script>

    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/dialog-min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/dialog-plus-min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/amazeui.datetimepicker.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.min.js?v=<?= $resources ?>"></script>

    <!--编辑器-->
    <script>var PESCMS_PATH = '<?= DOCUMENT_ROOT; ?>';</script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/ueditor.config.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/ueditor.all.min.js?v=<?= $resources ?>"></script>
    <script src="<?= DOCUMENT_ROOT ?>/Theme/assets/ueditor/lang/zh-cn/zh-cn.min.js?v=<?= $resources ?>"></script>

    <!--图片放大器-->
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/jquery.fancybox.min.js?v=<?=$resources?>"></script>
    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/jquery.fancybox.min.css?v=<?=$resources?>"/>
    <!--图片放大器-->

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

    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/app.min.js?v=<?= $resources ?>"></script>

    <?= !empty($system['siteStyle']) ? "<style>{$system['siteStyle']}</style>" : '' ?>

</head>
<body>