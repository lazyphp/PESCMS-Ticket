<div class="am-btn-toolbar">
    <div class="am-btn-group am-btn-group-xs">
        <a class="am-btn am-btn-secondary" href="<?= $label->url(GROUP.'-'.MODULE . '-action', array('id' => $value["model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>

        <a class="am-btn am-btn-warning" href="<?= $label->url(GROUP.'-'.'Field-index', array('model_id' => $value["model_id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-pencil-square-o"></span> 字段管理</a>

        <a class="am-btn am-btn-danger" href="<?= $label->url(GROUP.'-'.MODULE . '-action', array('id' => $value["model_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>" onclick="return confirm('确定删除吗?')"><span class="am-icon-trash-o"></span> 删除</a>
    </div>
</div>