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
                            <label class="am-block">登录帐号<i class="am-text-danger">*</i></label>
                            <input class="form-text-input input-leng3" name="account" placeholder="会员帐号" type="text" value="<?= $user_account ?>" required=""></div>
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

                <div class="am-g am-g-collapse am-margin-bottom">
                    <div class="am-u-sm-12 am-u-sm-centered">
                        <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>