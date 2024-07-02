<div class="am-panel am-panel-default">
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">点击版本号检查更新<i class="am-text-danger">*</i></label>
                    <a class="am-btn am-btn-sm am-btn-warning" href="<?= $label->url(GROUP . '-Setting-upgrade') ?>"><i class="am-icon-refresh"></i> <?= $version['value'] ?>
                    </a>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">网站URL<i class="am-text-danger">*</i></label>
                    <input name="domain" placeholder="网站URL" type="text" value="<?= $domain['value']; ?>" required="">
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 请填写正确的域名，以便工单能够正确地提交！域名需要带http或者https，按照服务器实际情况填写。
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">域名白名单</label>
                    <textarea rows="5" name="crossdomain"><?= empty($crossdomain) ? '' : implode("\n", $crossdomain); ?></textarea>
                    <div class="pes-alert pes-alert-error am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 需要填写白名单才可以启用跨域工单！域名白名单，请一行一个域名的形式填写。开启跨域工单后，除了填写跨域的域名，还需要填写当前程序所在的网站URL，否则站内工单将无法提交！！
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
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
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 若允许所有人通过首页填写工单查询，那么请开启。反之用户直接访问首页名将报404错误。
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">是否启用API接口<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="openapi" required="" <?= $openapi['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="openapi" required="" <?= $openapi['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 如果你不需要使用小程序，请不要开启API接口。
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">是否开启工单[已读]状态标识<i class="am-text-danger">*</i></label>
                    <label class="am-radio-inline">
                        <input type="radio" value="1" name="ticket_read" required="" <?= $ticket_read['value'] == '1' ? 'checked="checked"' : '' ?>> 开启
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" value="0" name="ticket_read" required="" <?= $ticket_read['value'] == '0' ? 'checked="checked"' : '' ?>> 关闭
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 本功能作用于工单详细页，客户是否可以知道本工单客服已查阅。[客服端默认即开启已读状态查询]
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">登录验证码</label>
                    <label class="am-checkbox-inline">
                        <input type="checkbox" value="1" name="login_verify[]"  <?= isset($login_verify['0']) && $login_verify['0'] == '1' ? 'checked="checked"' : '' ?>> 前台开启
                    </label>
                    <label class="am-checkbox-inline">
                        <input type="checkbox" value="2" name="login_verify[]"  <?= isset($login_verify['1']) && $login_verify['1'] == '2' ? 'checked="checked"' : '' ?>> 后台开启
                    </label>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 前后台用户登录是否需要验证码
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">验证码长度<i class="am-text-danger">*</i></label>
                    <input name="verifyLength" placeholder="验证码长度" type="number" value="<?= $verifyLength['value']; ?>" required="">
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">上传图片格式</label>
                    <textarea name="upload_img"><?= implode(',', $upload_img) ?></textarea>

                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 填写您要支持的图片格式，英文逗号分隔。
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">上传文件格式</label>
                    <textarea name="upload_file"><?= implode(',', $upload_file) ?></textarea>

                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 填写您要支持的文件格式，英文逗号分隔。.php, .html文件无法上传，需要上传此后缀文件请更改后缀。
                    </div>
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">上传大小<i class="am-text-danger">*</i></label>
                    <div class="am-input-group am-u-lg-2 am-u-sm-12">
                        <input name="max_upload_size" placeholder="1" type="number" value="<?= $max_upload_size['value']; ?>" class="am-form-field am-text-right" required="required">
                        <span class="am-input-group-label">MB</span>
                    </div>
                </div>
                <div class="pes-alert pes-alert-info am-text-xs " >
                    当前PHP.ini配置最大上传容量: <?= ini_get('max_file_uploads') ?>M
                </div>
            </div>
        </div>

    </div>
</div>