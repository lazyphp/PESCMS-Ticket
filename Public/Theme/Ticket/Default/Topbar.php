<header class="am-topbar am-text-sm">
    <h1 class="am-topbar-brand">
        <a href="<?= $label->url('Ticket-Index-index') ?>">PESCMS Ticket</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#ticket-topbar-collapse'}">
        <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="ticket-topbar-collapse">
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
                <li><a href="javascript:;">您好,<?= $this->session()->get('ticket')['user_name']; ?></a></li>
                <li><a href="<?= $label->url('Ticket-Login-logout'); ?>"><i class="am-icon-sign-out"></i> 退出</a></li>
            </ul>
        </div>
    </div>
</header>