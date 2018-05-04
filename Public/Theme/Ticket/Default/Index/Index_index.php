<div class="am-g ">
    <div class="am-u-sm-12">
        <table class="am-table am-table-bordered am-table-striped am-table-hover am-table-compact am-table-centered">
            <tr>
                <th class="am-danger"></th>
                <th class="am-danger">新工单</th>
                <th class="am-danger">处理数</th>
                <th class="am-danger">完成数</th>
                <th class="am-danger">执行率</th>
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
<div class="am-g ">
    <?php foreach ($list as $kye => $ticket): ?>
        <div class="am-u-sm-4">
            <div class="am-panel <?= $kye; ?>">
                <div class="am-panel-hd"><?= $ticket['title']; ?></div>
                <ul class="am-list">
                    <?php if (empty($ticket['list'])): ?>
                        <li>暂时没有符合该类型的工单</li>
                    <?php else: ?>

                        <?php foreach ($ticket['list'] as $value): ?>
                            <li class="">
                                <a href="<?= $label->url(GROUP . '-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" title="<?= $value['ticket_title']; ?>" class="am-text-truncate">
                                    <span class="am-badge am-margin-right-xs" style="background-color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></span><?= $value['ticket_title']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>