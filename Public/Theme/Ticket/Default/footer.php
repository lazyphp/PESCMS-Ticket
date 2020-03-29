<?php if(\Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1 ): ?>
<script>
    $(function(){
        var version  = '<?= $system['version'] ?>';
        var timestamp = Date.parse( new Date());

        //获取本地存储
        var important = parseInt(localStorage.getItem('important'));
        var close_important = parseInt(localStorage.getItem('close_important'));
        var record_version = localStorage.getItem('version');
        var check_time = localStorage.getItem('check_time');

        //检查是否需要弹窗重要更新提示框
        if(important == 1 && close_important != 1 && record_version == version ){
            var alter_str = '<div class="am-alert am-alert-warning am-margin-0 am-text-sm" data-am-alert><button type="button" class="am-close close-important">&times;</button>' +
                '当前系统有一个重要更新发布，点击 <a href="<?= $label->url(GROUP.'-Setting-upgrade') ?>" style="color:blue">这里</a> 查看' +
                '</div>';
            $('header').before(alter_str);
        }

        /**
         * 判断本地存储的版本号与程序版本号是否一致
         * 判断上次检查更新时间记录是否大于1天
         */
        if(record_version != version && check_time<= timestamp){
            $.getJSON(PESCMS_URL+'/patch/5/<?= $system['version'] ?>', function(data){
                if(data.status == 200){
                    if(data.data.important == 1){
                        localStorage.setItem('important', '1')
                    }
                    localStorage.setItem('version', version);
                    localStorage.removeItem('close_important')
                }
            }).complete(function(){
                localStorage.setItem('check_time', timestamp + 86400000);
            })
        }

        $('body').on('click', '.close-important', function(){
            localStorage.setItem('close_important', '1')
        })
        
        <?php if($system['tipsManual'] == 0): ?>
        dialog({
            fixed: true,
            title:'欢迎使用PESCMS Ticket',
            content: $('.tips-manual')[0],
            width: '300px',
            okValue: '我知道了',
            ok: function () {
                $.post('<?= $label->url('Ticket-Setting-recordTips') ?>', {name:'tipsManual', method:'PUT'}, function(){}, 'JSON')
            }
        }).showModal()
        <?php endif; ?>


        <?php if($system['ticketModel'] == 0 && MODULE == 'Ticket_model' && ACTION == 'index'): ?>
        dialog({
            content: '当前工单模型还没完善，点击 更多 - 管理，添加您需要记录的工单表单。',
            okValue: '我知道了',
            ok: function () {
                $.post('<?= $label->url('Ticket-Setting-recordTips') ?>', {name:'ticketModel', method:'PUT'}, function(){}, 'JSON')
            }
        }).show($('.more-operate').last()[0])
        <?php endif; ?>
    })
</script>
<div class="tips-manual" style="display: none">
    <a href="https://www.pescms.com/d/index/22.html" class="am-btn am-btn-warning am-btn-xs am-radius" target="_blank">PESCMS Ticket 使用教程</a>
    <p>
        常见问题
    </p>
    <ol class=" list-paddingleft-2" style="list-style-type: decimal;">
        <li>
            <a href="https://www.pescms.com/d/v/1.2.7/22/137.html" target="_blank">创建工单教程</a>
        </li>
        <li>
            <a href="https://www.pescms.com/d/v/1.2.7/22/147.html" target="_blank">访问工单404</a>
        </li>
        <li>
            <a href="https://www.pescms.com/different/5.html" target="_blank">开源版和授权版差异</a>
        </li>
    </ol>
</div>
<?php endif; ?>
</body>
</html>