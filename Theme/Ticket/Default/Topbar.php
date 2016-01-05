<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="#">PESCMS Ticket</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#doc-topbar-collapse'}">
        <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav">
            <?php foreach ($menu as $topValue): ?>
                <?php if (!empty($topValue['menu_child'])): ?>
                    <li class="am-dropdown" data-am-dropdown>
                        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                            <i class="<?= $topValue['menu_icon'] ?>"></i> <?= $topValue['menu_name'] ?> <span class="am-icon-caret-down"></span>
                        </a>
                        <ul class="am-dropdown-content">
                            <?php foreach ($topValue['menu_child'] as $value): ?>
                                <li><a href="<?= $value['menu_type'] == '0' ? $label->url($value['menu_link']) : $value['menu_link']; ?>"><i class="<?= $value['menu_icon'] ?>"></i> <?= $value['menu_name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="<?= $topValue['menu_type'] == '0' ? $label->url($topValue['menu_link']) : $topValue['menu_link'] ?>"> <i class="<?= $topValue['menu_icon'] ?>"></i> <?= $topValue['menu_name'] ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>

        <div class="am-topbar-right">
            <ul class="am-nav am-nav-pills am-topbar-nav admin-header-list">
                <li class=""><a href="javascript:;">您好,<?= $_SESSION['ticket']['user_name']; ?></a></li>
            </ul>
            <a href="<?= $label->url('Ticket-Login-logout'); ?>" class="am-btn am-btn-primary am-topbar-btn am-btn-sm">注销</a>
        </div>
    </div>
</header>