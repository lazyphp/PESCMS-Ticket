<div class="am-g">
    <div class="am-u-sm-11 am-u-sm-centered">
        <div class="am-panel am-panel-default">
            <div class="am-panel-bd member-center">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-lg-2">
                        <img class="am-img-thumbnail am-radius" alt="logo" src="<?= $system['siteLogo'] ?>" />
                        <hr>
                        <h3>我常提交的工单</h3>
                        <?php if(empty($oftenTicket)): ?>
                            <span class="am-badge">暂无记录</span>
                        <?php else: ?>
                            <?php foreach($oftenTicket as $key => $value): ?>
                                <a href="<?= $label->url('Category-ticket', ['number' => $value['ticket_model_number']]) ?>" class="am-badge am-badge-primary"><?= $value['ticket_model_name'] ?></a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="am-u-sm-12 am-u-lg-10">
                        <div class="am-margin-bottom">
                            <h2 class="am-inline am-text-xl "><?= $this->session()->get('member')['member_name'] ?></h2> 先生/女士
                            <small class="am-text-xs am-margin-left" style="color: #ccc"><i class="am-icon-bookmark-o"></i> 欢迎您的到来</small>
                        </div>

                        <div class="am-panel am-panel-default">
                            <div class="am-panel-bd am-padding-xs">
                                <div class="am-cf">
                                    <h3 class="am-margin-0 am-fl"><i class="am-icon-yelp"></i> 最近工单</h3>
                                    <a href="<?= $label->url('Member-ticket') ?>" class="am-fr">更多&gt;&gt;</a>
                                </div>
                            </div>
                            <ul class="am-list am-list-static">
                                <?php if(empty($list)): ?>
                                    <li>
                                        您还没有提交过工单。
                                    </li>
                                <?php else: ?>
                                    <?php foreach($list as $key => $value): ?>
                                    <li>
                                        <a href="<?= $label->url('View-ticket', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]) ?>" class="am-padding-0"><?= $value['ticket_title'] ?></a>
                                    </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </ul>
                        </div>


                        <div class="am-tabs pes-tabs am-margin-top-lg" data-am-tabs>
                            <ul class="am-tabs-nav am-nav am-nav-tabs">
                                <li class="am-active"><a href="#tab1"><i class="am-icon-user"></i> 个人信息</a></li>
                                <li><a href="#tab2"><i class="am-icon-refresh"></i> 更新信息</a></li>
                            </ul>

                            <div class="am-tabs-bd">
                                <div class="am-tab-panel am-fade am-in am-active" id="tab1">
                                    <form class="am-form ajax-submit" action="<?= $label->url('Member-changeEmail') ?>" method="post" data-am-validator>
                                    <?= $label->token(); ?>
                                    <input type="hidden" name="method" value="PUT">
                                    <table class="am-table am-remove-border member-info">
                                        <tr>
                                            <th>邮箱地址</th>
                                            <td>
                                                <?= $member['member_email'] ?><a href="javascript:;" class="change-email">[更改]</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>手机号码</th>
                                            <td><?= $member['member_phone'] ?></td>
                                        </tr>
                                        <tr class="change-email am-hide">
                                            <td colspan="2">
                                                <hr>
                                            </td>
                                        </tr>
                                        <tr class="change-email am-hide">
                                            <th class="am-text-middle">更改邮箱地址</th>
                                            <td class="am-text-middle">
                                                <input type="email" name="email" class="am-input-sm" placeholder="邮箱地址" value="" required="required">
                                            </td>
                                        </tr>
                                        <tr class="change-email am-hide">
                                            <td class="am-text-middle am-text-center" colspan="2">
                                                <input type="submit" class="am-btn am-btn-danger am-btn-sm " value="确认更改">
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
                                </div>
                                <div class="am-tab-panel am-fade" id="tab2">
                                    <form class="am-form ajax-submit"  method="post" data-am-validator>
                                        <input type="hidden" name="method" value="PUT">
                                        <?= $label->token() ?>
                                        <table class="am-table am-remove-border">
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
                                                        <input type="password" name="oldpassword" placeholder="旧密码">
                                                    </div>
                                                    <div class="am-form-group">
                                                        <div class="am-margin-bottom-xs">新密码:</div>
                                                        <input type="password" name="password" placeholder="新密码">
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