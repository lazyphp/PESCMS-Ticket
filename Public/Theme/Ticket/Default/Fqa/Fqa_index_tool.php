<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-6 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <?php ?>
                <?php $addUrl = empty($addUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $addUrl ?>
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default am-radius"><span class="am-icon-plus"></span> 新增</a>
            </div>
        </div>
    </div>


    <div class="am-u-sm-12 am-u-md-6 am-text-right">
        <form class="am-form-inline">
            <input type="hidden" name="g" value="<?= GROUP; ?>"/>
            <input type="hidden" name="m" value="<?= MODULE ?>"/>
            <input type="hidden" name="a" value="<?= ACTION ?>"/>
            <select name="ticket_model_id" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                <option value="-1">选择工单</option>
                <?php foreach($ticketModel as $key => $value): ?>
                    <option value="<?= $value['ticket_model_id'] ?>" <?= $value['ticket_model_id'] == $_GET['ticket_model_id'] ? 'selected="selected"' : '' ?>>
                        <?= "{$value['category_name']} - {$value['ticket_model_name']}" ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="keyword" value="<?= $_GET['keyword'] ?>" class="am-input-lg">
            <button type="submit" class="am-btn am-btn-default am-btn-sm">搜索</button>
        </form>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />