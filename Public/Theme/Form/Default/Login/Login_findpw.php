<div class="am-form-group">
    <input type="email" name="email" placeholder="邮箱地址" required="required">
</div>
<div class="am-form-group">
    <input type="text" class="login-verify" maxlength="4" name="verify" placeholder="验证码" required="">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>