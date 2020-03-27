<?php if(!empty($category)): ?>
	<hr class="am-margin-top-0" />
	<ul class="ticket-ul am-avg-sm-1 am-avg-lg-4 am-thumbnails">
		<?php foreach($category as $item ): ?>
			<li >
				<a href="<?= $label->url('Category-index', ['id' => $item['category_id'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="ticket-category">
					<h4 class="am-margin-bottom-xs"><?= $item['category_name'] ?></h4>
					<p class="am-margin-top-0"><?= $item['category_description'] ?></p>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif;?>
<?php if(!empty($ticket)): ?>
	<hr class="am-margin-top-0" />
	<?php if(!empty($category)): ?>
		<h4>可选择工单:</h4>
	<?php endif;?>
	<ul class="ticket-ul am-avg-sm-1 am-avg-lg-4 am-thumbnails">
		<?php foreach($ticket as $item ): ?>

            <?php if( !empty($item['ticket_model_organize_id']) && !in_array(self::session()->get('member')['member_organize_id'], explode(',', $item['ticket_model_organize_id'])) ){ continue; } ?>

			<li>
				<a href="javascript:;" data="<?= $label->url('Category-ticket', ['id' => $item['ticket_model_cid'], 'number' => $item['ticket_model_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="ticket-category ticket-list" number="<?= $label->url('Fqa-index', ['number' => $item['ticket_model_number']]) ?>">
					<h4 class="am-margin-0"><?= $item['ticket_model_name'] ?></h4>
                    <p class="am-margin-top-0"><?= htmlspecialchars_decode($item['ticket_model_explain']) ?></p>
                    <i class="am-icon-spinner am-icon-pulse am-icon-xs" style="display: none"></i>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif;?>
<?php if(empty($category) && empty($ticket) ): ?>
    <hr class="am-margin-top-0" />
    <p class="am-text-center">没有可选择内容</p>
<?php endif; ?>
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
</script>