<?php include 'header.php'; ?>
<?php include 'Topbar.php'; ?>
<div id="wrapper" class="am-text-sm">
    <?php include $file; ?>
</div>
<?php
/**
 * 非授权用户请勿删除程序版权信息，若需要删除请购买授权。
 * 授权说明: https://www.pescms.com/Page/Authorization.html
 */
?>
<footer class="my-footer my-footer-ticket pescms-footer-<?= $system['notice_way'] ?>">
    <small>© Copyright 2015-<?= date('Y') ?>. <?= $authorize_type == 0 ? 'Power by <a href="https://www.pescms.com" target="_blank">PESCMS Ticket</a>' : '' ?>
    </small>
</footer>
<?php include 'footer.php'; ?>
