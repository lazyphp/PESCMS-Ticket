<div class="am-panel am-panel-default ticket-info">
    <div class="am-panel-bd">
        <?php if (!empty($_GET['back_url'])): ?>
            <div class="">
                <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                            class="am-icon-reply"></i>返回上一页</a>
                <a class="am-link-muted print-ticket"
                   href="<?= $label->url('View-printer', ['number' => $ticket_number]); ?>"><span
                            class="am-icon-print"></span></a>
                <span class="am-hide cs-title"><?= $ticket_title ?></span>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
        <?php endif; ?>

        <div class="console-step row am-margin-bottom-sm">
            <?php foreach ($ticketStatus as $key => $value): ?>

                <div class="step am-u-sm-3 <?= $key == 0 ? 'step-first' : ($key == '3' ? 'step-end ' : '') ?>  <?= $ticket_status == $key ? 'step-active' : 'step-pass' ?>">
                    <span class="ng-binding  "><?= $value['name']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="am-text-center show-pt-info am-text-xs" style="display: none">
            <span class="text">展开详情</span>
            <span class="icon"><i class="am-icon-angle-double-down"></i></span>
        </div>

        <div class="am-padding pt-info-panel">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="pt-view-desc-question">
                    <span class="pt-text-explode">问题标题 : </span> <?= $ticket_title; ?> <?= $member_id == '-1' && GROUP == 'Ticket' ? '<b class="am-text-gray">[匿名工单]</b>' : '' ?>
                </div>
                <div class="am-g am-g-collapse pt-view-desc">
                    <div class="am-u-sm-12 am-u-lg-3"><span class="pt-text-explode">工单编号 : </span><?= $ticket_number; ?>
                    </div>
                    <div class="am-u-sm-12 am-u-lg-3"><span class="pt-text-explode">工单类型 : </span>
                        <?= $ticket_model_name; ?>
                    </div>
                    <div class="am-u-sm-12 am-u-lg-3">
                        <span class="pt-text-explode">提交时间 : </span><?= date('Y-m-d H:i:s', $ticket_submit_time); ?>
                    </div>
                    <div class="am-u-sm-12 am-u-lg-3"><span
                                class="pt-text-explode">工单状态 : </span><?= $ticket_close == '0' ? $ticketStatus[$ticket_status]['name'] : '工单关闭'; ?>
                    </div>
                    <div class="am-u-sm-12 am-u-lg-3"><span
                                class="pt-text-explode">联系方式 : </span><?= $ticket_contact_name ?? '未知联系方式'; ?></div>
                    <div class="am-u-sm-12 am-u-lg-3"><span class="pt-text-explode">联系信息 : </span>
                        <?php if (!empty($this->session()->get('ticket')['user_id'])): ?>
                            <?= $ticket_contact_account ?>
                        <?php else: ?>
                            <?= str_replace(substr($ticket_contact_account, 3, 6), '******', $ticket_contact_account); ?>
                        <?php endif; ?>
                    </div>

                    <div class="am-u-sm-12 am-u-lg-3">
                        <?php if (!empty($this->session()->get('ticket')['user_id']) && !empty($member) && GROUP == 'Ticket'): ?>
                        <span class="pt-text-explode">客户信息 :
                            <div class="am-dropdown ticket-member-table-dropdown am-dropdown-flip" data-am-dropdown>
                                <a href="javascript:;" class=" am-dropdown-toggle" data-am-dropdown-toggle><?= $member['member_name'] ?> <span class="am-icon-caret-down"></span></a>
                                <ul class="am-dropdown-content">
                                    <li class="am-dropdown-header">客户详细信息</li>
                                    <li class="am-scrollable-horizontal ticket-member-table">
                                        <?php if (!empty($memberField)): ?>
                                            <table class="am-table am-table-bordered am-table-striped am-table-hover am-text-xs am-text-nowrap">
                                            <tr>
                                                <?php foreach ($memberField as $value) : ?>
                                                    <?php if ($value['field_name'] == 'status'): ?>
                                                        <?php $class = 'table-set'; ?>
                                                    <?php else: ?>
                                                        <?php $class = 'table-title'; ?>
                                                    <?php endif; ?>
                                                    <th class="<?= $class ?>"><?= $value['field_display_name']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <?php foreach ($memberField as $fv) : ?>
                                                    <td class="am-text-middle">
                                                        <?= $label->valueTheme($fv, 'member_', $member); ?>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        </table>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>

                        <?php endif; ?>
                    </div>
                    <div class="am-u-sm-12 am-u-lg-3">
                        <?php if (GROUP == 'Form' && $ticket_status < 3 && $ticket_close == 0): ?>
                            <a href="<?= $label->url('Ticket-status', ['number' => $ticket_number, 'back_url' => base64_encode($_SERVER['REQUEST_URI']), 'method' => 'PUT']) ?>"
                               class="am-text-warning ajax-click ajax-dialog" msg="您确定要结束本工单吗?">[<i class="am-icon-check"></i>
                                结束工单]</a>
                        <?php elseif (GROUP == 'Form' && $ticket_status == 3 && $ticket_close == 0 && $ticket_complete_time >= time() - 86400 * $ticket_model_recovery_day): ?>
                            <a href="<?= $label->url('Ticket-status', ['number' => $ticket_number, 'back_url' => base64_encode($_SERVER['REQUEST_URI']), 'method' => 'PUT']) ?>"
                               class="am-text-success ajax-click ajax-dialog" msg="您可以恢复<?= $ticket_model_recovery_day ?? 7 ?>天内由已结束的工单。">[<i class="am-icon-refresh"></i>
                                恢复工单]</a>
                        <?php endif; ?>

                        <?php if ($label->checkAuth('TicketPUTTicketcomplete') === true && GROUP == 'Ticket' && $ticket_status == 3): ?>
                            <form action="<?= $label->url('Ticket-Ticket-reply'); ?>" class="am-form ajax-submit" method="POST" data-am-validator>
                                <a name="handleTicket"></a>
                                <input type="hidden" name="number" value="<?= $ticket_number; ?>"/>
                                <input type="hidden" name="back_url" value="<?= $label->xss($_GET['back_url']); ?>"/>
                                <input type="hidden" name="assign" value="5">
                                <?= $label->token() ?>
                                <button type="submit" class="am-btn am-btn-xs am-btn-warning" onclick="return confirm('确认要恢复本工单状态吗？')">
                                    <i class="am-icon-refresh"></i> 恢复工单
                                </button>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php if (!empty(self::session()->get('ticket')) && GROUP == 'Ticket'): ?>
                <hr/>
                <div class="am-padding-left"><span class="pt-text-explode">备注说明 : </span>
                    <input type="text" class="ticket-remark-input" maxlength="22" old="<?= $label->xss($ticket_remark) ?>" value="<?= $label->xss($ticket_remark) ?>" placeholder="若需要在列表标记说明，请在此处填写一句话，限22个字">
                </div>

                <?php if ($ticket_close == 1): ?>
                    <div class="am-padding-left am-margin-top">
                        <span class="pt-text-explode">工单关闭理由：</span>
                        <?= $ticket_close_reason ?>
                        <span class="pt-text-explode"><?= !empty($ticket_close_time) ? '[关闭于 ' . date('Y-m-d H:s', $ticket_close_time) . ']' : '' ?></span>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <hr/>
            <ul class="am-list am-list-static am-text-sm am-list-hover pes-ticket-content">
                <li class="am-text-gray-background">
                    <div class="am-g">
                        <div class="am-u-sm-2 am-u-lg-1">
                            <i class="am-icon-btn am-primary am-icon-user"></i>
                        </div>
                        <div class="am-u-sm-10 am-u-lg-11">
                            <div class="am-block">
                                <?php foreach ($form as $key => $value): ?>
                                    <?php if ($value['ticket_form_bind'] == '0'): ?>

                                        <div class="pt-text-border">
                                            <div class="pt-text-explode"><?= $value['ticket_form_description']; ?>:
                                            </div>
                                            <div><?= strlen($value['ticket_value']) == 0 ? '<del class="am-text-gray am-text-xs">(此选项值为空)</del>' : $value['ticket_value']; ?></div>
                                        </div>

                                    <?php else: ?>
                                        <?php if (in_array($form[$value['ticket_form_bind']]['ticket_form_content'], $value['ticket_form_bind_value'])): ?>

                                            <div class="pt-text-border">
                                                <div class="pt-text-explode"><?= $value['ticket_form_description']; ?>
                                                    :
                                                </div>
                                                <div><?= $value['ticket_value']; ?></div>
                                            </div>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

        </div>

    </div>
</div>

<div class="am-panel am-panel-default ticket-chat">
    <div class="am-panel-bd">
        <h3 class="am-margin-0">沟通记录</h3>
    </div>
    <ul class="am-list am-list-static am-text-sm am-list-hover pes-chat" data="<?= $pageObj->totalRow ?>">

        <?php require_once __DIR__ . '/Ticket_chat_list.php'?>
        <li class="replyRefresh" data="<?= $pageObj->totalRow ?>" style="display: none">
            <a href="#reply" onClick="window.location.reload()" class="am-padding-0">
                <div class="am-alert am-alert-warning am-margin-0 am-text-center">
                    有新回复
                </div>
            </a>
        </li>
    </ul>
</div>

<form action="<?= $label->url('Ticket-Ticket-tips') ?>" class="am-form ajax-submit" id="append-tips" method="POST" STYLE="display: none">
    <input type="hidden" name="method" value="POST">
    <input type="hidden" name="id" value="<?= $ticket_id ?>">
    <input type="hidden" name="cid" value="">
    <div class="am-form-group">
        <label>提醒内容</label>
        <textarea class="" rows="5" name="content"></textarea>
    </div>

    <div class="am-form-group">
        <label class="am-radio-inline">
            <input type="radio" name="type" value="0"> 全局
        </label>
        <label class="am-radio-inline">
            <input type="radio" name="type" value="1"> 仅自己
        </label>
    </div>

    <div>
        <button type="submit" class="am-btn am-btn-xs am-btn-primary">提交</button>
    </div>

</form>

<?php if ($pageObj->totalRow >= $pageObj->listRows): ?>
    <ul class="am-pagination am-pagination-centered am-text-sm">
        <?= $page; ?>
    </ul>
<?php endif; ?>
<script>
    $(function () {
        var siteTitle = $('title').html()
        setInterval(function () {
            $.get('<?= $label->url(GROUP . '-' . MODULE . '-' . ACTION, ['number' => $ticket_number, 'replyRefresh' => 'checked']) ?>', function (data) {
                var replyRefresh = parseInt($('.replyRefresh').attr('data'))
                var newReply = parseInt(data)
                if (newReply > replyRefresh) {
                    $('.replyRefresh').show();
                    $('title').html('[有新回复]' + siteTitle)
                }
            })
        }, 60000)

        $('.pes-ticket-content img, .pes-chat img').each(function () {
            var dom = $(this)
            var parent = $(this).parent();
            if (parent[0].tagName != 'a') {
                var imgStr = '<a href="' + dom.attr('src') + '" data-fancybox="gallery" class="am-inline-block view-pic">' + $(this).prop('outerHTML') + '</a>';
                $(this).prop('outerHTML', imgStr)
            }
        })

        $(document).on('click', '.add-chat-tips', function () {

            var cid = $(this).attr('cid')
            $('#append-tips').find('input[name="cid"]').val(cid)

            var d = dialog({
                id: 'tips-from',
                content: $('#append-tips'),
                quickClose: true
            })
            d.show($(this)[0]);
        })

    })

</script>



