<?php include THEME_PATH . '/header.php'; ?>
<div class="login">
    <div class="am-g am-margin-bottom-xl">
        <div class="am-u-sm-12 am-u-lg-4 am-u-sm-centered ">
            <div class="am-text-center am-margin-bottom">
                <a href="<?= DOCUMENT_ROOT ?>/"><img class="login-logo " src="<?= $system['siteLogo'] ?>" width="128"></a>
            </div>
            <?php if(in_array($_GET['signup_complete'], ['0', '2'])): ?>
            <div class="am-alert am-alert-warning am-radius am-text-sm">
                <i class="am-icon-exclamation"></i> <?= $_GET['signup_complete'] == 2 ? '刚注册的账号需要进行邮件激活才可以登录。' : '刚注册的账号需要审核完毕才可以登录。' ?>
            </div>
            <?php endif; ?>
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
