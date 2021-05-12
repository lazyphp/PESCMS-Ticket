<div class=" am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <ol class="am-breadcrumb am-breadcrumb-slash am-margin-0 am-padding-0">
                        <li>
                            <strong class="am-text-default am-text-lg"><a class="am-link-muted" href="<?= $label->url(GROUP .'-' . MODULE . '-index'); ?>">应用商店</a>
                            </strong>
                        </li>
                        <li>
                            <strong class="am-text-primary am-text-lg"><a href="<?= $label->url(GROUP .'-' . MODULE . '-' . ACTION); ?>"><?= $title ?></a>
                            </strong>
                        </li>
                    </ol>
                </div>
                <div class="am-fr">
                    <a href="javascript:;" class="am-btn am-btn-secondary am-btn-xs pes-login">登录</a>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
            <div>
                <div class="pes-alert pes-alert-dark"><i class="am-icon-lightbulb-o"></i> 收费应用插件需要登录PESCMS账号才可以检查更新。</div>
                <table class="am-margin-top am-table am-table-striped am-table-hover am-table-centered">

                    <?php if(empty($list)): ?>
                    <tr>
                        <td>
                            本地暂无安装任何应用。
                        </td>
                    </tr>
                    <?php else: ?>
                        <tr>
                            <th>插件名称</th>
                            <th>版本</th>
                            <th>作者</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach($list as $key => $value): ?>
                        <tr>
                            <td>
                                <?= $value['info']['name']  ?>
                                <span class="am-badge <?= $value['info']['status'] == 'enabled' ? 'am-badge-success' : '' ?> am-radius"><?= $value['info']['status'] == 'enabled' ? '启用中' : '未启用' ?>
                                </span>
                            </td>
                            <td><?= $value['info']['version'] ?></td>
                            <td>
                                <a href="<?= $value['info']['website'] ?>" target="_blank"><?= $value['info']['author'] ?></a>
                            </td>
                            <td><?= $value['info']['content'] ?></td>
                            <td>
                                <?php if($value['info']['status'] == 'enabled'): ?>
                                <a href="<?= $label->url(GROUP.'-Application-Init', ['n' => $value['index'], 'f' => 'disabled']) ?>" class="am-badge am-badge-secondary am-radius ajax-click">禁用</a>
                                <?php else: ?>
                                <a href="<?= $label->url(GROUP.'-Application-Init', ['n' => $value['index'], 'f' => 'enabled']) ?>" class="am-badge am-badge-secondary am-radius ajax-click">启用</a>
                                <?php endif; ?>

                                <?php if($value['info']['option'] == 1): ?>
                                <a href="<?= $label->url(GROUP.'-Application-Init', ['n' => $value['index'], 'f' => 'option']) ?>" class="am-badge am-badge-warning am-radius">配置</a>
                                <?php endif; ?>

                                <a href="<?= $label->url(GROUP.'-Application-upgrade', ['name' => $value['info']['name'], 'version' => $value['info']['version'], 'enname' => $value['info']['enname'], 'method' => 'GET']) ?>" class="am-badge am-badge-warning am-radius ajax-click ajax-dialog check-update am-hide" msg="请确保已备份本插件，更新过程存在出错的可能" name="<?= $value['info']['name'] ?>" version="<?= $value['info']['version'] ?>">有可用更新</a>

                                <a href="<?= $label->url(GROUP.'-Application-Init', ['n' => $value['index'], 'f' => 'remove']) ?>" class="am-badge am-badge-danger am-radius ajax-click ajax-dialog" msg="您确定要此删除插件吗?">删除</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="pes-installed am-hide"><?= empty($installed) ? json_encode([]) : $installed ?></div>
<script src="<?= PESCMS_URL ?>/Theme/Api/App/1.0/pescms_app.min.js?mt=<?= time() ?>"></script>
<script>
    $(function(){
        $('.check-update').each(function(){
            var dom = $(this)
            var name = dom.attr('name');
            var version = dom.attr('version');
            var href = dom.attr('href');
            $.ajax({
                url: "<?= PESCMS_URL ?>/?g=Api&m=Application&a=download",
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
                        dom.attr('href', href+'&appkey='+data.appkey);
                        dom.removeClass('am-hide');
                    }
                },
                error:function(obj){
                    dom.attr('class', 'am-badge am-badge-warning am-radius').attr('href', 'javascript:;').html('检查更新失败');
                }
            })

        })
    })
</script>