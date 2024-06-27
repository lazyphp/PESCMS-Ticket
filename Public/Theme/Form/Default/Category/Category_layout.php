<?php if (empty($_GET['new_index'])): ?>
    <?php include THEME_PATH . '/header.php'; ?>
    <?php include THEME_PATH . '/Topbar.php'; ?>
<?php endif; ?>
<div id="wrapper" class="am-text-sm">
    <div class="am-g">
        <div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">

            <?php if (ACTION == 'index'): ?>
                <div class="index-search">
                    <form action="<?= $label->url('View-ticket') ?>" class="am-margin-bottom" method="GET" data-am-validator>
                        <input type="hidden" name="m" value="View"/>
                        <input type="hidden" name="a" value="ticket">

                        <input type="text" name="number" class="am-form-field " required placeholder="查找工单或常见问题">
                        <button class="am-btn am-btn-default pes-search-button am-radius" type="submit">
                            <i class="am-icon-search"></i>
                            搜索
                        </button>
                    </form>
                </div>

            <?php endif; ?>

            <div class="am-panel am-panel-default">
                <div class="am-panel-bd">
                    <ol class="am-breadcrumb am-text-default am-margin-bottom-0 categort-breadcrumb">
                        <li class="am-active">
                            <a href="<?= $label->url('Category-index') ?>"><span class="am-badge am-badge-primary am-round am-text-default">1</span>
                                选择问题类型</a>
                        </li>
                        <li class="<?= empty($category) ? 'am-active' : '' ?>">
                            <a href="<?= empty($_GET['back_url']) ? 'javascript:;' : base64_decode($_GET['back_url']) ?>"><span class="am-badge am-badge-primary am-round am-text-default">2</span>
                                选择对应工单</a>
                        </li>
                        <li class="<?= ACTION != 'index' ? 'am-active' : '' ?>">
                            <a href="javascript:;"><span class="am-badge am-badge-primary am-round am-text-default">3</span>
                                创建工单</a>
                        </li>
                    </ol>
                    <?php include $file; ?>
                </div>
            </div>

            <?php require 'Ticket_fqa.php' ?>

        </div>
    </div>
</div>
<?php if (empty($_GET['new_index'])): ?>
    <?php include THEME_PATH . '/footer.php'; ?>
<?php endif; ?>
