<?
class SendMail extends CFormModel
{

	public $subject;
	public $sender_name;
	public $sender_email;
	public $body;
	public $test;
	public $useHtml;

	public function rules()
	{
		return array(
			array('subject, sender_name, sender_email, body', 'required'),
			array('sender_email', 'email'),
			array('useHtml', 'boolean'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'subject'      => 'Тема',
			'sender_name'  => 'Имя отправителя',
			'sender_email' => 'Email отправителя',
			'body'         => 'Сообщение',
			'useHtml'      => 'HTML формат',
		);
	}

	public function send()
	{
		$mails = Email::model()->findAll();

		$mailer           = Yii::app()->mail;
		$mailer->From     = $this->sender_email;
		$mailer->FromName = $this->sender_name;
		$mailer->Subject  = $this->subject;
		$mailer->Body     = $this->body;
		$mailer->AddReplyTo($this->sender_email);
		$mailer->isHtml((boolean)$this->useHtml);

		foreach($mails as $mail)
		{
			$mailer->ClearAllRecipients();
			$mailer->AddAddress($mail->email);
			$mailer->Send();
		}
		return true;
	}

}