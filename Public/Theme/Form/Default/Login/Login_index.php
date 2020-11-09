<div class="loginFlow">
<?php if($system['member_login'] == 1): ?>
    <input type="text" name="account" class="pes-login-input" placeholder="登录账号" autofocus required="required">
<?php elseif($system['member_login'] == 2): ?>
    <input type="text" name="phone" class="pes-login-input" placeholder="手机号码" autofocus required="required">
<?php else: ?>
        <input type="email" name="email" class="pes-login-input" placeholder="邮箱地址" autofocus required="required">
<?php endif; ?>
</div>

<div class="loginFlow">
    <input type="password" name="password" class="pes-login-input" placeholder="登录密码" minlength="6" data-am-popover="{trigger:'focus', theme: 'danger sm', content: '请输入不小于6位数的登录密码'}" required="required">
</div>

<?php if(json_decode($system['login_verify'])[0] == '1'): ?>
<div class="login-verify">
    <div class="am-alert am-alert-secondary am-text-center">
        <span class="am-text-xs am-block am-margin-bottom-xs">请将图中的字符输入在验证码输入框</span>
        <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify am-text-center">
    </div>

    <div class="loginFlow">
        <input type="text" class="pes-login-input" name="verify" placeholder="验证码" maxlength="<?= $system['verifyLength'] ?>" autocomplete="off" required>
    </div>
</div>

<?php endif; ?>

<div class="am-cf login-options am-text-sm">
    <div class="am-fl">
        还没<?= $system['siteTitle'] ?>账号？<a href="<?= $label->url('Login-signup') ?>" class="login-signup-link" >立即注册!</a>
    </div>
    <div class="am-fr">
        <a href="<?= $label->url('Login-findpw') ?>">忘记密码？</a>
    </div>
</div>

<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>">

<button type="submit" class="am-btn am-btn-primary am-radius am-btn-sm am-margin-top-sm am-btn-block">登录</button>

<div class="am-input-group am-margin-bottom signBAT" style="display: none">
    <span class="am-margin-right-xs">社交账号登录</span>
    <span>
        <a href="<?= $label->url('Login-weixinAgree') ?>" class="login-weixin am-text-success"><i class="am-icon-weixin"></i> 微信</a>
        <!--        <a href="" class=""><i class="am-icon-qq"></i> QQ</a>-->
    </span>
</div>

<?= $label->loginEvent(); ?>

<script>
    /**
     * @todo 目前只整合了微信公众号登录，以后在添加其他社交平台登录入口
     */
    $(function(){
        var ua = navigator.userAgent.toLowerCase();
        //判断是否微信浏览器访问
        if( ua.indexOf("wechat") != -1 || ua.indexOf("micromessenger") != -1 ){
            $('.signBAT').show();
        }
    })
</script>