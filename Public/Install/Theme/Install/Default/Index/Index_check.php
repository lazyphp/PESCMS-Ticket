<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">PHP版本:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="http://php.net/downloads.php" class="am-text-<?= $php_version == true ? 'success' : 'danger' ?>" target="_blank">
            <i class=" <?= $php_version == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $php_version == true ? '' : "{$program}必须运行于PHP5.6或更高级的版本，请升级版本！" ?>
        </a>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">PDO 扩展:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="http://php.net/manual/zh/book.pdo.php" class="am-text-<?= $pdo == true ? 'success' : 'danger' ?>" target="_blank">
            <i class=" <?= $pdo == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $pdo == true ? '' : "{$program}依靠pdo_mysql进行链接数据库，否则程序无法安装！" ?>
        </a>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">GD 库:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="http://php.net/manual/zh/book.image.php" class="am-text-<?= $gd == true ? 'success' : 'warning' ?>" target="_blank">
            <i class=" <?= $gd == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $gd == true ? '' : "缺少GD库支持，上图图片和验证码可能存在异常，不影响程序安装。" ?>
        </a>

    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">cURL扩展:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="http://php.net/manual/zh/book.curl.php" class="am-text-<?= $curl == true ? 'success' : 'warning' ?>" target="_blank">
            <i class=" <?= $curl == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $curl == true ? '' : "缺少cURL库支持，程序在线升级或外部请求功能将失效，不影响程序安装。" ?>
        </a>
    </div>
</div>