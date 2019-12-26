<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-envelope am-icon-fw"></i></span>
    <input type="email" name="email" class="am-form-field" placeholder="邮箱地址" required="required">
</div>

<div class="am-input-group am-margin-bottom">
    <span class="am-input-group-label"><i class="am-icon-shield am-icon-fw"></i></span>
    <input type="text" class="am-form-field login-verify" name="verify" placeholder="验证码" maxlength="<?= $system['verifyLength'] ?>">
    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify">
</div>
<button type="submit" class="am-btn am-btn-secondary am-radius am-btn-sm am-margin-top-sm">提交</button>