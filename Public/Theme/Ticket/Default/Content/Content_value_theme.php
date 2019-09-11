<?php switch ($field['field_type']):?>
<?php case 'category': ?>
    <?= \Model\Content::findContent('category', $value[$prefix . $field['field_name']], 'category_id', 'category_name')['category_name'] ?>
<?php break;?>

<?php case 'ticket': ?>
    <?= \Model\TicketModel::getTicketModelList($value[$prefix . $field['field_name']])['category_name']?>
        -
        <?= \Model\TicketModel::getTicketModelList($value[$prefix . $field['field_name']])['ticket_model_name']?>
<?php break;?>

<?php case 'date': ?>
        <?= empty($value[$prefix . $field['field_name']]) ? '' : date('Y-m-d H:i', $value[$prefix . $field['field_name']]); ?>
<?php break;?>

<?php case 'radio': ?>
<?php case 'checkbox': ?>
<?php case 'select': ?>
<?php case 'multiple': ?>
        <?= $this->getFieldOptionToMatch($field['field_id'], $value[$prefix . $field['field_name']]); ?>
<?php break;?>

<?php case 'icon': ?>
        <i class="<?= $value[$prefix . $field['field_name']]; ?>"></i>
<?php break;?>

<?php case 'thumb': ?>
    <?php if(!empty($value[$prefix . $field['field_name']])): ?>
        <a href="<?= $value[$prefix . $field['field_name']]; ?>" data-fancybox>
            <img class="am-radius" alt="<?= $value[$prefix . $field['field_name']]; ?>" src="<?= $value[$prefix . $field['field_name']]; ?>"  width="140" height="140" />
        </a>
    <?php endif; ?>
<?php break;?>

<?php case 'img': ?>
    <?php if(empty($value[$prefix . $field['field_name']])): ?>
        暂无图组上传
    <?php else: ?>
        <div class="am-dropdown" data-am-dropdown>
            <a href="javascript:;" class="am-dropdown-toggle" data-am-dropdown-toggle>查看图组 <span class="am-icon-caret-down"></span></a>
            <ul class="am-dropdown-content">
                <?php foreach(explode(',', $value[$prefix . $field['field_name']]) as $key => $file): ?>
                    <li><a href="<?= $file ?>" data-fancybox="gallery_<?= $value[$prefix . 'id']; ?>" data-caption="图片<?= $key + 1?>">图片<?= $key + 1?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php break;?>

<?php case 'file': ?>
    <?php if(empty($value[$prefix . $field['field_name']])): ?>
        暂无文件上传
    <?php else: ?>
    <div class="am-dropdown" data-am-dropdown>
        <a href="javascript:;" class="am-dropdown-toggle" data-am-dropdown-toggle>文件列表 <span class="am-icon-caret-down"></span></a>
        <ul class="am-dropdown-content">
            <?php
            $downloadFile = $this->ubbUrl($value[$prefix . $field['field_name']]);
            ?>
            <?php if($downloadFile == false): ?>
                <?php foreach(explode(',', $value[$prefix . $field['field_name']]) as $key => $file): ?>
                <li><a href="<?= $file ?>" target="_blank">下载文件<?= $key + 1?></a></li>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach($downloadFile as $key => $value): ?>
                    <li><?= $value ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>
<?php break;?>

<?php case 'color': ?>
        <span class="am-badge am-radius" style="background-color: <?= $value[$prefix . $field['field_name']]; ?>;color: <?= $value[$prefix . $field['field_name']]; ?>;width: 100%;height: 100%"> &nbsp;</span>
<?php break;?>

<?php case 'listsort': ?>
<?php break;?>

<?php default: ?>
        <?= $value[$prefix . $field['field_name']]; ?>
<?php endswitch; ?>

