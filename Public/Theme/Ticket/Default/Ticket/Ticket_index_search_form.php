<form action="/" class="am-form am-form-inline">
    <input type="hidden" name="g" value="<?= GROUP; ?>"/>
    <input type="hidden" name="m" value="<?= MODULE ?>"/>
    <input type="hidden" name="a" value="<?= ACTION ?>"/>

    <div class="am-margin-bottom-xs">

        <select name="time_type" class="am-form-field am-input-sm am-radius" data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}">
            <option value="1">创建时间</option>
            <option value="2" <?= $label->xss($_GET['time_type'] ?? '') == 2 ? 'selected="selected"' : '' ?>>完成时间</option>
        </select>

        <div class="am-form-group am-form-icon">
            <i class="am-icon-calendar"></i>
            <input type="text" class="am-form-field am-input-sm am-radius" name="begin" value="<?= !empty($_GET['begin']) ? $label->xss($_GET['begin']) : '' ?>" readonly data-am-datepicker>
        </div>

        <div class="am-form-group am-form-icon">
            <i class="am-icon-calendar"></i>
            <input type="text" class="am-form-field am-input-sm am-radius" name="end" value="<?= !empty($_GET['end']) ? $label->xss($_GET['end']) : '' ?>" readonly data-am-datepicker>
        </div>
    </div>

    <div class="am-margin-bottom-xs">
        <select name="model_id" class="am-form-field am-input-sm am-radius" data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}">
            <option value="-1">所有类型</option>
            <?php foreach ($ticketModel as $value): ?>
                <option value="<?= $value['ticket_model_id']; ?>" <?= isset($_GET['model_id']) && $value['ticket_model_id'] == $_GET['model_id'] ? 'selected="selected"' : '' ?> >
                    <?= $category[$value['ticket_model_cid']]['category_name']; ?> - <?= $value['ticket_model_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>


        <select name="status" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
            <option value="-1">所有进度</option>
            <?php foreach ($ticketStatus as $key => $value): ?>
                <option value="<?= $key; ?>" <?= isset($_GET['status']) && $_GET['status'] === (string)$key ? 'selected="selected"' : '' ?>><?= $value['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="read" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
            <option value="-1">查看状态</option>
            <option value="0" <?= isset($_GET['read']) && '0' == $_GET['read'] ? 'selected="selected"' : '' ?>>未读</option>
            <option value="1" <?= isset($_GET['read']) && '1' == $_GET['read'] ? 'selected="selected"' : '' ?>>已读</option>
        </select>

        <select name="close" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
            <option value="-1">关闭状态</option>
            <option value="0" <?= isset($_GET['close']) && '0' == $_GET['close'] ? 'selected="selected"' : '' ?>>正常</option>
            <option value="1" <?= isset($_GET['close']) && '1' == $_GET['close'] ? 'selected="selected"' : '' ?>>已关闭</option>
        </select>

        <?php if(!empty($member[$_GET['member'] ?? ''])): ?>
            <select name="member" class="am-form-field" placeholder=""
                    data-am-selected="{btnSize: 'sm', dropUp: 0}">
                <option value="-1" >不筛选用户</option>
                <option value="<?= $label->xss($_GET['member'] ?? '') ?>" selected="selected" ><?= $member[$_GET['member']]['member_name'] ?></option>
            </select>
        <?php endif; ?>

        <div class="am-form-group">
            <input type="text" name="keyword" value="<?= $label->xss(urldecode($_GET['keyword'] ?? '')) ?>" placeholder="工单单号、标题或备注搜索" class="am-block am-input-sm pes_input_radius fix-input-width am-radius pes-ticket-search-input">
        </div>

    </div>
    <div>
        <label class="am-checkbox am-secondary am-padding-left-0">
            工单内容搜索:
        </label>
        <div class="am-form-group">
            <input type="text" name="form_content" value="<?= $label->xss(urldecode($_GET['form_content'] ?? '')) ?>" placeholder="工单内容搜索" class="am-block am-input-sm pes_input_radius fix-input-width am-radius pes-ticket-search-input">
        </div>

        <label class="am-checkbox am-secondary am-padding-left-0">
            按客户名称搜索:
        </label>
        <div class="am-form-group">
            <input type="text" name="member_name" value="<?= $label->xss(urldecode($_GET['member_name'] ?? '')) ?>" placeholder="客户名称" class="am-block am-input-sm pes_input_radius fix-input-width am-radius pes-ticket-search-input">
        </div>

        <button type="submit" name="search" value="1" class="am-btn am-btn-default am-btn-sm am-radius"><i class="am-icon-search"></i> 搜索</button>
        <?php if(!empty($_GET['search'])): ?>
        <button type="submit" name="search-csv" value="1" class="am-btn am-btn-success am-btn-sm am-radius"><i class="am-icon-file-excel-o"></i> 导出CSV</button>
        <?php endif; ?>
    </div>

</form>