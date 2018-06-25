<div class=" am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <strong class="am-text-primary am-text-lg"><a href="<?= $label->url(GROUP .'-' . MODULE . '-' . ACTION); ?>">应用商店</a>
                    </strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
            <div id="app-list" project="5" version="<?= $system['version'] ?>">正在连接PESCMS应用商店...</div>
        </div>
    </div>
</div>
<script src="https://www.pescms.com/Theme/Api/App/1.0/pescms_app.js?mt=<?= time() ?>"></script>