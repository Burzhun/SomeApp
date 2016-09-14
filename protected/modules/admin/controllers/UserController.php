<?php

class UserController extends Controller
{

public $name = "Пользователи";

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model=new User;


		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);


		if(isset($_POST['User']))
		{
			$laststatus = $model->active;	
			$model->attributes=$_POST['User'];

			if($model->password_form)
			{
			$model->salt = PassHelper::salt();
			$model->hash = PassHelper::hash($model->password_form,$model->salt);
			}

			if($laststatus==0)
				if($model->active)
				{
		$mailer           = Yii::app()->mail;
		$mailer->From     = Yii::app()->params['email'];
		$mailer->FromName = Yii::app()->name;
		$mailer->Subject  = "Ваша учетная запись подтверждена!";
		$mailer->Body     = "Вы можете войти на сайт!";
		$mailer->AddAddress($model->email);
		$mailer->isHtml(1);
		$mailer->send();
				}

			if($model->save())
					$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

 	if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
 

 
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
