<div>
    <a class="am-text-warning" href="<?= $label->url('Ticket-' . 'Ticket_form-index', ['number' => $value["ticket_model_number"], 'cid' => $value['ticket_model_cid'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><i class="am-icon-compass"></i> 添加工单字段</a>
</div>

<div>
    <a class="am-text-secondary" href="<?= $label->url('Ticket-Ticket_model-action', ['id' => $value["ticket_model_number"], 'copy' => '1', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><i class="am-icon-copy"></i> 复制本模型</a>
</div>

<?php if ($value['ticket_model_login'] == 0): ?>
    <div>
        <a class="am-text-primary" href="<?= $label->url('Category-createJS', ['number' => $value["ticket_model_number"]]); ?>" target="_blank"><i class="am-icon-globe"></i> 生成跨域工单</a>
    </div>
<?php endif; ?>

<div>
    <a class="am-text-danger ajax-click ajax-dialog" msg="确定删除吗?" href="<?= $label->url('Ticket-' . MODULE . '-action', ['id' => $value["ticket_model_number"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><i class="am-icon-trash-o"></i> 删除</a>
</div>


<?php $label->opEvent(['id' => $value["ticket_model_number"]]) ?>

