<?php include THEME_PATH . '/header.php'; ?>
<?php include THEME_PATH.'/Topbar.php'; ?>
<div class="login">
    <div class="am-g  login-form-wrap am-margin-bottom-xl">
        <div class="am-u-sm-12 am-u-lg-5 am-u-sm-centered ">
            <div class="am-panel am-panel-default login-form ">
                <div class="am-text-center">
                    <h2 class="login-text-danger am-text-xxl"><?= $title ?></h2>
                    <form class="am-form ajax-submit am-padding" id="login-enterplorer" method="post" data-am-validator>
                        <?= $label->token() ?>
                        <?php require 'Login_' . ACTION . '.php' ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include THEME_PATH . '/footer.php'; ?>