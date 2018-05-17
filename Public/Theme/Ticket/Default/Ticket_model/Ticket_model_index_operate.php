<a class="am-text-primary" href="<?= $label->url('Ticket-'.MODULE . '-action', array('id' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-primary" href="<?= $label->url('Ticket-'.'Ticket_form-index', array('number' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 表单管理</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-primary" href="javascript:window.open('<?= $label->url('Ticket-CreateJs-action', array('number' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>', '', 'top=0,left=0,width=100,height=25');" target="_blank"><span class="am-icon-pencil-square-o"></span> 生成JS</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-primary" href="<?= $label->url('Ticket-CreateJs-preview', array('number' => $value["ticket_model_number"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>" target="_blank"><span class="am-icon-pencil-square-o"></span> 预览工单</a>
<i class="am-margin-left-xs am-margin-right-xs">|</i>

<a class="am-text-danger" href="<?= $label->url('Ticket-'.MODULE . '-action', array('id' => $value["ticket_model_number"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>" onclick="return confirm('确定删除吗?')"><span class="am-icon-trash-o"></span> 删除</a>