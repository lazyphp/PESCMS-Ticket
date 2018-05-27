<div class="am-form-group">
    <input type="password" name="passwd" placeholder="密码" required="required">
</div>
<div class="am-form-group">
    <input type="password" name="repasswd" placeholder="确认密码" required="required">
</div>
<div class="am-form-group">
    <input type="text" class="login-verify" maxlength="4" name="verify" placeholder="验证码" required="">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>