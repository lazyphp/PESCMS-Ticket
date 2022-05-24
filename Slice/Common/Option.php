<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Common;

/**
 * 赋予全站的选项
 */
class Option extends \Core\Slice\Slice{

    public function before() {
        $list = \Model\Content::listContent([
            'table' => 'option',
            'condition' => "option_range = 'system'"
        ]);
        $system = [];
        foreach($list as $value){
            $system[$value['option_name']] = $value['value'];
        }

        $this->checkInterior($system['interior_ticket']);

        $this->assign('resources', substr(md5($system['domain'].substr(md5(self::$config['USER_KEY']), 5, 10). $system['version'].$system['openindex'].$system['notice_way']), 4, 10));
        $this->assign('system', $system);

        $this->authorize();
    }

    /**
     * 验证站内工单是否开启
     * @param $interior_ticket
     */
    private function checkInterior($interior_ticket){
        if(GROUP == 'Form' && MODULE == 'Category' && $interior_ticket == 0 ){
            $this->_404();
        }
    }

    public function after() {
        // TODO: Implement after() method.
    }

    public function authorize(){
        $file = PES_CORE.'Core/LICENSE.pes';
        if(is_file($file)){
            $type = json_decode(file_get_contents($file), true);
            if(!empty($type['authorize_type'])){
                $this->assign('license', 1);
                $authorize_type = $type['authorize_type'] == 5 ? 0 : 1;
            }else{
                $authorize_type = 0;
            }
        }else{
            $authorize_type = 0;
        }
        $this->assign('authorize_type', $authorize_type);
    }


}