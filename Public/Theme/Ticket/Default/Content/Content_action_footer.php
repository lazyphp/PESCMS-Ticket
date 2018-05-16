<?php
/**
 * 本模板为智能表单添加/编辑模式下的底部复用模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>


<div class="am-g am-g-collapse am-margin-bottom">
    <div class="am-u-sm-12 am-u-sm-centered">
        <button type="submit" class="am-btn am-btn-primary am-btn-xs" >提交保存</button>
    </div>
</div>
</form>
</div>
</div>
</div>
<script>
    $(function () {
        $('#btn-submit').click(function () {
            var $btn = $(this)
            $btn.button('loading');
            setTimeout(function () {
                $btn.button('reset');
            }, 5000);
        });
    })
</script>