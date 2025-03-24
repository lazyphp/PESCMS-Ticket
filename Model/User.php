<?php
/**
 * 版权所有 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class User extends \Core\Model\Model {

    /**
     * 生成工号
     * @return string
     */
    public static function generateJobNumber(): string {
        // 读取全局工号规则
        $format = \Model\Option::getOptionValue('job_number_format');

        // 确保格式包含 %d
        if (!preg_match('/%(\d*)d/', $format)) {
            self::error("工号格式 job_number_format 必须包含 %0N。请打开系统设置补上此占位符。", self::url('Ticket-Setting-action'));
        }

        // 查询最大工号（提取数字部分）
        $list = self::db('user')->field('user_job_number')->where("user_job_number REGEXP '[0-9]+'")->select();


        foreach ($list as $item) {
            preg_match_all('/\d+/', $item['user_job_number'], $matches);
            if (!empty($matches[0])) {
                $numbers[] = (int)end($matches[0]); // 取最后的数字部分
            }
        }

        // 计算新的序号
        $newNumber = $numbers ? max($numbers) + 1 : 1;

        // 生成新的工号
        return sprintf($format, $newNumber);
    }


}