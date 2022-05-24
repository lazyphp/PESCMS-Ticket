<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\GET;

class Model extends Content {

    /**
     * 导入模型
     */
    public function import(){
        $this->layout();
    }

    /**
     * 导出模型
     */
    public function export(){
        $model = \Model\Content::findContent('model', $_GET['model_id'], 'model_id');
        if(empty($model)){
            $this->error('不存在的模型');
        }

        $table = $this->db()->fetch("SHOW CREATE TABLE {$this->prefix}".strtolower($model['model_name']));


        $field = $this->db('field')->where('field_model_id = :field_model_id')->select([
            'field_model_id' => $model['model_id']
        ]);

        $export = [
            'model' => $model,
            'field' => empty($field) ? '' : $field,
            'table' => empty($table['Create Table']) ? '' : $table['Create Table']
        ];

        $this->assign('model', $model);
        $this->assign('export', $export);
        $this->layout();
    }


}
