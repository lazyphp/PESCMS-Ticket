<?php if (isset(\Core\Func\CoreFunc::session()->get('ticket')['user_id']) && \Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1): ?>

    <script>
        $(function () {
            var version = '<?= $system['version'] ?>';
            var timestamp = Date.parse(new Date());

            //获取本地存储
            var important = parseInt(localStorage.getItem('important'));
            var close_important = parseInt(localStorage.getItem('close_important'));
            var record_version = localStorage.getItem('version');
            var check_time = localStorage.getItem('check_time');

            //检查是否需要弹窗重要更新提示框
            if (important == 1 && close_important != 1 && record_version == version) {
                var alter_str = '<div class="am-alert am-alert-warning am-margin-0 am-text-sm" data-am-alert><button type="button" class="am-close close-important">&times;</button>' +
                    '当前系统有一个重要更新发布，点击 <a href="<?= $label->url(GROUP . '-Setting-upgrade') ?>" style="color:blue">这里</a> 查看' +
                    '</div>';
                $('header').before(alter_str);
            }

            /**
             * 判断本地存储的版本号与程序版本号是否一致
             * 判断上次检查更新时间记录是否大于1天
             */
            if (record_version != version && check_time <= timestamp) {
                $.getJSON(PESCMS_URL + '/patch/5/<?= $system['version'] ?>', function (data) {
                    if (data.status == 200) {
                        if (data.data.important == 1) {
                            localStorage.setItem('important', '1')
                        }
                        localStorage.setItem('version', version);
                        localStorage.removeItem('close_important')
                    }
                }).complete(function () {
                    localStorage.setItem('check_time', timestamp + 86400000);
                })
            }

            $(document).on('click', '.close-important', function () {
                localStorage.setItem('close_important', '1')
            })


            <?php if($system['help_document'] == 0): ?>
            $('header').before('<div class="pes-help-doc am-alert am-alert-postscript am-text-sm am-margin-0" data-am-alert><button type="button" class="close-f1 am-close">&times;</button><i class="am-icon-leanpub"></i> 按F1可以打开PESCMS Ticket帮助文档。 [点击右方&times;按钮可关闭本提示]</div>')
            $('html, body').animate({scrollTop: 0}, '500');
            $('.close-f1').on('click', function () {
                confirm('请谨记在客服端按F1可随时打开PESCMS Ticket帮助文档。');
                $.post('<?= $label->url('Ticket-Setting-recordTips') ?>', {
                    name: 'help_document',
                    method: 'PUT'
                }, function () {
                }, 'JSON')

            })
            <?php endif; ?>

            let pesDriver = document.querySelector('.pes-driver')

            if (pesDriver) {
                pesDriver.addEventListener('click', function () {
                    let fqaDialog = dialog({
                        id: 'fqa-dialog',
                        skin: 'fqa-dialog',
                        fixed: true,
                        align: 'left top',
                        content: $(".document .fqa")[0].outerHTML,
                        quickClose: true
                    })
                    fqaDialog.show(pesDriver)
                })

            }

        })
    </script>
    <div class="tips-manual" style="display: none">

        <div class="desc">
            <p>
                感谢您使用PESCMS Ticket。为了更好的使用本系统，请您花费几分钟时间阅读以下提示和根据指引提示操作。若您已经熟悉本系统，您可以点击“跳开教学”按钮关闭本提示。
            </p>
            <p class="am-margin-bottom-0">
                本项目若对您有所帮助，您可以给我们一个Star支持一下，非常感谢！<br/>
                <a href="https://gitee.com/fallBirds/PESCMS-Ticket" target="_blank">Gitee地址</a>
                <a href="https://github.com/lazyphp/PESCMS-Ticket" target="_blank" class="am-margin-left">Github地址</a>
            </p>
        </div>

        <div class="document">
            <div class="fqa">
                <h3 class="am-text-center">常见问题</h3>
                <ol>
                    <li>
                        <a href="https://document.pescms.com/article/3/296096861045915648.html" target="_blank">创建工单教程</a>
                    </li>
                    <li>
                        <a href="https://document.pescms.com/article/3/296557456849371136.html" target="_blank"><span class="am-badge am-badge-danger am-radius">常见</span>
                            访问工单进入404页面或工单不显示</a>
                    </li>
                    <li>
                        <a href="https://document.pescms.com/article/3/735782623820906496.html" target="_blank">打开任意工单都是同一张工单</a>
                    </li>
                    <li>
                        <a href="https://www.pescms.com/shop/detail/software/PESCMS%20TICKET%20%E5%AE%A2%E6%9C%8D%E5%B7%A5%E5%8D%95%E7%B3%BB%E7%BB%9F/5.html" target="_blank">开源版和授权版差异</a>
                    </li>
                </ol>
            </div>
            <div class="miniprogram">
                <h3>微信小程序Demo</h3>
                <img src="<?= DOCUMENT_ROOT ?>/Theme/assets/i/miniprogram.jpg">
                <small>打开微信客户端扫一扫即可查看效果</small>
            </div>
        </div>
        <div class="ad">
            <h3>PESCMS带货服务器：</h3>

            <p>
                <a href="https://www.aliyun.com/minisite/goods?userCode=dwpuyec3" target="_blank"><i class="am-icon-external-link"></i>
                    新用户购阿里云服务器享受7.5折优惠，老用户一样有优惠。</a>
            </p>
            <p>
                <a href="https://cloud.tencent.com/act/cps/redirect?redirect=2446&cps_key=593915c4c0306b57e399c4259553c150&from=console" target="_blank" style="color: #f56c6c"><i class="am-icon-external-link"></i>
                    &nbsp;PESCMS用户也可以考虑使用腾讯云，官方服务器部署在腾讯云上。</a>
            </p>
            <p>
                <a href="https://my.locvps.net/page.aspx?c=referral&u=15004" target="_blank" style="color: #b88408"><i class="am-icon-external-link"></i>
                    &nbsp;免备案服务器，老牌LocVPS，PESCMS官方早期使用的服务器。</a>
            </p>

        </div>

    </div>
<?php endif; ?>

<script>
    $(function () {
        /**
         * F1帮助文档
         */
        $(document).on('keydown', function () {
            var e = window.event;
            var code = e.charCode || e.keyCode;
            if (code == 112) {
                $.getJSON('<?= $label->url('Ticket-HelpDocument-find', ['help_controller' => GROUP . '-' . MODULE . '-' . ACTION, 'match' => GROUP . '-' . MODULE . '-:a']) ?>', function (res) {
                    try {
                        if (res.status == 200) {
                            window.open(res.data.help_document_link)
                        } else {
                            window.open('https://document.pescms.com/article/3.html')
                        }
                    } catch (e) {
                        window.open('https://document.pescms.com/article/3.html')
                    }
                })
                return false;
            }

        })

        /**
         * PESCMS软件存活统计
         * 本请求只记录软件使用者存活情况，不会将您的服务器信息发给PESCMS，请放心使用。
         * 本请求只会在每个月的第一次访问时记录，且仅记录当前使用者的浏览器信息发给PESCMS服务器。
         */

        var survivalDate = localStorage.getItem('survivalDate');

        var recordSurvival = function () {
            //这是基于前端ajax跨域请求，因此并不会将软件部署的服务器信息发给PESCMS。
            $.post(PESCMS_URL + '/?g=Api&m=Statistics&a=survival&method=POST', {id: '5'}, function () {
            }, 'JSON')
        }

        var month = new Date().getMonth() + 1;
        if (survivalDate == null) {
            localStorage.setItem('survivalDate', month);
        } else {
            if (survivalDate != month) {
                localStorage.setItem('survivalDate', month);
                recordSurvival();
            }
        }
    })

</script>

<?php $label->footerEvent() ?>

<?php if (MODULE !== 'Login' && \Core\Func\CoreFunc::session()->get('ticket')['user_suspension_button'] == 0): ?>
    <div class="amz-toolbar" id="amz-toolbar" style="">

        <?= (new \Core\Plugin\Plugin())->event('suspensionButton', NULL); ?>

        <a href="#top" title="回到顶部" class="am-icon-btn am-icon-arrow-up " id="amz-go-top" data-am-smooth-scroll=""></a>
        <?php if (MODULE == 'Ticket' && ACTION == 'handle'): ?>
            <a href="javascript:;" title="处理工单" class="pes-handleTicket am-icon-btn am-icon-edit"></a>
        <?php endif; ?>
        <a href="javascript:;" title="关闭浮窗" class="pes-close-amz-toolbar am-icon-btn am-icon-chain-broken"></a>

        <?php if (in_array(MODULE, ['Index', 'Ticket_model']) && ACTION == 'index' &&
            (isset(\Core\Func\CoreFunc::session()->get('ticket')['user_id']) && \Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1)
        ): ?>
            <a href="javascript:;" title="常见问题" class="pes-driver am-icon-btn am-icon-question-circle"></a>
        <?php endif; ?>

    </div>
<?php endif; ?>
</body>
</html>