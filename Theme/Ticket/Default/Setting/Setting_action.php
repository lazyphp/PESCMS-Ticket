<div class="admin-content am-padding am-padding-top-0" xmlns="http://www.w3.org/1999/html">

    <div class="am-cf">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
        </div>
    </div>
    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>

    <form class="am-form am-form-horizontal" action="<?= $url; ?>" method="post" data-am-validator>
        <input type="hidden" name="method" value="PUT" />
        <ul class="am-list am-list-static am-list-border am-text-sm">
            <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">基础信息</li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">网站URL</label>

                    <div class="am-u-sm-9">
                        <input name="domain" placeholder="网站URL" type="text" value="<?= $domain['value']; ?>" required="">

                        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                            <i class="am-icon-lightbulb-o"></i> 请填写正确的域名，以便工单能够正确地提交！
                        </div>
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">跨域域名</label>

                    <div class="am-u-sm-9">
                        <textarea rows="5" name="crossdomain"><?= empty($crossdomain) ? '' : implode("\n", $crossdomain); ?></textarea>

                        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
                            <i class="am-icon-lightbulb-o"></i> 默认情况下，所有跨域请求可以正常提交工单，若需要设置跨域白名单，请一行一个域名的形式填写
                        </div>
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">开启首页</label>

                    <div class="am-u-sm-9">
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
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>

            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">全站通知发送方式</label>

                    <div class="am-u-sm-9">
                        <label class="am-radio-inline">
                            <input type="radio" value="1" name="notice_way" required="" <?= $notice_way['value'] == '1' ? 'checked="checked"' : '' ?>> 被动触发
                        </label>
                        <label class="am-radio-inline">
                            <input type="radio" value="2" name="notice_way" required="" <?= $notice_way['value'] == '2' ? 'checked="checked"' : '' ?>> 定时器触发
                        </label>
                        <label class="am-radio-inline">
                            <input type="radio" value="3" name="notice_way" required="" <?= $notice_way['value'] == '3' ? 'checked="checked"' : '' ?>> 两者兼有
                        </label>
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>

            <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">任务状态</li>
            <?php foreach (range('0', '3') as $iteration): ?>
                <li>
                    <div class="am-g">
                        <label for="" class="am-u-sm-2 am-form-label">工单状态颜色与名称</label>

                        <div class="am-u-sm-1">
                            <input class="custom" name="customcolor[]" placeholder="" type="text" value="<?= $customstatus[$iteration]['color']; ?>" required="">
                        </div>
                        <div class="am-u-sm-8">
                            <input name="customstatus[]" placeholder="" type="text" value="<?= $customstatus[$iteration]['name']; ?>" required="">
                        </div>
                        <div class="am-u-sm-1">
                            <span class="am-badge am-round am-badge-danger">必填</span>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

            <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">邮件通知</li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">邮箱账号</label>

                    <div class="am-u-sm-9">
                        <input name="mail[account]" placeholder="" type="text" value="<?= $mail['account']; ?>" required="">
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">邮箱密码</label>

                    <div class="am-u-sm-9">
                        <input name="mail[passwd]" placeholder="" type="password" value="<?= $mail['passwd']; ?>" required="">
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">SMTP地址</label>

                    <div class="am-u-sm-9">
                        <input name="mail[address]" placeholder="" type="text" value="<?= $mail['address']; ?>" required="">
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="am-g">
                    <label for="" class="am-u-sm-2 am-form-label">SMTP端口</label>

                    <div class="am-u-sm-9">
                        <input name="mail[port]" placeholder="" type="text" value="<?= $mail['port']; ?>" required="">
                    </div>
                    <div class="am-u-sm-1">
                        <span class="am-badge am-round am-badge-danger">必填</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="am-g">
                    <div class="am-u-sm-10 am-u-sm-offset-2">
                        <button type="submit" id="btn-submit" class="am-btn am-btn-primary am-btn-xs" data-am-loading="{spinner: 'circle-o-notch', loadingText: '提交中...', resetText: '再次提交'}">保存设置</button>
                    </div>
                </div>
            </li>
        </ul>
    </form>
</div>
<script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/spectrum.js"></script>
<link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/spectrum.css"/>
<script>
    $(".custom").spectrum({
        preferredFormat: "hex",
        showInput: true
    });
</script>
