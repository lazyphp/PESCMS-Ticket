<div class="am-btn-toolbar">
    <div class="am-btn-group am-btn-group-xs">
        <a class="am-text-secondary" href="<?= $label->url(GROUP.'-'.MODULE . '-action', array('id' => $value["model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
        <a class="am-text-warning" href="<?= $label->url(GROUP.'-'.'Field-index', array('model_id' => $value["model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 字段管理</a>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
        <a class="am-text-success" href="<?= $label->url(GROUP.'-'.'Model-export', array('model_id' => $value["model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-cloud-upload"></span> 导出模型</a>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
        <a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！" href="<?= $label->url(GROUP.'-'.MODULE . '-action', array('id' => $value["model_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-trash-o"></span> 删除</a>
    </div>
</div>