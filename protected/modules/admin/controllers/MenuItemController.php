<?php

class MenuItemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

	/**
	 * @return array action filters
	 */


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
	$menu = Menu::model()->findByPk($id);

		$dataProvider=new CActiveDataProvider('MenuItem',array(
											'criteria'=>array(
												'condition'=>'menu_id='.$id,
												'order'=>'position, id DESC',
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));
		
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'menu'=>$menu,
		));
	}

	
			public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {
            $model = MenuItem::model()->findByPk($item);
            $model->position = $i;
            $model->save();
            $i++;
        }
      }
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MenuItem;

$id = (int)$_GET['menu_id'];
$menu = Menu::model()->findByPk($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		if(isset($_POST['MenuItem']))
		{
		$model->attributes=$_POST['MenuItem'];
		
			if(!empty($_FILES['MenuItem']['tmp_name']['image_form'])) {
			$name = ImageFuck::save($_FILES['MenuItem']['tmp_name']['image_form'], true);
			$model->image= $name; }
		///если выбрали ссылку на страницу
		if($_POST['page'] != "")
		{
		///это - id страницы
		$page = (int)$_POST['page'];
		
		//находим url, если не пустой то ставим его
		$page_model = Page::model()->findByPk($page);
		
		if(empty($page_model->url))
		$model->link = "/page/$page";
		else
		$model->link = $page_model->url;
		
		}

		if($model->page){
				$model->link = Page::model()->findByPk($model->page)->url;
			}
		
		
		$model->menu_id = $_GET['menu_id'];
		if($model->save())
				$this->redirect(array('view','id'=>$model->menu_id));
		}

		$this->render('create',array(
			'model'=>$model,
			'menu'=>$menu,
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
		/*if($model->page){
			$model->page = Page::model()->find('alias=:alias', array(':alias'=>$model->page))->id;
		}*/
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenuItem']))
		{
			$model->attributes=$_POST['MenuItem'];

						if(!empty($_FILES['MenuItem']['tmp_name']['image_form'])) {
			$name = ImageFuck::save($_FILES['MenuItem']['tmp_name']['image_form'], true);
			$model->image= $name; }
			

			if($model->page){
				$model->link = Page::model()->findByPk($model->page)->url;
			}

			
			if($model->save())
				$this->redirect(array('view','id'=>$model->menu_id));
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
		$dataProvider=new CActiveDataProvider('MenuItem');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MenuItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MenuItem']))
			$model->attributes=$_GET['MenuItem'];

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
		$model=MenuItem::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
