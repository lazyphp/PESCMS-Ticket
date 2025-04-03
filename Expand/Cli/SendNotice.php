<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

require 'Core.php';

/**
 * @todo 由于一些历史原因，这个文件现在不能随便改名了，改名将会导致老用户升级后，程序定时任务失效。
 * 只能在这里进行一个扩展，以便支持插件的定时任务。
 * 当然了，以后有更好的解决方案，会在新版本中进行调整。
 */
class SendNotice extends Core
{

    /**
     * 发送通知
     * @return void
     */
    public function notice()
    {
        $noticeWay = \Model\Content::findContent('option', 'notice_way', 'option_name')['value'];
        if (in_array($noticeWay, ['2', '3'])) {
            \Model\Notice::sendNotice();
        }

        \Model\Behavior::behavior();
    }

    /**
     * 插件定时任务
     * @return bool|void
     */
    public function pluginCrontab()
    {
        $crontabJSONFile = PES_CORE . 'crontab.json';

        if (!file_exists($crontabJSONFile)) {
            return true;
        }

        $jsonData = file_get_contents($crontabJSONFile);
        $crontabArray = json_decode($jsonData, true) ?? [];

        $lockDirPath = PES_CORE . 'crontab_locks';
        // 确保锁目录存在
        if (!is_dir($lockDirPath)) {
            mkdir($lockDirPath, 0755, true);
        }

        foreach ($crontabArray as $crontabFile) {
            // 解析命名空间和类名
            $className = str_replace('/', '\\', pathinfo($crontabFile, PATHINFO_DIRNAME)) . '\\Crontab';

            // 创建一个基于类名的唯一锁文件名
            $lockFileName = md5($className) . '.lock';
            $lockFile = $lockDirPath . '/' . $lockFileName;

            // 尝试获取锁
            $lockHandle = @fopen($lockFile, 'c+');
            if (!$lockHandle) {
                echo "无法创建锁文件: $lockFile \n";
                continue;
            }

            // 尝试获取一个非阻塞的排他锁
            if (flock($lockHandle, LOCK_EX | LOCK_NB)) {
                // 成功获取锁，可以执行任务
                try {
                    if (class_exists($className)) {
                        $crontabInstance = new $className();
                        if (method_exists($crontabInstance, 'run')) {
                            echo "执行任务: $className \n";
                            $crontabInstance->run(); // 执行 run() 方法
                        }
                    } else {
                        echo "类 $className 不存在 \n";
                    }
                } finally {
                    // 释放锁并关闭文件
                    flock($lockHandle, LOCK_UN);
                    fclose($lockHandle);
                    @unlink($lockFile); // 删除锁文件
                }
            } else {
                // 无法获取锁，说明任务正在运行
                echo "任务 $className 正在运行中，跳过 \n";
                fclose($lockHandle);
            }
        }
    }
}

$cronTab = new SendNotice();
$cronTab->notice();
$cronTab->pluginCrontab();
