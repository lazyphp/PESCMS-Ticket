<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace Expand\Notice;

class Mail {

    /**
     * 暴露一个PHPMailer的对象
     * @var \PHPMailer
     */
    public $PHPMailer;

    private $error;

    public function __construct() {
        //读取邮件账号信息
        $mail = json_decode(\Model\Content::findContent('option', 'mail', 'option_name')['value'], true);

        if(empty($mail['address']) || empty($mail['passwd']) || empty($mail['port']) ){
            $this->error = '未配置邮箱接口信息';
            return $this->error;
        }

        require_once dirname(__FILE__) . '/PHPMailerAutoload.php';
        $this->PHPMailer = new \PHPMailer;
        $this->PHPMailer->CharSet = "utf-8";
        $this->PHPMailer->isSMTP();
        $this->PHPMailer->Debugoutput = 'html';
        $this->PHPMailer->Host = $mail['address'];
        $this->PHPMailer->SMTPAuth = true;
        $this->PHPMailer->Username = $mail['account'];
        $this->PHPMailer->Password = $mail['passwd'];
        //修正465发送失败的问题
        switch ($mail['port']){
            case '465':
                $this->PHPMailer->SMTPSecure = 'ssl';
                break;
            case '587':
                $this->PHPMailer->SMTPSecure = 'tls';
                break;
        }
	    $this->PHPMailer->FromName =  empty($mail['formname']) ? 'system' : $mail['formname'];
        $this->PHPMailer->Port = $mail['port'];
        $this->PHPMailer->From = $mail['account'];
    }

    /**
     * 发送邮件
     */
    public function send(array $email) {
        if(!empty($this->error)){
            \Model\Extra::errorSendResult($email['send_id'], $this->error);
            return $this->error;
        }

        if(\Model\Extra::checkInputValueType($email['send_account'], 1) === false){
            return "'{$email['send_account']}'非邮箱地址";
        }

        $this->PHPMailer->addAddress($email['send_account']);

        $this->PHPMailer->WordWrap = 50;
        $this->PHPMailer->isHTML(true);

        $this->PHPMailer->Subject = $email['send_title'];
        $this->PHPMailer->Body = htmlspecialchars_decode($email['send_content']);

        if ($this->PHPMailer->send() !== false) {
            //发送成功，移除成功记录
            \Core\Func\CoreFunc::db('send')->where('send_id = :send_id')->delete([
                'send_id' => $email['send_id']
            ]);
        }else{
            $msg = '邮件发送失败';
            \Model\Extra::errorSendResult($email['send_id'], $msg);
        }
        $this->PHPMailer->ClearAddresses();
        return $msg;
    }

	/**
	 * 邮件发送测试
	 * @throws \Exception
	 * @throws \phpmailerException
	 */
	public function test($email){
		$this->PHPMailer->addAddress($email);

		$this->PHPMailer->WordWrap = 50;
		$this->PHPMailer->isHTML(true);

		//开启调试模式
		$this->PHPMailer->SMTPDebug = 2;

		$this->PHPMailer->Subject = '邮件发送测试';
		$this->PHPMailer->Body = '007!007!这里是002，听到请回答!听到请回答，over٩(๑`н´๑)۶';

		if ($this->PHPMailer->send() !== false) {
			echo '<h1>邮件发送成功!</h1>';
		}else{
			echo '<h1>这里是002，无法联系到007，兹……</h1>';
		}
		$this->PHPMailer->ClearAddresses();
	}
}