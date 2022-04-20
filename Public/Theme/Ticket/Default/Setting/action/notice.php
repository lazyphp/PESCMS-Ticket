<div class="am-panel am-panel-default am-panel-hover am-panel-striped">
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
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 被动触发需要系统有人访问才生效。建议有动手能力的，选用定时触发。
                    </div>
                </div>
            </div>
        </div>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">勿扰时段</label>
                    <div class="am-form-inline">
                        <div class="am-form-group am-form-icon">
                            <i class="am-icon-clock-o"></i>
                            <input type="text" class="am-form-field" name="disturb[begin]" placeholder="开始时间" value="<?= $disturb['begin'] ?>" pattern="\d*" maxlength="2">
                        </div>

                        <div class="am-form-group am-form-icon">
                            <i class="am-icon-clock-o"></i>
                            <input type="text" class="am-form-field" name="disturb[end]" placeholder="结束时间" value="<?= $disturb['end'] ?>" pattern="\d*" maxlength="2">
                        </div>
                    </div>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 若您需要指定时间不接收消息，请在上述两个输入框填入时间。 <strong class="am-text-danger">注意：1. 24小时制 2. 本功能只对所有后台客服账户起效。</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">开启行锁<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="rowlock" required="" <?= $rowlock['value'] == '0' ? 'checked="checked"' : '' ?>>
                        关闭
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="rowlock" required="" <?= $rowlock['value'] == '1' ? 'checked="checked"' : '' ?>>
                        开启
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 若系统消息频繁重复发送，可以尝试开启行锁。但这样可能会导致系统打开缓慢。
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
                    <label class="am-checkbox-inline" data-am-popover="{content: '勾选钉钉企业，请确保下面钉钉企业的API填写正确', trigger: 'hover focus'}">
                        <input type="checkbox" value="5" name="cs_notice_type[5]" <?= $cs_notice_type['5'] == '5' ? 'checked="checked"' : '' ?>> 钉钉企业
                    </label>
                    <label class="am-checkbox-inline" data-am-popover="{content: '欢迎反馈给官方', trigger: 'hover focus'}">
                        <input type="checkbox" value="99" name="cs_notice_type[99]" <?= $cs_notice_type['99'] == '99' ? 'checked="checked"' : '' ?> disabled="disabled"> 其他方式
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 勾选上述选项，当系统有消息通知，将按照勾选的写入发送列表。建议只选用一种常用的接收方式，以免给内部人员造成消息接收压力。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <label class="am-block">全局工单联系方式<i class="am-text-danger">*</i></label>
                <?php foreach(array_merge($ticket_contact, [[]]) as $key => $value): ?>
                <div class="input-example">
                    <div class="am-form-inline am-margin-bottom-xs">
                        <div class="am-form-group">
                            <input type="text" name="ticket_contact_title[]" class="am-form-field" placeholder="工单联系方式名称" value="<?= $value['title'] ?>" <?= isset($value['key']) && $value['key'] <=6 ? 'readonly="readonly"' : '' ?>>
                        </div>
                        <div class="am-form-group">
                            <input type="text" name="ticket_contact_key[]" class="am-form-field" placeholder="工单联系方式值" value="<?= $value['key'] ?>" <?= isset($value['key']) && $value['key'] <=6 ? 'readonly="readonly"' : '' ?>>
                        </div>
                        <div class="am-form-group">
                            <input type="text" name="ticket_contact_field[]" class="am-form-field" placeholder="Member表对应字段名称" value="<?= $value['field'] ?>" <?= isset($value['key']) && $value['key'] <=6 ? 'readonly="readonly"' : '' ?>>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="pes-alert pes-alert-error am-text-xs ">
                    <i class="am-icon-lightbulb-o"></i> 若需要新增一个工单联系方式，请根据系统已有联系方式格式进行填写，非专业人士不建议更改此值！！
                </div>
            </div>
        </div>

    </div>
</div>