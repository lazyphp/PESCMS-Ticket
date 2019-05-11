<div id="wrapper" class="am-text-sm">
	<div class="am-g">
		<div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">

                        <form action="/?m=View&a=ticket" class="am-margin-bottom" method="GET" data-am-validator>
                <input type="hidden" name="m" value="View" />
                <input type="hidden" name="a" value="ticket">
                <div class="am-input-group">
                    <input type="text" name="number" class="am-form-field " required placeholder="键入工单编号，了解进度">
                    <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="submit"><i class="am-icon-search"></i> 查询进度</button>
            </span>
                </div>
            </form>
            
			<div class="am-panel am-panel-default">
				<div class="am-panel-bd">
					<ol class="am-breadcrumb am-text-default am-margin-bottom-0 categort-breadcrumb">
						<li class="am-active">
							<a href="/?m=Category&a=index"><span class="am-badge am-badge-primary am-round am-text-default">1</span> 选择问题类型</a>
						</li>
						<li class="">
							<a href="javascript:;"><span class="am-badge am-badge-primary am-round am-text-default">2</span> 选择对应工单</a>
						</li>
						<li class="" >
							<a href="javascript:;"><span class="am-badge am-badge-primary am-round am-text-default">3</span> 创建工单</a>
						</li>
					</ol>
						<hr class="am-margin-top-0" />
	<ul class="ticket-ul am-avg-sm-1 am-avg-lg-4 am-thumbnails">
					<li >
				<a href="/?m=Category&a=index&id=15&back_url=Lz9nPUZvcm0mbT1DYXRlZ29yeSZhPWluZGV4Jm5ld19pbmRleD0xJm1ldGhvZD1HRVQ=" class="ticket-category">
					<h4 class="am-margin-bottom-xs">主机租用</h4>
					<p class="am-margin-top-0">主机租用相关问题</p>
				</a>
			</li>
					<li >
				<a href="/?m=Category&a=index&id=14&back_url=Lz9nPUZvcm0mbT1DYXRlZ29yeSZhPWluZGV4Jm5ld19pbmRleD0xJm1ldGhvZD1HRVQ=" class="ticket-category">
					<h4 class="am-margin-bottom-xs">PESCMS TICKET</h4>
					<p class="am-margin-top-0">工单系统相关问题</p>
				</a>
			</li>
					<li >
				<a href="/?m=Category&a=index&id=13&back_url=Lz9nPUZvcm0mbT1DYXRlZ29yeSZhPWluZGV4Jm5ld19pbmRleD0xJm1ldGhvZD1HRVQ=" class="ticket-category">
					<h4 class="am-margin-bottom-xs">PESCMS TEAM</h4>
					<p class="am-margin-top-0">任务系统的工单</p>
				</a>
			</li>
					<li >
				<a href="/?m=Category&a=index&id=12&back_url=Lz9nPUZvcm0mbT1DYXRlZ29yeSZhPWluZGV4Jm5ld19pbmRleD0xJm1ldGhvZD1HRVQ=" class="ticket-category">
					<h4 class="am-margin-bottom-xs">PESCMS DOC</h4>
					<p class="am-margin-top-0">文档系统的反馈</p>
				</a>
			</li>
			</ul>
<script>
    $(function(){
        $('.ticket-list').on('click', function(){

            //初始化一些效果
            $('.ticket-list').removeClass('ticket-list-active');
            $(this).addClass('ticket-list-active')
            $('.ticket-fqa').hide()
            $(this).find('.am-icon-spinner').show()

            var href = $(this).attr('data');
            var number = $(this).attr('number');

            $.getJSON(number, function(data){
                if(data.status == 200){
                    $('.am-animation-shake').attr('href', href);
                    $('.ticket-fqa').show()

                    var str = '';
                    for(var key in data.data){
                        var no = parseInt(key) + 1;
                        str += '<li><a href="'+data.data[key]['fqa_url']+'" target="_blank">'+no+'. '+data.data[key]['fqa_title']+'</a></li>';
                        $('.fqa-list').html(str);
                    }
                }else{
                    window.location.href = href;
                }
                $('.am-icon-spinner').hide()
            }).fail(function(){
                //获取常见问题出错，直接跳转到工单提交.
                window.location.href = href;
            })
        })
    })
</script>				</div>
			</div>

            <div class="am-panel am-panel-default ticket-fqa" style="display: none">
    <div class="am-panel-bd am-margin-bottom">
        <span class="am-fl"><strong>常见问题</strong></span>
        <a href="javascript:;" class="am-fr am-text-danger am-show-sm-only am-animation-shake">创建工单>></a>
    </div>
    <ol class="fqa-list am-avg-sm-1 am-avg-lg-3">
        <li><a href="javascript:;"><p>努力加载中...</p></a></li>
    </ol>

    <ul>
        <li>
            <a href="javascript:;" class="am-btn am-btn-danger am-btn-sm am-radius am-animation-shake">创建工单</a>
        </li>
    </ul>

</div>
		</div>
	</div>
</div>
