<?php include THEME_PATH.'/header.php' ?>
<div class="am-g " style="padding-top: 200px;">
    <div class="am-u-sm-4 am-u-lg-centered am-u-sm-centered">
        <form action="" method="POST" data-am-validator>
            <h1 class="am-text-center" style="color: #fff">PESCMS Ticket</h1>
            <input name="account" class="am-form-field" type="text" placeholder="账号" required>
            <input name="passwd" class="am-form-field" type="password" placeholder="密码" required>
            <button class="am-btn am-btn-primary am-btn-block">提交</button>
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
