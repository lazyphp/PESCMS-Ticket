<div class="am-panel am-panel-default">
    <div class="am-panel-hd">微信设置</div>
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">appID</label>
                    <input name="weixin_api[appID]" placeholder="" type="text" value="<?= $weixin_api['appID']; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">appsecret</label>
                    <input name="weixin_api[appsecret]" placeholder="" type="text" value="<?= $weixin_api['appsecret']; ?>" >
                </div>
            </div>
        </div>
        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
            <i class="am-icon-lightbulb-o"></i> 如何设置微信登录：<a href="https://www.pescms.com/d/v//22/124.html" target="_blank" style="color:#0e90d2 "><b>查看教程</b></a>
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
                    <input name="weixinWork_api[corpid]" placeholder="" type="text" value="<?= $weixinWork_api['corpid']; ?>">
                </div>
                <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                    <i class="am-icon-lightbulb-o"></i> 登录企业微信WEB管理端，在 我的企业 - 企业信息，最下方可以看到企业ID。将此ID信息填入。
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">AgentId</label>
                    <input name="weixinWork_api[AgentId]" placeholder="" type="text" value="<?= $weixinWork_api['AgentId']; ?>" >
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">Secret</label>
                    <input name="weixinWork_api[Secret]" placeholder="" type="text" value="<?= $weixinWork_api['Secret']; ?>" >
                </div>
            </div>
        </div>

    </div>
</div>