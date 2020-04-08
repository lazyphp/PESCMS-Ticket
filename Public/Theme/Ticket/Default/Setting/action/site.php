<div class="am-panel am-panel-default">
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">授权码<i class="am-text-danger">*</i></label>
                    <input name="authorize" placeholder="请输入授权码" type="text" value="<?= $authorize['value']; ?>">
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 当前域名：<?= empty($_SERVER['HTTP_HOST']) ? '获取当前域名失败' : $_SERVER['HTTP_HOST'] ?> ;  授权购买请访问:《<a href="https://www.pescms.com/Page/Authorization.html" target="_blank" tyle="color:#0e90d2 ">商业授权</a>》
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group" disabled="disabled">
                    <label class="am-block">网站名称<i class="am-text-danger">*</i></label>
                    <input name="siteTitle" placeholder="网站名称" type="text"
                           value="<?= $siteTitle['value']; ?>" <?= $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买使用授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">网站LOGO<i class="am-text-danger">*</i></label>
                    <div data-am-webuploader-simple="{id:'siteLogo', name:'siteLogo',pick:{id:'#siteLogo'}, content:'<?= $siteLogo['value']; ?>', type:'thumb'}"></div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">网站联系方式</label>
                    <textarea rows="5"
                              name="siteContact" <?= $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买使用授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>><?= $siteContact['value']; ?></textarea>
                </div>
            </div>
        </div>

        <?php if ($authorize_type == 1): ?>
            <hr class="am-margin-top-0 am-divider-default"/>
            <div class="am-g am-g-collapse">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <div class="am-form-group" disabled="disabled">
                        <label class="am-block">网站Keywords | SEO设置</label>
                        <input name="siteKeywords" placeholder="网站Keywords" type="text"
                               value="<?= $siteKeywords['value']; ?>" <?= $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买域名授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>>
                    </div>
                </div>
            </div>

            <div class="am-g am-g-collapse">
                <div class="am-u-sm-12 am-u-sm-centered">
                    <div class="am-form-group">
                        <label class="am-block">网站Description | SEO设置</label>
                        <textarea rows="5"
                                  name="siteDescription" <?= $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买域名授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>><?= $siteDescription['value']; ?></textarea>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">页脚内容</label>
                    <textarea rows="10"
                              name="pescmsIntroduce" <?= $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买使用授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>><?= $pescmsIntroduce['value']; ?></textarea>
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 网站联系方式和页脚内容的设置，可以阅读这里查看教程:《<a
                                href="https://www.pescms.com/d/v/1.2.7/22/149.html" target="_blank" style="color:#0e90d2 ">自定义网站设置</a>》
                    </div>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">自定义样式</label>
                    <textarea rows="10"
                              name="siteStyle" <?= $license == 1 ? '' : 'readonly="readonly" data-am-popover="{content: \'需求购买使用授权方解除限制\', trigger: \'hover\', theme:\'sm\'}"' ?>><?= $siteStyle['value']; ?></textarea>
                </div>
            </div>
        </div>

        <hr class="am-margin-top-0 am-divider-default"/>
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">网站统计代码</label>
                    <textarea rows="10" name="siteTongji" ><?= $siteTongji['value']; ?></textarea>
                </div>
            </div>
        </div>

    </div>
</div>