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
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 关闭注册需要手动添加客户。(微信公众号登录注册不受影响，仅限快速注册)
                    </div>
                </div>
            </div>
        </div>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">启用手机验证码登录<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="sms_login" required="" <?= $sms_login['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="sms_login" required="" <?= $sms_login['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 开启后不受「开放注册」限制。默认手机号未注册时自动注册，除了手机号是真实，其余信息均为随机生成。
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
                    <label class="am-radio-inline">
                        <input type="radio" value="2" name="member_review" required="" <?= $member_review['value'] == '2' ? 'checked="checked"' : '' ?>> 邮件激活验证
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 按需启用审核，若为邮件激活验证，请确保系统注册选项中启用了邮箱字段。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">客户登录方式<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="member_login" required="" <?= $member_login['value'] == '0' ? 'checked="checked"' : '' ?>> 邮箱地址
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="member_login" required="" <?= $member_login['value'] == '1' ? 'checked="checked"' : '' ?>> 账号
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="2" name="member_login" required="" <?= $member_login['value'] == '2' ? 'checked="checked"' : '' ?>> 手机号码
                    </label>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">自定义注册选项</label>
                    <a href="<?= $label->url('Ticket-Field-index', ['model_id' => 20]) ?>" class="am-btn am-btn-danger am-btn-xs" target="_blank" onclick="return confirm('请先阅读文档说明，本操作极可能导致系统崩溃。')" >进行修改</a>
                </div>
                <div class="pes-alert pes-alert-warning am-text-xs " >
                    <i class="am-icon-lightbulb-o"></i> 修改前务必先阅读 <a href="https://document.pescms.com/article/3/276180133704892416.html" target="_blank">《客户管理》</a> 文档。任何修改导致系统崩溃，后果自负。
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">微信公众号注册需要填写完整的用户资料<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="weixinRegister" required="" <?= $weixinRegister['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="weixinRegister" required="" <?= $weixinRegister['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 考虑用户体验，默认从微信公众号访问系统的，都开启快速注册和绑定账号。若您希望用户填写完整资料才可以完成账号注册，请选择开启本选项。
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>