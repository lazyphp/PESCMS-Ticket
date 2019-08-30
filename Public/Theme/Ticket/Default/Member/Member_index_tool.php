<?php
/**
 * 本模板为智能表单列表的工具栏
 * 若没有特殊的需求，请加载本模板
 */
?>
<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-1 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <?php ?>
                <?php $addUrl = empty($addUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $addUrl ?>
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default am-radius"><span class="am-icon-plus"></span> 新增</a>
            </div>
        </div>
    </div>


    <div class="am-u-sm-12 am-u-md-11">
        <form class="am-form am-form-inline am-text-right">
            <input type="hidden" name="g" value="<?= GROUP; ?>"/>
            <input type="hidden" name="m" value="<?= MODULE ?>"/>
            <input type="hidden" name="a" value="<?= ACTION ?>"/>
            <select name="sortby" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}" >
                <option value="0" <?= '0' == $_GET['read'] ? 'selected="selected"' : '' ?>>默认排序</option>
                <option value="1" <?= '1' == $_GET['sortby'] ? 'selected="selected"' : '' ?>>按名称升序 ↑</option>
                <option value="2" <?= '2' == $_GET['sortby'] ? 'selected="selected"' : '' ?>>按名称降序 ↓</option>
            </select>

            <div class="am-form-group">
                <input type="text" name="keyword" placeholder="查找内容" value="<?= $label->xss($_GET['keyword']) ?>" class="am-block am-input-sm pes_input_radius fix-input-width am-radius">
            </div>

            <button type="submit" class="am-btn am-btn-default am-btn-sm am-radius">搜索</button>

        </form>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />