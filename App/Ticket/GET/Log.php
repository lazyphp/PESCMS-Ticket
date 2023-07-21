<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */


namespace App\Ticket\GET;

/**
 * 日志查询
 */
class Log extends \Core\Controller\Controller {

    /**
     * 只查询标准的日志目录
     * @return void
     */
    public function index(){

        $logPath = PES_CORE.self::$config['LOG_PATH'];

        $path = [];
        if ($handle = opendir("$logPath")) {
            while (false !== ($item = readdir($handle))) {
                $logDatePath = $logPath."/{$item}";
                if(in_array($item, ['.', '..', 'index.html']) || !is_dir($logDatePath) ){
                    continue;
                }

                if ($lastHandle = opendir($logDatePath)) {
                    while (false !== ($logFile = readdir($lastHandle))) {
                        if(in_array($logFile, ['.', '..', 'index.html']) || !is_file($logDatePath."/{$logFile}") ){
                            continue;
                        }

                        $path[$item][$logFile] = $item."/".substr($logFile, 0, -4);

                    }
                }

            }
        }
        
        krsort($path);

        $this->assign('title', '日志快查');
        $this->assign('path', $path);
        $this->layout();
    }

    public function view(){
        $file = str_replace(['/', '.', 'error_'], ['', '', '/error_'], $this->isG('file', '请提交您还要查询的日志文件'));


        $logFile = PES_CORE.self::$config['LOG_PATH'].'/'.$file.'.txt';

        if(!is_file($logFile)){
            $this->error('您要查询的日志文件不存在，请检查后再试。');
        }

        $log = str_replace(PES_CORE, '__PESCMS_SYSTEM_PATH__/', file_get_contents($logFile));

        $this->assign('title', "日志详情 - {$file}");
        $this->assign('log', $log);
        $this->layout();
    }

}