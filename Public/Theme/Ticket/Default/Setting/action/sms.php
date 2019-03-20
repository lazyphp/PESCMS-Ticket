<div class="am-panel am-panel-default">
    <div class="am-panel-hd">短信通知</div>
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIID</label>
                    <input name="sms[APIID]" placeholder="" type="text" value="<?= $sms['APIID']; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIKEY</label>
                    <input name="sms[APIKEY]" placeholder="" type="password" value="<?= $sms['APIKEY']; ?>">
                </div>
            </div>
        </div>

        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
            <i class="am-icon-lightbulb-o"></i> 使用短信业务，需要先进性注册：<a href="https://www.pescms.com/?m=Index&a=sms" target="_blank" style="color:#0e90d2 "><b>点击注册</b></a>
        </div>

    </div>
</div>