<div class="am-g am-margin-bottom">
    <div class="am-u-lg-8 am-u-md-8 am-u-sm-centered">
        <form action="<?=DOCUMENT_ROOT?>/?m=Index&a=option" class="am-form am-form-horizontal" method="POST" data-am-validator>
            <input type="hidden" name="method" value="GET" />
            <?php include 'Index_check.php'; ?>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">数据库地址:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="host" value="localhost" placeholder="数据库地址" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">数据库名称:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="name" placeholder="数据库名称" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">数据库帐号:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="account" placeholder="数据库帐号" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">数据库密码:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="passwd" placeholder="数据库密码" >
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">数据库端口:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="port" value="3306" placeholder="数据库端口" required>
                </div>
            </div>

            <div class="am-margin-top am-fl">
                <a href="<?=DOCUMENT_ROOT?>/?m=Index&a=index" class="am-btn am-btn-default">上一步</a> 
            </div>

            <div class="am-margin-top am-fr">
                <button type="submit" id="next" class="am-btn am-btn-default">下一步</button> 
            </div>
        </form>
    </div>
</div>
<script>
    $(function () {
        $("#next").on("click", function () {
            if($("#version,#pdo").attr("class") == 'am-btn am-btn-danger'){
                alert($(".install_tips").text());
                return false;
            }
            
        })
    })
</script>