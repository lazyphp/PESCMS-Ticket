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

    public static $checkType = [
        '不验证' => 'noVerify',
        '电子邮箱' => '1',
        '国内手机号码' => '2',
        '数字' => '3',
        '英文' => '4',
        '网址' => '5',
        '英文数字' => '6'
    ];

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
            case 6:
                if(!preg_match("/^[a-z0-9\d]$/i",$value)){
                    return false;
                }
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

        //删除7天发送失败和成功的记录
        self::db('send')->where('send_time < :time AND send_status > 0')->delete([
            'time' => time() - 86400 * 7
        ]);

        //获取未发送或者重发少于5次的通知
        $list = \Model\Content::listContent([
            'table' => 'send',
            'condition' => "send_time <= :time AND send_status < 2 AND send_sequence < 5 ",
            'lock' => 'FOR UPDATE',
            'param' => [
                'time' => time()
            ]
        ]);

        foreach ($list as $value) {
            //@todo 此处代码可优化。基本上整个发送模式大部分代码都是相似的。唔……有时间再优化了。毕竟不影响运行效率，暂时以开发进度为主。
            switch ($value['send_type']) {
                case '1':
                    $result = (new \Expand\Notice\Mail())->send($value);
                    break;
                case '2':
                    $result = (new \Expand\SMS\SMSMain())->send($value);
                    break;
                case '3':
                    $result = (new \Expand\weixin())->sendTemplate($value);
                    break;
                case '4':
                    $result = (new \Expand\weixinWork())->send_notice($value);
                    break;
                case '5':
                    $result = (new \Expand\dingtalk())->send_notice($value);
                    break;
            }

            if(DEBUG == true){
                echo "<p>{$value['send_type']}T: {$result}</p>";
            }

        }
    }

    /**
     * 因配置等信息，直接终止发送
     * @param $sendID
     * @param $msg
     */
    public static function stopSend($sendID, $msg){
        \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
            'noset' => [
                'send_id' => $sendID
            ],
            'send_result' => $msg,
            'send_status' => 1,
            'send_sequence' => 5,
        ]);
    }

    /**
     * 更新发送状态
     * @param array $param 参数有 id, msg, status, second
     */
    public static function updateSendStatus(array $param){
        \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->update([
            'noset' => [
                'send_id' => $param['id']
            ],
            'send_result' => $param['msg'],
            'send_status' => $param['status'],
            'send_time' => time() + $param['second'], //发送失败，则增加600秒时间，再重发
            'send_sequence' => $param['sequence'] + 1,
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
        if(DEBUG == true){
            return true;
        }
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

    /**
     * 验证提交过来的密码
     * @return mixed|string
     */
    public static function verifyPassword(){
        $password = self::isP('password', '请填密码');
        $repassword = self::isP('repassword', '请填写再次确认密码');

        if(strlen($password) < 6){
            self::error('登录密码长度至少需要6位，请重新填写。');
        }

        if (strcmp($password, $repassword) != 0) {
            self::error('两次输入的密码不一致');
        }

        return $password;
    }

}
