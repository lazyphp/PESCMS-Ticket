<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-success" href="<?= $label->url('Category-ticket', ['number' => $value["ticket_model_number"]]); ?>" target="_blank"><span class="am-icon-external-link"></span>
    预览</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-primary" href="<?= $label->url('Ticket-' . MODULE . '-action', ['id' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><span class="am-icon-pencil-square-o"></span>
    设置基础信息</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-warning" href="<?= $label->url('Ticket-Fqa-index', ['ticket_model_id' => $value["ticket_model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><span class="am-icon-question-circle"></span>
    FQA列表</a>

<i class="am-margin-left-xs am-margin-right-xs">|</i>
<a class="<?= $license == 1 ? '' : 'link-disabled' ?>" href="<?= $license == 1 ? $label->url('Ticket-Fqa-index', ['ticket_model_id' => $value["ticket_model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) : 'javascript:;'; ?>" data-am-popover="<?= $license == 1 ? '' : '{content: \'此功能需要购买软件授权方可使用\', trigger: \'hover focus\'}' ?>" ><span class="am-icon-sign-in"></span>
    导入文档系统</a>