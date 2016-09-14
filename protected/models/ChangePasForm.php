<?php

class ChangePasForm extends CFormModel
{
	public $password;
	public $dpassword;
	public $oldpassword;
	private $_identity;
	
	public function rules(){
		return array(
			array('password,dpassword, oldpassword', 'required'),
			array('password', 'compare', 'compareAttribute'=>'dpassword', 'message'=>'Пароли не совпадают'),
			array('password', 'authenticate'),
		);
	}

	public function authenticate($attribute,$params){
		$user = User::model()->findbyPk(Yii::app()->user->id);
		if($user){
			
			$this->_identity=new UserIdentity($user->email,$this->oldpassword);
			if(!$this->_identity->authenticate())
				$this->addError('oldpassword','Неправильный пароль');
			else
				return true;
			/*if($user->validatePassword($this->oldpassword)){
				return true;
			}else{
				$this->addError('oldpassword','Неправильный пароль');
			}*/
		}else{
			$this->addError('oldpassword','Вы не авторизованы!');
		}
	}

	public function attributeLabels(){
		return array(
			'password' => 'Новый пароль',
			'oldpassword' => 'Старый пароль',
			'dpassword'=>'Повоторите пароль',
		);
	}
}
