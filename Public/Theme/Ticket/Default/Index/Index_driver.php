<?php if (isset(\Core\Func\CoreFunc::session()->get('ticket')['user_id']) && \Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1): ?>

    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/driver.css?v=<?= $resources ?>">
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/driver.js?v=<?= $resources ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let tipsManualStatus = parseInt('<?= $system['tipsManual'] ?>');

            const driver = window.driver.js.driver;

            let tipsElement = $('.tips-manual')[0].cloneNode(true);
            tipsElement.style.display = 'block';


            const driverObj = driver({
                nextBtnText: '下一步',
                prevBtnText: '上一步',
                doneBtnText: '完成',
                progressText: '{{current}} / {{total}}',
                showProgress: true,
                allowClose: false,
                steps: [
                    
                    {
                        popover: {
                            title: '欢迎使用PESCMS Ticket',
                            description: tipsElement.outerHTML,
                        }
                    },
                    {
                        element: '.pes-help-doc',
                        popover: {
                            description: '如果您使用PT软件遇到疑问，可以按F1查看我们的软件帮助文档。大部分文档在文档中都可以找到答案。',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    {
                        element: '.pes-ad-admin-only',
                        popover: {
                            description: '仪表盘右侧栏目仅超级管理员账号可见。您可以根据自己的业务需求，选择安装合适的应用插件或者模板主题。同时可以查阅PT软件最新的咨询。',
                            side: "left",
                            align: 'start',
                            onNextClick: () => {
                                handleTicketMenu('moveNext');
                            },
                        }
                    },

                    {
                        element: $('#ticket-topbar-collapse .am-topbar-nav>li').eq(2).find('>ul')[0],
                        popover: {
                            description: '在开始使用工单系统前，您需要先完成工单分类和工单模型的创建，具体教学指引我们将在您进行操作时再次进行指引。',
                            side: "left",
                            align: 'start',
                        }
                    },

                    {
                        element: '.pes-driver',
                        popover: {
                            description: '在仪表盘和工单模型您可以点击问号，唤出常见问题列表。此按钮仅超级管理员可见。',
                            side: "bottom",
                            align: 'start',
                            onPrevClick:() => {
                                handleTicketMenu('movePrevious');
                            }
                        }
                    },
                    {
                        popover: {
                            description: '至此，您已经对PT系统有了初步的了解。我们将会在后续一些地方继续指引您。<br/>后续若您使用过程中有任何疑问，可以随时联系我们。'+

                            '<div class="am-margin-top-sm">推荐登录问答中心反馈问题：<a href="https://forum.pescms.com/" target="_blank">https://forum.pescms.com/</a></div>'+

                            '<div class="am-margin-top-sm">或者加入官方QQ群：<br/>PESCMS官方QQ 1群：451828934 <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=70b9d382c5751b7b64117191a71d083fbab885f1fb7c009f0dc427851300be3a"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS官方1群" title="PESCMS官方1群"></a> <br/> PESCMS官方QQ 2群：496804032 <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=5HqmNLN"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS官方2群" title="PESCMS官方2群"></a></div>',
                            side: "bottom",
                            align: 'start',
                        }
                    }
                    
                ],

                onDestroyStarted: () => {
                    if (!driverObj.hasNextStep() || confirm("确认要跳开新手教学吗?")) {
                        driverObj.destroy();
                    }
                },
                onPopoverRender: (popover, {config, state}) => {
                    const firstButton = document.createElement("button");
                    firstButton.innerText = "跳开教学";

                    popover.footerButtons.prepend(firstButton);

                    firstButton.addEventListener("click", () => {
                        driverObj.destroy();
                    });
                },

                onDestroyed: () => {

                    $('#ticket-topbar-collapse .am-topbar-nav>li').eq(2).find('>ul').hide();

                    $.post('<?= $label->url('Ticket-Setting-recordTips') ?>', {
                        name: 'tipsManual',
                        method: 'PUT'
                    }, function () {
                    }, 'JSON')
                }

            });

            if (tipsManualStatus == 0) {
                driverObj.drive();
            }

            // 添加处理菜单的通用函数
            function handleTicketMenu(moveAction) {
                let ticketMenu = $('#ticket-topbar-collapse .am-topbar-nav>li').eq(2).find('>ul');
                ticketMenu.show();
                driverObj[moveAction]();
                ticketMenu.removeClass('driver-active-element');
            }

        });

    </script>
<?php endif; ?>