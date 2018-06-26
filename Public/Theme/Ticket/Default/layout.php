<?php include 'header.php'; ?>
<?php include 'Topbar.php'; ?>
<div id="wrapper" class="am-text-sm">
    <?php include $file; ?>
</div>
<footer class="my-footer pescms-footer-<?= $system['notice_way'] ?>">
    <small>© Copyright 2015-<?= date('Y') ?>. Power by <a href="//www.pescms.com" target="_blank">PESCMS Ticket</a>
    </small>
</footer>
<?php include 'footer.php'; ?>
