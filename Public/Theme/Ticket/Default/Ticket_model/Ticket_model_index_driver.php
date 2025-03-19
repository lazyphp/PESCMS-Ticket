<?php if (isset(\Core\Func\CoreFunc::session()->get('ticket')['user_id']) && \Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1): ?>

    <link rel="stylesheet" href="<?= DOCUMENT_ROOT; ?>/Theme/assets/css/driver.css?v=<?= $resources ?>">
    <script src="<?= DOCUMENT_ROOT; ?>/Theme/assets/js/driver.js?v=<?= $resources ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let tipsManualStatus = parseInt('<?= $system['tipsManual'] ?>');
            let ticket_model_table = document.querySelector('.ticket-model-table');
            let ticketModelAlert = document.querySelector('.nothing-ticketModel');
            const driver = window.driver.js.driver;

            if (ticket_model_table) {
                return false;
            }

            $.getJSON('<?= $label->url('Ticket-HelpDocument-example') ?>', function (res) {

                if (res.status != 200) {
                    return false;
                }

                const driverObj = driver({
                    nextBtnText: '下一步',
                    prevBtnText: '上一步',
                    doneBtnText: '完成',
                    progressText: '{{current}} / {{total}}',
                    showProgress: true,
                    allowClose: false,
                    steps: [
                        {
                            element: '.am-btn-group-xs > .am-btn-default',
                            popover: {
                                description: '点击此按钮，根据表单提示填写工单模型的名称、分类、自动化设置等信息。',
                                side: "bottom",
                                align: 'start',
                                onNextClick: () => {
                                    if(ticketModelAlert){
                                        ticketModelAlert.style.display = 'none';
                                        ticketModelAlert.insertAdjacentHTML('afterend', res.data);
                                    }

                                    driverObj.moveNext();
                                },
                            }
                        },
                        {
                            element: '.ticket_model_table',
                            popover: {
                                description: '时间关系，我们创建了一个示例的工单模型。这是一个非常典型的宿舍报修工单模型。',
                                side: "bottom",
                                align: 'start'
                            }
                        },
                        {
                            element: '.driver_ticket_cat',
                            popover: {
                                description: '此处显示都是工单分类，同一分类的工单模型我们会整合在一起。',
                                side: "bottom",
                                align: 'start'
                            }
                        },
                        {
                            element: '#driver_ticket_model_base',
                            popover: {
                                description: '<p>此处区域是工单模型的名称、模型号码。</p><p>若您需要修改工单模型的信息，点击：“<span class="am-text-primary">设置基础信息</span>”。</p><p>如果相同问题比较多，可以进入<span class="am-text-primary">FQA列表</span>添加常见问题指引，减少重复问题的提问。</p>',
                                side: "bottom",
                                align: 'start'
                            }
                        },
                        {
                            element: '.ticket_model_operate',
                            popover: {
                                description: '<p>此区域您可以对工单模型进行表单添加、复制和删除。</p><p>通过数据整合，有小部分用户忘记添加工单表单，导致预览工单模型打开就是404页面。因此创建工单模型后，记得进入“<span class="am-text-warning">添加和管理工单字段</span>”完善工单模型</p>',
                                side: "bottom",
                                align: 'start'
                            }
                        },
                        {
                            element: '#driver-important-ticket-form',
                            popover: {
                                description: '<strong>重要的事情要提示多一次：</strong><p>工单模型创建后，记得进入“<span class="am-text-warning">添加和管理工单字段</span>”完善工单模型</p>',
                                side: "bottom",
                                align: 'start'
                            }
                        },
                        {
                            popover: {
                                description: '<div class="am-text-center am-text-xxxl">👏</div><p>现在到这里我们相信您已经掌握了PT系统工单模型创建的流程了！</p>',
                                side: "top",
                                align: 'center'
                            }
                        },
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
                            status: 2,
                            method: 'PUT'
                        }, function () {
                        }, 'JSON')

                        ticketModelAlert.style.display = 'block';
                        $('.ticket_model_table').remove()

                    }

                });

                if (tipsManualStatus <= 1) {
                    driverObj.drive();
                }


            })


        });

    </script>
<?php endif; ?>