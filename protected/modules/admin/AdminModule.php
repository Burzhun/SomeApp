<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
		
		Yii::app()->getComponent('bootstrap');
		Yii::app()->errorHandler->errorAction = '/admin/default/error';
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(isset($_POST['username'])) 
			{
				if($_POST['username'] == Yii::app()->params->admin_username)
					if($_POST['password'] == Yii::app()->params->admin_password)
					{
						Yii::app()->session->add("admin","1");
						Yii::app()->user->getState('admin', "1");
					}
			} 
		  
			if(Yii::app()->session->get("admin") != 1) 
			{ 
					?>
				<!DOCTYPE html>
				<html>
				<head>
				<title><?=Yii::app()->name?></title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link type="text/css" rel="stylesheet" media="all" href="/css/login.css" />
				</head>
				<body><form id="login" method= "POST">
				    <h1><?=Yii::app()->name?></h1>
				    <fieldset id="inputs">
				        <input id="username" name = "username" type="text" placeholder="Ваше имя" autofocus required>   
				        <input id="password" name="password" type="password" placeholder="Пароль" required>
				    </fieldset>
				    <fieldset id="actions">
				        <input type="submit" id="submit" value="Вход">
				    </fieldset>
				  </form>
				</body>
				</html>
				<?
			die();
			}

			return true;
		}
		else
			return false;
	}
}