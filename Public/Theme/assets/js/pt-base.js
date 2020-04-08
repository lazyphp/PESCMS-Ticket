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
    var dialogOption = {id:'submit-tips', zIndex: '9999', fixed:true, skin:'submit-warning'};

    progress.start();

    $.ajax({
        url: obj.url,
        data: obj.data,
        type: "POST",
        dataType:'JSON',
        crossDomain: true,
        xhrFields: {
            withCredentials: true
        },
        success: function (data) {
            if (obj.dialog == true) {
                if (data.status == 200) {
                    dialogOption.content = '  ';
                    dialogOption.skin = 'submit-success';
                    if(data.waitSecond == -1){
                        window.location.href = WEBSITE_URL + data.url
                        return false;
                    }

                    setTimeout(function () {
                        data.url ? window.location.href = WEBSITE_URL + data.url : location.reload();
                    }, 2000);
                }else{
                    dialogOption.content = '  ';
                }
                dialogOption.content += data.msg;

            }
            $.refreshToken(data.token);
            callback(data);
        },
        error:function(obj){
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
            dialogOption.skin = 'submit-error';
            dialogOption.content = ' '+msg;
        },
        complete:function () {
            var d = dialog(dialogOption).showModal();
            var src = $('.refresh-verify').attr('src')
            $('.refresh-verify').attr('src', src + '&time=' + Math.random());
            setTimeout(function () {
                d.close().remove();
            }, 3000);
            progress.done();
        }
    });
}

/**
 * 点击打开验证码
 */
$(".display-verify").on("click", function () {
    $(this).remove();
    $(".refresh-verify").removeClass("am-hide").attr("src", WEBSITE_URL +"/?m=Index&a=verify&time=" + Date.parse(new Date()) + Math.random());
});

/**
 * 刷新验证码
 */
$(document).on('click', '.refresh-verify', function () {
    var src = $(this).attr('src')
    $(this).attr('src', src + '&time=' + Math.random());
});

$.refreshToken = function (token) {
    $('input[name=token]').each(function () {
        $(this).val(token);
    })
};

var contact = function(){
    var dom = $('input[name=contact]:checked');
    var checkContact = dom.val();
    var label = dom.parent().text().trim()

    $('.contact_label').html(' ('+label+')')

    if(checkContact == '3'){
        $('input[name=contact_account]').parent().hide()
    }else{
        $('input[name=contact_account]').parent().show();
    }
    $('input[name=contact_account]').val(dom.attr('data'))
}

contact();


$('input[name=contact]').click(function(){
    contact();
})