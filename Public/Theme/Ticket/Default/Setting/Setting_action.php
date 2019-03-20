<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
            <form class="am-form am-form-horizontal ajax-submit" action="<?= $url; ?>" method="post" data-am-validator>
                <input type="hidden" name="method" value="PUT"/>

                <?php include 'action/base.php';?>

                <?php include 'action/ticket.php';?>

                <?php include 'action/email.php';?>

                <?php include 'action/sms.php';?>

                <?php include 'action/weixin.php';?>

                <div class="am-g am-g-collapse am-margin-bottom">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <button type="submit" class="am-btn am-btn-primary am-btn-xs" >提交保存</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.js"></script>
<link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Themec/Theme/assets/css/spectrum.css"/>
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
	})
</script>
