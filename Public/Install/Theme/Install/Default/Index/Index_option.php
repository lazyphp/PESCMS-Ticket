<div class="am-panel-hd">
    <h3 class="am-panel-title">网站信息配置</h3>
</div>
<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">网站域名:</label>
    <div class="am-u-sm-10">
        <input type="text" name="domain" placeholder="请填写正确的域名，以便工单能够正确地提交！域名需要带http或者https，按照服务器实际情况填写。" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">管理员帐号:</label>
    <div class="am-u-sm-10">
        <input type="text" name="account" placeholder="管理员帐号" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">管理员密码:</label>
    <div class="am-u-sm-10">
        <input type="text" name="passwd" placeholder="管理员密码" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">再次确认密码:</label>
    <div class="am-u-sm-10">
        <input type="text" name="repasswd" placeholder="再次确认密码" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">管理员邮箱:</label>
    <div class="am-u-sm-10">
        <input type="text" name="mail" placeholder="管理员邮箱" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">管理员名字:</label>
    <div class="am-u-sm-10">
        <input type="text" name="name" placeholder="管理员名字" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">后台入口程序:</label>
    <div class="am-u-sm-10">
        <div>
            <input type="text" name="manage" class="am-inline-block am-text-right" placeholder="admin"
                   style="width: 80px" required><input type="text" value=".php" class="am-inline-block" disabled
                                                       style="width: 60px">
        </div>
        <div class="am-alert am-alert-secondary am-text-xs " data-am-alert>
            <i class="am-icon-lightbulb-o"></i> 填写后台入口程序，程序将会创建一个后台入口地址。如admin，那么您访问后台只需要 http://您的程序/admin.php
        </div>
    </div>
</div>