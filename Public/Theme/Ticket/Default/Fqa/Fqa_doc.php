<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0 fqa-doc">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd" style="min-height: 75vh">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <?php if (!empty($_GET['back_url'])): ?>
                        <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                                    class="am-icon-reply"></i>返回</a>
                    <?php endif; ?>
                    <strong class="am-text-primary am-text-lg"><?= $title ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed am-no-layout">
            <form class="am-form am-form-horizontal ajax-submit" action="" method="post" data-am-validator>
                <?= $label->token(); ?>

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">选择要导入的文档<i class="am-text-danger">*</i></label>
                            <select name="doc">
                                <option value="">请选择文档</option>
                                <?php foreach ($doc as $docID => $docTitle): ?>
                                    <option value="<?= $docID ?>"><?= $docTitle ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered doc-transfer">
                        <div class="doc-path">
                            <div class="am-text-center am-margin-top">等待选择文档</div>
                        </div>
                        <div class="doc-path-list">
                            <div class="am-text-center am-margin-top">
                                还没有选择文档
                            </div>
                        </div>
                    </div>
                </div>


                <div class="am-g am-g-collapse am-margin-vertical">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('[name="doc"]').on('change', function () {
            var docID = $(this).val();
            if (docID) {
                $.ajaxsubmit({
                    url: '<?= $this->url('Ticket-Fqa-getDocPath', ['method' => 'GET']) ?>',
                    data: {id: docID},
                    dialog: false,
                    jump: false
                }, function (res) {
                    if (res.status == 200) {
                        $('.doc-path').html(res.data);

                        // ** 重新勾选已选中的 checkbox **
                        $(".doc-path-list div.selected-doc").each(function () {
                            let aid = $(this).attr("data-aid");
                            $(".doc-path input[value='" + aid + "']").prop("checked", true);
                        });

                    }
                })
            }
        })

        $(document).on('change', '.doc-path input[type="checkbox"]', function () {
            let label = $(this).closest("label").text().trim();
            let docID = $(this).attr("doc_id"); // 读取 doc_id 值
            let aid = $(this).val(); // 读取 aid 值

            if ($(this).is(":checked")) {
                // 创建 div 并添加隐藏的 input
                let newItem = $(`
            <div class="selected-doc" data-aid="${aid}">
                ${label}
                <input type="hidden" name="docID[]" value="${docID}">
                <input type="hidden" name="title[]" value="${label}">
                <input type="hidden" name="aidlist[]" value="${aid}">
            </div>
                `);
                $(".doc-path-list").find(".am-text-center").remove();
                $(".doc-path-list").append(newItem);
                $(".doc-path-list").stop().animate({ scrollTop: $(".doc-path-list")[0].scrollHeight }, 300);

            } else {
                // 取消勾选时，删除对应的 div
                $(".doc-path-list div[data-aid='" + aid + "']").remove();
            }
        });

        // 点击 doc-path-list 中的 div 进行删除
        $(document).on("click", ".doc-path-list div.selected-doc", function () {
            let aid = $(this).attr("data-aid");
            $(".doc-path input[value='" + aid + "']").prop("checked", false);
            $(this).remove();
        });


    })
</script>