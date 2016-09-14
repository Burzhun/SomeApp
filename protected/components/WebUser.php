<?php

class WebUser extends CWebUser
{
	private $_model;
	public $admin;

	protected function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null)
				$this->_model=User::model()->findByPk($id);
		}
		return $this->_model;
	}

	public function getIsAdmin()
	{
		return Yii::app()->session->get("admin") ==1;
	}

	public function getseehidden()
	{
		return $this->getState('seehidden')==1;
	}

	public function getIsActive()
	{
		return User::model()->findByPk(Yii::app()->user->id)->active==1;
	}

	protected function changeIdentity($id,$name,$states) 
	{ 
		// Yii::app()->getSession()->regenerateID(true); 
		$this->setId($id); 
		$this->setName($name); 
		$this->loadIdentityStates($states); 
	}
}