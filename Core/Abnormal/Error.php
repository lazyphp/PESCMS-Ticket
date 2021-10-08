<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core\Abnormal;

use Core\Func\CoreFunc as CoreFunc;

/**
 * 错误机制
 */
class Error {

    private static $prompt = '';

    /**
     * 自定义错误提示
     * @param type $errno 错误等级|值
     * @param type $errstr 错误类型
     * @param type $errfile 错误文件
     * @param type $errline 错误行数
     */
    public static function getError($errno, $errstr, $errfile, $errline) {
        //调试模式关闭的状态下和ajax请求将不输出任何信息
        if (DEBUG === false || !empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return true;
        }

        $str = "<b>%s</b></b>{$errstr}<br /><b>File</b>：{$errfile} <b>Line {$errline}</b><br />";

        switch ($errno) {
            case E_ERROR:
                echo sprintf($str, "Error");
                break;
            case E_WARNING:
                echo sprintf($str, "Warning");
                break;
            case E_PARSE:
                echo sprintf($str, "Parse Error");
                break;
            case E_NOTICE:
                echo "";
                break;
            case E_CORE_ERROR:
                echo sprintf($str, "Core Error");
                break;
            case E_CORE_WARNING:
                echo sprintf($str, "Core Warning");
                break;
            case E_COMPILE_ERROR:
                echo sprintf($str, "Compile Error");
                break;
            case E_COMPILE_WARNING:
                echo sprintf($str, "Compile Warning");
                break;
            case E_USER_ERROR:
                echo sprintf($str, "User Error");
                break;
            case E_USER_WARNING:
                echo sprintf($str, "User Warning");
                break;
            case E_USER_NOTICE:
                echo sprintf($str, "User Notice");
                break;
            case E_STRICT:
                echo sprintf($str, "Strict Notice");
                break;
            case E_RECOVERABLE_ERROR:
                echo sprintf($str, "Recoverable Error");
                break;
            default:
                echo sprintf($str, "Unknown error ($errno)");
                break;
        }
    }

    /**
     * 自定义脚本停止执行提示
     */
    public static function getShutdown() {
        $error = error_get_last();
        if ($error) {
            if (strstr($error['message'], 'PHP Startup')) {
                echo '当前PHP环境有扩展加载失败';
                exit;
            }
            //记录日志
            self::recordLog($error);
            if (DEBUG == true) {

                $message = $error['message'];
                $file = $error['file'];
                $line = $error['line'];
                //由于能力有限，目前仅显示致命错误和解析错误。
                switch ($error['type']) {
                    case '1':
                        $type = 'Fatal error';
                        break;
                    case '4';
                        $type = 'Parse error';
                        break;
                    default :
                        $type = 'PHP error';
                }
                $errorMsg = "<b>{$type}:</b>{$message}";
                $errorFile = "<b>File:</b>{$file}<b>Line:</b>{$line}";
            } else {
                $errorMsg = "服务器当前出了点小差。请稍后再尝试。";
                $errorFile = "此错误我们将会记录起来。";
            }
            header("HTTP/1.1 500 Internal Server Error");
            $title = "500 内部服务器错误";

            if (!empty($db->errorInfo)) {
                CoreFunc::isAjax(['msg' => $errorMsg], 500);
            }
            CoreFunc::isAjax(['msg' => $errorMsg], 500);

            require self::promptPage();
            exit;
        }
    }

    /**
     * SQL执行错误提示信息
     */
    public static function errorSql() {
        $db = CoreFunc::db();
        
        if (!empty($db->errorInfo)) {
            self::recordLog(implode("\r", $db->errorInfo), false);
        }
        if (DEBUG == true) {
            /**
             * 处理最后一次执行的 SQL
             */
            if (!empty($db->getLastSql)) {
                if (!empty($db->param)) {
                    foreach ($db->param as $key => $value) {
                        $placeholder[] = ":{$key}";
                        $paramValue[] = "'{$value['value']}'";
                    }
                    $sql = str_replace($placeholder, $paramValue, $db->getLastSql);
                } else {
                    $sql = $db->getLastSql;
                }
            }

            $errorMsg = "<b>Sql Run Message</b>: {$db->errorInfo['message']}";
            $errorFile = "<b>Sql Error Info</b>:<br/>" . implode("<br/>", explode("\n", $db->errorInfo['string']));
        } else {
            $errorMsg = "服务器当前出了点小差。请稍后再尝试。";
            $errorFile = "此错误我们将会记录起来。";
        }
        header("HTTP/1.1 500 Internal Server Error");
        $title = "500 内部服务器错误";

        CoreFunc::isAjax(['msg' => $errorMsg], 500);
        require self::promptPage();
        exit;
    }

    /**
     * 记录错误日志
     * @param type $error 错误信息
     */
    private static function recordLog($error, $extract = true) {
        $fileName = 'error_' . md5(self::loadConfig('PRIVATE_KEY') . date("Ymd"));
        $msg = 'Date:' . date('Y-m-d H:i:s') . "\rTimestamp:" . time() . "\r";
        if ($extract == true) {
            $msg .= "Rank[{$error['type']}] PHP error: {$error['message']}\rFile:{$error['file']};Line:{$error['line']}\r\r";
        } else {
            $msg .= "{$error}\r";
        }
        $msg .= "\r\r";

        $log = new \Expand\Log();
        $log->creatLog($fileName, $msg);
    }

    /**
     * 获取提示页
     * @return type 返回模板
     */
    private static function promptPage() {
	    if(is_file(THEME_PATH.'/error.php')){
		    return THEME_PATH.'/error.php';
	    }else{
		    return PES_CORE . 'Core/Theme/error.php';
	    }

    }

    /**
     * 获取系统配置信息
     * @param type $name 配置信息 | 为空则获取所有
     * @return type 返回配置信息
     */
    private static function loadConfig($name = NULL) {
        return CoreFunc::loadConfig($name);
    }

}
