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

                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd">基础信息</div>
                    <div class="am-panel-bd">
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">检查更新<i class="am-text-danger">*</i></label>
                                    <a class="am-btn am-btn-sm am-btn-warning" href="<?= $label->url(GROUP . '-Setting-upgrade') ?>"><i class="am-icon-refresh"></i> <?= $version['value'] ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">网站URL<i class="am-text-danger">*</i></label>
                                    <input name="domain" placeholder="网站URL" type="text" value="<?= $domain['value']; ?>" required="">
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 请填写正确的域名，以便工单能够正确地提交！域名需要带http或者https，按照服务器实际情况填写。
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">域名白名单<i class="am-text-danger">*</i></label>
                                    <textarea rows="5" name="crossdomain"><?= empty($crossdomain) ? '' : implode("\n", $crossdomain); ?></textarea>
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 默认情况下，所有请求可以正常提交工单，若指定域名白名单，请一行一个域名的形式填写
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">开启首页<i class="am-text-danger">*</i></label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="1" name="openindex" required="" <?= $openindex['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="0" name="openindex" required="" <?= $openindex['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                                    </label>
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 若允许所有人通过首页填写工单查询，那么请开启。反之用户直接访问首页名将报404错误。
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">开启站内工单<i class="am-text-danger">*</i></label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="1" name="interior_ticket" required="" <?= $interior_ticket['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="0" name="interior_ticket" required="" <?= $interior_ticket['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                                    </label>
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 若允许在站内提交工单请开启，反之禁止。
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">开启注册和登录<i class="am-text-danger">*</i></label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="1" name="open_register" required="" <?= $open_register['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="0" name="open_register" required="" <?= $open_register['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                                    </label>
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 开启则用户可以进行登录和注册，站内提交工单将自动填充必要的信息。
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">全站通知发送方式<i class="am-text-danger">*</i></label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="1" name="notice_way" required="" <?= $notice_way['value'] == '1' ? 'checked="checked"' : '' ?>>
                                        被动触发
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="2" name="notice_way" required="" <?= $notice_way['value'] == '2' ? 'checked="checked"' : '' ?>>
                                        定时器触发
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="3" name="notice_way" required="" <?= $notice_way['value'] == '3' ? 'checked="checked"' : '' ?>>
                                        两者兼有
                                    </label>
                                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                        <i class="am-icon-lightbulb-o"></i> 请填写正确的域名，以便工单能够正确地提交！
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd">工单状态</div>
                    <div class="am-panel-bd am-padding-0">
                        <table class="am-table am-table-bordered am-margin-bottom-0 am-table-centered">
                            <?php foreach (range('0', '3') as $iteration): ?>
                            <tr>
                                <td class="am-text-middle">工单状态颜色与名称</td>
                                <td class="am-text-middle">
                                    <input type="text" class="custom" name="customcolor[]" placeholder=""  value="<?= $customstatus[$iteration]['color']; ?>" required="">
                                </td>
                                <td class="am-text-middle">
                                    <input  type="text"name="customstatus[]" placeholder=""  value="<?= $customstatus[$iteration]['name']; ?>" required="">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd">邮件通知</div>
                    <div class="am-panel-bd">
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">邮箱账号<i class="am-text-danger">*</i></label>
                                    <input name="mail[account]" placeholder="" type="text" value="<?= $mail['account']; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">邮箱密码<i class="am-text-danger">*</i></label>
                                    <input name="mail[passwd]" placeholder="" type="password" value="<?= $mail['passwd']; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">SMTP地址<i class="am-text-danger">*</i></label>
                                    <input name="mail[address]" placeholder="" type="text" value="<?= $mail['address']; ?>" required="">
	                                <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
		                                <i class="am-icon-lightbulb-o"></i> 不需要添加http://或者https://前缀。常见的邮件服务商smtp地址：<a href="https://www.pescms.com/d/v/1.0/10/56.html#%E5%B8%B8%E8%A7%81%E9%82%AE%E4%BB%B6%E6%9C%8D%E5%8A%A1%E5%95%86%E5%9C%B0%E5%9D%80" target="_blank" style="color: blue">查看</a>
	                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">SMTP端口<i class="am-text-danger">*</i></label>
                                    <input name="mail[port]" placeholder="" type="text" value="<?= $mail['port']; ?>" required="">
	                                <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
		                                <i class="am-icon-lightbulb-o"></i> 一般填写25端口，加密端口请填写587。具体发送端口，请参考您的邮件服务提供商文档。
	                                </div>
                                </div>
                            </div>
                        </div>

	                    <div class="am-g am-g-collapse">
		                    <div class="am-u-sm-12 am-u-sm-centered">
			                    <div class="am-form-group">
				                    <label class="am-block">邮件发送名称<i class="am-text-danger">*</i></label>
				                    <input name="mail[formname]" placeholder="" type="text" value="<?= empty($mail['formname']) ? 'system' : $mail['formname']; ?>" required="">
				                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
					                    <i class="am-icon-lightbulb-o"></i> 用户查收邮件时看到的发送人名称，默认为system。
				                    </div>
			                    </div>
		                    </div>
	                    </div>

	                    <div class="am-g am-g-collapse">
		                    <div class="am-u-sm-12 am-u-sm-centered">
			                    <div class="am-form-group">
				                    <label class="am-block">邮件发送测试</label>
				                    <input type="email" class="test_email am-inline" style="width: 20%">
				                    <a href="javascript:;" data="<?= $label->url(GROUP.'-Setting-emailTest') ?>" type="submit" class="am-inline am-btn am-btn-warning email-test" >发送测试邮件</a>
				                    <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
					                    <i class="am-icon-lightbulb-o"></i> 请先保存邮件smtp的设置，再进行邮件发送测试。
				                    </div>
			                    </div>
		                    </div>
	                    </div>

                    </div>
                </div>

                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd">微信设置</div>
                    <div class="am-panel-bd">
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">appID<i class="am-text-danger">*</i></label>
                                    <input name="weixin_api[appID]" placeholder="" type="text" value="<?= $weixin_api['appID']; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">appsecret<i class="am-text-danger">*</i></label>
                                    <input name="weixin_api[appsecret]" placeholder="" type="text" value="<?= $weixin_api['appsecret']; ?>" required="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd">企业微信设置</div>
                    <div class="am-panel-bd">

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">企业ID<i class="am-text-danger">*</i></label>
                                    <input name="weixinWork_api[corpid]" placeholder="" type="text" value="<?= $weixinWork_api['corpid']; ?>" required="">
                                </div>
                                <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                                    <i class="am-icon-lightbulb-o"></i> 登录企业微信WEB管理端，在 我的企业 - 企业信息，最下方可以看到企业ID。将此ID信息填入。
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">AgentId<i class="am-text-danger">*</i></label>
                                    <input name="weixinWork_api[AgentId]" placeholder="" type="text" value="<?= $weixinWork_api['AgentId']; ?>" required="">
                                </div>
                            </div>
                        </div>

                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-12 am-u-sm-centered">
                                <div class="am-form-group">
                                    <label class="am-block">Secret<i class="am-text-danger">*</i></label>
                                    <input name="weixinWork_api[Secret]" placeholder="" type="text" value="<?= $weixinWork_api['Secret']; ?>" required="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

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
