<?php switch ($field['field_type']):?>
<?php case 'category': ?>
    <?= \Model\Content::findContent('category', $value[$prefix . $field['field_name']], 'category_id', 'category_name')['category_name'] ?>
<?php break;?>

<?php case 'date': ?>
        <?= date('Y-m-d H:i', $value[$prefix . $field['field_name']]); ?>
<?php break;?>

<?php case 'radio': ?>
<?php case 'checkbox': ?>
<?php case 'select': ?>
        <?= $this->getFieldOptionToMatch($field['field_id'], $value[$prefix . $field['field_name']]); ?>
<?php break;?>

<?php case 'icon': ?>
        <i class="<?= $value[$prefix . $field['field_name']]; ?>"></i>
<?php break;?>

<?php case 'thumb': ?>
        <img class="am-radius" alt="140*140" src="<?= $value[$prefix . $field['field_name']]; ?>" width="140" height="140" />
<?php break;?>

<?php case 'color': ?>
        <span class="am-badge am-radius" style="background-color: <?= $value[$prefix . $field['field_name']]; ?>;color: <?= $value[$prefix . $field['field_name']]; ?>;width: 100%;height: 100%"> &nbsp;</span>
<?php break;?>

<?php case 'listsort': ?>
<?php break;?>

<?php default: ?>
        <?= $value[$prefix . $field['field_name']]; ?>
<?php endswitch; ?>

