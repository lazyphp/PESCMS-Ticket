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
                                let ticketMenu = $('#ticket-topbar-collapse .am-topbar-nav>li').eq(2).find('>ul');
                                ticketMenu.show();
                                driverObj.moveNext();
                                ticketMenu.removeClass('driver-active-element')
                            },
                        }
                    },

                    {
                        element: $('#ticket-topbar-collapse .am-topbar-nav>li').eq(2).find('>ul')[0],
                        popover: {
                            description: '在开始使用工单系统前，您需要先完成工单分类和工单模型的创建，具体教学指引我们将在您进行操作时再次进行指引。',
                            side: "left",
                            align: 'start',
                            onNextClick: () => {
                                $('#ticket-topbar-collapse .am-topbar-nav>li').eq(2).find('>ul').hide();
                                driverObj.moveNext();
                            }
                        }
                    },

                    {
                        element: '.pes-driver',
                        popover: {
                            description: '在仪表盘和工单模型您可以点击问号，唤出常见问题列表。此按钮仅超级管理员可见。',
                            side: "bottom",
                            align: 'start'
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

        });

    </script>
<?php endif; ?>