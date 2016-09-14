<?php

class UserRecoveryForm extends CFormModel {
	public $login_or_email, $user_id;
	
	public function rules(){
		return array(
			array('login_or_email', 'required'),
			array('login_or_email', 'match', 'pattern' => '/^[A-Za-z0-9@.-\s_,]+$/u','message' => "Неверный ввод"),
			array('login_or_email', 'checkexists'),
		);
	}
	
	public function attributeLabels(){
		return array(
			'login_or_email'=> "ID  или email",
		);
	}
	
	public function checkexists($attribute,$params) {
		if(!$this->hasErrors()){  // we only want to authenticate when no input errors
		
			if (strpos($this->login_or_email,"@")) {
				$user=User::model()->findByAttributes(array('email'=>$this->login_or_email));
				if ($user)
					$this->user_id=$user->id;
			} 
			else {
				$user=User::model()->findByAttributes(array('login'=>$this->login_or_email));
				if ($user)
					$this->user_id=$user->id;
			}
			
			if($user===null)
				if (strpos($this->login_or_email,"@")) {
					$this->addError("login_or_email","Пользователя с таким email не существует");
				} else {
					$this->addError("login_or_email","Пользователя с таким ID не существует");
				}
		}
	}
	
}