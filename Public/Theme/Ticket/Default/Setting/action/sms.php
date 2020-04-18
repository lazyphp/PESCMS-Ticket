<div class="am-panel am-panel-default am-panel-hover am-panel-striped">
    <div class="am-panel-hd">短信通知</div>
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">业务提供商</label>
                    <select name="sms[COMPANY]" required>
                        <option value="">请选择短信业务提供商</option>
                        <option value="1" <?= $sms['COMPANY'] == 1 ? 'selected="selected"' :'' ?>>阿里云</option>
                        <option value="2" <?= $sms['COMPANY'] == 2 ? 'selected="selected"' :'' ?>>互亿无线</option>
                    </select>
                </div>
            </div>
        </div>
        <!--阿里云API参数-->
        <div class="pes-alert pes-alert-error am-text-xs sms-1 am-margin-top-0" >
            <i class="am-icon-lightbulb-o"></i> 阿里云短信注册享优惠：<a href="https://www.pescms.com/goAd/10.html" target="_blank" style="color:#0e90d2 "><b>点击注册</b></a>。短信的设置教程:<a href="https://www.pescms.com/d/v/1.3.x/22/161.html" target="_blank" style="color:#0e90d2 "> <b>教程</b></a>
        </div>

        <div class="am-g am-g-collapse sms-1">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">accessKeyId</label>
                    <input name="sms[aliyun_accessKeyId]" placeholder="请填写短信平台的accessKeyId" type="text" value="<?= $sms['aliyun_accessKeyId']; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-1">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">accessSecret</label>
                    <input name="sms[aliyun_accessSecret]" placeholder="请填写短信平台的accessSecret" type="text" value="<?= $sms['aliyun_accessSecret']; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-1">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">SignName</label>
                    <input name="sms[aliyun_SignName]" placeholder="请填写短信平台的SignName" type="text" value="<?= $sms['aliyun_SignName']; ?>">
                </div>
            </div>
        </div>

        <?php foreach(\Model\Content::listContent(['table' => 'mail_template']) as $key => $value): ?>
            <div class="am-g am-g-collapse sms-1">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <div class="am-form-group">
                        <label class="am-block"><?= $label->getFieldOptionToMatch(183, $value['mail_template_type']); ?>的TemplateCode</label>
                        <input name="sms[aliyun_TemplateCode][<?= $value['mail_template_id'] ?>]" placeholder="请填写短信对应模板的的TemplateCode" type="text" value="<?= $sms['aliyun_TemplateCode'][$value['mail_template_id']]; ?>">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!--阿里云API参数-->

        <!--互亿无线API参数-->
        <div class="pes-alert pes-alert-info am-text-xs sms-2 am-margin-top-0" >
            <i class="am-icon-lightbulb-o"></i> 使用短信业务，需要先进行注册：<a href="https://www.pescms.com/goAd/11.html" target="_blank" style="color:#0e90d2 "><b>点击注册</b></a>。短信的设置教程:<a href="https://www.pescms.com/d/v/1.2.7/22/145.html" target="_blank" style="color:#0e90d2 "> <b>教程</b></a>
        </div>
        <div class="am-g am-g-collapse sms-2">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIID</label>
                    <input name="sms[ihuyi_APIID]" placeholder="请填写短信平台的APIID" type="text" value="<?= $sms['ihuyi_APIID']; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-2">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIKEY</label>
                    <input name="sms[ihuyi_APIKEY]" placeholder="请填写短信平台的APIKEY" type="password" value="<?= $sms['ihuyi_APIKEY']; ?>">
                </div>
            </div>
        </div>
        <!--互亿无线API参数-->

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
    <script>
        $(function () {

            var showSMS = function(value){
                $("div[class*='sms-']").hide();
                $('.sms-'+value).show();
            }
            showSMS('<?= $sms['COMPANY'] ?>')

            $('select[name="sms[COMPANY]"]').on('click', function () {
                var value = $(this).val();
                showSMS(value)
            })
        })
    </script>
</div>