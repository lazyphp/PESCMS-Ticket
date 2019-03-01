<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="/">PESCMS Ticket</a>
    </h1>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#ticket-topbar-collapse'}">
        <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse am-topbar-right am-text-sm" id="ticket-topbar-collapse">
        <ul class="am-nav am-nav-pills am-topbar-nav admin-header-list">
            <?php if ((MODULE != 'Index' || ACTION != 'index') && $system['interior_ticket'] == 1 ): ?>
                <li>
                    <a href="<?= $label->url('Category-index') ?>"><i class="am-icon-yelp"></i> 提交工单</a>
                </li>
            <?php endif; ?>

            <?php if (empty($this->session()->get('member'))): ?>
                <?php if($system['open_register'] == 1): ?>
                <li>
                    <a href="<?= $label->url('Login-index') ?>"><i class="am-icon-sign-in"></i> 登录</a>
                </li>
                <li>
                    <a href="<?= $label->url('Login-signup') ?>"><i class="am-icon-user-plus"></i> 注册</a>
                </li>
                <?php endif; ?>
            <?php else: ?>
                <li>
                    <a href="<?= $label->url('Member-index') ?>"><i class="am-icon-fire"></i> 我的工单</a>
                </li>
                <li>
                    <a href="<?= $label->url('Member-update') ?>"><i class="am-icon-user"></i> 个人信息</a>
                </li>
                <li>
                    <a href="<?= $label->url('Login-logout'); ?>"><i class="am-icon-sign-out"></i> 退出登录</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>

</header>