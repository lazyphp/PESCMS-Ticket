<?php if ($this->session()->get('ticket')['user_id'] == '1'): ?>
    <div class="pes-ad-admin-only">
        <?php foreach (
            [
                'Application' => [
                    'title' => '应用推荐',
                    'url'   => $label->url('Ticket-Application-index'),
                    'open'  => '打开应用商店',
                    'field' => 'app',
                    'api'   => 'Application',
                ],
                'Theme'       => [
                    'title' => '模板推荐',
                    'url'   => $label->url('Ticket-Theme-index'),
                    'open'  => '打开模板商店',
                    'field' => 'theme',
                    'api'   => 'ThemeCenter',
                ],
            ] as $key => $item): ?>
            <div class="am-panel am-panel-default">
                <div class="am-panel-bd am-margin-bottom">
                    <span class="am-fl"><strong><i class="am-icon-cart-arrow-down"></i> <?= $item['title'] ?><span class="am-text-xs am-text-danger"> [仅超级管理员可见]</span></strong></span>
                    <a href="<?= $item['url'] ?>" class="am-fr"><?= $item['open'] ?>
                        <i class="am-icon-external-link"></i></a>
                </div>

                <div class="pes-<?= $item['field'] ?>-recommend" style="border-top: 1px solid #ddd;min-height: 40px;max-height: 200px;overflow-y: auto">
                    <div class="am-margin"><i class="am-icon-spinner am-icon-spin"></i> 正在获取PT<?= $item['title'] ?>...
                    </div>
                </div>

                <ul class="pes-<?= $item['field'] ?>-str am-hide" style="display: none;">
                    <li>
                        <div class="am-gallery-item am-text-center" style="position: relative">
                            <a href="{<?= $item['field'] ?>-url}">
                                <img src="{<?= $item['field'] ?>-img}" class="am-img-responsive am-img-thumbnail" alt="{<?= $item['field'] ?>-title}">
                            </a>
                            {<?= $item['field'] ?>-vip}
                            <h3 class="am-gallery-title am-text-xl"><strong>{<?= $item['field'] ?>-title}</strong></h3>
                            <div class="am-text-danger am-text-sm">{<?= $item['field'] ?>-price}</div>

                            <div>
                                <a href="{<?= $item['field'] ?>-url}">查看详细</a>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
            <script>
                $(function () {

                    $.getJSON('<?= PESCMS_URL ?>/?g=Api&m=<?= $item['api'] ?>&a=recommend&project=5', function (res) {
                        var status = res.status;

                        if (status == 200) {

                            var templateStr = '';

                            var str = $('.pes-<?= $item['field'] ?>-str').html();

                            for (var i in res.data) {
                                var result = str.replace(/\{<?= $item['field'] ?>-url\}|\{<?= $item['field'] ?>-title\}|\{<?= $item['field'] ?>-img\}|\{<?= $item['field'] ?>-price\}|\{<?= $item['field'] ?>-vip\}/g, function (match) {
                                    var map = {
                                        '{<?= $item['field'] ?>-url}': '/?g=Ticket&m=<?= $key ?>&a=shop&open=' + res['data'][i]['url'],
                                        '{<?= $item['field'] ?>-title}': res['data'][i]['name'],
                                        '{<?= $item['field'] ?>-img}': res['data'][i]['cover'],
                                        "{<?= $item['field'] ?>-price}": res['data'][i]['price'],
                                        "{<?= $item['field'] ?>-vip}": res['data'][i]['vip'] == 1 ? '<span class="am-badge am-badge-danger pes-vip" style="position: absolute;top: 2px;right: 2px">授权专属</span>' : ''
                                    };
                                    return map[match];
                                });

                                templateStr += result;
                            }

                            if (templateStr.length > 0) {
                                $('.pes-<?= $item['field'] ?>-recommend').html('<ul data-am-widget="gallery" class="am-gallery am-avg-sm-4 am-gallery-imgbordered">' + templateStr + '</ul>');
                            } else {
                                $('.pes-<?= $item['field'] ?>-recommend').html("<div class=\"am-margin\">「<?= $item['title'] ?>」正在如火如荼地开发中...</div>");
                            }


                        }


                    }).fail(function () {
                        $('.pes-<?= $item['field'] ?>-recommend').html("<div class=\"am-margin\">获取「<?= $item['title'] ?>」失败，请稍后再试！</div>");
                    })
                })
            </script>
        <?php endforeach; ?>


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

                //获取PESCMS Ticket最新动态
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

    </div>
<?php endif; ?>