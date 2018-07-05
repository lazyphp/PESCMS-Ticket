<div class="agree am-padding" style="height: 300px; overflow-y: auto;border: 1px solid #DDDDDD">
    <p>请等待协议加载完成</p>
</div>
<div class="am-margin-top am-fr">
    <a href="<?= DOCUMENT_ROOT ?>/?m=Index&a=config" class="am-btn am-btn-default am-disabled">程序协议加载中...</a>
</div>
<div class="am-cf"></div>
<script>
    $(function(){
        var progress = $.AMUI.progress;


        $.ajax({
            url:'https://www.pescms.com/UserProtocol',
            dataType:'JSON',
            beforeSend:function(){
                progress.start();
            },
            success:function(data){
                $(".agree").html(data.data.replace(/\{program\}/g, "PESCMS Ticket"));
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
        var data = {
            id: 3,
            type: 1,
            version : '<?= $version ?>',
            sessionid : '<?= $this->session()->getId() ?>'
        };
        $.post('https://www.pescms.com/?g=Api&m=Statistics&a=action', data, function (data) {
        }, 'JSON')
    })
</script>