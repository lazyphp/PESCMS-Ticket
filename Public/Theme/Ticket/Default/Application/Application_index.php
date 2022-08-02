<div class=" am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl">
                    <ol class="am-breadcrumb am-breadcrumb-slash am-margin-0 am-padding-0">
                        <li>
                            <strong class="am-text-default am-text-lg"><a href="<?= $label->url(GROUP . '-' . MODULE . '-index'); ?>"><?= $title ?></a>
                            </strong>
                        </li>
                        <li>
                            <strong class="am-text-primary am-text-lg"><a class="am-link-muted" href="<?= $label->url(GROUP . '-' . MODULE . '-local'); ?>">本地应用</a>
                            </strong>
                        </li>
                    </ol>
                </div>
                <div class="am-fr">
                    <a href="javascript:;" class="am-btn am-btn-secondary am-btn-xs pes-login">登录</a>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
            <div class="am-alert am-alert-postscript"><i class="am-icon-lightbulb-o"></i>
                应用插件安装完毕后，请点击上面的<strong class="am-text-danger">[本地应用]</strong>打开本地应用列表进行启用。
            </div>
            <div id="app-list" project="5" version="<?= $system['version'] ?>" entrance="Application">
                正在连接PESCMS应用商店...
            </div>
        </div>
    </div>
</div>
<div class="pes-installed am-hide"><?= empty($installed) ? json_encode([]) : $installed ?></div>

<?php if (!empty($_GET['open'])): ?>
    <a class="app-detail open-app" href="<?= $label->xss(base64_decode($_GET['open'])) ?>" style="display: none"></a>
<?php endif; ?>

<script src="<?= PESCMS_URL ?>/Theme/Api/App/1.1/pescms_app.min.js?mt=<?= time() ?>"></script>
<script>
    $(function () {
        $('body').on('click', '.pes-plugin-install', function () {
            var name = $(this).attr('data')
            var enname = $(this).attr('enname')
            var appkey = $('input[name=appkey]').val();
            $.ajaxsubmit({
                url: '<?= $label->url(GROUP . '-Application-install', ['method' => 'GET']) ?>',
                data: {name: name, enname: enname, appkey: appkey}
            }, function () {

            })
        })

        if($('.open-app').length > 0){
            setTimeout(function () {
                $('.open-app').trigger('click')
            }, 200)
        }


    })
</script>
