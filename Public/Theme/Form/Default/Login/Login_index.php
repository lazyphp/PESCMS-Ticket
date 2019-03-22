<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
    <input type="email" name="email" class="am-form-field" placeholder="邮箱地址" required="required">
</div>

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
<div class="am-g">

    <div class="am-u-sm-6 am-u-md-6 am-u-lg-6" style="border-right: 1px solid silver">
        <?php if($system['open_register'] == 1): ?>
        <a href="<?= $label->url('Login-signup') ?>">注册帐号</a>
        <?php endif; ?>
    </div>

    <div class="am-u-sm-6 am-u-md-6 am-u-lg-6">
        <a href="<?= $label->url('Login-findpw') ?>">忘记密码</a>
    </div>
</div>
<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>">
