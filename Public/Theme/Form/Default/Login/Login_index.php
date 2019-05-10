<?php if($system['member_login'] == 1): ?>
    <div class="am-input-group am-margin-bottom">
        <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
        <input type="text" name="account" class="am-form-field" placeholder="登陆账号" autofocus required="required">
    </div>
<?php elseif($system['member_login'] == 2): ?>
    <div class="am-input-group am-margin-bottom">
        <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
        <input type="text" name="phone" class="am-form-field" placeholder="手机号码" autofocus required="required">
    </div>
<?php else: ?>
    <div class="am-input-group am-margin-bottom">
        <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
        <input type="email" name="email" class="am-form-field" placeholder="邮箱地址" autofocus required="required">
    </div>
<?php endif; ?>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
    <input type="password" name="password" class="am-form-field" placeholder="登录密码" required="required">
</div>

<?php if(json_decode($system['login_verify'])[0] == '1'): ?>
    <div class="am-input-group am-margin-bottom">
        <span class="am-input-group-label"><i class="am-icon-shield am-icon-fw"></i></span>
        <input type="text" class="am-form-field login-verify" name="verify" placeholder="验证码" maxlength="7">
        <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
    </div>
<?php endif; ?>

<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>">

<button type="submit" class="am-btn am-btn-secondary am-radius am-btn-sm am-margin-top-sm">登录</button>

<a href="<?= $label->url('Login-findpw') ?>" class="am-btn am-btn-white am-radius am-btn-sm am-margin-top-sm">忘记密码</a>
