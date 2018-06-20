<?php include THEME_PATH . '/header.php'; ?>
<?php include THEME_PATH.'/Topbar.php'; ?>
<div class="login">
    <div class="am-g am-container login-form-wrap">
	    <div class="am-u-sm-8 am-u-md-4 am-u-lg-3">

	    </div>
        <div class="am-u-sm-4 am-u-lg-4">
            <div class="am-panel am-panel-default login-form">
                <div class="am-panel-bd am-text-center">
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
<?php include THEME_PATH . '/footer.php'; ?>