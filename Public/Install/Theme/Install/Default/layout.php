<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/css/ui-dialog.css"/>
    <!--[if (gte IE 9)|!(IE)]><!-->
    <script src="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/js/jquery.min.js"></script>
    <script src="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/js/amazeui.min.js"></script>
    <script src="<?= str_replace("/Install", "", DOCUMENT_ROOT) ?>/Theme/assets/js/dialog-min.js"></script>
    <!--<![endif]-->
    <style>
        html, body {
            -moz-background-size: 100% 100%;
            background-size: cover;
            background: url('<?=str_replace("/Install", "", DOCUMENT_ROOT)?>/Theme/assets/i/lattice.png');
        }

        .header {
            margin-top: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }

        .header p {
            font-size: 14px;
        }
        .am-panel-hd{
            color: #444;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            margin: 20px 0;
            text-align: center;
        }
        label{
            margin: 0;
        }
        .am-alert{
            font-size: 1.2rem !important;
        }
        .install{
            background-color:#fff;
            border-radius: 4px;
            color: #333;
        }
        .install .ui-dialog-header{
            border-radius: 4px;
            background: #F8F8F8;
        }

        .agree h2{
            padding-bottom: 10px;
            border-bottom: 1px solid #cfcfcf;
        }
    </style>
</head>
<body>

<div class="am-g am-padding-top">
    <div class="am-u-lg-8 am-u-md-8 am-u-sm-centered">
        <div class="am-panel am-panel-default am-text-sm">
            <div class="am-panel-bd">
                <div class="pesad"></div>
                <script>
                    $(function () {
                        $.getJSON('https://www.pescms.com/pesad/2', function (data) {
                            if (data.status == 200) {
                                for (var i = 0; i < data.data.length; i++) {
                                    $('.pesad').append(data.data[i]);
                                }
                            } else {
                                $('.pesad').append('<a href="https://www.pescms.com/Page/ad.html" style="color: #fff;"><div class="am-vertical-align" style="background: #61cff9;height: 70px;text-align: center;"><div class="am-vertical-align-middle am-text-xxxl">广告投放</div></div></a>');
                            }
                        })
                    })
                </script>

                <div class="header">
                    <h1 class="am-margin-top-0"><?= $title ?>
                        <small class="am-text-xs">v<?= $version ?></small>
                    </h1>
                    <p>一款开源且简单得客服工单系统<br/>The open source ticket system</p>
                    <hr/>
                </div>
                <?php include $file; ?>

            </div>
            <form method="POST" class="am-form am-form-horizontal" data-am-validator>
                <?php require 'Index/Index_config.php' ?>
                <?php require 'Index/Index_option.php' ?>
                <hr/>
                <div class="am-g am-g-collapse am-margin-bottom">
                    <div class="am-u-sm-12 am-u-sm-centered am-text-center am-margin-bottom-xs">
                        <div class="am-checkbox am-inline-block">
                            <label>
                                <input type="checkbox" class="i-do"> <strong>我已阅读且同意<a href="https://www.pescms.com/article/view/-1.html" target="_blank">《<?= $program ?>软件使用协议》</a> </strong>
                            </label>

                        </div>
                    </div>

                    <div class="am-u-sm-12 am-u-sm-centered am-text-center">
                        <div class="am-text-danger install-tips am-margin-bottom-xs">
                            [勾选阅读且同意框方可安装程序]
                        </div>
                        <button type="submit" class="am-btn am-btn-success am-btn-sm begin-install" disabled >开始安装</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="pes-success" style="display: none">
    <div class="am-block am-text-center am-margin-top">
        <a href="<?= str_replace("Install", "", DOCUMENT_ROOT) ?>"  target="_blank" class="am-btn am-btn-success am-margin-left-sm am-inline am-btn-sm">查看前台</a>
        <a href="" target="_blank"  class="am-btn am-btn-primary am-inline am-btn-sm mange-url ">查看后台</a>
    </div>
</div>

<script>
    $(function(){
        var progress = $.AMUI.progress;

        $.ajax({
            url:'https://www.pescms.com/UserProtocol',
            dataType:'JSON',
            beforeSend:function(){
                progress.start();
            },
            success:function(data){
                $(".agree").html(data.data.replace(/\{program\}/g, "<?= $program ?>"));
                progress.done();
            },
            error:function(){
                $(".agree").html('拉取用户协议失败，请点击<a href="https://www.pescms.com/article/view/-1.html" target="_blank">https://www.pescms.com/article/view/-1.html</a>查阅用户协议')
                progress.done();
            }
        })

        var data = {
            id: 3,
            type: 1,
            version : '<?= $version ?>',
            sessionid : '<?= $this->session()->getId() ?>'
        };
        $.post('https://www.pescms.com/?g=Api&m=Statistics&a=action', data, function (data) {
        }, 'JSON')

        $('body').on('submit', '.am-form', function () {
            var d = dialog({
                title: '提示',
                content : '<div class="am-text-center"><i class="am-icon-spinner am-icon-pulse "></i> 安装进行中...</div>',
                width : '500',
                fixed: true,
                skin: 'install'
            });


            var formData = $(this).serialize();
            $.ajax({
                url: '',
                data: formData,
                type: 'POST',
                dataType: 'json',
                beforeSend : function(){
                    progress.start();
                    d.showModal();
                },
                success: function (data) {
                    console.log('这是安装请求的回调信息:')
                    console.log(data)
                    console.log('')

                    if(data.status == 0){
                        d.content('<div class="am-text-center"><i class="am-icon-close am-text-danger"></i> '+data.msg + '</div>');
                    }else if(data.status == 200){
                        $('.mange-url').attr('href', data.data)
                        var showManage = $('.pes-success').html();
                        d.content('<div class="am-text-center"><i class="am-icon-check am-text-success"></i> 安装完毕!</div>' + showManage);
                    }else{
                        d.content('<div class="am-text-center"><i class="am-icon-close am-text-danger"></i> 安装失败，未知原因！</div>');
                    }
                },
                complete : function(){
                    progress.done();
                },
                error: function (obj) {
                    console.log('下面是按照出错的调试信息:')
                    console.log(obj)
                    console.log("")

                    d.title("安装出错啦 :'(");
                    var responseText = obj.responseJSON == '' || obj.responseJSON == undefined ? obj.responseText : obj.responseJSON.msg
                    d.content("<p class='am-text-break'>Status Code: " + obj.status + " " + obj.statusText + "</p>" +
                        "<p class='am-text-break'>Response Text: " + responseText + "</p>" +
                        "<p>请访问<a href=\"https://document.pescms.com/article/1/385975176602320896.html\" target='_blank'>本链接</a>获取解决方案</p>" +
                        "<p>注意：请先检查程序根目录下是否存在STRICT_TRANS_TABLES.txt文件</p>"
                    );
                }
            })

            return false;
        })

        $('.i-do').on('click', function (){
            if($(this).prop('checked') == true){
                $('.am-btn-success').removeAttr('disabled')
                $('.install-tips').hide();
            }else{
                $('.am-btn-success').attr('disabled', 'disabled')
                $('.install-tips').show();
            }
        })

    })
</script>
</body>
</html>