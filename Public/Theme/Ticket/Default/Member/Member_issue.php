<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default" style="min-height: 600px; ">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

            <div class="am-g" style="display: flex;align-items: center;height: 400px;">
                <div class="am-u-sm-6 am-u-lg-centered am-text-center">
                    <form <?= ACTION == 'issue' ? 'target="_blank"' : 'class="am-form am-form-horizontal ajax-submit" method="POST"' ?>>
                        <?php if (ACTION == 'issue'): ?>
                            <input type="hidden" name="g" value="<?= GROUP ?>">
                            <input type="hidden" name="m" value="<?= MODULE ?>">
                            <input type="hidden" name="a" value="issueLogin">
                        <?php else: ?>
                            <input type="hidden" name="back_url" value="<?= htmlspecialchars($_GET['back_url'] ?? NULL) ?>">
                            <input type="hidden" name="method" value="PUT">
                        <?php endif; ?>
                        <?= $label->token(); ?>

                        <select class="organize" data-am-selected="{searchBox: 1, maxHeight: 200}" placeholder="请选择客户分组" required>
                            <option value="">请选择客户分组</option>
                            <?php foreach ($member_organize as $key => $value): ?>
                                <option value="<?= $value['member_organize_id'] ?>"><?= $value['member_organize_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="id" data-am-selected="{searchBox: 1, maxHeight: 200}" required>
                            <option value="">请选择客户</option>
                        </select>
                        <button type="submit" class="am-btn am-btn-primary am-radius"><?= ACTION == 'issue' ? '调用此账号' : '绑定此账号' ?></button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function () {
        $('.organize').on('change', function () {
            var id = $(this).val()
            $.getJSON(PESCMS_PATH + '/?g=Ticket&m=Member&a=issue&id=' + id + '&keepToken=' + Math.random(), function (data) {
                if (data.status == 200) {
                    $('select[name="id"]').html(data.data)
                } else {
                    alert(data.msg || '请求出错了，请刷新页面')
                }
            })
        })
    })
</script>