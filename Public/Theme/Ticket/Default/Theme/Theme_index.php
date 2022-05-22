<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default" id="setting-panel">
        <div class="am-panel-bd am-padding-bottom-0">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <ol class="am-breadcrumb am-breadcrumb-slash am-margin-0 am-padding-0">
                        <li>
                            <strong class="am-text-default am-text-lg"><a class="am-link-muted" href="<?= $label->url(GROUP .'-' . MODULE . '-index'); ?>"><?= $title ?></a>
                            </strong>
                        </li>
                        <li>
                            <strong class="am-text-primary am-text-lg"><a  href="<?= $label->url(GROUP .'-' . MODULE . '-shop'); ?>">主题商店</a>
                            </strong>
                        </li>
                    </ol>
                </div>

                <div class="am-fr">
                    <a href="javascript:;" class="am-btn am-btn-secondary am-btn-xs pes-login">登录</a>
                </div>

            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
        </div>
        <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-default">
            <?php foreach($list as $patchName => $item): ?>
                <li>
                    <div class="am-gallery-item am-text-center">
                        <a href="<?= DOCUMENT_ROOT ?>/Theme/Form/<?= $patchName ?>/<?= $item['img'] ?>" data-fancybox="gallery">
                            <img src="<?= DOCUMENT_ROOT ?>/Theme/Form/<?= $patchName ?>/<?= $item['img'] ?>" class="am-img-thumbnail"  alt=""/>
                        </a>
                        <div class="am-gallery-desc am-margin-top">
                            <div class="am-g">
                                <p class="am-margin-xs">名称：<?= $item['name'] ?></p>
                                <p class="am-margin-xs">作者：<?= $item['author'] ?></p>
                                <p class="am-margin-xs">版本：<?= $item['version'] ?></p>
                                <p class="am-margin-xs">官网：<?= $item['website'] ?></p>
                                <p class="am-margin-xs">简介：<?= $item['content'] ?></p>

                                <a href="<?= $label->url(GROUP.'-Theme-upgrade', ['name' => $item['name'], 'enname' => $item['enname'], 'version' => $item['version'], 'method' => 'GET']) ?>" class="am-badge am-badge-warning am-radius check-update am-margin-vertical am-hide" name="<?= $item['name'] ?>" version="<?= $item['version'] ?>">有可用更新</a>
                            </div>

                            <label class="am-radio-inline">
                                <input type="radio" name="template" value="<?= $patchName ?>" <?= $patchName == $currentTheme ? 'checked="checked"' : '' ?> ><?= $item['name'] ?>
                            </label>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div id="app-list" class=" am-hide" project="5" version="<?= $system['version'] ?>" entrance="ThemeCenter">正在连接PESCMS主题商店...</div>
<div class="pes-installed am-hide"><?= empty($installed) ? json_encode([]) : $installed ?></div>
<script src="<?= PESCMS_URL ?>/Theme/Api/App/1.1/pescms_app.min.js?mt=<?= time() ?>"></script>

<script>
    $(function(){
        $('input[name=template]').on('click', function(){
            if($(this).attr('checked') || confirm('确认切换主题模板吗？') == false ){
                return false;
            }

            var template = $(this).val();
            $.ajaxsubmit({
                url:'<?= $label->url('Ticket-Theme-call') ?>',
                data: {
                    template:template,
                    method:'PUT'
                }
            }, function(){

            });
        })

        $('.check-update').each(function(){
            var dom = $(this)
            var name = dom.attr('name');
            var version = dom.attr('version');
            var href = dom.attr('href');
            $.ajax({
                url: "<?= PESCMS_URL ?>/?g=Api&m=ThemeCenter&a=download",
                data: {
                    project:5,
                    check:1,
                    depend:'<?= $system['version'] ?>',
                    name:name,
                    check_version:version
                },
                type: "POST",
                dataType:'JSON',
                crossDomain: true,
                xhrFields: {
                    withCredentials: true
                },
                success: function (data) {
                    if(data.status == 200){
                        dom.removeClass('am-hide');
                    }
                },
                error:function(obj){
                    dom.attr('class', 'am-badge am-badge-warning am-radius').attr('href', 'javascript:;').html('检查更新失败');
                }
            })

        })

        $('.check-update').on('click', function () {
            if(confirm('请确保已备份本主题，更新过程存在出错的可能') == false){
                return false;
            }
            var url = $(this).attr('href');
            var appkey = $('input[name="appkey"]').val();
            if(appkey == ''){
                alert('获取API数据失败，请刷新页面再试.')
            }

            $.ajaxsubmit({
                url: url,
                data: {appkey:appkey}
            }, function () {
            });

            return false;

        })

    })
</script>