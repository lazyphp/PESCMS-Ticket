<div class="am-panel am-panel-default">
    <div class="am-panel-hd">基础信息</div>
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">检查更新<i class="am-text-danger">*</i></label>
                    <a class="am-btn am-btn-sm am-btn-warning" href="<?= $label->url(GROUP . '-Setting-upgrade') ?>"><i class="am-icon-refresh"></i> <?= $version['value'] ?>
                    </a>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">网站URL<i class="am-text-danger">*</i></label>
                    <input name="domain" placeholder="网站URL" type="text" value="<?= $domain['value']; ?>" required="">
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 请填写正确的域名，以便工单能够正确地提交！域名需要带http或者https，按照服务器实际情况填写。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">域名白名单<i class="am-text-danger">*</i></label>
                    <textarea rows="5" name="crossdomain"><?= empty($crossdomain) ? '' : implode("\n", $crossdomain); ?></textarea>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 默认情况下，所有请求可以正常提交工单，若指定域名白名单，请一行一个域名的形式填写
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">开启首页<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="openindex" required="" <?= $openindex['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="openindex" required="" <?= $openindex['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 若允许所有人通过首页填写工单查询，那么请开启。反之用户直接访问首页名将报404错误。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">开启站内工单<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="interior_ticket" required="" <?= $interior_ticket['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="interior_ticket" required="" <?= $interior_ticket['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 若允许在站内提交工单请开启，反之禁止。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">开启注册和登录<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="open_register" required="" <?= $open_register['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="open_register" required="" <?= $open_register['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 开启则用户可以进行登录和注册，站内提交工单将自动填充必要的信息。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
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
                    <label class="am-block">登录验证码<i class="am-text-danger">*</i></label>
                    <label class="am-checkbox-inline">
                        <input type="checkbox" value="1" name="login_verify[]" required="" <?= $login_verify['0'] == '1' ? 'checked="checked"' : '' ?>> 前台开启
                    </label>
                    <label class="am-checkbox-inline">
                        <input type="checkbox" value="2" name="login_verify[]" required="" <?= $login_verify['1'] == '2' ? 'checked="checked"' : '' ?>> 后台开启
                    </label>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> 前后台用户登录是否需要验证码
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
                    <label class="am-checkbox-inline" data-am-popover="{content: '接口功能努力开发中', trigger: 'hover focus'}">
                        <input type="checkbox" value="2" name="cs_notice_type[2]" <?= $cs_notice_type['2'] == '2' ? 'checked="checked"' : '' ?> disabled="disabled"> 手机短信
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