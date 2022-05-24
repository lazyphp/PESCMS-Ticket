<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
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
            \Model\Extra::stopSend($email['send_id'], $this->error);
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
            $sendStatus = [
                'msg' => '邮件发送成功。',
                'status' => 2,
                'second' => 0,
            ];
        }else{
            $sendStatus = [
                'msg' => '邮件发送失败!',
                'status' => 1,
                'second' => 600,
            ];
        }
        $sendStatus['id'] = $email['send_id'];
        $sendStatus['sequence'] = $email['send_sequence'];
        $sendStatus['full'] = '邮件发送没有详细信息';

        \Model\Extra::updateSendStatus($sendStatus);

        $this->PHPMailer->ClearAddresses();

        return $sendStatus;
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