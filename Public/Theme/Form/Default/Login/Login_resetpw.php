<div class="loginFlow">
    <input type="password" name="password" class="pes-login-input" placeholder="新密码" minlength="6" data-am-popover="{trigger:'focus', theme: 'danger sm', content: '请输入不小于6位数的密码'}" required="required">
    <span>新密码</span>
</div>

<div class="loginFlow">
    <input type="password" name="repassword" class="pes-login-input" placeholder="确认新密码" minlength="6" data-am-popover="{trigger:'focus', theme: 'danger sm', content: '请输入不小于6位数的密码'}" required="required">
    <span>确认新密码</span>
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