<?php if (!empty($chatTips[$value['ticket_chat_id']])): ?>
<div class="am-g">

    <div class="am-u-sm-2 am-u-lg-1"></div>
    <div class="am-u-sm-10 am-u-lg-11 pes-chat-tips">

            <?php foreach ($chatTips[$value['ticket_chat_id']] as $tipsItem): ?>
                <?php
                    //非全局只有本人可见
                    if($tipsItem['tips_type'] == 1 && $tipsItem['tips_user_id'] != self::session()->get('ticket')['user_id']){
                        continue;
                    }
                ?>
                <ul>
                <li>
                    <?= $tipsItem['tips_user_id'] == self::session()->get('ticket')['user_id'] ? '我' : $getUserList[$tipsItem['tips_user_id']]['user_name'] ?> :
                    <?= $tipsItem['tips_content'] ?>
                    <div>
                        
                        <?php if($tipsItem['tips_type'] == 1): ?>
                            <span class="am-badge am-radius am-badge-warning">[仅本人可见]</span>
                        <?php endif; ?>
                        
                        <?= date('Y-m-d H:i', $tipsItem['tips_time']) ?> 
                        <?php if($tipsItem['tips_user_id'] == self::session()->get('ticket')['user_id']): ?>
                            <a href="<?= $label->url('Ticket-Ticket-tips', ['id' => $ticket_id, 'tid' => $tipsItem['tips_id'], 'method' => 'DELETE']) ?>" class="ajax-click ajax-dialog"><i class="am-icon-remove"></i></a>
                        <?php endif; ?>
                    </div>
                </li>

            <?php endforeach; ?>
            <?php foreach ($chatTips[$value['ticket_chat_id']] as $tipsItem): ?>
                </ul>
            <?php endforeach; ?>

    </div>
</div>
<?php endif; ?>

