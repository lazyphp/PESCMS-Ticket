<div class="am-panel am-panel-default am-panel-hover am-panel-striped">
    <div class="am-panel-hd">微信小程序设置</div>
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">appID</label>
                    <input name="wxapp_api[appID]" placeholder="请填写微信小程序的appID" type="text" value="<?= $wxapp_api['appID']  ?? ''; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">appsecret</label>
                    <input name="wxapp_api[appsecret]" placeholder="请填写微信小程序的appsecret" type="text" value="<?= $wxapp_api['appsecret']  ?? ''; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">模板消息发送测试</label>
                    <select class="am-inline" name="template" style="width: auto">
                        <option>选择发送的模板</option>
                        <?php foreach(\Model\Content::listContent(['table' => 'mail_template']) as $key => $value): ?>
                            <option value="<?= $value['mail_template_id'] ?>"><?= $label->getFieldOptionToMatch(183, $value['mail_template_type']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" class="test_account am-inline" placeholder="接收消息的微信小程序openid" style="width: 20%">
                    <a href="javascript:;" data="<?= $label->url(GROUP.'-Setting-wxappTest') ?>" type="submit" class="am-inline am-btn am-btn-warning send-test" >发送模板消息</a>
                    <a href="<?= $label->url(GROUP.'-Setting-wxappTest', ['debug_access_token' => true]) ?>" target="_blank">[access_token调试]</a>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">生成微信小程序</label>
                    <a href="<?= $label->url('Ticket-Setting-wxapp', ['method' => 'GET']) ?>" msg="确认要生成微信小程序吗？" class="ajax-click ajax-dialog am-btn am-btn-success am-btn-sm am-margin-top-xs" ><i class="am-icon-plus"></i> 开始生成</a>
                </div>
            </div>
        </div>

    </div>
</div>