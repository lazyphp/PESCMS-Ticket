<?php
/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\DELETE;

/**
 * 公用内容删除方法
 */
class Content extends \Core\Controller\Controller {

    /**
     * 魔术方法，执行删除
     * @param type $name
     * @param type $arguments
     */
    public function __call($name, $arguments) {
        $this->delete();
    }

    /**
     * 执行删除动作
     */
    public function delete() {
        $this->checkToken();
        if(!empty($_POST['id']) && is_array($_POST['id']) ){
            $tips = [];
            foreach ($_POST['id'] as $id){
                $result = \Model\ModelManage::deleteFromModelId(MODULE, (int) $id);
                if($result == false){
                    $tips[$id] = $id;
                }
            }
            if(!empty($tips)){
                $this->error("ID: '".implode(',', $tips)."' 删除失败", '', '10');
            }else{
                $this->success('批量删除完成');
            }

        }else{
            $id = $this->isG('id', '请选择要删除的数据!');
            $result = \Model\ModelManage::deleteFromModelId(MODULE, $id);
            if (empty($result)) {
                $this->error('删除失败');
            } else {
                $this->success('删除成功');
            }
        }

    }

}
