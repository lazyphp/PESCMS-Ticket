<div class="am-panel am-panel-default">
    <div class="am-panel-hd">钉钉设置</div>
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">AgentId</label>
                    <input name="dingtalk[AgentId]" placeholder="请填写钉钉企业应用的AgentId" type="text" value="<?= $dingtalk['AgentId']; ?>">
                </div>
                <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                    <i class="am-icon-lightbulb-o"></i> 登录钉钉企业管理平台 -- 工作台 -- 自建应用 -- 在应用详情中找到相关的信息<a href="https://www.pescms.com/" target="_blank" style="color:#0e90d2 "><b>查看教程</b></a>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">AppKey</label>
                    <input name="dingtalk[AppKey]" placeholder="请填写钉钉企业应用的AppKey" type="text" value="<?= $dingtalk['AppKey']; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">AppSecret</label>
                    <input name="dingtalk[AppSecret]" placeholder="请填写钉钉企业应用的AppSecret值" type="text" value="<?= $dingtalk['AppSecret']; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">钉钉企业调试</label>
                    <input type="text" class="test_account am-inline" placeholder="接收消息的钉钉企业帐号" style="width: 20%">
                    <a href="javascript:;" data="<?= $label->url(GROUP.'-Setting-dingtalkTest') ?>" type="submit" class="am-inline am-btn am-btn-warning send-test" >钉钉企业消息测试</a>
                    <a href="<?= $label->url(GROUP.'-Setting-dingtalkTest', ['debug_access_token' => true]) ?>" target="_blank">[access_token调试]</a>

                </div>
            </div>
        </div>

    </div>
</div>