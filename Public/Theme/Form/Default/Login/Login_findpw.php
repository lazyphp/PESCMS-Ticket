<div class="loginFlow">
    <input type="email" name="email" class="pes-login-input" placeholder="邮箱地址" required="required">
    <span>邮箱地址</span>
</div>

<div class="login-verify">
    <div class="am-alert am-alert-secondary am-text-center">
        <span class="am-text-xs am-block am-margin-bottom-xs">请将图中的字符输入在验证码输入框</span>
        <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify am-text-center">
    </div>

    <div class="loginFlow">
        <input type="text" class="pes-login-input" name="verify" placeholder="验证码" maxlength="<?= $system['verifyLength'] ?>" autocomplete="off" required>
        <span>验证码</span>
    </div>
</div>


<button type="submit" class="am-btn am-btn-primary am-radius am-btn-sm am-margin-top am-btn-block">提交</button>

<div class="am-text-sm am-margin-vertical">
    <a href="<?= $label->url('Login-index') ?>" class="login-signup-link" > <i class="am-icon-arrow-left"></i> 我想起账号密码了！</a>
</div>