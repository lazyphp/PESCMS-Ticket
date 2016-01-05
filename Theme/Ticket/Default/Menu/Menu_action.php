<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<script>
    $(function(){
        var pid = '<?= $menu_pid ?>';
        var topMenu = eval('('+'<?= $topMenu ?>'+')');
        var option = '<option value="0">顶层菜单</option>';
        var selected = '';
        for(var key in topMenu){
            if(topMenu[key]['menu_id'] == pid){
                selected = 'selected="selected"';
            }else{
                selected = '';
            }
            option += '<option value="'+topMenu[key]['menu_id']+'"  '+selected+'>'+topMenu[key]['menu_name']+'</option>';
        }
        $("select[name=pid]").html(option);
    })
</script>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>