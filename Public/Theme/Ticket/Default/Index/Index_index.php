<div class="am-g ">
    <div class="am-u-sm-12">
        <table class="am-table am-table-bordered am-table-centered">
            <tr>
                <th></th>
                <th>全站新工单</th>
                <th>我的处理数</th>
                <th>我的完成数</th>
                <th>我的执行率</th>
            </tr>
            <?php foreach ($count as $date => $dateValue): ?>
                <tr>
                    <td><?= $date; ?></td>
                    <?php foreach ($dateValue as $value): ?>
                        <td><?= $value; ?></td>
                    <?php endforeach; ?>
                    <td><?= $dateValue['new'] + $dateValue['accept'] == 0 ? '0' : round($dateValue['complete']/($dateValue['new'] + $dateValue['accept'] ) * 100 , 2)  ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php if(!empty($list)): ?>
    <div class="am-g ">
        <div class="am-u-sm-12 am-u-lg-8">

            <?php foreach($list as $key => $item): ?>
                <?php if($key == 'am-panel-success'){ continue;}  ?>
                <div class="am-panel am-panel-default">
                    <div class="am-panel-bd am-margin-bottom">
                        <span class="am-fl"><strong><?= $item['title'] ?></strong></span>
                        <a href="<?= $item['url'] ?>" class="am-fr">更多>></a>
                    </div>
                    <table class="am-table am-table-striped am-table-hover am-text-sm ticket-index-table">
                        <?php if(empty($item['list'])): ?>
                            <tr class="am-text-center">
                                <td>当前没有<?= $item['title'] ?>工单!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($item['list'] as $value): ?>
                                <tr>
                                    <td class="am-show-sm-only">
                                        <div class="admin-task-meta">
                                            <span class="am-badge" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></span>
                                            [<?= $value['ticket_model_name'] ?>]
                                            <?= $value['ticket_number'] ?>
                                        </div>
                                        <div class="admin-task-bd">
                                            <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>">
                                                <?= $value['ticket_title'] ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="am-show-lg-only">
                                        <span class="am-badge" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></span>
                                        <?= $value['ticket_number'] ?>
                                    </td>
                                    <td class="am-show-lg-only">
                                        <?= "{$value['ticket_model_name']} - {$value['ticket_title']}" ?>
                                    </td>
                                    <td class="am-show-lg-only">
                                        <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>">处理</a>
                                        <i class="am-margin-left-xs am-margin-right-xs">|</i>
                                        <a href="">删除</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="am-u-sm-12 am-u-lg-4">

            <div class="am-panel am-panel-default">
                <div class="am-panel-hd">
                    <strong>我的平均时间</strong>
                </div>
                <table class="am-table am-table-hover am-text-sm">
                    <?php if(!empty($runTime)): ?>
                        <?php foreach($runTime as $key => $value): ?>
                            <tr>
                                <td class="am-text-right"><?= $key ?> :</td>
                                <td><?= round($value['run_time']/60) ?>分钟</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="am-text-center">
                            <td>您当前还没管辖的工单</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="am-panel am-panel-default">
                <div class="am-panel-hd">
                    <strong>我管辖的工单</strong>
                </div>
                <table class="am-table am-table-hover am-text-sm am-text-center">
                    <?php if(!empty($obligations)): ?>
                        <?php foreach($obligations as $key => $value): ?>
                        <tr>
                            <td><?= $value['ticket_model_name'] ?></td>
                            <td class="am-text-left"><?= $value['total'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="am-text-center">
                            <td>您当前还没管辖的工单</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="am-panel am-panel-default">
                <div class="am-panel-bd am-margin-bottom">
                    <span class="am-fl"><strong><?= $list['am-panel-success']['title'] ?></strong></span>
                    <a href="<?= $list['am-panel-success']['url']  ?>" class="am-fr">更多>></a>
                </div>
                <table class="am-table am-table-striped am-table-hover am-text-sm">
                    <?php if(empty($list['am-panel-success']['list'])): ?>
                        <tr class="am-text-center">
                            <td>当前没有<?= $list['am-panel-success']['title'] ?>工单!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($list['am-panel-success']['list'] as $value): ?>
                            <tr>
                                <td>
                                    <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>"><?= $value['ticket_number'] ?> - <?= $value['ticket_title'] ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
