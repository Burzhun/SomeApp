<?php

class CarouselController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
		//	'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
	/*	return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	*/
	}

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
		$model=new Carousel;
        $this->performAjaxValidation($model);

		if(isset($_POST['Carousel']))
		{
		
			$model->attributes=$_POST['Carousel'];
			$model->position = 0;
			if($model->validate()) {

			if(!empty($_FILES['Carousel']['tmp_name']['image_form']))
			$model->image = ImageFuck::save($_FILES['Carousel']['tmp_name']['image_form'], true);

			if(!empty($_FILES['Carousel']['tmp_name']['image_form2']))
			$model->image2 = ImageFuck::save($_FILES['Carousel']['tmp_name']['image_form2'], true);

			}

			$model->start = strtotime($model->start);
			$model->end = strtotime($model->end);

			if($model->save())
			{
			Yii::app()->user->setFlash('success', 'Баннер добавлен!');
			        $this->redirect(array('index'));
			}
				
		} 

		$this->render('create',array(
			'model'=>$model,
		));
	}

 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
			$model->start = date('d-m-Y',$model->start);
			$model->end = date('d-m-Y',$model->end);

		if(isset($_POST['Carousel']))
		{ 

			$model->attributes=$_POST['Carousel'];

			if(!empty($_FILES['Carousel']['tmp_name']['image_form']))
			$model->image = ImageFuck::save($_FILES['Carousel']['tmp_name']['image_form'], true);

			if(!empty($_FILES['Carousel']['tmp_name']['image_form2']))
			$model->image2 = ImageFuck::save($_FILES['Carousel']['tmp_name']['image_form2'], true);

			$model->start = strtotime($model->start);
			$model->end = strtotime($model->end);
			if($model->save()) {
						Yii::app()->user->setFlash('success', 'Баннер изменен!');		
			$this->redirect(array('index','id'=>$model->id));
		}}

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
				
			
			//удаляем все картиночки
			$model = Carousel::model()->findByPk($id);
			ImageFuck::delete($model->image);
				
			$this->loadModel($id)->delete();

	
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
		if($this->themeId){
			$dataProvider=new CActiveDataProvider('Carousel',array(
			                                  'criteria'=>array(
			                                    'order'=>'position, id DESC',
			                                    'condition'=>'type<>0',
			                       ),
			));
		}else{
			$dataProvider=new CActiveDataProvider('Carousel',array(
			                                  'criteria'=>array(
			                                    'order'=>'position, id DESC',
			                                    'condition'=>'type=0',
			                       ),
			));
		}
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

		public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {
            $catalog = Carousel::model()->findByPk($item);
            $catalog->position = $i;
            $catalog->save();
            $i++;
        }
      }
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Carousel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Carousel']))
			$model->attributes=$_GET['Carousel'];

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
		$model=Carousel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='carousel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
