<?php include THEME_PATH.'/header.php' ?>
<div class="am-g " style="padding-top: 8rem;">
    <div class="am-u-lg-4 am-u-sm-12  am-u-lg-centered am-u-sm-centered">
        <form action="" class="ajax-submit" method="POST" data-am-validator>
            <?= $label->token() ?>
            <input type="hidden" name="back_url" value="<?= $_GET['back_url']; ?>"/>
            <h1 class="am-text-center am-text-xxxl" style="color: #fff"><?= $system['siteTitle'] ?></h1>

            <div class="am-input-group am-margin-bottom">
                <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
                <input name="account" class="am-form-field" type="text" placeholder="账号" autofocus required>
            </div>
            <div class="am-input-group am-margin-bottom">
                <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
                <input name="passwd" class="am-form-field" type="password" placeholder="密码" required>
            </div>
            
            <?php if(json_decode($system['login_verify'])[1] == '2'): ?>
            <div class="am-input-group am-margin-bottom">
                <span class="am-input-group-label"><i class="am-icon-shield am-icon-fw"></i></span>
                <input type="text" class="am-form-field" name="verify" maxlength="<?= $system['verifyLength'] ?>">
                <span class="am-input-group-btn">
                    <img src="<?= $label->url('Index-verify') ?>" class="refresh-verify am-padding-left-sm">
                </span>
            </div>
            <?php endif; ?>

            <div class="am-form-group am-form-group-sm">
                <div class="am-checkbox">
                    <label>
                        <input type="checkbox" class="remember-password" value="1"> 记住登录信息
                    </label>
                </div>
            </div>

            <button class="am-btn am-btn-primary am-btn-block">登录</button>
        </form>
    </div>
</div>
<style>
    html, body{
        -moz-background-size: 100% 100%;
        background-size: cover;
        background-image: url('<?= DOCUMENT_ROOT; ?>/Theme/assets/i/162284main_image_feature_693_ys_full.jpg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>
<script>
    $(function(){

        /**
         * 记住登录信息
         */
        var taccount = localStorage.getItem('taccount')
        var tpassword = localStorage.getItem('tpassword')
        if(tpassword && taccount ){
            $('.remember-password').prop('checked', true)
            $('input[name=account]').val(atob(taccount))
            $('input[name=passwd]').val(atob(tpassword))
        }else{
            localStorage.removeItem('taccount')
            localStorage.removeItem('tpassword')
        }

        $('.am-btn').on('click', function(){
            if($('.remember-password').prop('checked') == false){
                localStorage.removeItem('taccount')
                localStorage.removeItem('tpassword')
            }else{
                var account = $('input[name=account]').val()
                if(account){
                    localStorage.setItem('taccount', btoa(account))
                }
                var password = $('input[name=passwd]').val()
                if(password){
                    localStorage.setItem('tpassword', btoa(password))
                }
            }
        })


    })
</script>
<?php include THEME_PATH.'/footer.php' ?>
