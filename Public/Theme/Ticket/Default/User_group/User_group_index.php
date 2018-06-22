<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_tool.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_list.php"; ?>

<script>
    $(function () {

        $(".dialog").on("click", function () {
            var d = dialog({
                id: 'dialog-setting',
                quickClose: true,
                zIndex: 100,
                width: 300,
                ok: function () {
                    this.title('提交中…');
                    $(".setting-form").submit();
                    return false;
                }
            });
            d.show($(this)[0]);
            var href = $(this).attr("href");
            var title = $(this).text();

            $.get(href, function (html) {
                d.title(title);
                d.content('<div class="am-scrollable-vertical">' + html + '</div>');
            })
            return false;
        })
    })
</script>
<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
