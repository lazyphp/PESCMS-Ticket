<?php
/**
 * Copyright (c) 2021 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace App\Ticket\DELETE;

/**
 * 公用内容删除方法
 */
class Attachment extends Content {

    public function delete() {
        $file = \Model\Content::findContent('attachment', $_GET['id'], 'attachment_id');
        if (is_file(APP_PATH . $file['attachment_path'])) {
            if($file['attachment_type'] == '1'){
                $extension = pathinfo(APP_PATH . $file['attachment_path'])['extension'];
                unlink(APP_PATH . $file['attachment_path']."_150x150.{$extension}");
            }
            unlink(APP_PATH . $file['attachment_path']);
        }
        parent::delete();
    }

}