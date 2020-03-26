<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title ?></strong>
                </div>
            </div>
            <div class="am-g am-margin-bottom-xs am-g-collapse am-margin-top-xs">
                <div class="am-u-sm-12 am-u-md-12">
                    <form action="/" class="am-form am-form-inline">
                        <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                        <input type="hidden" name="m" value="<?= MODULE ?>"/>
                        <input type="hidden" name="a" value="<?= ACTION ?>"/>

                        <div class="am-margin-bottom-xs">

                            <select name="time_type" class="am-form-field am-input-sm am-radius" data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}">
                                <option value="1">创建时间</option>
                                <option value="2" <?= $label->xss($_GET['time_type']) == 2 ? 'selected="selected"' : '' ?>>完成时间</option>
                            </select>

                            <div class="am-form-group am-form-icon">
                                <i class="am-icon-calendar"></i>
                                <input type="text" class="am-form-field am-input-sm am-radius" name="begin" value="<?= !empty($_GET['begin']) ? $label->xss($_GET['begin']) : '' ?>" readonly data-am-datepicker>
                            </div>

                            <div class="am-form-group am-form-icon">
                                <i class="am-icon-calendar"></i>
                                <input type="text" class="am-form-field am-input-sm am-radius" name="end" value="<?= !empty($_GET['end']) ? $label->xss($_GET['end']) : '' ?>" readonly data-am-datepicker>
                            </div>
                        </div>

                        <div>
                            <select name="model_id" class="am-form-field am-input-sm am-radius" data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}">
                                <option value="-1">所有类型</option>
                                <?php foreach ($ticketModel as $value): ?>
                                    <option value="<?= $value['ticket_model_id']; ?>" <?= $value['ticket_model_id'] == $_GET['model_id'] ? 'selected="selected"' : '' ?> >
                                        <?= $category[$value['ticket_model_cid']]['category_name']; ?> - <?= $value['ticket_model_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>


                            <select name="status" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                                <option value="-1">所有进度</option>
                                <?php foreach ($ticketStatus as $key => $value): ?>
                                    <option value="<?= $key; ?>" <?= (string)$key === $_GET['status'] ? 'selected="selected"' : '' ?>><?= $value['name']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <select name="read" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                                <option value="-1">查看状态</option>
                                <option value="0" <?= '0' == $_GET['read'] ? 'selected="selected"' : '' ?>>未读</option>
                                <option value="1" <?= '1' == $_GET['read'] ? 'selected="selected"' : '' ?>>已读</option>
                            </select>

                            <select name="close" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                                <option value="-1">关闭状态</option>
                                <option value="0" <?= '0' == $_GET['close'] ? 'selected="selected"' : '' ?>>正常</option>
                                <option value="1" <?= '1' == $_GET['close'] ? 'selected="selected"' : '' ?>>已关闭</option>
                            </select>

                            <?php if(!empty($member[$_GET['member']])): ?>
                                <select name="member" class="am-form-field" placeholder=""
                                        data-am-selected="{btnSize: 'sm', dropUp: 0}">
                                    <option value="-1" >不筛选用户</option>
                                    <option value="<?= $_GET['member'] ?>" selected="selected" ><?= $member[$_GET['member']]['member_name'] ?></option>
                                </select>
                            <?php endif; ?>
                            <div class="am-form-group">
                                <input type="text" name="keyword" value="<?= urldecode($_GET['keyword']) ?>" class="am-block am-input-sm pes_input_radius fix-input-width am-radius">
                            </div>

                            <button type="submit" class="am-btn am-btn-default am-btn-sm am-radius">搜索</button>
                        </div>

                    </form>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
            <?php if (empty($list)): ?>
                <div class="am-alert am-alert-secondary am-margin-top am-margin-bottom am-text-center" data-am-alert>
                    <p>本页面没有数据 :-(</p>
                </div>
            <?php else: ?>
                <table class="am-table  am-table-striped am-table-hover am-text-sm">
                    <?php foreach ($list as $key => $value): ?>
                        <tr>
                            <td class="">
                                <div class="admin-task-meta">
                                    <?php if($value['ticket_close'] == 1): ?>
                                        <span class="am-badge">已关闭</span>
                                    <?php elseif($value['ticket_exclusive'] == 1 && $value['user_id'] == self::session()->get('ticket')['user_id']  ): ?>
                                        <span class="am-badge gold-badge">专属工单</span>
                                    <?php endif; ?>
                                    <span class="am-badge" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></span>
                                    [<?= $category[$value['ticket_model_cid']]['category_name'] ?> - <?= $value['ticket_model_name'] ?>]
                                    <?= $value['ticket_number'] ?>
                                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                                    <?php if($value['member_id'] == -1 ): ?>
                                        匿名用户
                                    <?php else: ?>
                                        <a href="<?= $label->url('Ticket-Ticket-'.ACTION, ['member' => $value['member_id']]) ?>"><?= $member[$value['member_id']]['member_name'] ?></a>
                                    <?php endif; ?>

                                    <span>
                                        发布于: <?= date('Y-m-d H:i', $value['ticket_submit_time']); ?>
                                    </span>
                                </div>
                                <div class="admin-task-bd <?= $label->ticketTimeOutTag($value) ?>">
                                    <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>">
                                        <span class="am-text-primary"><?= $value['ticket_read'] == '0' ? '[未读]' : ''; ?></span>
                                        <?= $value['ticket_title'] ?>
                                    </a>
                                </div>
                            </td>
                            <td class="am-show-lg-only am-text-right am-text-bottom ">
                                <?php if(!empty($value['ticket_remark'])): ?>
                                <div class="am-text-warning">
                                    备注: <?= $label->strCut($value['ticket_remark'], '44', '') ?>
                                </div>
                                <?php endif; ?>
                                <div class="admin-task-bd">
                                    <a class="am-link-muted print-ticket" href="<?= $label->url('View-printer', array('number' => $value["ticket_number"])); ?>"><span class="am-icon-print"></span></a>

                                    <span>
                                        耗时: <?= empty($value['ticket_run_time']) ? '未处理' : $label->timing($value['ticket_run_time']); ?>
                                    </span>
                                    <i class="am-margin-left-xs am-margin-right-xs">|</i>
                                    <span>
                                        责任人: <?= $value['user_id'] > 0 ? $value['user_name'] : '<span class="am-text-danger">暂无</span>'; ?>
                                </span>
                                    <i class="am-margin-left-xs am-margin-right-xs">|</i>

                                    <a href="<?= $label->url('Ticket-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"
                                       class="am-text-primary">处理</a>
                                    <i class="am-margin-left-xs am-margin-right-xs">|</i>

                                    <?php if ($value['ticket_close'] == '0' && $value['ticket_status'] < 3): ?>
                                        <a href="<?= $label->url('Ticket-Ticket-close', ['number' => $value['ticket_number'], 'method' => 'POST', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-text-danger ajax-click ajax-dialog" msg="确定要关闭本工单吗？">关闭工单</a>
                                    <?php else: ?>
                                        <a href="javascript:;" class="am-text-warning"><?= $value['ticket_status'] == '3' ? '已结束' : '已关闭' ?></a>

                                    <?php endif; ?>
                                    <?php if($label->checkAuth(GROUP . 'DELETETicketaction') === true): ?>
                                        <i class="am-margin-left-xs am-margin-right-xs">|</i>
                                        <a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！" href="<?= $label->url(GROUP . '-' . MODULE . '-action', array('id' => $value["ticket_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-trash-o"></span></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </table>
                <ul class="am-pagination am-pagination-right am-text-sm">
                    <?= $page; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>