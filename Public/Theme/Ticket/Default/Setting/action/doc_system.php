<div class="am-panel am-panel-default">
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">文档系统地址</label>
                    <input name="doc[url]" placeholder="文档系统地址" type="text" value="<?= $doc['url'] ?>">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">文档系统的Authorization</label>
                    <input name="doc[authorization]" placeholder="文档系统的Authorization" type="text" value="<?= $doc['authorization'] ?>">
                    <div class="pes-alert pes-alert-info am-text-xs ">
                        <i class="am-icon-lightbulb-o"></i> 要将文档系统的内容与PT系统产生关联，请完成填写上述2个选项内容。其中Authorization的获取方式请查看 <a href="https://document.pescms.com/article/4/664720334762541056.html" target="_blank">《基础和全局》</a>
                    </div>
                </div>
            </div>
        </div>

<!--        <div class="am-g am-g-collapse">-->
<!--            <div class="am-u-sm-12 am-u-sm-centered">-->
<!--                <div class="am-form-group">-->
<!--                    <label class="am-block">文档定时更新时间</label>-->
<!--                    <div class="am-input-group time-picker-wrapper">-->
<!--                        <input name="doc[timer]" id="doc-timer" class="am-form-field" placeholder="选择时分 (24小时制)" type="text" value="--><?//= $doc['timer'] ?? '' ?><!--">-->
<!--                        <span class="am-input-group-label"><i class="am-icon-clock-o"></i></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

    </div>
</div>

<style>
    .time-picker-popup {
        position: absolute;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        padding: 10px;
        display: none;
        z-index: 1000;
        width: 200px;
    }

    .time-picker-popup select {
        width: 45%;
        display: inline-block;
        margin-right: 5px;
    }
</style>

<script>
    $(function() {
        // 创建时间选择器元素
        var $timePicker = $('<div class="time-picker-popup">' +
            '<select id="hour-select" class="am-form-field"></select>' +
            '<select id="minute-select" class="am-form-field"></select>' +
            '<button class="am-btn am-btn-primary am-btn-xs am-btn-block am-margin-top-sm">确定</button>' +
            '</div>');

        // 添加到body
        $('body').append($timePicker);

        // 填充小时选项
        var $hourSelect = $('#hour-select');
        for (var h = 0; h < 24; h++) {
            var hourStr = h < 10 ? '0' + h : h;
            $hourSelect.append('<option value="' + hourStr + '">' + hourStr + ' 时</option>');
        }

        // 填充分钟选项
        var $minuteSelect = $('#minute-select');
        for (var m = 0; m < 60; m += 5) {
            var minStr = m < 10 ? '0' + m : m;
            $minuteSelect.append('<option value="' + minStr + '">' + minStr + ' 分</option>');
        }

        // 显示时间选择器
        $('#doc-timer').on('focus', function() {
            var offset = $(this).offset();
            var height = $(this).outerHeight();

            // 如果有已有的值，设置选择器的初始值
            var currentVal = $(this).val();
            if (currentVal) {
                var parts = currentVal.split(':');
                if (parts.length === 2) {
                    $hourSelect.val(parts[0]);
                    $minuteSelect.val(parts[1]);
                }
            }

            $timePicker.css({
                top: offset.top + height,
                left: offset.left
            }).show();
        });

        // 点击确定按钮
        $timePicker.find('button').on('click', function() {
            var hour = $hourSelect.val();
            var minute = $minuteSelect.val();
            $('#doc-timer').val(hour + ':' + minute);
            $timePicker.hide();
        });

        // 点击外部区域关闭选择器
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.time-picker-popup').length &&
                !$(e.target).closest('#doc-timer').length &&
                !$(e.target).closest('.time-picker-wrapper').length) {
                $timePicker.hide();
            }
        });
    });
</script>