<?php include THEME_PATH . '/header.php'; ?>
<style type="text/css" media="print">
    .print-btn{display: none;}
</style>
<div class="am-padding-xs am-margin-top am-text-sm">
    <div class="printer_logo am-nbfc">
        <div class="am-fl">
            <img src="<?= $system['siteLogo'] ?>" height="60"/>
        </div>
        <div class="am-fr am-margin-right-lg">
            <button onclick="javascript:window.print();" class="am-btn am-btn-danger print-btn">打印</button>
        </div>
    </div>

    <div class="printer_info am-margin-top">
        <table class="am-table am-table-radius am-table-striped">
            <tr>
                <td colspan="4">
                    <span class="pt-text-explode">问题标题 : </span><?= $ticket['ticket_title'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="pt-text-explode">工单编号 : </span><?= $ticket['ticket_number'] ?>
                </td>
                <td>
                    <span class="pt-text-explode">工单类型 : </span><?= $ticket['ticket_model_name'] ?>
                </td>
                <td>
                    <span class="pt-text-explode">提交时间 : </span><?= date('Y-m-d H:i:s', $ticket['ticket_submit_time']) ?>
                </td>
                <td>
                    <span class="pt-text-explode">工单状态 : </span><?= $ticket['ticket_close'] == '0' ? $ticketStatus[$ticket['ticket_status']]['name'] : '工单关闭'; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="pt-text-explode">联系方式 : </span><?= $ticket['ticket_contact'] == 1 ? '邮件' : ($ticket['ticket_contact'] == 2 ? '手机' : '微信'); ?>
                </td>
                <td>
                    <span class="pt-text-explode">联系信息 : </span><?= $ticket['ticket_contact_account'] ?>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table class="am-table am-table-radius am-table-striped">
            <tr>
                <th class="am-text-lg">问题描绘</th>
            </tr>
            <?php foreach ($form as $key => $value): ?>
                <?php if ($value['ticket_form_bind'] == '0'): ?>
                    <tr>
                        <td>
                            <strong><?= $value['ticket_form_description']; ?>:</strong>
                            <span><?= $value['ticket_value']; ?></span>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php if (in_array($form[$value['ticket_form_bind']]['ticket_form_content'], $value['ticket_form_bind_value'])): ?>
                        <tr>
                            <td>
                                <strong><?= $value['ticket_form_description']; ?>:</strong>
                                <span><?= $value['ticket_value']; ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>

            <?php endforeach; ?>
        </table>

        <?php if(!empty($chat['list'])): ?>
        <table class="am-table am-table-radius am-table-striped">
            <tr>
                <th class="am-text-lg">沟通记录</th>
            </tr>
            <?php foreach($chat['list'] as $key => $value): ?>
            <tr>
                <td>
                    <strong class="am-block"><?= $value['user_id'] == '-1' ? '用户' : "客服 - {$value['user_name']}" ?> :</strong>
                    <span class="am-block"><?=  $label->xss(htmlspecialchars_decode($value['ticket_chat_content'])) ?></span>
                    <small><?= date('Y-m-d H:i:s', $value['ticket_chat_time']); ?></small>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>

    </div>

</div>
