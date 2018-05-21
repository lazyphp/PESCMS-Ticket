<hr class="am-margin-top-0" />
<h3><?= $ticketInfo['title'] ?></h3>
<form action="<?= $domain; ?>/?g=Form&m=Submit&a=ticket" method="POST" class="am-form am-form-horizontal" data-am-validator>
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
</form>