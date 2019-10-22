$(function () {

    //追加新的选项值
    $(document).on('click', '.option-plus-square', function(){
        var clone_html = $(this).parents('.pes-option-line').clone();
        $(this).parents('.pes-option-line').after(clone_html)
        $(clone_html.find('input')).each(function(){
            $(this).val('')
        })
    })

    //移除选项值
    $(document).on('click', '.option-minus-square', function(){
        $(this).parents('.pes-option-line').remove();
    })

})