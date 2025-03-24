<div class="am-panel am-panel-default">
    <div class="am-panel-bd">
        <div class="am-g am-g-collapse">
            <div class="am-u-sm-12 am-u-sm-centered">
                <div class="am-form-group">
                    <label class="am-block">客服工号格式<i class="am-text-danger">*</i></label>
                    <input name="job_number_format" placeholder="客服工号格式" type="text" value="<?= $job_number_format['value'] ?>" required="">
                    <div class="pes-alert pes-alert-info am-text-xs " >
                        <i class="am-icon-lightbulb-o"></i> 工号格式必须包含 %0Nd，其中 N 表示数字的最小宽度，d 表示递增的数字部分，生成的工号将按此格式自动递增并补足零。例如：PT%05d，生成的工号为PT00001。
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>