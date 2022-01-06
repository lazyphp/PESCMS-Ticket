<?php
/**
 * 非授权用户请勿删除程序版权信息，若需要删除请购买授权。
 * PESCMS将对非授权的用户，删除版权的用户保留追究法律责任的权利
 * 授权说明: https://www.pescms.com/Page/Authorization.html
 */
?>
<footer class="my-footer pescms-footer-<?= $system['notice_way'] ?>">
    <!--这部分关于PESCMS产品简介的可以自行修改或删除-->
    <?php if(!empty($system['pescmsIntroduce'])): ?>
    <div class="am-g pescms-introduce">
        <?= htmlspecialchars_decode($system['pescmsIntroduce']) ?>
    </div>
    <?php endif; ?>
    <!--这部分关于PESCMS产品简介的可以自行修改或删除-->

    <div class="copyright am-text-center">
        <small>© Copyright 2015-<?= date('Y') ?>. <?= $authorize_type == 0 ? 'Power by <a href="https://www.pescms.com" target="_blank">PESCMS Ticket</a>' : '' ?>
        </small>
    </div>
</footer>
<div class="am-hide">
    <?= $system['siteTongji'] ?>
</div>
<?php $label->footerEvent() ?>

<div class="amz-toolbar" id="amz-toolbar" style="">
    <a href="#top" title="回到顶部" class="am-icon-btn am-icon-arrow-up " id="amz-go-top" data-am-smooth-scroll=""></a>
    <?php if(GROUP == 'Form' && MODULE == 'View' && ACTION == 'ticket' ): ?>
        <a href="javascript:;" title="处理工单" class="pes-handleTicket am-icon-btn am-icon-edit"></a>
    <?php endif; ?>
    <a href="javascript:;" title="关闭浮窗" class="pes-close-amz-toolbar am-icon-btn am-icon-chain-broken"></a>
</div>
</body>
</html>