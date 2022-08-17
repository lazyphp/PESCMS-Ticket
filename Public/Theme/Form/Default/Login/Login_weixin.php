<input type="hidden" name="openid" value="<?= $user['openid'] ?? '' ?>">

<?php if (empty($user['openid'])): ?>
    <div class="am-alert am-alert-secondary am-text-xs">
        <i class="am-icon-warning"></i> 当前获取用户信息失败，请点击此链接完成校验:
        <a href="<?= $label->url('Login-wexinGetUSerTest') ?>" class="am-text-danger">点击</a>
    </div>

<?php else: ?>


    <div class="account-bind am-form-group">
        <a class="am-btn am-btn-danger am-btn-block am-btn-sm am-margin-top-sm am-radius">已注册账号? 绑定账号</a>
    </div>
    <?php if ($system['weixinRegister'] == 1 && $system['open_register'] == 1): ?>
        <div class="account-login am-form-group">
            <a href="javascript:;" data="<?= $label->url('Login-signup') ?>" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm am-radius">注册账号</a>
        </div>
    <?php else: ?>
        <div class="weixin-login am-form-group">
            <button type="submit" class="am-btn am-btn-success am-btn-block am-btn-sm am-margin-top-sm am-radius">直接登录
            </button>
        </div>
    <?php endif; ?>

    <div class="account" style="display: none">

        <div class="loginFlow">
            <input type="email" name="email" class="pes-login-input" placeholder="要绑定的已注册邮箱地址" required="required">
            <span>填写要绑定的已注册邮箱地址</span>
        </div>

        <div class="loginFlow">
            <input type="password" name="password" class="pes-login-input" placeholder="密码" data-am-popover="{trigger:'focus', theme: 'danger sm', content: '请输入不小于6位数的密码'}" required="required">
            <span>填写绑定的账户密码</span>
        </div>

        <button type="submit" class="am-btn am-btn-primary am-radius am-btn-sm am-margin-top am-btn-block"><i class="am-icon-save"></i> 提交</button>
        <a href="<?= $login && empty($_GET['qrcode']) ? $login : $label->url('Login-index') ?>" class="am-btn am-btn-white am-radius am-btn-sm am-margin-top am-btn-block"><i class="am-icon-reply"></i> 返回</a>

    </div>
    <script>
        $(function () {

            $('input[type=submit]').hide();

            $('.account-bind').on('click', function () {
                $('.account, input[type=submit]').show();
                $('.account-bind, .weixin-login, .account-login').hide();
            })

            $('.account-login').on('click', function () {
                var url = $(this).find('a').attr('data')
                $('#weixin-redirect').remove();
                $('.am-form').after('<form id="weixin-redirect" action="' + url + '" method="POST">' +
                    '<input type="hidden" name="method" value="GET">' +
                    '<input type="hidden" name="weixin" value="<?= $user['openid'] ?? '' ?>">' +
                    '</form>');
                $('#weixin-redirect').submit();
                return false;
            })

        })
    </script>

<?php endif; ?>
