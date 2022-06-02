<?php if(isset(\Core\Func\CoreFunc::session()->get('ticket')['user_id']) && \Core\Func\CoreFunc::session()->get('ticket')['user_id'] == 1 ): ?>
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
        var topTips = dialog({
            fixed: true,
            title:'欢迎使用PESCMS Ticket',
            content: $('.tips-manual')[0],
            width: '300px',
        }).showModal();

        $('.btn-loading-example').button('loading').html('加载完成还需要5秒...');
        setTimeout(function(){
            $('.btn-loading-example').button('reset');
        }, 5000);

        $('body').on('click', '.btn-loading-example', function () {
            $.post('<?= $label->url('Ticket-Setting-recordTips') ?>', {name:'tipsManual', method:'PUT'}, function(){}, 'JSON')
            topTips.close();
        })
        <?php endif; ?>

        <?php if($system['help_document'] == 0): ?>
            $('header').before('<div class="am-alert am-alert-postscript am-text-sm am-margin-0" data-am-alert><button type="button" class="close-f1 am-close">&times;</button><i class="am-icon-leanpub"></i> 按F1可以打开PESCMS Ticket帮助文档</div>')
            $('html, body').animate({scrollTop: 0}, '500');
            $('.close-f1').on('click', function (){
                confirm('请谨记在客服端按F1可随时打开PESCMS Ticket帮助文档。');
                $.post('<?= $label->url('Ticket-Setting-recordTips') ?>', {name:'help_document', method:'PUT'}, function(){}, 'JSON')

            })
        <?php endif; ?>

    })
</script>
<div class="tips-manual" style="display: none">
    <a href="https://document.pescms.com/article/3.html" class="am-btn am-btn-warning am-btn-xs am-radius" target="_blank"><i class="am-icon-book"></i> 查看PESCMS Ticket 使用教程</a>
    <p>
        常见问题
    </p>
    <ol class=" list-paddingleft-2" style="list-style-type: decimal;">
        <li>
            <strong class="am-text-danger">大部分问题官方文档有解决方案！！！</strong>
        </li>
        <li>
            <a href="https://document.pescms.com/article/3/296096861045915648.html" target="_blank">创建工单教程</a>
        </li>
        <li>
            <a href="https://document.pescms.com/article/3/296557456849371136.html" target="_blank">访问工单404或工单不显示</a>
        </li>
        <li>
            <a href="https://www.pescms.com/different/5.html" target="_blank">开源版和授权版差异</a>
        </li>
    </ol>

    <hr>
    <!--为了让项目可持续发展，加入广告投放-->
    <article class="am-article">
        <div class="am-article-hd">
            <h3 class="am-text-success">PESCMS推荐您使用阿里云服务器</h3>
        </div>
        <div class="am-article-bd">
            <p ><a href="https://www.pescms.com/goAd/12.html" target="_blank" style="color: #f56c6c"><i class="am-icon-external-link"></i>【采购季】上云仅¥223/3年</a></p>
            <p ><a href="https://www.pescms.com/goAd/12.html" target="_blank" style="color: #f56c6c"><i class="am-icon-external-link"></i> &nbsp;新用户福利专场，云服务器ECS低至102元/年</a></p>
            <p ><a href="https://www.pescms.com/goAd/12.html" target="_blank" style="color: #f56c6c"><i class="am-icon-external-link"></i> &nbsp;更多优惠云产品，点击查看详情</a></p>
        </div>
    </article>
    <!--为了让项目可持续发展，加入广告投放-->

    <div class=" am-text-right ">
        <button type="button" class="am-btn am-btn-primary am-btn-sm am-radius btn-loading-example">朕已阅</button>
    </div>

</div>
<?php endif; ?>

<script>
    /**
     * F1帮助文档
     */
    $(document).on('keydown', function (){
        var e = window.event;
        var code = e.charCode || e.keyCode;
        if(code == 112){
            $.getJSON('<?= $label->url('Ticket-HelpDocument-find', ['help_controller' => GROUP.'-'.MODULE.'-'.ACTION, 'match' => GROUP.'-'.MODULE.'-:a']) ?>', function (res){
                try {
                    if(res.status == 200){
                        window.open(res.data.help_document_link)
                    }else{
                        window.open('https://document.pescms.com/article/3.html')
                    }
                }catch (e){
                    window.open('https://document.pescms.com/article/3.html')
                }
            })
            return false;
        }

    })
</script>

<?php $label->footerEvent() ?>

<?php if(MODULE !== 'Login'): ?>
<div class="amz-toolbar" id="amz-toolbar" style="">

    <?= (new \Core\Plugin\Plugin())->event('suspensionButton', NULL); ?>

    <a href="#top" title="回到顶部" class="am-icon-btn am-icon-arrow-up " id="amz-go-top" data-am-smooth-scroll=""></a>
    <?php if(MODULE == 'Ticket' && ACTION == 'handle' ): ?>
    <a href="javascript:;" title="处理工单" class="pes-handleTicket am-icon-btn am-icon-edit"></a>
    <?php endif; ?>
    <a href="javascript:;" title="关闭浮窗" class="pes-close-amz-toolbar am-icon-btn am-icon-chain-broken"></a>
</div>
<?php endif; ?>
</body>
</html>