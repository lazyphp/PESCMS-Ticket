<?php
/**
 * 重写UE文件获取文件列表
 * Copyright (c) 2019 PESCMS (https://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

class resource{

    private $getType = 0, $session = [], $start = 0;

    public function __construct() {
        switch ($_GET['action']){
            case 'listimage':
                $this->getType = 0;
                break;
            case 'listfile':
                $this->getType = 1;
                break;
            default:
                die($this->returnMsg('获取类型失败'));
        }

        $this->session = \Core\Func\CoreFunc::session();
        //判断是否登录状态下获取资源列表
        if(empty($this->session->get('ticket')) && empty($this->session->get('member')) ){
            die($this->returnMsg('非法请求，我们已记录此错误信息'));
        }

        $this->start = (int) trim($_GET['start']);

    }

    public function index(){

        $param = [
            'attachment_type' => $this->getType
        ];

        //客户登录状态下，获取自己上传的文件
        if(!empty($this->session->get('member'))){
            $condition = ' AND attachment_owner = 0 AND attachment_member_id = :id';
            $param['id'] = $this->session->get('member')['member_id'];
        }

        //管理员登录状态，则覆写搜索条件
        if(!empty($this->session->get('ticket'))){
            $condition = ' AND attachment_owner = 1';
        }

        $result = \Model\Content::listContent([
            'table' => 'attachment',
            'condition' => "attachment_type = :attachment_type {$condition}",
            'limit' => "{$this->start}, 20",
            'param' => $param
        ]);

        if(!empty($result)){
            foreach ($result as $item){
                $list[] = [
                    'url' => $item['attachment_path'],
                    'mtime' => $item['attachment_createtime'],
                    'name' => $item['attachment_name']
                ];
            }
        }

        return $this->returnMsg('SUCCESS', $list);
    }

    private function returnMsg($status, $list = array()){
        return json_encode([
            'state' => $status,
            'list' => $list,
            "start" => $this->start,
        ]);
    }

}

return (new resource())->index();