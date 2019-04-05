<?php include THEME_PATH . '/header.php'; ?>
<?php include THEME_PATH.'/Topbar.php'; ?>
<div class="login">
    <div class="am-g  login-form-wrap">
	    <div class="am-u-lg-3 am-hide-md-dow">

	    </div>
        <div class="am-u-sm-12 am-u-lg-4">
            <div class="am-panel am-panel-default login-form">
                <div class="am-text-center">
                    <h2 class="login-text-danger"><?= $title ?></h2>
                    <form class="am-form ajax-submit am-padding" id="login-enterplorer" method="post" data-am-validator>
                        <?= $label->token() ?>
                        <?php require 'Login_' . ACTION . '.php' ?>

                        <input type="submit" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--背景版权来自NASA https://www.nasa.gov/multimedia/imagegallery/image_feature_693.html-->
<style>
    html, body{
        -moz-background-size: 100% 100%;
        background-size: cover;
        background-image: url('<?= DOCUMENT_ROOT; ?>/Theme/assets/i/162284main_image_feature_693_ys_full.jpg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    header{
        opacity: 0.1;
        transition: opacity 0.3s linear;
    }
    header:hover{
        opacity: 1;
        transition: opacity 0.3s linear;
    }
    .my-footer{
        display: none;
    }
</style>
<?php include THEME_PATH . '/footer.php'; ?>