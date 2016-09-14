<?php

class ItemImageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


	public function actionView($id)
	{







	$item = Item::model()->findByPk($id);
	$subcatalog = Catalog::model()->findByPk($item->catalog_id);
	$catalog = Catalog::model()->findByPk($subcatalog->parent_id);
	


$model = Catalog::model()->findByPk($item->catalog_id);		
//вычисление динамических хлебных крошек

		$breadcrumbs = array();


			$breadcrumbs[$item->name] = array('item/view', 'catalog_id' => $item->catalog_id);
			// текущие
			$breadcrumbs[$model->name] = " ";
		
		$parent_id = $model->parent_id;
		while ($parent_id != 0) {
			$temp = Catalog::model()->findByPk($parent_id);
			$parent_id = $temp->parent_id;
			$breadcrumbs[$temp->name] = array('catalog/index', id => $temp->id);
		}

		$breadcrumbs["Каталог"] = array('catalog/index');
		
		
		$breadcrumbs["Админка"] = array('/admin');
		
		//и реверс

		$breadcrumbs = array_reverse($breadcrumbs);


		$dataProvider=new CActiveDataProvider('ItemImage',array(
											'criteria'=>array(
												'condition'=>'item_id='.$id,
												'order'=>'position, id DESC',
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));
		
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'modelitem'=>$item,
			'subcatalog'=>$subcatalog,
			'catalog'=>$catalog,
			'breadcrumbs'=>$breadcrumbs,
		));
	}

	
		public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {
		
            $model = ItemImage::model()->findByPk($item);
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
	{	$item_id = (int)$_GET['id'];
		$item = Item::model()->findByPk($item_id);
		$subcatalog = Catalog::model()->findByPk($item->catalog_id);
		$catalog = Catalog::model()->findByPk($subcatalog->parent_id);
	
	
	
		$model=new ItemImage;
		
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ItemImage']))
		{
			$model->attributes=$_POST['ItemImage'];
			$model->item_id=$item_id;
			
			
			$name  =  ImageFuck::save($_FILES['ItemImage']['tmp_name']['filename']);
			$model->filename = $name;
			
			
			if($model->save())
				$this->redirect(array('view','id'=>$item_id));

		}

		$this->render('create',array(
			'model'=>$model,
			'modelitem'=>$item,
			'subcatalog'=>$subcatalog,
			'catalog'=>$catalog,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ItemImage']))
		{
			$model->attributes=$_POST['ItemImage'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->item->id));
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
			ImageFuck::delete($model->filename);
			$model->delete();

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
		$dataProvider=new CActiveDataProvider('ItemImage');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ItemImage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ItemImage']))
			$model->attributes=$_GET['ItemImage'];

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
		$model=ItemImage::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-image-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
