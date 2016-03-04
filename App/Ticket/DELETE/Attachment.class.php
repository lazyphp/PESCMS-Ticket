<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.8
 * @version 1.0
 */

namespace App\Ticket\DELETE;

/**
 * 公用内容删除方法
 */
class Attachment extends Content {

    public function delete() {
        $file = \Model\Content::findContent('attachment', $_GET['id'], 'attachment_id');
        if (is_file(PES_PATH . $file['attachment_path'])) {
            if($file['attachment_type'] == '1'){
                $extension = pathinfo(PES_PATH . $file['attachment_path'])['extension'];
                unlink(PES_PATH . $file['attachment_path']."_50x50.{$extension}");
                unlink(PES_PATH . $file['attachment_path']."_150x150.{$extension}");
                unlink(PES_PATH . $file['attachment_path']."_300x300.{$extension}");
            }
            unlink(PES_PATH . $file['attachment_path']);
        }
        parent::delete();
    }

}