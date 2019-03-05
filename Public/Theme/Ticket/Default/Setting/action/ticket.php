<div class="am-panel am-panel-default">
    <div class="am-panel-hd">工单状态</div>
    <div class="am-panel-bd am-padding-0">
        <table class="am-table am-table-bordered am-margin-bottom-0 am-table-centered">
            <?php foreach (range('0', '3') as $iteration): ?>
                <tr>
                    <td class="am-text-middle">工单状态颜色与名称</td>
                    <td class="am-text-middle">
                        <input type="text" class="custom" name="customcolor[]" placeholder=""  value="<?= $customstatus[$iteration]['color']; ?>" required="">
                    </td>
                    <td class="am-text-middle">
                        <input  type="text"name="customstatus[]" placeholder=""  value="<?= $customstatus[$iteration]['name']; ?>" required="">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>