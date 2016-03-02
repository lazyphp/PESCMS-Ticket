<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <div class="agree am-padding" style="height: 300px; overflow-y: auto;border: 1px solid #DDDDDD">
			<p>请等待协议加载完成</p>
        </div>
        <div class="am-margin-top am-fr">
            <a href="<?=DOCUMENT_ROOT?>/?m=Index&a=config" class="am-btn am-btn-default am-disabled">程序协议加载中...</a>
        </div>
    </div>
</div>
<script>
    $(function(){
        var progress = $.AMUI.progress;


        $.ajax({
            url:'http://app.pescms.com/?m=Bulletin&a=index&id=1&type=1',
            dataType:'JSONP',
            jsonpCallback:'receive',
            beforeSend:function(){
                progress.start();
            },
            success:function(data){
                $(".agree").html(data.replace(/\{program\}/g, "PESCMS Ticket"));
                progress.done();
            },
            complete:function(){
                $(".am-btn").removeClass('am-disabled').html('下一步');
            },
            error:function(){
                alert('出错了,刷新试下');
                progress.done();
            }
        })
    })
</script>