<?php if(empty($list)): ?>
    <li><a href="javascript:;" class="close-tips">暂无新消息</a></li>
<?php else: ?>

    <?php foreach($list as $key => $value): ?>
        <li><a href="<?= $label->url('Ticket-User-notice', ['type' => $value['csnotice_type']]) ?>" class="close-tips"><?= sprintf('有%s条%s', $value['num'], $label->getFieldOptionToMatch(255, $value['csnotice_type'])) ?></a></li>
    <?php endforeach; ?>
<?php endif; ?>