<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default" id="setting-panel">
        <div class="am-panel-bd am-padding-bottom-0">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
        </div>
        <form class="am-form am-form-horizontal ajax-submit" action="<?= $url; ?>" method="post" data-am-validator>
            <input type="hidden" name="method" value="PUT"/>

            <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
                <ul class="am-tabs-nav am-nav am-nav-tabs am-padding-left-sm">
                    <li class="am-active"><a href="#tab1">基础信息</a></li>
                    <li><a href="#tab2">通知设置</a></li>
                </ul>

                <div class="am-tabs-bd">
                    <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                        <?php include 'action/base.php';?>
                        <?php include 'action/ticket.php';?>
                    </div>
                    <div class="am-tab-panel am-fade" id="tab2">
                        <?php include 'action/notice.php';?>

                        <?php include 'action/email.php';?>

                        <?php include 'action/sms.php';?>

                        <?php include 'action/weixin.php';?>
                    </div>
                </div>
            </div>

            <div class="am-g am-g-collapse am-margin-bottom am-padding-sm">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <button type="submit" class="am-btn am-btn-primary am-btn-xs" >提交保存</button>
                </div>
            </div>

        </form>
    </div>
</div>
<script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.js"></script>
<link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/spectrum.css"/>
<script>
    $(".custom").spectrum({
        preferredFormat: "hex",
        showInput: true
    });
	$(function(){
		$('.email-test').on('click', function(){
            var email = $('.test_email').val();
            var url = $(this).attr('data')
            if(email == ''){
                return false;
            }
            window.open(url + '&email='+email);
            return false;
        })

        $('.send-test').on('click', function(){
            var parent = $(this).parent()
            var account = parent.find('.test_account').val();
            var template = parent.find('select[name=template]').val();
            var url = $(this).attr('data')
            if(account == '' || template == '' ){
                return false;
            }
            window.open(url + '&account='+account+'&template='+template);
            return false;
        })

        var authorizeKey = $('input[name=authorize]').val()

        $.getJSON('/?g=Ticket&m=Setting&a=authorize', {key:authorizeKey}, function(data){
            if(data.status == 200){
                $('input[name=siteTitle], textarea[name=siteContact], textarea[name=pescmsIntroduce]').removeAttr('readonly').unbind('mouseenter mouseleave')
            }
        })

	})
</script>
