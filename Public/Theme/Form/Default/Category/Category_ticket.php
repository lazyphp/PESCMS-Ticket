<hr class="am-margin-top-0" />
<h3>新工单 > <?= $ticketInfo['title'] ?></h3>
<form action="<?= $label->url('Submit-ticket') ?>" method="POST" class="am-form ajax-submit am-form-horizontal" data-am-validator>
    <input type="hidden" name="number" value="<?= $ticketInfo['number'] ?>">
    <?= $label->token() ?>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">联系方式<i class="am-text-danger">*</i></label>
                <label class="form-radio-label am-radio-inline">
                    <input class="form-radio" type="radio" name="contact" value="1" required="required"  checked="checked" />
                    <span>邮件</span>
                </label>
            </div>
        </div>
    </div>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">联系信息<i class="am-text-danger">*</i></label>
                <input class="form-text-input input-leng3 am-field-valid" name="contact_account" placeholder="请填写您的联系信息,方便我们与您联系" type="text" value="" required="">
            </div>
        </div>
    </div>

    <div class="am-g am-g-collapse">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block">工单标题<i class="am-text-danger">*</i></label>
                <input class="form-text-input input-leng3 am-field-valid" name="title" placeholder="简单扼要描述本次工单遇到的问题" type="text" value="" required="">
            </div>
        </div>
    </div>

    <?php foreach ($field as $key => $value): ?>
    <div id="<?= $value['field_name'] ?>" class="am-g am-g-collapse <?= $value['field_bind'] != '0' ? 'am-hide' : '' ?>">
        <div class="am-u-sm-12 am-u-sm-centered">
            <div class="am-form-group">
                <label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>
                <?= (new \Expand\Form\Form())->formList($value); ?>
                <?php if (!empty($value['field_explain'])): ?>
                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                        <i class="am-icon-lightbulb-o"></i> <?= $value['field_explain'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if ($ticketInfo['verify'] == '1'): ?>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">验证码<i class="am-text-danger">*</i></label>
                    <input type="text" name="verify" class="am-inline am-input-sm" style="width: 15%" required/>
                    <img class="refresh-verify " src="<?= $label->url('Index-verify', ['t' => time()]) ?>" class="am-inline"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="am-g am-g-collapse am-margin-bottom">
        <div class="am-u-sm-12 am-u-sm-centered">
            <button type="submit" class="am-btn am-btn-primary am-btn-xs" >提交</button>
        </div>
    </div>
</form>