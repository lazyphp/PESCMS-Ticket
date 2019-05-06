<div class="am-panel am-panel-default">
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">开放注册<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="open_register" required="" <?= $open_register['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="open_register" required="" <?= $open_register['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 关闭注册需要手动添加客户。(微信公众号登录注册不受影响)
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">客户注册是否需要审核<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="member_review" required="" <?= $member_review['value'] == '0' ? 'checked="checked"' : '' ?>> 开启审核
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="member_review" required="" <?= $member_review['value'] == '1' ? 'checked="checked"' : '' ?>> 关闭审核
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 通过注册的客户是否需要进行审核。
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>