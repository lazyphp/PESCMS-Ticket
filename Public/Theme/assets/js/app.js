/**
 * PESCMS核心的JS类库
 */
$(function () {


    /**
     * 日历语言包
     * @type {{days: string[], daysShort: string[], daysMin: string[], months: string[], monthsShort: string[], today: string, suffix: Array, meridiem: string[]}}
     */
    $.fn.datetimepicker.dates['zh-CN'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        today: "今天",
        suffix: [],
        meridiem: ["上午", "下午"]
    };

    /**
     * 触发表单提交功能。
     */
    $('body').on('submit', '.ajax-submit', function () {
        var url = $(this).attr("action")

        $.ajaxsubmit({
            url: url,
            data: $(".ajax-submit").serialize()
        }, function(){});

        return false;
    })

    /**
     * 适用于GET请求的ajax方法
     * 需要注意的是，若需要明确restful的话，请在URL中声明method方法。
     * 若监听的class中存在ajax-delete，在该标签中声明 msg="提示信息" ，将可以自定义提示信息
     */
    $("body").on("click", ".ajax-click", function () {
        var url = $(this).attr("href");
        var stop = false;
        //设置了禁用则不允许触发事件
        if($(this).hasClass('am-disabled')){
            return false;
        }


        //弹出对话框 @todo 此处是否应该换成dialog?
        if ($(this).hasClass('ajax-delete')) {
            var msg = $(this).attr("msg") ? $(this).attr("msg") : '确定删除吗？';
            if (!confirm(msg)) {
                stop = true;
            }
        }
        if (stop == true) {
            return false;
        }

        $.ajaxsubmit({
            url: url
        }, function(){});
        return false;
    })

    /**
     * 封装过的ajax方法
     * 注：本方法仅适用于PESCMS系列程序
     * @param param ajax请求信息设置，以对象形式提交： {url:'请求地址', data:{'表单名称':'表单值'}, dialog:'是否在请求完成后进行对话框提示并刷新'}
     * @param callback 回调函数。请求成功后，会返回success的数据包
     * @returns {boolean}
     */
    $.ajaxsubmit = function (param, callback) {
        var obj = {url: '', data: {'': ''}, dialog: true};
        $.extend(obj, param)

        var progress = $.AMUI.progress;
        var d = dialog({title: '系统提示', zIndex: '9999999'});
        progress.start();

        $.post(obj.url, obj.data, function (data) {

            if (obj.dialog == true) {
                if (data.status == '200') {
                    setTimeout(function () {
                        data.url ? window.location.href = data.url : location.reload();
                    }, 2000);
                }
                if (data.status) {
                    d.content(data.msg).showModal();
                } else {
                    d.content('系统响应出问题，请再次提交').showModal();
                }
            }
            callback(data);

        }, 'JSON').fail(function () {
            d.content('系统请求出错！请再次提交!').showModal();
        });
        setTimeout(function () {
            d.close();
        }, 3000);

        progress.done();
    }

    /**
     * 预览输入的图标
     */
    $("body").on("blur", ".icon-input", function(){
        var name = $(this).attr("name");
        $('.'+name).attr("class", $(this).val()+ ' '+ name);
    })

    /**
     * 拾色器
     */
    $(".color-input").spectrum({
        preferredFormat: "hex",
        showInput: true
    });

    /**
     * 日期选择器
     */
    $('.datetimepicker').datetimepicker({
        language: 'zh-CN',
        format: 'yyyy-mm-dd hh:00',
        maxView: '2',
        minView: '1',
        startDate: new Date(),
        autoclose: true
    });
})