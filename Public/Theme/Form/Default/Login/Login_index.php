<div class="am-form-group">
    <input type="email" name="email" placeholder="邮箱地址" required="required">
</div>
<div class="am-form-group">
    <input type="password" name="password" placeholder="登录密码" required="required">
</div>

<div class="am-form-group">
    <input type="text" class="login-verify" maxlength="7" name="verify" placeholder="验证码" required="">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>
<div class="am-g">
    <div class="am-u-sm-6 am-u-md-6 am-u-lg-6" style="border-right: 1px solid silver">
        <a href="<?= $label->url('Login-signup') ?>">注册帐号</a>
    </div>
    <div class="am-u-sm-6 am-u-md-6 am-u-lg-6">
        <a href="<?= $label->url('Login-findpw') ?>">忘记密码</a>
    </div>
</div>
<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>">
