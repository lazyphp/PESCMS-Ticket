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
                    <?php foreach (array_merge(['最近反馈'], array_column($ticketStatus, 'name'), ['所有工单', '已关闭']) as $key => $name): ?>
                        <a href="<?= $label->url('Ticket-' . MODULE . '-' . ACTION, ['q' => $key]) ?>" class="am-btn am-btn-default am-btn-xs am-fl <?= (isset($_GET['q']) && $_GET['q'] == $key && empty($_GET['search'])) || (empty($_GET['q']) && $key == 0 && empty($_GET['search'])) ? 'am-disabled' : '' ?>"><?= $name ?></a>
                    <?php endforeach; ?>

                    <a href="javascript:;" class="am-btn am-btn-primary show-search-form am-btn-xs am-fl" data="<?= !empty($_GET['search']) || $this->session()->get('ticket')['user_open_search'] == 1  ? '0' : '1' ?>"><i class="am-icon-search"></i>
                        工单搜索</a>
                    <a href="<?= $label->url('Ticket-' . MODULE . '-' . ACTION, ['q' => (int)($_GET['q'] ?? ''), 'csv' => '1']) ?>" class="am-btn am-btn-success am-btn-xs am-fl pes-quick-csv" <?= !empty($_GET['search']) ? 'style="display:none"' : '' ?>><i class="am-icon-upload"></i>
                        导出CSV</a>

                    <?= (new \Core\Plugin\Plugin())->event('filterTool', NULL); ?>

                </div>

                <div class="am-u-sm-12 am-u-md-12 ticket-search-form am-margin-top " style="display: none" >
                    <?php require_once __DIR__ . '/Ticket_index_search_form.php' ?>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <?php if (empty($list)): ?>
                <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center">
                    <p class="am-margin-0">本页面没有数据 :-(</p>
                </div>
            <?php else: ?>
                <?= $label->token() ?>
                <?php require_once __DIR__ . '/Ticket_index_table.php' ?>
                <ul class="am-pagination am-pagination-right am-text-sm">
                    <?= $page; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(function () {

        var checkSearchStatus = function () {
            var dom = $('.show-search-form');
            var data = dom.attr('data');
            if (data == '1') {
                dom.html('<i class="am-icon-search"></i> 工单搜索');
                dom.attr('data', '0')
                $('.ticket-search-form').hide()
            } else {
                dom.html('<i class="am-icon-compress"></i> 收起搜索');
                dom.attr('data', '1')
                $('.ticket-search-form').show()
            }
        }

        checkSearchStatus();

        $('.show-search-form').on('click', function () {
            checkSearchStatus();
        })

    })
</script>