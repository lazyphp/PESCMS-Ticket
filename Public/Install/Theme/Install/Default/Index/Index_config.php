<div class="am-panel-hd">
    <h3 class="am-panel-title">检查配置与数据库配置</h3>
</div>
<?php include 'Index_check.php'; ?>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">数据库地址:</label>
    <div class="am-u-sm-10">
        <input type="text" name="db_host" value="localhost" placeholder="数据库地址" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">数据库名称:</label>
    <div class="am-u-sm-10">
        <input type="text" name="db_name" placeholder="数据库名称" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">数据库帐号:</label>
    <div class="am-u-sm-10">
        <input type="text" name="db_account" placeholder="数据库帐号" required>
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">数据库密码:</label>
    <div class="am-u-sm-10">
        <input type="text" name="db_passwd" placeholder="数据库密码">
    </div>
</div>

<div class="am-form-group">
    <label class="am-u-sm-2 am-form-label">数据库端口:</label>
    <div class="am-u-sm-10">
        <input type="text" name="db_port" value="3306" placeholder="数据库端口" required>
    </div>
</div>

<script>
    $(function () {
        $("#next").on("click", function () {
            if ($("#version,#pdo").attr("class") == 'am-btn am-btn-danger') {
                alert($(".install_tips").text());
                return false;
            }

        })
    })
</script>