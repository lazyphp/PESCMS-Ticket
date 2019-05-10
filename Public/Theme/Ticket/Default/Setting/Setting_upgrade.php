<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">

    <div class="am-cf">
        <div class="am-fl am-cf">
            <?php if (!empty($_GET['back_url'])): ?>
                <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i class="am-icon-reply"></i>返回</a>
            <?php endif; ?>
            <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
        </div>
    </div>
    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

    <div class="am-alert am-alert-secondary" id="patch" data-am-alert>
        正在与PESCMS官网进行通讯，获取更新中……
    </div>
    <article class="am-article am-hide"></article>

            <hr/>
            <a href="<?= $label->url(GROUP . '-Setting-atUpgrade', ['method' => 'PUT']) ?>" class="am-btn am-radius am-btn-success am-btn-xs">执行自动更新</a>
            <hr/>
            <div class="am-alert am-alert-secondary"  data-am-alert>
                当自动更新多次失败时，您可以尝试将补丁下载到本地，执行手动升级。
            </div>
            <form action="<?= $label->url(GROUP . '-Setting-mtUpgrade') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="method" value="PUT">

                <div class="am-form-group am-form-file am-margin-bottom-0">
                    <button type="button" class="am-btn am-radius am-btn-danger am-btn-xs">
                        <i class="am-icon-cloud-upload"></i> 导入zip升级包
                    </button>
                    <input id="doc-form-file" type="file" name="zip" accept="application/zip">
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
                <button type="submit" id="btn-submit" class="am-btn am-radius am-btn-default am-btn-xs am-margin-top-sm">
                    手动安装更新
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){

        $.getJSON(PESCMS_URL+'/patch/5/<?= $system['version'] ?>', function(data){
            if(data.status == 200){
                var update_patch_file = data.data.update_patch_file ? ' <a class="am-btn am-radius am-btn-primary am-radius am-btn-xs" href="' + PESCMS_URL + data.data.update_patch_file + '" >下载更新</a>' : '';
                $('#patch').html('有新版本发布: '+data.data.new_version + update_patch_file);
                $('.am-article').html('<h3>更新内容:</h3>'+data.data.update_content).removeClass('am-hide')
            }else{
                $('#patch').html(data.msg)
            }
        }).fail(function(){
            $('#patch').html('与PESCMS官网无法取得链接，请检查您的网络是否正常。');
        })
    })
</script>