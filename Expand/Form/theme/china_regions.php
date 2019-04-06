<div class="am-form-inline">
    <select class="pes_regions_<?= $field['field_name'] ?>_provinces" <?= $field['field_required'] == '1' ? 'required' : '' ?> data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}" >
        <option>请选择</option>
    </select>

    <select class="pes_regions_<?= $field['field_name'] ?>_cities" <?= $field['field_required'] == '1' ? 'required' : '' ?> data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}" >
        <option>请选择</option>
    </select>

    <select class="pes_regions_<?= $field['field_name'] ?>_areas" <?= $field['field_required'] == '1' ? 'required' : '' ?> data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}" >
        <option>请选择</option>
    </select>

    <select class="pes_regions_<?= $field['field_name'] ?>_streets" <?= $field['field_required'] == '1' ? 'required' : '' ?> data-am-selected="{maxHeight: 200, btnSize: 'sm', dropUp: 0}" >
        <option>请选择</option>
    </select>

    <input class="form-text-input input-leng3 am-hide" name="<?= $field['field_name'] ?>"  type="text" value="<?= $field['value'] ?>" <?= $field['field_required'] == '1' ? 'required' : '' ?>  />

</div>
<script>
    $(function(){

        $('select[class^="pes_regions_<?= $field['field_name'] ?>_"]').on('change', function(){
            var str = '';
            $('select[class^="pes_regions_<?= $field['field_name'] ?>_"]').each(function(){
                if($(this).val()){
                    str += $(this).val().trim();
                }
            })

            $('input[name=<?= $field['field_name'] ?>]').val(str)

        })


        var getJsonRegions = function(name, id){
            //不设区城市
            var noAreaCity = [
                '4419',  // 东莞市
                '4420',  // 中山市
                '4604'   // 儋州市
            ];
            if(noAreaCity.indexOf(id) > -1){
                name = 'streets'
                id = id + '00'
                $('.pes_regions_<?= $field['field_name'] ?>_areas').selected('destroy').hide();
            }

            $.getJSON('/Theme/assets/js/regions/'+name+'.json', function(data){
                if(id){
                    var foo = data.filter(function(item){
                        return item.provinceCode == id || item.cityCode == id || item.areaCode == id
                    })
                }else{
                    var foo = data
                }
                var option = '<option value="">请选择</option>';
                for(var key in foo){
                    option += '<option value="'+foo[key]['name']+'" data="'+foo[key]['code']+'">'+foo[key]['name']+'</option>'
                }
                $('.pes_regions_<?= $field['field_name'] ?>_'+name).html(option).selected('enable')
            })
        }

        var clearOption = function(obj){
            $.each(obj, function(index, name){
                $('.pes_regions_<?= $field['field_name'] ?>_'+name).html('<option value="">请选择</option>').selected('destroy').hide()
            })
        }

        getJsonRegions('provinces', '');
        clearOption(['cities', 'areas', 'streets'])


        $('body').on('change', 'select[class^="pes_regions_<?= $field['field_name'] ?>_"]', function(){
            var name = $(this).attr('class').split(' ');
            var id = $('option:selected', this).attr('data');
            if(id){
                switch(name[0]){
                    case 'pes_regions_<?= $field['field_name'] ?>_provinces':
                        clearOption(['cities', 'areas', 'streets'])
                        getJsonRegions('cities', id);
                        break;
                    case 'pes_regions_<?= $field['field_name'] ?>_cities':
                        clearOption(['areas', 'streets'])
                        getJsonRegions('areas', id);
                        break;
                    case 'pes_regions_<?= $field['field_name'] ?>_areas':
                        clearOption(['streets'])
                        getJsonRegions('streets', id);
                        break;
                }
            }
        })
    })
</script>