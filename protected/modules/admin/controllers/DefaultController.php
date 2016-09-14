<?php

class DefaultController extends Controller
{
	public $layout='/layouts/column2';
	public function actionIndex(){
		$this->render('index');
	}

	public function actionGoodstore(){
		$model=new Goodstore('search');
		$model->unsetAttributes();
		if(isset($_GET['Goodstore']))
			$model->attributes=$_GET['Goodstore'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionGoodstone(){
		$model=new Goodstone('search');
		$model->unsetAttributes();
		if(isset($_GET['Goodstone']))
			$model->attributes=$_GET['Goodstone'];

		$this->render('stone',array(
			'model'=>$model,
		));
	}
	
		public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

		public function actionClearCache()
	{
Yii::app()->cache->flush();
Flash::success("Кэш очищен!");
$this->redirect("/admin");
	}
	
	
}