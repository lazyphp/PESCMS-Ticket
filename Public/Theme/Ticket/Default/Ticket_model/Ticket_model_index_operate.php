<a class="am-text-primary" href="<?= $label->url('Ticket-'.MODULE . '-action', array('id' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<?php /*
<a class="am-text-primary" href="<?= $label->url('Category-createJS', array('number' => $value["ticket_model_number"])); ?>" target="_blank"><span class="am-icon-pencil-square-o"></span> 生成JS</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>
*/
?>


<a class="am-text-warning" href="<?= $label->url('Ticket-Fqa-index', ['ticket_model_id' => $value["ticket_model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><span class="am-icon-question-circle"></span> FQA列表</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>


<div class="am-dropdown" data-am-dropdown>
    <a href="javascript:;" class="am-dropdown-toggle am-link-muted more-operate" data-am-dropdown-toggle><span class="am-icon-cog"></span> 更多 <span class="am-icon-caret-down"></span></a>
    <ul class="am-dropdown-content">
        <li>
            <a class="am-text-primary" href="<?= $label->url('Ticket-'.'Ticket_form-index', array('number' => $value["ticket_model_number"], 'cid' => $value['ticket_model_cid'],'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-compass"></span> 管理</a>
        </li>
        <li>
            <a class="am-text-primary" href="<?= $label->url('Ticket-'.MODULE . '-action', array('id' => $value["ticket_model_number"], 'copy' => true, 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-copy"></span> 复制</a>
        </li>
        <li>
            <a class="am-text-primary" href="<?= $label->url('Category-ticket', array('number' => $value["ticket_model_number"])); ?>" target="_blank"><span class="am-icon-external-link"></span> 预览</a>
        </li>
        <li>
            <a class="am-text-danger ajax-click ajax-dialog" msg="确定删除吗?" href="<?= $label->url('Ticket-'.MODULE . '-action', array('id' => $value["ticket_model_number"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>" ><span class="am-icon-trash-o"></span> 删除</a>
        </li>
    </ul>
</div>

<?php $label->opButton(['id' => $value["ticket_model_number"]]) ?>

