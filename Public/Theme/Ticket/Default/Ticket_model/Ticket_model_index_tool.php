<div class="am-g am-margin-bottom-xs am-g-collapse">
    <div class="am-u-sm-12 am-u-md-2 am-padding-top-xs">
        <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
                <?php ?>
                <?php $addUrl = empty($addUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $addUrl ?>
                <a href="<?= $addUrl ?>" class="am-btn am-btn-default am-radius"><span class="am-icon-plus"></span> 新增</a>

                <?php if($system['indexStyle'] == 1): ?>
                    <a href="<?= $label->url('Form-Category-index', ['new_index' => 1, 'method' => 'GET', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="am-btn am-btn-secondary am-radius ajax-click" style="margin-left: .2rem" data-am-popover="{content: '您开启了首页工单样式，点击我进行更新', trigger: 'hover focus'}">
                        <span class="am-icon-refresh"></span> 更新首页工单样式
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>


    <div class="am-u-sm-12 am-u-md-10">
        <form class="am-form am-form-inline am-text-right">
            <input type="hidden" name="g" value="<?= GROUP; ?>"/>
            <input type="hidden" name="m" value="<?= MODULE ?>"/>
            <input type="hidden" name="a" value="<?= ACTION ?>"/>
            <select name="sortby" class="am-form-field am-input-sm am-radius" data-am-selected="{btnSize: 'sm', dropUp: 0}" >
                <option value="0" <?= '0' == $_GET['read'] ? 'selected="selected"' : '' ?>>默认排序</option>
                <option value="1" <?= '1' == $_GET['sortby'] ? 'selected="selected"' : '' ?>>按工单分类排序(升序)</option>
            </select>

            <div class="am-form-group">
                <input type="text" name="keyword" placeholder="查找工单模型" value="<?= $label->xss($_GET['keyword']) ?>" class="am-block am-input-sm pes_input_radius fix-input-width am-radius">
            </div>

            <button type="submit" class="am-btn am-btn-default am-btn-sm am-radius">搜索</button>

        </form>
    </div>
</div>
<hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
