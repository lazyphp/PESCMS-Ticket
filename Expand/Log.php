<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Expand;

/**
 * 日志记录扩展
 */
class Log {

    private $config, $logPath, $path;

    public function __construct() {
        $this->checkPath();
        $this->deleteLog($this->logPath);
    }

    /**
     * 验证日志目录是否存在
     */
    private function checkPath() {
        $this->config = require CONFIG_PATH . 'config.php';

        $this->logPath = PES_CORE . $this->config['LOG_PATH'];

        $this->path = $this->logPath . date('/Ymd');

        \Expand\CreatePath::action($this->config['LOG_PATH']. date('/Ymd'), PES_CORE);
    }

    /**
     * 创建日志
     * @param type $fileName 日志名称
     * @param type $logContent 日志内容
     * @param bool $custom 是否客户自定义日志名称 | 默认为false
     */
    public function creatLog($fileName, $logContent, $custom = false) {
        $file = $custom === false ?  "{$this->path}/{$fileName}_" . md5(md5($this->config['PRIVATE_KEY'])) . ".txt" : $fileName ;

        if (!file_exists("$file")) {
            fopen("$file", "w");
            $fp = fopen("$file", 'ab');
        } else {
            $fp = fopen("$file", 'ab');
        }
        fwrite($fp, $logContent . "\n");
        fclose($fp);
    }

    /**
     * 移除过期的日志
     */
    public function deleteLog($path) {
        $expired = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - $this->config['LOG_DELETE'], date("Y")));
        if ($handle = opendir($path)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("{$path}/{$item}") && $item < $expired) {
                        $this->deleteLog("{$path}/{$item}");
                    } else {
                        if ($path != $this->logPath) {
                            unlink("{$path}/{$item}");
                        }
                    }
                }
            }
            closedir($handle);

            if ($path != $this->logPath) {
                rmdir($path);
            }
        }
    }

}
