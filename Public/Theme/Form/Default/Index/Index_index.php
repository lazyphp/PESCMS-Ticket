<header class="am-topbar">
    <h1 class="am-topbar-brand">
        <a href="#">PESCMS Ticket</a>
    </h1>

        <div class="am-topbar-right">
            <a href="<?=DOCUMENT_ROOT?>/?g=Ticket&m=Login&a=index" class="am-btn am-btn-primary am-topbar-btn am-btn-sm">管理工单</a>
        </div>
    </div>
</header>
<div class="am-g am-padding-top-xl" style="padding-top: 100px;">
    <!--    logo-->
    <div class="am-u-sm-3 am-u-sm-centered">
        <img src="https://www.baidu.com/img/bdlogo.png" width="270"/>
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