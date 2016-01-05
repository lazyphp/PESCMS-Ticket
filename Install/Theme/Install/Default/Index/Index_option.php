<div class="am-g am-margin-bottom">
    <div class="am-u-lg-8 am-u-md-8 am-u-sm-centered">
        <form action="<?=DOCUMENT_ROOT?>/?m=Index&a=doinstall" class="am-form am-form-horizontal" method="POST" data-am-validator>
            <input type="hidden" name="method" value="GET" />
			
			<div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">网站域名:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="domain" placeholder="网站域名" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">管理员帐号:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="account" placeholder="管理员帐号" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">管理员密码:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="passwd" placeholder="管理员密码" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">管理员邮箱:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="mail" placeholder="管理员邮箱" required>
                </div>
            </div>

            <div class="am-form-group">
                <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">管理员名字:</label>
                <div class="am-u-sm-10">
                    <input type="text" name="name"  placeholder="管理员名字" required>
                </div>
            </div>

            <div class="am-margin-top am-fl">
                <a href="<?=DOCUMENT_ROOT?>/?m=Index&a=config" class="am-btn am-btn-default">上一步</a> 
            </div>

            <div class="am-margin-top am-fr">
                <button type="submit" id="next" class="am-btn am-btn-default">下一步</button> 
            </div>
        </form>
    </div>
</div>