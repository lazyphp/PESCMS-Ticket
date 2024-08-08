<div class="am-text-sm am-margin-vertical">
    <p>您的账号还没完成激活，请登录「<?= self::session()->get('toBeActivated') ?>」邮箱进行激活。</p>
    <p>
        若长时间没有收到邮件，请点击<a href="<?= $label->url('Login-reActivate') ?>" class="ajax-click">重新发送</a>。
    </p>
</div>

<hr/>

<div class="am-text-sm am-margin-vertical">
    <a href="<?= $label->url('Login-index') ?>" class="login-signup-link"> <i class="am-icon-arrow-left"></i> 返回账号密码登录</a>
</div>