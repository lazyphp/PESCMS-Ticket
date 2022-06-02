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
    <?php if($system['open_register'] == 1): ?>
    <div class="am-fl">
        还没<?= $system['siteTitle'] ?>账号？<a href="<?= $label->url('Login-signup') ?>" class="login-signup-link" >立即注册!</a>
    </div>
    <?php endif; ?>
    <div class="am-fr">
        <a href="<?= $label->url('Login-findpw') ?>">忘记密码？</a>
    </div>
</div>

<input type="hidden" name="back_url" value="<?= $label->xss($_GET['back_url'] ?? '') ?>">

<button type="submit" class="am-btn am-btn-primary am-radius am-btn-sm am-margin-top-sm am-btn-block">登录</button>

<?php if(!empty(json_decode($system['weixin_api'] ?? [], true)['appID']) ): ?>
<div class="am-input-group signBAT" >
    <span class="am-margin-right-xs">社交账号登录</span>
    <span>
        <a href="<?= $label->url('Login-weixinAgree') ?>" class="login-weixin am-text-success" style="display: none"><i class="am-icon-weixin"></i> 微信</a>
        <a href="javascript:;" class="am-text-success am-show-md-up weixin-scan"><i class="am-icon-weixin"></i> 微信扫一扫</a>
        <i id="qrcode"></i>
        <?= (new \Core\Plugin\Plugin())->event('OAuth2', NULL); ?>
    </span>
</div>
<script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/qrcode.min.js?v=<?= $resources ?>"></script>
<?php endif; ?>

<?= $label->loginEvent(); ?>

<script>
    /**
     * @todo 目前只整合了微信公众号登录，以后在添加其他社交平台登录入口
     */
    $(function(){
        var ua = navigator.userAgent.toLowerCase();
        //判断是否微信浏览器访问
        if( ua.indexOf("wechat") != -1 || ua.indexOf("micromessenger") != -1 ){
            $('.login-weixin').show();
            $('.weixin-scan').hide();
        }else{
            $('.login-weixin').hide();
        }

        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width : 180,
            height : 180
        });

        let qrStatus = false;

        $('.weixin-scan').popover({
            trigger: 'click',
            content: $('#qrcode')
        }).on('open.popover.amui',function(){
            qrStatus = true;
            qrcode.makeCode('<?= $system['domain']. $label->url('Login-weixinAgree', ['qrcode' => $qrcode]) ?>');
        }).on('close.popover.amui',function(){
            qrStatus = false;
        });



        (function qrVerify(interval){
            interval = interval || 5000; // default polling to 1 second
            let timer

            timer = setTimeout(function(){

                if(qrStatus == true){

                    $.getJSON(PESCMS_PATH+'/?m=Login&a=weixinScanVerify&qrcode=<?= $qrcode ?>&timing='+Math.random(), function (res){
                        try{
                            switch (res.status){
                                case 200:
                                    qrStatus = false;
                                    dialog({content:'微信登录成功', zIndex: 2000, skin: 'submit-success'}).showModal();
                                    setTimeout(function (){
                                        window.location.href = '<?= $label->url('Login-weixin', ['qrcode' => $qrcode]) ?>';
                                    }, 1800)
                                    break;
                                case 201:
                                    qrStatus = false;
                                    dialog({content:'微信二维码发生变化，本页面将刷新', zIndex: 2000, skin:'submit-error'}).showModal();
                                    setTimeout(function (){
                                        window.location.reload();
                                    }, 3000)
                                    break;
                                case 0:
                                    break;
                            }
                        }catch (e){
                            qrStatus = false;
                            dialog({content:'系统出错了', zIndex: 2000, skin:'submit-error'}).showModal();
                            setTimeout(function (){
                                window.location.reload();
                            }, 3000)
                        }
                    }).fail(function (){
                        qrStatus = false;
                        dialog({content:'请求异常', zIndex: 2000, skin:'submit-error'}).showModal();
                        setTimeout(function (){
                            window.location.reload();
                        }, 3000)
                    })
                }

                qrVerify();
            }, interval);

        })();

        (function loopsiloop( interval ){

        })();

        // clearInterval(timer)

    })
</script>