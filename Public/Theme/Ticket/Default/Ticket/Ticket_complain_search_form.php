<form action="/" class="am-form am-form-inline">
    <input type="hidden" name="g" value="<?= GROUP; ?>"/>
    <input type="hidden" name="m" value="<?= MODULE ?>"/>
    <input type="hidden" name="a" value="<?= ACTION ?>"/>

    <div class="am-margin-bottom-xs">

        <select name="time_type" class="am-form-field am-input-sm am-radius" data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}">
            <option value="1">创建时间</option>
            <option value="2" <?= $label->xss($_GET['time_type']) == 2 ? 'selected="selected"' : '' ?>>完成时间</option>
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
                <option value="<?= $value['ticket_model_id']; ?>" <?= $value['ticket_model_id'] == $_GET['model_id'] ? 'selected="selected"' : '' ?> >
                    <?= $category[$value['ticket_model_cid']]['category_name']; ?> - <?= $value['ticket_model_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>


        <select name="fix" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
            <option value="-1">问题是否解决</option>
            <option value="0" <?= '0' == $_GET['fix'] ? 'selected="selected"' : '' ?>>否</option>
            <option value="1" <?= '1' == $_GET['fix'] ? 'selected="selected"' : '' ?>>是</option>
        </select>

        <?php if(!empty($member[$_GET['member']])): ?>
            <select name="member" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}">
                <option value="-1" >不筛选用户</option>
                <option value="<?= $_GET['member'] ?>" selected="selected" ><?= $member[$_GET['member']]['member_name'] ?></option>
            </select>
        <?php endif; ?>

        <div class="am-form-group">
            <input type="text" name="keyword" value="<?= $label->xss($_GET['keyword']) ?>" class="am-input-sm pes_input_radius fix-input-width am-radius pes-ticket-search-input" placeholder="工单单号、标题或备注搜索">
        </div>
    </div>

    <div>
        <label class="am-checkbox am-secondary am-padding-left-0">
            工单内容搜索:
        </label>
        <div class="am-form-group">
            <input type="text" name="form_content" value="<?= $label->xss(urldecode($_GET['form_content'])) ?>" placeholder="工单内容搜索" class="am-block am-input-sm pes_input_radius fix-input-width am-radius pes-ticket-search-input">
        </div>

        <label class="am-checkbox am-secondary am-padding-left-0">
            按客户名称搜索:
        </label>
        <div class="am-form-group">
            <input type="text" name="member_name" value="<?= $label->xss(urldecode($_GET['member_name'])) ?>" placeholder="客户名称" class="am-block am-input-sm pes_input_radius fix-input-width am-radius pes-ticket-search-input">
        </div>

        <button type="submit" class="am-btn am-btn-default am-btn-sm am-radius">搜索</button>
        <button type="submit" name="csv" value="1" class="am-btn am-btn-success am-btn-sm am-radius"><i class="am-icon-file-excel-o"></i> 导出CSV</button>

    </div>


</form>