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
                    <?php foreach(array_merge(['最近反馈'], array_column($ticketStatus, 'name'), ['所有工单']) as $key => $name): ?>
                    <a href="<?= $label->url('Ticket-'.MODULE.'-'.ACTION, ['q' => $key]) ?>" class="am-btn am-btn-default am-btn-xs am-fl <?= $_GET['q'] == $key && empty($_GET['search']) ? 'am-disabled' : '' ?>"><?= $name ?></a>
                    <?php endforeach; ?>
                    <a href="javascript:;" class="am-btn am-btn-primary show-search-form am-btn-xs am-fl" data="<?= !empty($_GET['search']) ? '0' : '1' ?>" ><i class="am-icon-search"></i> 工单搜索</a>
                </div>

                <div class="am-u-sm-12 am-u-md-12 ticket-search-form am-margin-top " style="display: none">
                    <?php require_once __DIR__.'/Ticket_index_search_form.php'?>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <?php if (empty($list)): ?>
                <div class="pes-alert pes-alert-info am-margin-top am-margin-bottom am-text-center" >
                    <p class="am-margin-0">本页面没有数据 :-(</p>
                </div>
            <?php else: ?>
                <?= $label->token() ?>
                <?php require_once __DIR__.'/Ticket_index_table.php'?>
                <ul class="am-pagination am-pagination-right am-text-sm">
                    <?= $page; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(function () {

        var checkSearchStatus = function (){
            var dom = $('.show-search-form');
            var data = dom.attr('data');
            if(data == '1'){
                dom.html('<i class="am-icon-search"></i> 工单搜索');
                dom.attr('data', '0')
                $('.ticket-search-form').fadeOut('800')
            }else{
                dom.html('<i class="am-icon-compress"></i> 收起搜索');
                dom.attr('data', '1')
                $('.ticket-search-form').fadeIn('800');
            }
        }

        checkSearchStatus();

        $('.show-search-form').on('click', function () {
            checkSearchStatus();
        })
    })
</script>