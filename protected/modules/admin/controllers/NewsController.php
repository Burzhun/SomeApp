<?php

class NewsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';

	/**
	 * @return array action filters
	 */


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new News;
		$model->date = date('d-m-Y',time());
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
		$model->attributes=$_POST['News'];
		$model->theme = $this->themeId;
		$model->date = strtotime($model->date);
		if(!isset($_FILES['News']['tmp_name']['image'])) {} else {
			$name  =  ImageFuck::save($_FILES['News']['tmp_name']['image']);
			$model->image = $name;    }


			$model->date = time();
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Новость <b>$model->title</b> успешно добавлена");
				$this->redirect(array('index'));
			}else{
				$model->date = date('d-m-Y',$model->date);
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->date = date('d-m-Y',$model->date);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['News']))
		{
		$oldimage = $model->image;
		$model->attributes=$_POST['News'];
		$model->date = strtotime($model->date);
			if(empty($_FILES['News']['tmp_name']['image'])) {
			$model->image = $oldimage;
			} else {
			$name  =  ImageFuck::save($_FILES['News']['tmp_name']['image']);
			ImageFuck::delete($oldimage);
			$model->image = $name;
								}




			if($model->save()) {
				Yii::app()->user->setFlash('success', "Новость <b>$model->title</b> изменена");
			$this->redirect(array('index'));
			}else{
				$model->date = date('d-m-Y',$model->date);
			}
	}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{

			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			$model->delete();
			ImageFuck::delete($model->image);
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('News',array(
											'criteria'=>array(
												'order'=>'date DESC',
												'condition'=>'theme='.$this->themeId,
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));


		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
