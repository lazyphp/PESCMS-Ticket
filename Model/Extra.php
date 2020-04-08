<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Model;

/**
 * 额外的模型
 * 主要存放一些冷门，定位不准确，傻傻的方法
 */
class Extra extends \Core\Model\Model {

    const EMAIL = 1;
    const URL = 2;
    const NUMBER = 3;
    const ALPHANUMERIC = 4;
    const PHONE = 5;

    /**
     * 生成唯一的ID
     */
    public static function getOnlyNumber() {
        $randStr = range('A', 'Z');
        shuffle($randStr);
        $microtime = explode(" ", microtime());
        $number = round($microtime['0'] * $microtime['1'] * rand(1, 100));

        $No = "";
        for ($i = 0; $i < rand(1, 10); $i++) {
            $No .= $randStr[$i];
        }
        return $No . $number;
    }


    /**
     * 验证输入的内容类型
     * @param $value 输入的内容
     * @param $type 验证的类型
     * @return bool 符合则返回true，反之false
     */
    public static function checkInputValueType($value, $type) {
        switch ($type) {
            case 1:
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            case 2:
                $preg = "/^1[3456789]\d{9}$/";
                if (!preg_match($preg, $value)) {
                    return false;
                }

                break;
            case 3:
                if (!is_numeric($value)) {
                    return false;
                }
                break;
            case 4:
                if(!preg_match("/^[a-z\d]$/i",$value)){
                    return false;
                }
                break;
            case 5:
                return filter_var($value, FILTER_VALIDATE_URL);
        }
        return true;
    }

    /**
     * 快速插入通知
     * @param string $title 标题 | 可以为空
     * @param $content 发送的内容
     * @param $type 通知类型
     * @return mixed
     */
    public static function insertSend($account, $title = '', $content, $type){
        $param = [
            'send_account' => $account,
            'send_title' => $title,
            'send_time' => time(),
            'send_content' => $content,
            'send_type' => $type
        ];
        return self::db('send')->insert($param);
    }

    /**
     * 执行通知发送
     */
    public static function actionNoticeSend(){
        $list = \Model\Content::listContent([
            'table' => 'send',
            'condition' => "send_time <= :time AND send_result = '' ",
            'lock' => 'FOR UPDATE',
            'param' => [
                'time' => time()
            ]
        ]);

        foreach ($list as $value) {
            switch ($value['send_type']) {
                case '1':
                    $result = (new \Expand\Notice\Mail())->send($value);
                    break;
                case '2':
                    $result = (new \Expand\sms())->send($value);
                    break;
                case '3':
                    $result = (new \Expand\weixin())->sendTemplate($value);
                    break;
                case '4':
                    $result = (new \Expand\weixinWork())->send_notice($value);
                    break;
            }

            if(DEBUG == true){
                echo "<p>{$value['send_type']}T: {$result}</p>";
            }

        }
    }

    public static function errorSendResult($sendID, $msg){
        \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
            'noset' => [
                'send_id' => $sendID
            ],
            'send_result' => $msg,
            'send_time' => time() + 600, //发送失败，则增加600秒时间，再重发
        ]);
    }

    /**
     * 移除指定目录下所有文件
     * @param string $dirName 要移除的目录
     * @param string $stopDir 停止移除的目录
     * @return array
     */
    public static function clearDirAllFile($dirName = PES_CORE.'Temp', $stopDir = PES_CORE.'Temp') {
        if ($handle = opendir("$dirName")) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dirName/$item")) {
                        self::clearDirAllFile("$dirName/$item");
                    } else {
                        if (!unlink("$dirName/$item")) {
                            return [
                                'status' => 0,
                                'msg' => "移除文件失败： $dirName/$item"
                            ];
                        }
                    }
                }
            }
            closedir($handle);
            if ($dirName == $stopDir) {
                return [
                    'status' => 200,
                    'msg' => "{$dirName}目录已清空"
                ];
            }

            if (!rmdir($dirName)) {
                return [
                    'status' => 0,
                    'msg' => "移除{$dirName}目录失败"
                ];
            }

        }
    }

    /**
     * 限制提交频率
     * @todo #1 实际上，这个功能应该交给redis来实现才对。可考虑到PT属于通用软件，让用户部署redis不现实，才使用PHP的session文件来实现。
     * @todo #2 此功能还应该结合redis/数据库/文件缓存，通过记录IP来实现进一步的限制。
     * @param $mark 标记名称
     * @param $frequency 合法的提交次数
     * @param $interval 提交间隔次数
     * @param string $msg 提示信息
     * @return bool
     */
    public static function limitSubmit($mark, $frequency, $interval, $msg = '你手速有点快，请休息一下再来'){
        $res = self::session()->get($mark);
        if(empty($res)){
            $res = [
                'frequency' => 1,
                'interval' => time()
            ];
            self::session()->set($mark, $res);
            return true;
        }

        if($res['frequency'] >= $frequency && $res['interval'] > time() - $interval){
            $res['interval'] = time();
            self::session()->set($mark, $res);
            self::error($msg);
        }elseif($res['frequency'] >= $frequency && $res['interval'] <= time() - $interval){
            $res['frequency'] = 1;
            $res['interval'] = time();
        }else{
            $res['frequency'] += 1;
            $res['interval'] = time();
        }
        self::session()->set($mark, $res);
        return true;

    }

}
