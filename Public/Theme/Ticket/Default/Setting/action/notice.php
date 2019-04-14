<div class="am-panel am-panel-default">
    <div class="am-panel-hd">发送设置</div>
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">全站通知发送方式<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="notice_way" required="" <?= $notice_way['value'] == '1' ? 'checked="checked"' : '' ?>>
                        被动触发
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="2" name="notice_way" required="" <?= $notice_way['value'] == '2' ? 'checked="checked"' : '' ?>>
                        定时器触发
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="3" name="notice_way" required="" <?= $notice_way['value'] == '3' ? 'checked="checked"' : '' ?>>
                        两者兼有
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 请填写正确的域名，以便工单能够正确地提交！
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">客服人员接收通知方式<i class="am-text-danger">*</i></label>
                    <label class="am-checkbox-inline">
                        <input type="checkbox" value="1" name="cs_notice_type[1]" <?= $cs_notice_type['1'] == '1' ? 'checked="checked"' : '' ?>> 邮箱地址
                    </label>
                    <label class="am-checkbox-inline" data-am-popover="{content: '勾选企业微信，请确保下面企业微信的API填写正确', trigger: 'hover focus'}">
                        <input type="checkbox" value="4" name="cs_notice_type[4]" <?= $cs_notice_type['4'] == '4' ? 'checked="checked"' : '' ?>> 企业微信
                    </label>
                    <label class="am-checkbox-inline" data-am-popover="{content: '欢迎反馈给官方', trigger: 'hover focus'}">
                        <input type="checkbox" value="99" name="cs_notice_type[99]" <?= $cs_notice_type['99'] == '99' ? 'checked="checked"' : '' ?> disabled="disabled"> 其他方式
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 勾选上述选项，当系统有消息通知，将按照勾选的写入发送列表。建议只选用一种常用的接收方式，以免给内部人员造成消息接收压力。
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>