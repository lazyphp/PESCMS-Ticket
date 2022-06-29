<?php include THEME_PATH . '/header.php'; ?>
<style>
    .am-g{
        margin-top: 300px;
    }
</style>
<script>
    $(function (){
        $('.am-btn').on('click', function (){
            //这个可以关闭安卓系统的手机
            document.addEventListener('WeixinJSBridgeReady', function(){ WeixinJSBridge.call('closeWindow'); }, false);
            //这个可以关闭ios系统的手机
            WeixinJSBridge.call('closeWindow');
        })
    })
</script>
<div class="am-g am-text-center">
    <div class="am-u-lg-11 am-u-sm-12">
        <button class="am-btn am-btn-success am-btn-block">登录系统成功</button>
    </div>
</div>

</body>
</html>

