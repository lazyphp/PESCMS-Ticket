<div class="am-g">
    <div class="am-u-sm-12 am-u-sm-centered">
        <div class="am-g">
            <div class="am-u-sm-12 am-u-lg-6">
                <div class="am-panel am-panel-default">
                    <div class="am-panel-bd am-padding-xs">
                        <h3 class="am-margin-0">帐号信息</h3>
                    </div>
                    <table class="am-table am-text-left">
                        <tr>
                            <td style="width: 7.8rem">
                                <p>帐号邮箱</p>
                                <p>账号昵称</p>
                                <p>手机号码</p>
                            </td>
                            <td>
                                <p>
                                    <?= $member['member_email'] ?>
                                    <a href="javascript:;" class="change-email">[更改]</a>
                                </p>
                                <p><?= $member['member_name'] ?></p>
                                <p><?= $member['member_phone'] ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="change-email am-panel am-panel-default am-hide">
                    <div class="am-panel-bd am-padding-xs">
                        <h3 class="am-margin-0">更改邮箱地址</h3>
                    </div>
                    <form class="am-form ajax-submit" action="<?= $label->url('Member-changeEmail') ?>" method="post" data-am-validator>
                        <input type="hidden" name="method" value="PUT">
                        <?= $label->token() ?>
                        <table class="am-table">
                            <tr>
                                <td>
                                    <div class="am-form-group am-margin-bottom-0">
                                        <div class="am-margin-bottom-xs">邮箱地址:</div>
                                        <input type="email" name="email" placeholder="邮箱地址" value="" required="required">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" class="am-btn am-btn-danger am-btn-block am-btn-sm " value="确认更改">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-lg-6">
                <div class="am-panel am-panel-default">
                    <div class="am-panel-bd am-padding-xs">
                        <h3 class="am-margin-0">更新信息</h3>
                    </div>
                    <form class="am-form ajax-submit" id="login-enterplorer" method="post" data-am-validator>
                        <input type="hidden" name="method" value="PUT">
                        <?= $label->token() ?>
                        <table class="am-table">
                            <tr>
                                <td>
                                    <div class="am-form-group am-margin-bottom-0">
                                        <div class="am-margin-bottom-xs">手机号码:</div>
                                        <input type="text" name="phone" placeholder="手机号码" value="<?= $member['member_phone'] ?>" required="required" maxlength="11">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="am-form-group am-margin-bottom-0">
                                        <div class="am-margin-bottom-xs">用户昵称:</div>
                                        <input type="text" name="name" placeholder="用户昵称" value="<?= $member['member_name'] ?>" required="required" maxlength="10">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="am-form-group">
                                        <div class="am-margin-bottom-xs">旧密码:</div>
                                        <input type="password" name="oldpassword" placeholder="旧密码" >
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-margin-bottom-xs">新密码:</div>
                                        <input type="password" name="password" placeholder="新密码" >
                                    </div>
                                    <div class="am-form-group">
                                        <div class="am-margin-bottom-xs">确认新密码:</div>
                                        <input type="password" name="repassword" placeholder="确认新密码">
                                    </div>
                                    <input type="submit" class="am-btn am-btn-success am-btn-block am-btn-sm " value="更新信息">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.change-email').on('click', function(){
            $('.change-email').removeClass('am-hide')
        })
    })
</script>