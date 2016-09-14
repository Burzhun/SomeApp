<?php

class UserIdentity extends CUserIdentity
{
	 private $_id;
	 private $admin ;

	public function authenticate()
	{

	$user=User::model()->find(array(
    'condition'=>'email=:email',
    'params'=>array(':email'=>$this->username),
	));
 
		if($user===NULL)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		if($user->hash != PassHelper::hash($this->password, $user->salt))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {


			if($user->admin == 1) {
				$this->admin = true;
						Yii::app()->session->add("admin","1");
				}
			$this->errorCode=self::ERROR_NONE;
			$this->setState('admin', $user->admin);
			$this->setState('seehidden', $user->seehidden);
		    $this->_id=$user->id;
            $this->username=$user->name;
		}
		return !$this->errorCode;
	}
	   

	   public function getId()
    {
        return $this->_id;
    }


	   public function getAdmin()
    {
        return $this->admin;
    }
	   public function getseeHidden()
    {
        return $this->seehidden;
    }

    
}