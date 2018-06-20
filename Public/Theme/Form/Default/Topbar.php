<header class="am-topbar am-padding-bottom-xl">
    <h1 class="am-topbar-brand">
        <a href="/">PESCMS Ticket</a>
    </h1>

    <div class="am-topbar-right am-text-sm">
        <ul class="am-nav am-nav-pills am-topbar-nav admin-header-list">
            <?php if (empty($this->session()->get('member'))): ?>
                <li>
                    <a href="<?= $label->url('Login-index') ?>"><i class="am-icon-sign-in"></i> 登录</a>
                </li>
                <li>
                    <a href="<?= $label->url('Login-signup') ?>"><i class="am-icon-user-plus"></i> 注册</a>
                </li>
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