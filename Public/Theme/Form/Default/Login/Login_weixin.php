<input type="hidden" name="openid" value="<?= $user['openid'] ?? '' ?>">

<?php if(empty($user['openid'])): ?>
<div class="am-alert am-alert-secondary am-text-xs">
    <i class="am-icon-warning"></i> 当前获取用户信息失败，请点击此链接完成校验: <a href="<?= $label->url('Login-wexinGetUSerTest') ?>" class="am-text-danger">点击</a>
</div>

<?php else: ?>


    <div class="account-bind am-form-group">
        <a class="am-btn am-btn-danger am-btn-block am-btn-sm am-margin-top-sm am-radius">已注册账号? 绑定账号</a>
    </div>
    <?php if($system['weixinRegister'] == 1 && $system['open_register'] == 1): ?>
        <div class="account-login am-form-group">
            <a href="javascript:;" data="<?= $label->url('Login-signup') ?>" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm am-radius">注册账号</a>
        </div>
    <?php else: ?>
        <div class="weixin-login am-form-group">
            <button type="submit" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm am-radius">直接登录</button>
        </div>
        <?php if(empty($user['nickname'])): ?>

            <div class="loginFlow">
                <input type="text" maxlength="10" name="name" class="pes-login-input"
                       value="<?= $user['nickname'] ?? '' ?>" placeholder="您还需要填写用户名称" required="required">
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="account" style="display: none">

        <div class="loginFlow">
            <input type="email" name="email" class="pes-login-input" placeholder="要绑定的已注册邮箱地址" required="required">
        </div>

        <div class="loginFlow">
            <input type="password" name="password" class="pes-login-input" placeholder="密码" data-am-popover="{trigger:'focus', theme: 'danger sm', content: '请输入不小于6位数的密码'}" required="required">
        </div>

        <button type="submit" class="am-btn am-btn-primary am-radius am-btn-sm am-margin-top am-btn-block">提交</button>

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
                    '<input type="hidden" name="weixin" value="<?= $user['openid'] ?? '' ?>">' +
                    '<input type="hidden" name="name" value="<?= $user['nickname'] ?? '' ?>">' +
                    '</form>');
                $('#weixin-redirect').submit();
                return false;
            })

        })
    </script>

<?php endif; ?>
