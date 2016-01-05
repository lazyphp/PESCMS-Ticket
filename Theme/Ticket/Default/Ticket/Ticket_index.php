<div class="admin-content  am-padding am-padding-top-0">
    <div class="am-cf">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">工单列表</strong>
        </div>
    </div>
    <div class="am-g am-margin-bottom-xs am-g-collapse am-margin-top-xs">
        <div class="am-u-sm-12 am-u-md-12">
            <form action="/" class="am-form-inline">
                <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                <input type="hidden" name="m" value="<?= MODULE ?>"/>
                <input type="hidden" name="a" value="<?= ACTION ?>"/>

                <select name="model_id" class="am-form-field" placeholder="所有类型" data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}">
                    <option value="-1">所有类型</option>
                    <?php foreach ($ticketModel as $value): ?>
                        <option value="<?= $value['ticket_model_id']; ?>" <?=$value['ticket_model_id'] == $_GET['model_id'] ? 'selected="selected"' : '' ?> ><?= $value['ticket_model_name']; ?></option>
                    <?php endforeach; ?>
                </select>


                <select name="status" class="am-form-field" placeholder="所有进度" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                    <option value="-1">所有进度</option>
                    <?php foreach ($ticketStatus as $key => $value): ?>
                        <option value="<?= $key; ?>" <?= (string) $key === $_GET['status'] ? 'selected="selected"' : '' ?>><?= $value['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="read" class="am-form-field" placeholder="" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                    <option value="-1">查看状态</option>
                    <option value="0" <?='0' == $_GET['read'] ? 'selected="selected"' : '' ?>>未读</option>
                    <option value="1" <?='1' == $_GET['read'] ? 'selected="selected"' : '' ?>>已读</option>
                </select>

                <select name="close" class="am-form-field" placeholder="" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                    <option value="-1">关闭状态</option>
                    <option value="0" <?='0' == $_GET['close'] ? 'selected="selected"' : '' ?>>正常</option>
                    <option value="1" <?='1' == $_GET['close'] ? 'selected="selected"' : '' ?>>已关闭</option>
                </select>

                <input type="text" name="keyword" value="<?= urldecode($_GET['keyword']) ?>" class=" am-input-lg">

                <button type="submit" class="am-btn am-btn-default am-btn-sm">搜索</button>
            </form>
        </div>
    </div>
    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

    <?php if (empty($list)): ?>
        <div class="am-alert am-alert-secondary am-margin-top am-margin-bottom am-text-center" data-am-alert>
            <p>本页面没有数据 :-(</p>
        </div>
    <?php else: ?>
        <table class="am-table am-table-bordered am-table-striped am-table-hover am-text-sm">
            <tr>
                <th>工单No.</th>
                <th>工单类型</th>
                <th>问题内容</th>
                <th class="am-text-center">状态</th>
                <th class="am-text-center">查看</th>
                <th class="am-text-center">提交时间</th>
                <th class="am-text-center">反馈时长</th>
                <th class="am-text-center">责任人</th>
                <th class="am-text-center">操作</th>
            </tr>
            <?php foreach ($list as $key => $value): ?>
                <tr>
                    <td class="am-text-middle"><?= $value['ticket_number'] ?></td>
                    <td class="am-text-middle">
                        <?= $value['ticket_model_name']; ?>
                    </td>
                    <td class="am-text-middle" title="<?= $value['ticket_title'] ?>"><?= mb_substr($value['ticket_title'], 0 ,25, 'UTF-8'); ?></td>
                    <td class="am-text-center am-text-middle"><span class="am-badge" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></span></td>
                    <td class="am-text-center am-text-middle"><?= $value['ticket_read'] == '0' ? '未' : '已'; ?></td>
                    <td class="am-text-center am-text-middle"><?= date('Y-m-d H:i', $value['ticket_submit_time']); ?></td>
                    <td class="am-text-center am-text-middle"><?= empty($value['ticket_run_time']) ? '未处理' : $label->timing($value['ticket_run_time']); ?></td>
                    <td class="am-text-center am-text-middle">
                        <?= $value['user_id'] > 0 ? $value['user_name'] : '<span class="am-text-danger">无人问津</span>'; ?>
                    </td>
                    <td class="am-text-center am-text-middle">
                        <div class="am-btn-group am-btn-group-xs">
                            <a href="<?= $label->url('Ticket-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-btn am-btn-primary">处理</a>
                            <?php if ($value['ticket_close'] == '0' && $value['ticket_status'] < 3): ?>
                                <a href="<?= $label->url('Ticket-Ticket-close', ['number' => $value['ticket_number'], 'method' => 'POST', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-btn am-btn-danger" onclick="return confirm('确定要关闭本工单吗？')" class="am-btn am-btn-danger">关闭工单</a>
                            <?php else: ?>
                                <a href="javascript:;" class="am-btn am-btn-warning"><?= $value['ticket_status'] == '3' ? '已结束' : '已关闭' ?></a>
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