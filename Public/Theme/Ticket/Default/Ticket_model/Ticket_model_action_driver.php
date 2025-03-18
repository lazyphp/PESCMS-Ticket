<?php if (isset(\Core\Func\CoreFunc::session()->get('ticket')['user_id']) && \Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1): ?>

    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/driver.css?v=<?= $resources ?>">
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/driver.js?v=<?= $resources ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let tipsManualStatus = parseInt('<?= $system['tipsManual'] ?>');

            const driver = window.driver.js.driver;

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
                            description: '我们又见面了，接下来我将会告诉您工单模型中一些容易设置错误的地方。',
                            side: "bottom",
                            align: 'start',
                        }
                    },
                    {
                        element: '.am-form-group:has([name="custom_no"])',
                        popover: {
                            description: '如果您需要自定义工单单号，在这里根据说明填写即可。需要注意的是：<strong style="color: red;">尽量带有{S}或者{His}</strong>，避免工单号重复，导致工单无法打开的问题。您可以按F1打开文档，查看常见问题找到工单号重复解决方案。',
                            side: "bottom",
                            align: 'start',
                            onNextClick: () => {
                                let link = $("a:contains('工单内部设置')");
                                $(link).trigger('click');
                                const animatedElement = $(link.attr('href'));
                                animatedElement.one('transitionend', function () {
                                    // 动画已完成，继续操作
                                    let id = link.attr('href');
                                    // 操作目标元素
                                    driverObj.moveNext();
                                });
                            },
                        }
                    },
                    {
                        element: '.am-form-group:has([name="organize_id[]"])',
                        popover: {
                            description: '若没有特殊需求，尽量不要勾选此选项。只有您希望特定客户分组的账户登录后才可见此工单时，您才勾选本选项。',
                            side: "bottom",
                            align: 'start'
                        }
                    },
                    {
                        popover: {
                            description: '本教程就到此结束，祝您工作顺利！',
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
                        status: 3,
                        method: 'PUT'
                    }, function () {
                    }, 'JSON')

                }

            });

            if (tipsManualStatus <= 2) {
                driverObj.drive();
            }


        });

    </script>
<?php endif; ?>