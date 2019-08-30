<div class="am-panel am-panel-default">
    <div class="am-panel-hd">微信公众号设置</div>
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">appID</label>
                    <input name="weixin_api[appID]" placeholder="请填写微信公众平台的appID" type="text" value="<?= $weixin_api['appID']; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">appsecret</label>
                    <input name="weixin_api[appsecret]" placeholder="请填写微信公众平台的appsecret" type="text" value="<?= $weixin_api['appsecret']; ?>" >
                </div>
            </div>
        </div>
        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
            <i class="am-icon-lightbulb-o"></i> 如何设置微信公众号登录：<a href="https://www.pescms.com/d/v/1.2.7/22/142.html" target="_blank" style="color:#0e90d2 "><b>查看教程</b></a>
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
                    <input type="text" class="test_account am-inline" placeholder="接收消息的微信openid" style="width: 20%">
                    <a href="javascript:;" data="<?= $label->url(GROUP.'-Setting-weixinTest') ?>" type="submit" class="am-inline am-btn am-btn-warning send-test" >发送模板消息</a>
                    <a href="<?= $label->url(GROUP.'-Setting-weixinTest', ['debug_access_token' => true]) ?>" target="_blank">[access_token调试]</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd">企业微信设置</div>
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">企业ID</label>
                    <input name="weixinWork_api[corpid]" placeholder="请填写企业微信的企业ID" type="text" value="<?= $weixinWork_api['corpid']; ?>">
                </div>
                <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                    <i class="am-icon-lightbulb-o"></i> 登录企业微信WEB管理端，在 我的企业 - 企业信息，最下方可以看到企业ID。将此ID信息填入。<a href="https://www.pescms.com/d/v/1.2.7/22/143.html" target="_blank" style="color:#0e90d2 "><b>查看教程</b></a>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">AgentId</label>
                    <input name="weixinWork_api[AgentId]" placeholder="请填写企业微信应用的AgentId值" type="text" value="<?= $weixinWork_api['AgentId']; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">Secret</label>
                    <input name="weixinWork_api[Secret]" placeholder="请填写企业微信应用的Secret值" type="text" value="<?= $weixinWork_api['Secret']; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">企业微信调试</label>
                    <input type="text" class="test_account am-inline" placeholder="接收消息的企业微信帐号" style="width: 20%">
                    <a href="javascript:;" data="<?= $label->url(GROUP.'-Setting-weixinWorkTest') ?>" type="submit" class="am-inline am-btn am-btn-warning send-test" >企业消息测试</a>
                    <a href="<?= $label->url(GROUP.'-Setting-weixinWorkTest', ['debug_access_token' => true]) ?>" target="_blank">[access_token调试]</a>

                </div>
            </div>
        </div>

    </div>
</div>