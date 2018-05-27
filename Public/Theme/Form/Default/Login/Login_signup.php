<div class="am-form-group">
    <input type="text" maxlength="10" name="name" placeholder="用户名称" required="required">
</div>

<div class="am-form-group">
    <input type="email" name="email" placeholder="邮箱地址" required="required">
</div>
<div class="am-form-group">
    <input type="password" name="password" placeholder="密码" required="required">
</div>
<div class="am-form-group">
    <input type="password" name="repassword" placeholder="确认密码" required="required">
</div>

<div class="am-form-group">
    <input type="text" class="login-verify" maxlength="4" name="verify" placeholder="验证码" required="">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>

<div class="am-checkbox am-cf">
    <label>
        <input type="checkbox" name="agree" value="1" required=""> <a href="<?= $label->url('Index-agreement') ?>" target="_blank" class="am-fl">同意《基金定投助手用户协议》</a>
    </label>
</div>