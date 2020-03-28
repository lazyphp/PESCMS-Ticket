<div class="am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default" id="setting-panel">
        <div class="am-panel-bd am-padding-bottom-0">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
        </div>
        <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-default">
            <?php foreach($list as $patchName => $item): ?>
                <li>
                    <div class="am-gallery-item am-text-center">
                        <a href="<?= DOCUMENT_ROOT ?>/Theme/Form/<?= $patchName ?>/<?= $item['img'] ?>" data-fancybox="gallery">
                            <img src="<?= DOCUMENT_ROOT ?>/Theme/Form/<?= $patchName ?>/<?= $item['img'] ?>" class="am-img-thumbnail"  alt=""/>
                        </a>
                        <div class="am-gallery-desc am-margin-top">
                            <div class="am-g">
                                <p class="am-margin-xs">名称：<?= $item['name'] ?></p>
                                <p class="am-margin-xs">作者：<?= $item['author'] ?></p>
                                <p class="am-margin-xs">版本：<?= $item['version'] ?></p>
                                <p class="am-margin-xs">官网：<?= $item['website'] ?></p>
                                <p class="am-margin-xs">简介：<?= $item['content'] ?></p>
                            </div>

                            <label class="am-radio-inline">
                                <input type="radio" name="template" value="<?= $patchName ?>" <?= $patchName == $currentTheme ? 'checked="checked"' : '' ?> ><?= $item['name'] ?>
                            </label>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    $(function(){
        $('input[name=template]').on('click', function(){
            if($(this).attr('checked') || confirm('确认切换主题模板吗？') == false ){
                return false;
            }

            var template = $(this).val();
            $.ajaxsubmit({
                url:'<?= $label->url('Ticket-Theme-call') ?>',
                data: {
                    template:template,
                    method:'PUT'
                }
            }, function(){

            });
        })
    })
</script>