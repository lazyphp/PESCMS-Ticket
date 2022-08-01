<?php if ($this->session()->get('ticket')['user_id'] == '1'): ?>

    <div class="am-panel am-panel-default">
        <div class="am-panel-bd am-margin-bottom">
            <span class="am-fl"><strong><i class="am-icon-cart-arrow-down"></i> 应用推荐<span class="am-text-xs am-text-danger"> [仅超级管理员可见]</span></strong></span>
            <a href="<?= $label->url('Ticket-Application-index') ?>" class="am-fr">打开应用商店
                <i class="am-icon-external-link"></i></a>
        </div>

        <div class="pes-app-recommend" style="border-top: 1px solid #ddd;min-height: 40px;max-height: 200px;overflow-y: auto">
            <div class="am-margin"><i class="am-icon-spinner am-icon-spin"></i> 正在获取PT推荐应用...</div>
        </div>

        <div class="pes-app-str am-hide" style="display: none;">
            <ul data-am-widget="gallery" class="am-gallery am-avg-sm-4 am-gallery-imgbordered">
                <li>
                    <div class="am-gallery-item am-text-center">
                        <a href="{app-url}" class="app-detail">
                            <img src="{app-img}" class="am-img-responsive am-img-thumbnail" alt="{app-title}">
                        </a>
                        <h3 class="am-gallery-title am-text-xl"><strong>{app-title}</strong></h3>
                        <div class="am-text-danger am-text-sm">{app-price}</div>

                        <div>
                            <a href="{app-url}" class="app-detail">查看详细</a>
                        </div>

                    </div>
                </li>
            </ul>
        </div>
    </div>


    <div class="am-panel am-panel-default">
        <div class="am-panel-bd am-margin-bottom">
            <span class="am-fl"><strong>PESCMS Ticket最近动态<span class="am-text-xs am-text-danger"> [仅超级管理员可见]</span></strong></span>
            <a href="https://www.pescms.com/article/list/7/5.html" class="am-fr" target="_blank">更多>></a>
        </div>
        <table class="pes-article am-table am-table-hover am-text-xs">
            <tr>
                <td><i class="am-icon-spinner am-icon-spin"></i> 正在获取PT最新动态...</td>
            </tr>
        </table>
    </div>
    <script>
        $(function () {

            $.getJSON('https://www.pescms.com/?g=Api&m=Application&a=recommend&project=5', function (res) {
                var status = res.status;
                if (status == 200) {
                    var str = $('.pes-app-str').html();
                    console.dir(str)

                    console.dir(str.replace(/\{app-url\}/, 'dddd'))

                    console.dir(str)

                }
            })

            $.getJSON('https://www.pescms.com/?g=Api&m=Article&a=index&type=5', function (res) {
                var status = res.status;
                if (status == 200) {
                    let pesArtciel = '';
                    for (var i in res.data) {
                        pesArtciel +=
                            '<tr>' +
                            '<td><a href="' + res['data'][i]['url'] + '" target="_blank" style="color: #036"><span style="color: #7b91a4">[' + res['data'][i]['create_date'] + ']</span> ' + res['data'][i]['title'] + '</a></td>' +
                            '</tr>';
                    }
                    $('.pes-article').html(pesArtciel)
                }
            })
        })
    </script>


<?php endif; ?>