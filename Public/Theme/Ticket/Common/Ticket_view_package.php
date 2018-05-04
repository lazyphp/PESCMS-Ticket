<div class="am-g console-step row am-margin-bottom-sm">
    <?php foreach ($ticketStatus as $key => $value): ?>

        <div
            class="step am-u-sm-3 <?= $key == 0 ? 'step-first' : ($key == '3' ? 'step-end ' : '') ?>  <?= $ticket_status == $key ? 'step-active' : 'step-pass' ?>">
            <span class="ng-binding  "><?= $value['name']; ?></span>
        </div>
    <?php endforeach; ?>
</div>


<div class="am-g am-padding pt-info-panel ">
    <div class="am-u-sm-12 am-u-sm-centered">
        <div><span class="pt-text-explode">问题标题 : </span> <?= $ticket_title; ?></div>
        <div class="am-g">
            <div class="am-u-sm-4"><span class="pt-text-explode">工单编号 : </span><?= $ticket_number; ?></div>
            <div class="am-u-sm-4">
                <span class="pt-text-explode">提交时间 : </span><?= date('Y-m-d H:i:s', $ticket_submit_time); ?></div>
            <div class="am-u-sm-4"><span class="pt-text-explode">工单状态 : </span><?= $ticket_close == '0' ? $ticketStatus[$ticket_status]['name'] : '工单关闭'; ?>
            </div>
        </div>
    </div>
</div>

<ul class="am-list am-list-static am-list-border am-text-sm am-list-hover">
    <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">沟通记录</li>
    <li class="am-text-gray">
        <div class="am-g">
            <div class="am-u-sm-1">
                <img src="<?= DOCUMENT_ROOT.'/Theme/assets/i/custom.ico'; ?>" alt=""
                     class="am-comment-avatar" width="48" height="48">
            </div>
            <div class="am-u-sm-11">
                <div class="am-block">
                    <?php foreach ($form as $key => $value): ?>
                        <?php if ($value['ticket_form_bind'] == '0'): ?>
                            <p>
                                    <span class="pt-text-explode"><?= $value['ticket_form_description']; ?>
                                        : </span><?= $value['ticket_value']; ?>
                            </p>
                        <?php else: ?>
                            <?php if (in_array($form[$value['ticket_form_bind']]['ticket_form_content'], $value['ticket_form_bind_value'])): ?>
                                <p>
                                        <span class="pt-text-explode"><?= $value['ticket_form_description']; ?>
                                            : </span><?= $value['ticket_value']; ?>
                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div class="am-block"><?= date('Y-m-d H:i:s', $ticket_submit_time); ?></div>
            </div>
        </div>
    </li>
    <?php if (!empty($chat)): ?>
        <?php foreach ($chat as $value): ?>
            <li class="<?= $value['user_id'] == '-1' ?  'am-text-gray' : '' ?> ">
                <div class="am-g">
                    <div class="am-u-sm-1">
                        <img src="<?= DOCUMENT_ROOT.'/Theme/assets/i/'; ?><?= $value['user_id'] == '-1' ?  'custom.ico' : 'service.ico' ?>" alt=""
                             class="am-comment-avatar" width="48" height="48">
                    </div>
                    <div class="am-u-sm-11">
                        <div class="am-block">
                            <?= $value['user_id'] == '-1' ? '' : "{$value['user_name']} : " ?><?= $value['ticket_chat_content'] ?>
                        </div>
                        <div class="am-block"><?= date('Y-m-d H:i:s', $value['ticket_chat_time']); ?></div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>