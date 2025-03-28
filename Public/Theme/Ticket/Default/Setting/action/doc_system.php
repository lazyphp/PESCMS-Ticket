<div class="am-panel am-panel-default">
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">文档系统地址</label>
                    <input name="doc[url]" placeholder="文档系统地址" type="text" value="<?= $doc['url'] ?>" required="">
                </div>
            </div>
        </div>

        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">文档系统的Authorization</label>
                    <input name="doc[authorization]" placeholder="文档系统的Authorization" type="text" value="<?= $doc['authorization'] ?>" required="">
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 要将文档系统的内容与PT系统产生关联，请完成填写上述2个选项内容。其中Authorization的获取方式请查看 <a href="https://document.pescms.com/article/4/664720334762541056.html" target="_blank">《基础和全局》</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>