<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div class="am-alert am-alert-secondary" data-am-alert>
                尝试连接PESCMS官方自动更新程序失败...
            </div>

            <hr/>
            <form action="<?= $label->url(GROUP . '-Setting-mtUpgrade') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="method" value="PUT">

                <div class="am-form-group am-form-file">
                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                        <i class="am-icon-cloud-upload"></i> 导入zip升级包
                    </button>
                    <input id="doc-form-file" type="file" name="zip" multiple>
                </div>
                <div id="file-list"></div>
                <script>
                    $(function () {
                        $('#doc-form-file').on('change', function () {
                            var fileNames = '';
                            $.each(this.files, function () {
                                fileNames += '<span class="am-badge">' + this.name + '</span> ';
                            });
                            $('#file-list').html(fileNames);
                        });
                    });
                </script>
                <button type="submit" id="btn-submit" class="am-btn am-btn-default am-btn-xs">
                    安装更新
                </button>
            </form>
        </div>
    </div>
</div>