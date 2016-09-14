<?php

class StoneController extends Controller
{
 
	public $layout='/layouts/column2';
	public $name = "Камни";
 

	public function actionView($kod)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($kod),
		));
	}
 
	public function actionCreate()
	{
		$model=new Stone;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stone']))
		{
			$model->attributes=$_POST['Stone'];
			$model->kod='000000002213';


			if($model->validate())
			{
				$name = ImageFuck::save($_FILES['Stone']['tmp_name']['image'], true);
				$model->imageStone = new StoneImage();
				$model->imageStone->filename = $name; 
				$model->imageStone->stonekod = $model->kod;
				$model->imageStone->save();
			}

			if($model->save())
			{
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $kod the ID of the model to be updated
	 */
	public function actionUpdate($kod)
	{
		$model=$this->loadModel($kod);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stone']))
		{
			$model->imageStone = new StoneImage();
			$oldimage = $model->imageStone->filename;
	 		$model->attributes=$_POST['Stone'];
			if(empty($_FILES['Stone']['tmp_name']['image'])) {
				$model->imageStone->filename = $oldimage; 
			} else {
				$name  =  ImageFuck::save($_FILES['Stone']['tmp_name']['image'],true);
				ImageFuck::delete($oldimage);
				$model->imageStone->filename = $name;
				$model->imageStone->stonekod = $kod;
				$model->imageStone->save();
			}
 
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $kod the ID of the model to be deleted
	 */
	public function actionDelete($kod)
	{
		$this->loadModel($kod)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Stone');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Stone('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stone']))
			$model->attributes=$_GET['Stone'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($kod)
	{
		$model=Stone::model()->findByPk($kod);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tire-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
