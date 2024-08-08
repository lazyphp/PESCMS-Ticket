<div class="loginFlow">
    <input type="text" name="phone" class="pes-login-input" placeholder="请输入您的手机号码" required="required">
    <span>手机号码</span>
</div>


<div class="login-verify <?= $sendCount > 2 ? '' : 'am-hide' ?> ">
    <div class="am-alert am-alert-secondary am-text-center">
        <span class="am-text-xs am-block am-margin-bottom-xs">请将图中的字符输入在验证码输入框</span>
        <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify am-text-center">
    </div>

    <div class="loginFlow">
        <input type="text" class="pes-login-input" name="verify" placeholder="验证码" maxlength="<?= $system['verifyLength'] ?>" autocomplete="off" required>
        <span>验证码</span>
    </div>
</div>

<div class="loginFlow">
    <input type="text" name="smscode" class="pes-login-input" placeholder="请输入您收到的验证码" required="required" maxlength="6">
    <span>手机验证码</span>
    <a href="javascript:;" class="am-btn am-btn-white am-btn-sm get-sms-code">获取验证码</a>
</div>


<button type="submit" class="am-btn am-btn-primary am-radius am-btn-sm am-margin-top am-btn-block">提交
</button>

<div class="am-text-sm am-margin-vertical">
    <a href="<?= $label->url('Login-index', ['back_url' => $label->xss($_GET['back_url'] ?? '')]) ?>" class="login-signup-link"> <i class="am-icon-retweet"></i> 切换账号密码登录</a>
</div>

<script>
    $(function () {

        $('.get-sms-code').click(function () {
            let $btn = $(this)
            let phone = $('input[name=phone]').val()
            //判断是否国内手机号号码
            if (!/^1[3456789]\d{9}$/.test(phone)) {
                let d = dialog({
                    content: '请输入正确的手机号码',
                    skin: 'submit-error',
                    quickClose: true
                })
                d.show($('input[name=phone]')[0])
                return false
            }

            $.ajaxsubmit({
                url: '<?= $label->url('Login-sendSMSCode') ?>',
                data: $('.am-form').serialize(),
                jump: false
            }, function (res) {
                if (res.status == 200) {
                    if (res.data >= 2) {
                        $('.login-verify').removeClass('am-hide')
                    } else {
                        $('.login-verify').addClass('am-hide')
                    }
                    let wait = 60
                    $btn.button('loading');
                    $btn.text(wait + '秒后重新获取');
                    let interval = setInterval(function () {
                        let time = --wait;
                        if (time <= 0) {
                            $btn.button('reset');
                            clearInterval(interval);
                        } else {
                            $btn.text(time + '秒后重新获取');
                        }
                    }, 1000);
                }
            })
        });

        $('input[name="smscode"]').blur(function () {
            let smscode = $(this).val();
            //判断smscode是否为数字
            if (!/^\d{6}$/.test(smscode)) {
                let d = dialog({
                    content: '请输入正确的手机验证码',
                    skin: 'submit-error',
                    quickClose: true
                })
                d.show($('input[name=smscode]')[0])
                return false
            }
        })
    })
</script>