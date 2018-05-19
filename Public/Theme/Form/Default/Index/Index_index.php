<div class="am-g">
    <!--    logo-->
    <div class="am-u-sm-3 am-u-sm-centered am-padding-top am-margin-bottom">
        <img src="<?= DOCUMENT_ROOT; ?>/Theme/assets/i/logo.png" width="180"/>
    </div>

    <div class="am-u-sm-6 am-u-sm-centered">
        <form action="<?= $label->url('View-ticket') ?>" method="GET" data-am-validator>
            <input type="hidden" name="m" value="View" />
            <input type="hidden" name="a" value="ticket">
            <div class="am-input-group ">
                <input type="text" name="number" class="am-form-field" required placeholder="填入您所知道工单，马上了解进度">
            <span class="am-input-group-btn">
                <button class="am-btn am-btn-default" type="submit">获知</button>
            </span>
            </div>
        </form>
    </div>
</div>