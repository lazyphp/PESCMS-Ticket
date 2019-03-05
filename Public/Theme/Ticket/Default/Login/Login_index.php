<?php include THEME_PATH.'/header.php' ?>
<div class="am-g " style="padding-top: 14rem;">
    <div class="am-u-lg-4 am-u-sm-12  am-u-lg-centered am-u-sm-centered">
        <form action="" class="ajax-submit" method="POST" data-am-validator>
            <?= $label->token() ?>
            <input type="hidden" name="back_url" value="<?= $_GET['back_url']; ?>"/>
            <h1 class="am-text-center" style="color: #fff">PESCMS Ticket</h1>

            <div class="am-input-group am-margin-bottom">
                <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
                <input name="account" class="am-form-field" type="text" placeholder="账号" required>
            </div>
            <div class="am-input-group am-margin-bottom">
                <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
                <input name="passwd" class="am-form-field" type="password" placeholder="密码" required>
            </div>
            
            <?php if(json_decode($system['login_verify'])[1] == '2'): ?>
            <div class="am-input-group am-margin-bottom">
                <span class="am-input-group-label"><i class="am-icon-shield am-icon-fw"></i></span>
                <input type="text" class="am-form-field" name="verify">
                <span class="am-input-group-btn">
                    <img src="/?m=Index&a=verify" class="refresh-verify am-padding-left-sm">
                </span>
            </div>
            <?php endif; ?>

            <button class="am-btn am-btn-primary am-btn-block">登录</button>
        </form>
    </div>
</div>
<style>
    html, body{
        -moz-background-size:100% 100%;
        background-size:cover;
    }
</style>
<script>
    $(function(){
        var background = {
            'morning': 'http://s.cn.bing.net/az/hprichbg/rb/PalmTreePantanal_ZH-CN12515523449_1920x1080.jpg',
            'noon': 'http://s.cn.bing.net/az/hprichbg/rb/MourningDoves_ZH-CN10786728372_1920x1080.jpg',
            'nightfall': 'http://s.cn.bing.net/az/hprichbg/rb/CemoroLawangCrater_ZH-CN10441912392_1920x1080.jpg',
            'night' : 'http://s.amazeui.org/media/i/demos/bing-1.jpg'};
        var mydate = new Date();
        var hover = mydate.getHours();
        console.dir(background)
        if(hover >6 && hover < 10){
            $("html, body").css('background' ,'url('+background.morning+')');
        }else if(hover >10 && hover < 16){
            $("html, body").css('background' ,'url('+background.noon+')');
        }else if(hover >16 && hover < 19){
            $("html, body").css('background' ,'url('+background.nightfall+')');
        }else if(hover >19 && hover < 24){
            $("html, body").css('background' ,'url('+background.night+')');
        }else{
            $("html, body").css('background' ,'url('+background.morning+')');
        }

    })
</script>
<?php include THEME_PATH.'/footer.php' ?>
