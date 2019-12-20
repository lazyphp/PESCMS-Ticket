<input type="hidden" name="weixin" value="<?= !empty($_POST['weixin']) ? $label->xss($_POST['weixin']) : '' ?>">
<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
    <input type="text" name="account" class="am-form-field" placeholder="登陆账号" autofocus required="required">
</div>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-navicon am-icon-fw"></i></span>
    <input type="text" maxlength="10" name="name" class="am-form-field" value="<?= !empty($_POST['name']) ? $label->xss($_POST['name']) : '' ?>" placeholder="用户名称" required="required">
</div>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-envelope am-icon-fw"></i></span>
    <input type="email" name="email" class="am-form-field" placeholder="邮箱地址" required="required">
</div>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-phone am-icon-fw"></i></span>
    <input type="text" name="phone" class="am-form-field" placeholder="手机号码" required="required">
</div>


<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
    <input type="password" name="password" class="am-form-field" placeholder="密码" required="required">
</div>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
    <input type="password" name="repassword" class="am-form-field" placeholder="确认密码" required="required">
</div>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-shield am-icon-fw"></i></span>
    <input type="text" class="am-form-field login-verify" name="verify" placeholder="验证码" maxlength="<?= $system['verifyLength'] ?>">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>
<button type="submit" class="am-btn am-btn-secondary am-radius am-btn-sm am-margin-top-sm">注册</button>