<?php if (!empty($chat)): ?>
    <?php foreach ($chat as $value): ?>
        <li class="<?= $value['user_id'] == '-1' ? ' am-text-gray-background' : '' ?> ">


            <div class="am-g">
                <div class="am-u-sm-2 am-u-lg-1">
                    <?php if ($value['user_id'] == '-1'): ?>
                        <i class="am-icon-btn am-primary am-icon-user"></i>
                    <?php else: ?>
                        <i class="am-icon-btn am-danger am-icon-slideshare"></i>
                    <?php endif; ?>
                </div>
                <div class="am-u-sm-10 am-u-lg-11">
                    <div class="am-block am-nbfc <?= $value['ticket_chat_delete'] == 1 ? 'pes-chat-delete' : '' ?> ">
                        <?= $value['user_id'] == '-1' ? (empty($member) ? '匿名用户 : ' : "{$member['member_name']} : ") : "{$value['user_name']} : " ?><?= $label->xss(htmlspecialchars_decode($value['ticket_chat_content']), false) ?>
                    </div>

                    <div class="am-block">
                        <div class="am-fl"><?= date('Y-m-d H:i:s', $value['ticket_chat_time']); ?>
                            <?php if ($system['ticket_read'] == 1 || (!empty(self::session()->get('ticket')) && GROUP == 'Ticket')): ?>
                                <span class="am-text-gray">[<?= $value['ticket_chat_read'] == 1 ? '已读' : '未读' ?>]</span>
                            <?php endif; ?>
                        </div>

                        <?php if (GROUP == 'Ticket'): ?>

                            <?php if (!empty(self::session()->get('ticket')) && self::session()->get('ticket')['user_id'] == $value['user_id'] && $value['ticket_chat_delete'] == 0 && $ticket_close == 0 && $ticket_status != 3 && $label->checkAuth('TicketDELETETicketchat') === true  ): ?>
                                <div class="am-fr am-margin-left">
                                    <span><a href="<?= $label->url('Ticket-Ticket-chat', ['id' => $value['ticket_chat_id'], 'method' => 'DELETE']) ?>" class="am-text-danger ajax-click ajax-dialog" msg="确定删除此回复内容吗？已产生的通知是不会被删除的。">[<i class="am-icon-remove"></i> 删除]</a></span>
                                </div>
                            <?php endif; ?>


                            <?php if (!empty(self::session()->get('ticket')) && self::session()->get('ticket')['user_id'] == $value['user_id'] && $user_id == self::session()->get('ticket')['user_id'] ): ?>
                                <div class="am-fr">
                                    <a href="javascript:;" class="add-chat-tips" cid="<?= $value['ticket_chat_id'] ?>">[<i class="am-icon-lightbulb-o"></i>
                                        添加提醒]</a>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>
            </div>

            <?php require __DIR__ . '/Ticket_vew_chat_tips.php' ?>
        </li>
    <?php endforeach; ?>
<?php else: ?>
    <li>
        暂时还没有沟通记录。
    </li>
<?php endif; ?>