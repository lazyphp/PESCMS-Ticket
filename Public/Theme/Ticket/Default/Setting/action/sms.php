<div class="am-panel am-panel-default am-panel-hover am-panel-striped">
    <div class="am-panel-hd">短信通知</div>
    <div class="am-panel-bd">

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">业务提供商</label>
                    <select name="sms[COMPANY]">
                        <option value="">请选择短信业务提供商</option>
                        <option value="1" <?= isset($sms['COMPANY']) && $sms['COMPANY'] == 1 ? 'selected="selected"' : '' ?>>
                            阿里云
                        </option>
                        <option value="2" <?= isset($sms['COMPANY']) && $sms['COMPANY'] == 2 ? 'selected="selected"' : '' ?>>
                            互亿无线
                        </option>
                    </select>

                    <div class="pes-alert pes-alert-error am-text-sm sms-1">
                        <i class="am-icon-lightbulb-o"></i>
                        阿里云短信注册享优惠：<a href="https://www.pescms.com/goAd/10.html" target="_blank" style="color:#0e90d2 "><b>点击注册</b></a>。短信的设置教程:<a href="https://document.pescms.com/article/3/279813254090326016.html" target="_blank" style="color:#0e90d2 ">
                            <b>教程</b></a>
                    </div>

                    <div class="pes-alert pes-alert-info am-text-xs sms-2">
                        <i class="am-icon-lightbulb-o"></i>
                        使用短信业务，需要先进行注册：<a href="https://www.pescms.com/goAd/11.html" target="_blank" style="color:#0e90d2 "><b>点击注册</b></a>。短信的设置教程:<a href="https://document.pescms.com/article/3/279815441193369600.html" target="_blank" style="color:#0e90d2 ">
                            <b>教程</b></a>
                    </div>

                </div>
            </div>
        </div>


        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">手机验证码模板</label>
                    <textarea rows="5" name="sms_verify_template" <?= isset($license) && $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>><?= $sms_verify_template['value'] ?></textarea>

                    <div class="pes-alert pes-alert-warning am-text-xs ">
                        <i class="am-icon-lightbulb-o"></i> 若没有特殊情况，可直接使用本模板。其中模板的中验证码生成的变量为：{sms_code}
                    </div>

                </div>
            </div>
        </div>

        <!--阿里云API参数-->
        <div class="am-g am-g-collapse sms-1">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">accessKeyId</label>
                    <input name="sms[aliyun_accessKeyId]" placeholder="请填写短信平台的accessKeyId" type="text" value="<?= $sms['aliyun_accessKeyId'] ?? ''; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-1">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">accessSecret</label>
                    <input name="sms[aliyun_accessSecret]" placeholder="请填写短信平台的accessSecret" type="text" value="<?= $sms['aliyun_accessSecret'] ?? ''; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-1">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">SignName</label>
                    <input name="sms[aliyun_SignName]" placeholder="请填写短信平台的SignName" type="text" value="<?= $sms['aliyun_SignName'] ?? ''; ?>">
                </div>
            </div>
        </div>


        <?php foreach (\Model\Content::listContent(['table' => 'mail_template']) as $key => $value): ?>

            <?php if ($value['mail_template_id'] == 1 || empty($sms['aliyun_TemplateCode'][$value['mail_template_id']])): ?>
                <div class="am-g am-g-collapse sms-1">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">手机验证码的TemplateCode</label>
                            <input name="sms[aliyun_TemplateCode][0]" placeholder="请填写短信手机验证码登录的TemplateCode" type="text" value="<?= $sms['aliyun_TemplateCode'][0] ?? ''; ?>">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="am-g am-g-collapse sms-1">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <div class="am-form-group">
                        <label class="am-block"><?= $label->getFieldOptionToMatch(183, $value['mail_template_type']); ?>的TemplateCode</label>
                        <input name="sms[aliyun_TemplateCode][<?= $value['mail_template_id'] ?>]" placeholder="请填写短信对应模板的的TemplateCode" type="text" value="<?= $sms['aliyun_TemplateCode'][$value['mail_template_id']] ?? ''; ?>">
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

        <!--阿里云API参数-->

        <!--互亿无线API参数-->
        <div class="am-g am-g-collapse sms-2">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIID</label>
                    <input name="sms[ihuyi_APIID]" placeholder="请填写短信平台的APIID" type="text" value="<?= $sms['ihuyi_APIID'] ?? ''; ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse sms-2">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">APIKEY</label>
                    <input name="sms[ihuyi_APIKEY]" placeholder="请填写短信平台的APIKEY" type="password" value="<?= $sms['ihuyi_APIKEY'] ?? ''; ?>">
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
                        <?php foreach (\Model\Content::listContent(['table' => 'mail_template']) as $key => $value): ?>
                            <option value="<?= $value['mail_template_id'] ?>"><?= $label->getFieldOptionToMatch(183, $value['mail_template_type']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" class="test_account am-inline" placeholder="测试手机号码" style="width: 20%">
                    <a href="javascript:;" data="<?= $label->url(GROUP . '-Setting-mobileTest') ?>" type="submit" class="am-inline am-btn am-btn-secondary send-test">发送短信</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {

            var showSMS = function (value) {
                $("div[class*='sms-']").hide();
                $('.sms-' + value).show();

                if($('textarea[name="sms_verify_template"]').attr("readonly") == 'readonly'){
                    if(value == 1) {
                        $('textarea[name="sms_verify_template"]').val('{"code":"{sms_code}"}')
                    }else{
                        $('textarea[name="sms_verify_template"]').val('您的验证码是:{sms_code}，有效期十分钟。若非本人操作，请忽略本短信。')
                    }
                }

            }
            showSMS('<?= $sms['COMPANY'] ?? '' ?>')

            $('select[name="sms[COMPANY]"]').on('click', function () {
                var value = $(this).val();
                showSMS(value)
            })
        })
    </script>
</div>