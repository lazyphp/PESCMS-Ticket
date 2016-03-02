<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <div class="action am-padding am-margin-bottom am-text-xs" style="height: 200px; overflow-y: auto;border: 1px solid #DDDDDD">

        </div>
        <div class="am-g doc-am-g">
            <div class="am-u-sm-2">安装进度:</div>
            <div class="am-u-sm-10">
                <div class="am-progress am-progress-striped am-active ">
                    <div class="am-progress-bar am-progress-bar-secondary"  style="width: 0%">0%</div>
                </div>
            </div>
        </div>
        <div class="am-center" style="width: 100px;">
            <a href="<?=str_replace("/Install", "", DOCUMENT_ROOT)?>/" id="next" class="am-btn am-btn-success am-hide">查看系统</a>
        </div>
    </div>
</div>
<script>
    $(function () {
        var obj = eval('(<?= $table ?>)');
        var timeId;
        var i = 0;
        var process = 0;
        $(".action").prepend("<p class=\"wait-begin\">等待响应</p><p>执行安装程序...</p>");
        $.ajax({
            url: '<?=DOCUMENT_ROOT?>/?m=Index&a=import&method=GET',
            data: {domain:'<?= $domain ?>', account: '<?= $account ?>', passwd: '<?= $passwd ?>', mail: '<?= $mail ?>', name: '<?= $name ?>'},
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                timeId = setInterval(function () {
                    if (process > 80) {
                        clearTimeout(timeId);
                        return true;
                    }
                    if (process <= '80') {
                        $(".am-progress-bar").css("width", process + "%").html(process + "%");
                    }
                    $(".wait-begin").append(".");
                    process++;
                }, '100');
            },
            success: function (data) {
                clearTimeout(timeId);
                if (data['status'] == '200') {
                    var endtimeId = setInterval(function () {
                        if (i >= obj.length && process > 100) {
                            $(".action").prepend("<p>安装结束，Install目录请手动移除!</p>");
                            $("#next").removeClass("am-hide");
                            clearTimeout(endtimeId);
                            return true;
                        }
                        $(".am-progress-bar").css("width", process + "%").html(process + "%");
                        if (i < obj.length) {
                            $(".action").prepend("<p>" + obj[i] + "...</p>");
                        } else if (i == obj.length) {
                            $(".action").prepend("<p class=\"wait\">请耐心等待安装结束</p>");
                        }
                        $(".wait").append(".");
                        i++;
                        process++;
                    }, '100');
                } else if (data['status'] != '200') {
                    $(".action").prepend("<p>" + data['msg'] + "</p>");
                } else {
                    $(".action").prepend("<p>安装遇到无法解析的错误!</p><p>"+data+"</p><p>请访问<a href=\"http://www.pescms.com/d/v/10/37\">本链接</a>获取解决方案</p>");
                }
            },
            error:function(obj){
                $(".action").prepend("<p>安装出错,未知原因!</p><p>"+obj.responseText+"</p><p>请访问<a href=\"http://www.pescms.com/d/v/10/37\">本链接</a>获取解决方案</p>");
            }
        })
    })
</script>
