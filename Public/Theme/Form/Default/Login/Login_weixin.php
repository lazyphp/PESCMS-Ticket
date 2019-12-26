<input type="hidden" name="openid" value="<?= $user['openid'] ?>">
<input type="hidden" name="name" value="<?= $user['nickname'] ?>">

<div class="account-bind am-form-group">
    <a class="am-btn am-btn-danger am-btn-block am-btn-sm am-margin-top-sm am-radius">已注册帐号? 绑定账号</a>
</div>
<?php if($system['weixinRegister'] == 1): ?>
    <div class="account-login am-form-group">
        <a href="javascript:;" data="<?= $label->url('Login-signup') ?>" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm am-radius">注册帐号</a>
    </div>
<?php else: ?>
    <div class="weixin-login am-form-group">
        <button type="submit" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm am-radius">直接登录</button>
    </div>
<?php endif; ?>

<div class="account" style="display: none">
    <div class="am-input-group am-margin-bottom">
        <span class="am-input-group-label"><i class="am-icon-envelope am-icon-fw"></i></span>
        <input type="email" name="email" class="am-form-field" placeholder="要绑定的已注册邮箱地址" required="required">
    </div>

    <div class="am-input-group am-margin-bottom">
        <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
        <input type="password" name="password" class="am-form-field" placeholder="密码" required="required">
    </div>

    <button type="submit" class="am-btn am-btn-secondary am-radius am-btn-sm am-margin-top-sm">提交</button>

</div>
<script>
    $(function(){
        $('input[type=submit]').hide();

        $('.account-bind').on('click', function(){
            $('.account, input[type=submit]').show();
            $('.account-bind, .weixin-login').hide();
        })

        $('.account-login').on('click', function(){
            var url = $(this).find('a').attr('data')
            $('#weixin-redirect').remove();
            $('.am-form').after('<form id="weixin-redirect" action="'+url+'" method="POST">' +
                '<input type="hidden" name="method" value="GET">' +
                '<input type="hidden" name="weixin" value="<?= $user['openid'] ?>">' +
                '<input type="hidden" name="name" value="<?= $user['nickname'] ?>">' +
                '</form>');
            $('#weixin-redirect').submit();
            return false;
        })

    })
</script>