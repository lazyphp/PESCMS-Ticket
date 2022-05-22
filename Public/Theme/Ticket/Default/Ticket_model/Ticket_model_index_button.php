<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-success" href="<?= $label->url('Category-ticket', array('number' => $value["ticket_model_number"])); ?>" target="_blank"><span class="am-icon-external-link"></span> 预览</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-primary" href="<?= $label->url('Ticket-'.MODULE . '-action', array('id' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 设置基础信息</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-warning" href="<?= $label->url('Ticket-Fqa-index', ['ticket_model_id' => $value["ticket_model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><span class="am-icon-question-circle"></span> FQA列表</a>