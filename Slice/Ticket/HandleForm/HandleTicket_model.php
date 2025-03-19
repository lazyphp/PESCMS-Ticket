<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace Slice\Ticket\HandleForm;

/**
 * 处理后台 工单模型添加/编辑提交过来的表单
 * @package Slice\Ticket
 */
class HandleTicket_model extends \Core\Slice\Slice {

    public function before() {

        if(in_array(METHOD, ['POST', 'PUT'])){
            if(empty($_POST['group_id']) && !is_array($_POST['group_id'])){
                $this->error('请提交工单模型正确的管辖客户分组');
            }
            $_POST['group_id'] = ','.implode(',', $_POST['group_id']).',';
        }

        // 根据不同的请求方法处理 ID 和 number
        switch (METHOD) {
            case 'GET':
                $this->handleGetMethod();
                break;
            case 'POST':
                $this->handlePostMethod();
                break;
            case 'PUT':
            case 'DELETE':
                $this->handlePutDeleteMethod(METHOD);
                $this->handleDeleteMethod(METHOD);
                break;
        }
    }

    /**
     * 处理 GET 请求的参数
     */
    private function handleGetMethod() {
        if (!empty($_GET['id'])) {
            $number = $this->g('id');
            $_GET['id'] = \Model\TicketModel::numberFind($number)['ticket_model_id'];
        }
    }

    /**
     * 处理 POST 请求的参数
     */
    private function handlePostMethod() {
        // 统一工单模型的ID号为10个长度
        $_POST['number'] = (string)str_pad(
            substr(\Model\Extra::getOnlyNumber(), 0, 10), 
            10, 
            0, 
            STR_PAD_RIGHT
        );
    }

    /**
     * 处理 PUT 和 DELETE 请求的参数
     * @param string $method 请求方法
     */
    private function handlePutDeleteMethod($method) {
        // 根据请求方法确定使用的验证函数
        $validationMethod = ($method == 'PUT') ? 'isP' : 'isG';
        
        // 获取并验证工单ID
        $number = $this->$validationMethod('id', '请提交您要编辑的工单ID');
        $_POST['number'] = $_GET['number'] = $number;
        
        // 获取工单内容并设置ID
        $content = \Model\TicketModel::numberFind($number);
        $_POST['id'] = $_GET['id'] = (string)$content['ticket_model_id'];
    }

    /**
     * 处理 DELETE 请求的参数
     * @param string $method 请求方法
     */
    private function handleDeleteMethod($method) {
        if($method != 'DELETE'){
            return ;
        }
        //检查工单模型是否被使用
        $count = \Model\Content::findContent('ticket', $_GET['id'], 'ticket_model_id');
        if(!empty($count)){
            $this->error('该工单模型已有工单存在，无法删除。');
        }
    }

    public function after() {
    }


}