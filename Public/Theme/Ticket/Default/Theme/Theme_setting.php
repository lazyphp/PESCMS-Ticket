<div id="wrapper">
    <!-- content start -->
    <div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd">
                <div class="am-cf">
                    <div class="am-fl am-cf">
                        <?php if (!empty($_GET['back_url'])): ?>
                            <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                                        class="am-icon-reply"></i>返回</a>
                        <?php endif; ?>
                        <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                    </div>
                </div>
                <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed am-no-layout">
                <form class="am-form ajax-submit" action="" method="post" data-am-validator>
                    <input type="hidden" name="method" value="PUT">
                    <input type="hidden" name="id" value="2">
                    <?= $label->token(); ?>
                    <input type="hidden" name="back_url" value="<?= $label->xss($_GET['back_url'] ?? '') ?>">


                    <div class="am-g am-g-collapse">
                        <div class="am-u-sm-12 am-u-sm-centered">
                            <div class="am-form-group">
                                <label class="am-block">首页布局形式<i class="am-text-danger">*</i></label>
                                <?php foreach (['0' => '简洁搜索框', '1' => '工单列表模式', '2' => '展示特定工单分类'] as $key => $name): ?>
                                    <label class="form-radio-label am-radio-inline">
                                        <input class="form-radio" type="radio" name="index_type" value="<?= $key ?>" required="" <?= $setting['index_type'] == $key ? 'checked="checked"' : '' ?>>
                                        <span><?= $name ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="am-g am-g-collapse" id="hot_key">
                        <div class="am-u-sm-12 am-u-sm-centered">
                            <div class="am-form-group">
                                <label class="am-block">搜索框热门搜索词</label>
                                <input class="form-text-input input-leng3 am-radius" name="hot_key" placeholder="热门搜索词用分号隔开"
                                       type="text" value="<?= $setting['hot_key'] ?>"></div>
                        </div>
                    </div>

                    <div class="am-g am-g-collapse" id="index_cid">
                        <div class="am-u-sm-12 am-u-sm-centered">
                            <div class="am-form-group">
                                <label class="am-block">特定工单分类ID</label>
                                <?php $category = \Model\Category::recursion(true); ?>
                                <select class="input-leng3 am-radius" name="index_cid">
                                    <option value="">请选择工单分类</option>
                                    <?php foreach ($category as $key => $value): ?>
                                        <option value="<?= $value['category_id'] ?>" <?= isset($field['value']) && $field['value'] == $value['category_id'] ? 'selected="selected"' : '' ?> ><?= $value['space'] . ($value['guide'] ?? '') . $value['category_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="am-g am-g-collapse">
                        <div class="am-u-sm-12 am-u-sm-centered">
                            <div class="am-form-group">
                                <label class="am-block">首页显示常见问题<i class="am-text-danger">*</i></label>
                                <label class="form-radio-label am-radio-inline">
                                    <input class="form-radio" type="radio" name="fqa" value="0" required="" <?= $setting['fqa'] == 0 ? 'checked="checked"' : '' ?>>
                                    <span>隐藏</span>
                                </label>
                                <label class="form-radio-label am-radio-inline">
                                    <input class="form-radio" type="radio" name="fqa" value="1" required="" <?= $setting['fqa'] == 1 ? 'checked="checked"' : '' ?>>
                                    <span>显示</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($indexField as $key => $value) : ?>
                        <?php $value['value'] = $setting[$value['field_name']] ?? ''  ?>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block"><?= $value['field_display_name'] ?><?= $value['field_required'] == '1' ? '<i class="am-text-danger">*</i>' : '' ?></label>
                                    <?= $form->formList($value); ?>
                                    <?php if (!empty($value['field_explain'])): ?>
                                        <div class="pes-alert pes-alert-info am-text-xs ">
                                            <i class="am-icon-lightbulb-o"></i> <?= $value['field_explain'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="am-g am-g-collapse am-margin-bottom">
                        <div class="am-u-sm-12 am-u-sm-centered">
                            <button type="submit" class="am-btn am-btn-primary am-btn-xs am-radius"><i
                                        class="am-icon-save"></i> 提交保存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        $('input[name="index_type"]').on('click', function () {
            if ($(this).val() == 0) {
                $('#hot_key').show();
                $('#index_cid').hide();
            } else if ($(this).val() == 1) {
                $('#hot_key').hide();
                $('#index_cid').hide();
            } else if ($(this).val() == 2) {
                $('#hot_key').hide();
                $('#index_cid').show();
            }
        })
        var index_type = $('input[name="index_type"]:checked').val();
        $('input[name="index_type"][value="' + index_type + '"]').prop('checked', true).click();

    })
</script>