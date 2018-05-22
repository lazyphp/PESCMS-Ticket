$(function(){
    
setTimeout(function(){
    $.webuploaderConfig({
        server: WEBSITE_URL + '/index.php?m=Upload&a=ueditor&method=POST&action=uploadimage'
    });
}, 200)
    
} )


$('body').on('submit', '.ajax-submit', function () {
    var url = $(this).attr("action")
    var dom = $(this)
    $.ajaxsubmit({
        url: url,
        data: dom.serialize()
    }, function () {
    });

    return false;
})
$.ajaxsubmit = function (param, callback) {
    var obj = {url: '', data: {'': ''}, dialog: true};
    $.extend(obj, param)

    var progress = $.AMUI.progress;
    var d = dialog({title: '系统提示', zIndex: '999', fixed:true}).showModal();
    progress.start();

    $.post(obj.url, obj.data, function (data) {

        if (obj.dialog == true) {
            if (data.status == 200) {

                if(data.waitSecond == -1){
                    window.location.href = data.url
                    return false;
                }

                setTimeout(function () {
                    data.url ? window.location.href = data.url : location.reload();
                }, 2000);
            }
            d.content(data.msg);

        }
        $.refreshToken(data.token);
        callback(data);

    }, 'JSON').fail(function (jqXHR, textStatus, error) {
        var msg = '系统请求出错！请再次提交!';
        try{
            $.refreshToken(jqXHR.responseJSON.token);
            switch (jqXHR.responseJSON.status){
                case 500:
                    msg = jqXHR.responseJSON.msg;
                    break;
                case 404:
                    msg = jqXHR.responseJSON.msg;
                    break;
            }

        }catch (e){

        }
        d.content(msg);
    }).complete(function(){
        var src = $('.refresh-verify').attr('src')
        $('.refresh-verify').attr('src', src + '&time=' + Math.random());
        setTimeout(function () {
            d.close();
        }, 3000);
        progress.done();
    });
}

$.refreshToken = function (token) {
    $('input[name=token]').each(function () {
        $(this).val(token);
    })
}