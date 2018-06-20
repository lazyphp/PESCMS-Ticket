<div class="am-form-group">
    <input type="text" maxlength="10" name="name" placeholder="用户名称" required="required">
</div>

<div class="am-form-group">
    <input type="email" name="email" placeholder="邮箱地址" required="required">
</div>
<div class="am-form-group">
    <input type="text" name="phone" placeholder="手机号码" required="required">
</div>
<div class="am-form-group">
    <input type="password" name="password" placeholder="密码" required="required">
</div>
<div class="am-form-group">
    <input type="password" name="repassword" placeholder="确认密码" required="required">
</div>

<div class="am-form-group">
    <input type="text" class="login-verify" maxlength="7" name="verify" placeholder="验证码" required="">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>