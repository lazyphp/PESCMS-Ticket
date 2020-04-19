<div class="am-g">
    <div class="am-u-sm-12 am-u-sm-centered">

        <?php if(!empty($statistics)): ?>
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd am-text-center">
                <div class="am-g">
                    <?php foreach ($statistics as $key => $value): ?>
                        <div class="am-u-sm-3">
                            <a href="<?= $label->url(MODULE.'-index', ['status' => $value['ticket_status']]) ?>">
                                <div class="am-text-xxxl"><?= $value['total'] ?></div>
                                <div><?= $ticketStatus[$value['ticket_status']]['name']; ?></div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="am-g am-margin-bottom am-g-collapse">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-sm">
                        <a href="<?= $label->url(MODULE.'-index') ?>" class="am-btn am-btn-white <?= empty($_GET['dataType']) && empty($_GET['close'])  ? 'am-disabled' : '' ?>">全部</a>
                        <?php foreach (['1' => '今天', '-1' => '昨天', '-7' => '本周'] as $key => $value): ?>
                            <a href="<?= $label->url(MODULE.'-index', ['dataType' => $key, 'keyword' => $keyword]) ?>" class="am-btn am-btn-white <?= $_GET['dataType'] == $key ? 'am-disabled' : '' ?>"><?= $value ?></a>
                        <?php endforeach; ?>
                        <a href="<?= $label->url(MODULE.'-index', ['close' => 1, 'keyword' => $keyword]) ?>" class="am-btn am-btn-white <?= $_GET['close'] == 1 ? 'am-disabled' : '' ?>">已关闭: <?=$close?></a>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-4">
                <form>
                    <div class="am-input-group am-input-group-sm">
                        <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                        <input type="hidden" name="m" value="<?= MODULE ?>"/>
                        <input type="hidden" name="a" value="<?= ACTION ?>"/>
                        <input type="text" name="keyword" placeholder="请输入工单编号或者工单内容" value="<?= $keyword ?>" class="am-form-field">
                        <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="submit"><span class="am-icon-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="am-panel am-panel-default">
            <table class="am-table">
                <tr>
                    <th class="am-show-lg-only">工单编号</th>
                    <th class="am-show-lg-only">相关产品</th>
                    <th>问题内容</th>
                    <th class="am-show-lg-only">状态</th>
                    <th class="am-show-lg-only">提交时间</th>
                    <th class="am-show-lg-only">操作</th>
                </tr>
                <?php if(empty($list)): ?>
                    <tr>
                        <td colspan="6" class="am-text-center">当前没有工单提交记录</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($list as $key => $value): ?>
                        <tr>
                            <td class="am-show-lg-only">
                                <?= $value['ticket_number'] ?>
                            </td>
                            <td class="am-show-lg-only"><?= "{$category[$value['ticket_model_cid']]['category_name']} - {$value['ticket_model_name']}" ?>	</td>
                            <td>
                                <a href="<?= $label->url('View-ticket', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>"><?= $value['ticket_title'] ?></a>
                            </td>
                            <td class="am-show-lg-only" style="color: <?= $value['ticket_close'] == 1 ? '#000' :$ticketStatus[$value['ticket_status']]['color']; ?>">
                                <?= $value['ticket_status'] == 3 && $value['ticket_score_time'] == 0 ? '待评价' : ($value['ticket_close'] == 1 ? '已关闭' : $ticketStatus[$value['ticket_status']]['name']); ?>
                            </td>
                            <td class="am-show-lg-only"><?= date('Y-m-d H:i', $value['ticket_submit_time']) ?></td>
                            <td class="am-show-lg-only">

                                <a class="am-link-muted print-ticket" href="<?= $label->url('View-printer', array('number' => $value["ticket_number"])); ?>"><span class="am-icon-print"></span></a>

                                <a href="<?= $label->url('View-ticket', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>">查看详情</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
        <ul class="am-pagination am-pagination-right am-text-sm">
            <?= $page; ?>
        </ul>
    </div>
</div>
