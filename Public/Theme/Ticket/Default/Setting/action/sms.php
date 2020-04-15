<div class="am-panel am-panel-default">
    <div class="am-panel-hd">短信通知</div>
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">业务提供商</label>
                    <select name="sms[COMPANY]" required>
                        <option value="">请选择短信业务提供商</option>
                        <option value="1">阿里云</option>
                        <option value="2">互亿无线</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-2">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIID</label>
                    <input name="sms[APIID]" placeholder="请填写短信平台的APIID" type="text" value="<?= $sms['APIID']; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-2">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIKEY</label>
                    <input name="sms[APIKEY]" placeholder="请填写短信平台的APIKEY" type="password" value="<?= $sms['APIKEY']; ?>">
                </div>
            </div>
        </div>

        <div class="am-alert am-alert-secondary am-text-xs sms-2" data-am-alert>
            <i class="am-icon-lightbulb-o"></i> 使用短信业务，需要先进行注册：<a href="https://www.pescms.com/?m=Index&a=sms" target="_blank" style="color:#0e90d2 "><b>点击注册</b></a>。短信的设置教程:<a href="https://www.pescms.com/d/v/1.2.7/22/145.html" target="_blank" style="color:#0e90d2 "> <b>教程</b></a>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">短信发送测试</label>
                    <select class="am-inline" name="template" style="width: auto">
                        <option>选择发送的模板</option>
                        <?php foreach(\Model\Content::listContent(['table' => 'mail_template']) as $key => $value): ?>
                            <option value="<?= $value['mail_template_id'] ?>"><?= $label->getFieldOptionToMatch(183, $value['mail_template_type']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" class="test_account am-inline" placeholder="测试手机号码" style="width: 20%">
                    <a href="javascript:;" data="<?= $label->url(GROUP.'-Setting-mobileTest') ?>" type="submit" class="am-inline am-btn am-btn-secondary send-test" >发送短信</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        $('select[name="sms[COMPANY]"]').on('click', function () {
            var value = $(this).val();
            $("div[class*='sms-']").hide();
            $('.sms-'+value).show();
        })
    })
</script>