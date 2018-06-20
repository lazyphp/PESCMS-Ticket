<div class="am-g">
    <div class="am-u-sm-12 am-u-sm-centered">
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd am-text-center">
                <div class="am-g">
                    <?php foreach ([1, 2, 3] as $key => $value): ?>
                        <div class="am-u-sm-4">
                            <a href="">
                                <div class="am-text-xxxl">0</div>
                                <div>待处理</div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="am-g am-margin-bottom am-g-collapse">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-sm">
                        <?php foreach ([1, 2, 3, 4] as $key => $value): ?>
                            <a href="" class="am-btn am-btn-white">今天</a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-3">
                <form>
                    <div class="am-input-group am-input-group-sm">
                        <input type="hidden" name="g" value="<?= GROUP; ?>"/>
                        <input type="hidden" name="m" value="<?= MODULE ?>"/>
                        <input type="hidden" name="a" value="<?= ACTION ?>"/>
                        <input type="text" name="keyword" value="<?= $_GET['keyword'] ?>" class="am-form-field">
                        <span class="am-input-group-btn">
                        <input class="am-btn am-btn-default" type="submit" value="搜索"/>
                    </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="am-panel am-panel-default">
            <table class="am-table">
                <tr>
                    <th>工单编号</th>
                    <th>相关产品</th>
                    <th>问题内容</th>
                    <th>状态</th>
                    <th>提交时间</th>
                    <th>操作</th>
                </tr>
                <?php foreach($list as $key => $value): ?>
                    <tr>
                        <td><?= $value['ticket_number'] ?></td>
                        <td><?= $value['ticket_model_name'] ?>	</td>
                        <td><?= $value['ticket_title'] ?></td>
                        <td style="color: <?= $ticketStatus[$value['ticket_status']]['color']; ?>"><?= $ticketStatus[$value['ticket_status']]['name']; ?></td>
                        <td><?= date('Y-m-d H:i', $value['ticket_submit_time']) ?></td>
                        <td>
                            <a href="<?= $label->url('View-ticket', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>">查看详情</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
