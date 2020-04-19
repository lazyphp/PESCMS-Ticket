<?php include 'header.php'; ?>
<?php include 'Topbar.php'; ?>
<div id="wrapper" class="am-text-sm <?= MODULE =='Index' && ACTION == 'index' ? 'index-background' : '' ?>">
    <?php include $file; ?>
</div>
<?php include 'footer.php'; ?>
