<?php
/**
 * 本模板为智能表单添加/编辑模式下的底部复用模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>

<li>
    <div class="am-g">
        <div class="am-u-sm-10 am-u-sm-offset-2">
            <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">提交保存</button>
        </div>
    </div>
</li>
</ul>
</form>
</div>
<script>
    $(function(){
        $('#btn-submit').click(function () {
            var $btn = $(this)
            $btn.button('loading');
            setTimeout(function(){
                $btn.button('reset');
            }, 5000);
        });
    })
</script>