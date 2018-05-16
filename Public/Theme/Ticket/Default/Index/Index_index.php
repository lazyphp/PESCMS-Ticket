<div class="am-g ">
    <div class="am-u-sm-12">
        <table class="am-table am-table-bordered am-table-centered">
            <tr>
                <th></th>
                <th>新工单</th>
                <th>处理数</th>
                <th>完成数</th>
                <th>执行率</th>
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
        <div class="am-u-sm-4 am-text-center">
            <div class="am-panel <?= $kye; ?>">
                <div class="am-panel-hd"><?= $ticket['title']; ?></div>
                <div class="am-panel-bd">
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
        </div>
    <?php endforeach; ?>
</div>