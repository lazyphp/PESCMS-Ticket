<header class="am-topbar" id="ticket-nav">
    <div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">
        <h1 class="am-topbar-brand">
            <a href="/">PESCMS Ticket</a>
        </h1>

        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
                data-am-collapse="{target: '#ticket-topbar-collapse'}">
            <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse am-topbar-right am-text-sm" id="ticket-topbar-collapse">
            <ul class="am-nav am-nav-pills am-topbar-nav admin-header-list">

                <?php if (empty($this->session()->get('member'))): ?>
                    <li>
                        <a href="<?= $label->url('Login-index') ?>"><i class="am-icon-sign-in"></i> 登录</a>
                    </li>
                    <?php if($system['open_register'] == 1): ?>
                        <li>
                            <a href="<?= $label->url('Login-signup') ?>"><i class="am-icon-user-plus"></i> 注册</a>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li>
                        <a href="<?= $label->url('Member-update') ?>"><?= $this->session()->get('member')['member_name'] ?> 先生/女士, 您好</a>
                    </li>
                    <li>
                        <a href="<?= $label->url('Login-logout'); ?>"><i class="am-icon-sign-out"></i> 退出登录</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

</header>
<header class="am-topbar tool-container">
    <div class="am-u-sm-12 am-u-lg-11 am-u-sm-centered">
        <div class="logo am-fl">
            <a href="/">
                <img src="http://www.pt.com/Theme/assets/i/logo.png">
            </a>
        </div>
        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
                data-am-collapse="{target: '#tool-container-collapse'}">
            <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

        <div class="am-collapse am-topbar-collapse am-topbar-right am-text-sm" id="tool-container-collapse">
            <ul class="am-nav am-nav-pills am-topbar-nav admin-header-list">
                <li>
                    <a href="/">网站首页</a>
                </li>
                <li>
                    <a href="<?= $label->url('Category-index') ?>">提交工单</a>
                </li>
                <li>
                    <a href="<?= $label->url('Fqa-list') ?>">常见问题</a>
                </li>
                <li>
                    <a href="<?= $label->url('Member-index'); ?>">我的工单</a>
                </li>
            </ul>
        </div>
    </div>
</header>

