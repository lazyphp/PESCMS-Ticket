<?php include THEME_PATH . '/header.php'; ?>
<div class="login">
    <div class="am-g am-margin-bottom-xl">
        <div class="am-u-sm-12 am-u-lg-4 am-u-sm-centered ">
            <div class="am-text-center am-margin-bottom">
                <a href="<?= DOCUMENT_ROOT ?>/"><img class="login-logo " src="<?= $system['siteLogo'] ?>" width="128"></a>
            </div>
            <div class="am-panel am-panel-default login-panel ">
                    <form class="am-form ajax-submit" id="login-enterplorer" method="post" data-am-validator>
                        <div class="login-tab am-active">
                            <h3><?= $title ?></h3>
                        </div>
                        <?= $label->token() ?>
                        <?php require 'Login_' . ACTION . '.php' ?>
                    </form>
            </div>
        </div>
    </div>
</div>
