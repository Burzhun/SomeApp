<?php

class GoodtypeController extends Controller
{
	public $layout='column2';
	
	public function actionUpdate($id)
	{
		$model=Goodtype::model()->find(array('condition'=>"idgoodtype = '".$id."'"));

		
		if(isset($_POST['Goodtype']))
		{
			$model->attributes=$_POST['Goodtype'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Goodtype');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Goodtype::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='goodtype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
