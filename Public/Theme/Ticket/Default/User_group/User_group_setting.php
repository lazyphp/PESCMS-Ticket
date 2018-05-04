<?php include THEME_PATH.'/header.php' ?>
    <form class="am-form setting-form ajax-submit" action="<?= $label->url(GROUP.'-'.MODULE.'-'.ACTION) ?>" method="POST">
        <input type="hidden" name="method" value="PUT"/>
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>"/>
        <table class="am-table am-table-striped am-table-hover table-main">
            <tr>
                <th>名称</th>
            </tr>
            <?php if (!empty($list)): ?>
                <?php foreach ($list as $topkey => $topValue) : ?>
                    <tr>
                        <td class="am-text-middle">
                            <div class="am-checkbox am-margin-0">
                                <label class="am-block">
                                    <input type="checkbox" name="node[<?= $topValue["{$prefix}id"]; ?>]"
                                           value="<?= $topValue["{$prefix}id"]; ?>">
                                    <?= $topValue["{$prefix}name"]; ?>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <?php if (!empty($topValue["{$prefix}child"])): ?>
                        <?php foreach ($topValue["{$prefix}child"] as $key => $value) : ?>
                            <tr>
                                <td class="am-text-middle">
                                    <div class="am-checkbox am-margin-0"">
                                        <label class="am-block" data-parent="<?= $topValue["{$prefix}id"]; ?>">
                                            <input type="checkbox" name="node[<?= $value["{$prefix}id"]; ?>]"
                                                   value="<?= $value["{$prefix}id"]; ?>">
                                            <span class="plus_icon plus_end_icon"></span><?= $value["{$prefix}name"]; ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </form>

    <script>
        $(function () {
            var record = eval('(' + '<?=$record?>' + ')');
            for(var kr in record){
                $("input[name^='node'][value=" + record[kr] + "]").prop("checked", "checked");
            }

            $("label input").on("click", function () {
                var data_parent = $(this).parent().attr("data-parent");
                if (data_parent != undefined) {
                    var unchecked = false;
                    $("label[data-parent=" + data_parent + "] input").each(function () {
                        if ($(this).is(":checked")) {
                            unchecked = true;
                        }
                    });

                    if (unchecked == true) {
                        $("input[name^='node'][value=" + data_parent + "]").prop("checked", "checked")
                    } else {
                        $("input[name^='node'][value=" + data_parent + "]").removeAttr("checked")
                    }
                } else {
                    var child = $(this).val();
                    var dom = $(this);
                    $("label[data-parent=" + child + "] input").each(function () {
                        if (dom.is(":checked")) {
                            $(this).prop("checked", "checked")
                        } else {
                            $(this).removeAttr("checked")
                        }
                    });

                }
            })
        })
    </script>
<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>