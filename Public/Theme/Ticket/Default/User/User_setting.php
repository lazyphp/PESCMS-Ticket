<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed am-no-layout">
            <form class="am-form am-form-horizontal ajax-submit" action="" method="post" data-am-validator>
                <?= $label->token(); ?>
                <input type="hidden" name="method" value="PUT">

                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">邮箱地址<i class="am-text-danger">*</i></label>
                            <input class="form-text-input input-leng3" name="mail" placeholder="邮箱地址" type="text"  value="<?= $user_mail ?>" required=""></div>
                    </div>
                </div>
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">昵称<i class="am-text-danger">*</i></label>
                            <input class="form-text-input input-leng3" name="name" placeholder="会员名称" type="text" value="<?= $user_name ?>" required=""></div>
                    </div>
                </div>
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">企业微信ID</label>
                            <input class="form-text-input input-leng3" name="weixinWork" placeholder="企业微信ID" type="text" value="<?= $user_weixinWork ?>"></div>
                    </div>
                </div>
                <hr data-am-widget="divider" style="" class="am-divider am-divider-default am-margin-top-xs" />
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">登录账号<i class="am-text-danger">*</i></label>
                            <input class="form-text-input input-leng3" name="account" placeholder="会员账号" type="text" value="<?= $user_account ?>" required=""></div>
                    </div>
                </div>
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">新密码</label>
                            <input class="form-text-input input-leng3" name="password" placeholder="" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">确认新密码</label>
                            <input class="form-text-input input-leng3" name="repassword" placeholder="" type="text" value="">
                        </div>
                    </div>
                </div>

                <hr data-am-widget="divider" style="" class="am-divider am-divider-default am-margin-top-xs" />
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">我的状态<i class="am-text-danger">*</i></label>
                            <label class="form-radio-label am-radio-inline">
                                <input class="form-radio" type="radio" name="vacation" value="0" required="" <?= $user_vacation == 0 ? 'checked="checked"' : '' ?>>
                                <span>工作</span>
                            </label>
                            <label class="form-radio-label am-radio-inline">
                                <input class="form-radio" type="radio" name="vacation" value="1" required="" <?= $user_vacation == 1 ? 'checked="checked"' : '' ?>><span>休假</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="am-g am-g-collapse">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <div class="am-form-group">
                            <label class="am-block">点击浏览器通知测试</label>
                            <a href="javascript:;" class="am-btn am-btn-warning am-btn-xs pes-notice-test"><i class="am-icon-bell"></i></a>
                            <div class="pes-alert pes-alert-info am-text-xs ">
                                <i class="am-icon-lightbulb-o"></i> 点击上面图标可以测试浏览器通知功能是否正常工作。需要注意的是，当前域名需要带有https://才可工作。
                            </div>
                        </div>

                    </div>
                </div>

                <div class="am-g am-g-collapse am-margin-bottom">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function () {

    $('.pes-notice-test').on('click', function () {
        try{
            Notification.requestPermission( function(status) {

                if(status == 'granted'){
                    var n = new Notification("工单系统浏览器通知测试", {
                        body: "本条消息为测试内容。",
                        icon: SITE_URL + SITE_LOGO
                    }); // 显示通知

                    n.onclick = function () {
                        alert('您点击了本次消息，点确认后本页面将被刷新');
                        window.location.reload();
                    }
                }else{
                    alert('当前您还没有允许浏览器授权本域名通知消息，请允许后再测试。')
                }


            });
        }catch (e) {
            alert('当前浏览器不支持通知消息')
        }
    })


})
</script>