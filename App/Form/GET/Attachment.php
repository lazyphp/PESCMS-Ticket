<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Form\GET;

class Attachment extends \Core\Controller\Controller {

    public function index(){
        $id = $this->isG('id', '请提交正确的ID');
        $attachment = $this->db('attachment')->where('attachment_id = :attachment_id')->find(['attachment_id' => $id]);

        if (empty($attachment) ||
            (
                !empty($attachment) &&
                $attachment['attachment_member_id'] != '-1' && // 非匿名文件
                (
                    empty($this->session()->get('ticket')) &&  // 未登录
                    ($this->session()->get('member')['member_id'] ?? null) != $attachment['attachment_member_id'] // 登录用户非上传人
                )
            )
        ) {
            $this->_404(false,'文件不存在');
        }
        $extension = pathinfo($attachment['attachment_path'], PATHINFO_EXTENSION);
        $uploadExt = \Model\Option::getOptionValue('upload_img', true);


        // 检查文件是否存在
        $filePath = HTTP_PATH.$attachment['attachment_path'];

        if (!file_exists($filePath)) {
            $this->_404(false,'文件不存在');
        }

        if(in_array(".{$extension}", $uploadExt)){
            // 输出图片
            header('Content-Type: ' . mime_content_type($filePath));
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
        }else{
            // 触发文件下载
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
        }

    }

}