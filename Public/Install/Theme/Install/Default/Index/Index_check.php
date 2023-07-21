<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">PHP版本:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="https://php.net/downloads.php" class="am-text-<?= $php_version == true ? 'success' : 'danger' ?>" target="_blank">
            <i class=" <?= $php_version == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $php_version == true ? '' : "{$program}必须运行于PHP5.6或更高级的版本，请升级版本！" ?>
        </a>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">PDO 扩展:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="https://php.net/manual/zh/book.pdo.php" class="am-text-<?= $pdo == true ? 'success' : 'danger' ?>" target="_blank">
            <i class=" <?= $pdo == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $pdo == true ? '' : "{$program}依靠pdo_mysql进行链接数据库，否则程序无法安装！" ?>
        </a>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">GD 库:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="https://php.net/manual/zh/book.image.php" class="am-text-<?= $gd == true ? 'success' : 'warning' ?>" target="_blank">
            <i class=" <?= $gd == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $gd == true ? '' : "缺少GD库支持，上图图片和验证码可能存在异常，不影响程序安装。" ?>
        </a>

    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">cURL扩展:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="https://php.net/manual/zh/book.curl.php" class="am-text-<?= $curl == true ? 'success' : 'warning' ?>" target="_blank">
            <i class=" <?= $curl == true ? 'am-icon-check' : 'am-icon-close' ?>"></i> <?= $curl == true ? '' : "缺少cURL库支持，程序在线升级或外部请求功能将失效，不影响程序安装。" ?>
        </a>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-text-right am-text-middle">Public目录指向:</label>
    <div class="am-u-sm-10 am-text-middle">
        <a href="https://document.pescms.com/article/1/262604572827058176.html#nav-2-H2" class="am-text-<?= $public == false ? 'success' : 'warning' ?>" target="_blank">
            <i class=" <?= $public == true ? 'am-icon-warning' : 'am-icon-check' ?>"></i> <?= $public == false ? '' : "系统检测到您没有将程序的运行目录指向到Public，您安装软件后可能会遇到路径错误的问题，请点击本提示获取解决方案。" ?>
        </a>
    </div>
</div>
<?php if($public === true): ?>
<script>
    $(function (){
        var d = dialog({
            fixed: true,
            title: '系统提示',
            content:'<p>系统检测到您没有将程序的运行目录指向到Public，您安装软件后可能会遇到路径错误的问题。详情请阅读：<a href="https://document.pescms.com/article/1/262604572827058176.html#nav-2-H2" target="_blank">《软件安装 - 注意事项》</a></p>' +
                '<p>请根据浏览器地址栏显示的请求地址，来识别是否指向到Public目录。</p>' +
                '<p><strong>正确的请求地址：</strong><span class="am-text-success"><?= $_SERVER['HTTP_HOST'] ?><?= str_replace('Public/', '', $_SERVER['SCRIPT_NAME']) ?> <i class="am-icon-check"></i></span></p>' +
                '<p><strong>当前浏览器显示错误的请求地址：</strong><span class="am-text-danger"><?= $_SERVER['HTTP_HOST'] ?><?= $_SERVER['SCRIPT_NAME'] ?> <i class="am-icon-close"></i></span></p>' +
                '<p>若信息误报，请忽略本提示。</p>',
            okValue: '我知道了',
            ok: function () {

            }
        });
        d.showModal();
    })
</script>
<?php endif; ?>
