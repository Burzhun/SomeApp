<?php

class CatalogController extends Controller
{
	
	
	public $layout='/layouts/column2';

	
	
	public function actionView($parent_id)
	{
	
	$model = Catalog::model()->findByPk($parent_id);
		$dataProvider=new CActiveDataProvider('Catalog',array(
											'criteria'=>array(
												'condition'=>'parent_id='.$parent_id,
												'order'=>'position, id DESC',
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));



	

		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}


	
	public function actionCreate()
	{
	$model = new Catalog();	
        if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
			if(empty($_POST['Catalog']['parent_id']))
			{
				$model->parent_id = 0;
			}	

			if(!$model->alias)
			$model->alias = Translit::url($model->name);
			

			if($model->validate()) {
			$name = ImageFuck::save($_FILES['Catalog']['tmp_name']['image_form'], true);
			$model->image= $name; 	

			// $name = ImageFuck::save($_FILES['Catalog']['tmp_name']['image_form2'], true);
			// $model->image2= $name; 

		}

			if($model->save())
			{
			    if (!empty($_GET['parent_id']))
				{
				Yii::app()->user->setFlash('success', "Подкатегория <b>$model->name</b> успешно добавлена");
				$this->redirect(array('index', 'parent_id'=>$model->parent_id));
			    }else{
				Yii::app()->user->setFlash('success', "Категория <b>$model->name</b> успешно добавлена");
				$this->redirect(array('index'));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Catalog']))
		{
			$model->attributes=$_POST['Catalog'];
			
			if(!empty($_FILES['Catalog']['tmp_name']['image_form'])) {
			$name = ImageFuck::save($_FILES['Catalog']['tmp_name']['image_form'], true);
			$model->image= $name; }

			// if(!empty($_FILES['Catalog']['tmp_name']['image_form2'])) {
			// $name = ImageFuck::save($_FILES['Catalog']['tmp_name']['image_form2'], true);
			// $model->image2= $name; }

			if($model->save()) {
           Yii::app()->user->SetFlash('success', "Категория $model->name изменена!");	
				if($model->parent_id == 0) 
				$this->redirect(array('index'));
				else
				$this->redirect(array('index','parent_id'=>$model->parent_id));				
		}}
		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionCount()
	{

$catalogs = Catalog::model()->findAll();
if(!empty($catalogs)) 
{

foreach ($catalogs as $catalog) {
		

	$sum = 0;

	if(!empty($catalog->Sub))
		foreach ($catalog->Sub as $item) {
					if(!empty($item->Sub)) {
						foreach ($item->Sub as $parent) {
							$sum+=$parent->itemsCount;				
						}
					}
					$sum+=$item->itemsCount;
			}
	$sum+=$catalog->itemsCount;

	$catalog->count = $sum;
	$catalog->save();

}
           Yii::app()->user->SetFlash('success', "Счетчики обновлены!");	
	$this->redirect('/admin');
}

	}

	public function actionDelete($id)
	{
	
	/*
	
				$model=$this->loadModel($id);
			
			
			if($model->images[0]->id == null) {} else {
			foreach($model->images as $image)
			{
			ImageFuck::delete($image->filename);
			}}
			$model->delete();
	*/
		if(Yii::app()->request->isPostRequest)
		{
		
			$model = $this->loadModel($id);

		if($model->parent_id == 0) 
		{
		if(isset($model->Sub[0]->id)) 
		{
			foreach ($model->Sub as $sub)  
				{
				if(isset($sub->Items[0]->id))
					{					
					foreach($sub->Items as $item) 	{
							if(isset($item->images[0]->id))		{
										foreach($item->images as $image) { ImageFuck::delete($image->filename); }
														    	}	
							$item->delete();
													}
					$sub->delete();
					} 
				}
		}
		}
		 else 
		{

				if(isset($model->Items[0]->id))
					{					
					foreach($model->Items as $item) 	{
							if(isset($item->images[0]->id))		{
										foreach($item->images as $image) { ImageFuck::delete($image->filename); }
														    	}	
							$item->delete();
													}
					
					} 
				
		}

		
		
		
		$model->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

		public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {
            $catalog = Catalog::model()->findByPk($item);
            $catalog->position = $i;
            $catalog->save();
            $i++;
        }
      }
	}

	public function actionIndex()
	{	
$itemProvider = '';
$breadcrumbs = array();
$breadcrumbs["Админка"] = array('/admin');
$breadcrumbs["Каталог"] = array('catalog/index');
//Functions::dbupdate();
$id = Yii::app()->request->getParam('parent_id');

if(!empty($id))    {

$criteria_parent = $id;
$model = $this->loadModel($id);	



		$itemProvider=new CActiveDataProvider('Item',array(
											'criteria'=>array(
												'condition'=>'catalog_id='.$id,
												'order'=>'position, id DESC',
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));		
//вычисление динамических хлебных крошек

		$breadcrumbs = array();

			// текущие
			$breadcrumbs[$model->name] = " ";
		
		$parent_id = $model->parent_id;
		while ($parent_id != 0) {
			$temp = Catalog::model()->findByPk($parent_id);
			$parent_id = $temp->parent_id;
			$breadcrumbs[$temp->name] = array('catalog/index', 'parent_id' => $temp->id);
		}
		$breadcrumbs["Каталог"] = array('catalog/index');
		$breadcrumbs["Админка"] = array('/admin');
		//и реверс
		$breadcrumbs = array_reverse($breadcrumbs);

} else
$criteria_parent = 0;


		$dataProvider=new CActiveDataProvider('Catalog',array(
											'criteria'=>array(
												'condition'=>'parent_id='.$criteria_parent,
												'order'=>'position, id DESC',
											),
											'pagination'=>array(
												'pageSize'=>100,
											),
		));


		$this->render('index',array(
			'model'=>$model,
			'itemProvider'=>$itemProvider,
			'dataProvider'=>$dataProvider,
			'breadcrumbs'=>$breadcrumbs,
	
		));
	}


	public function actionAdmin()
	{
		$model=new Catalog('search');
		$model->unsetAttributes(); 
		if(isset($_GET['Catalog']))
			$model->attributes=$_GET['Catalog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		$model=Catalog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}




	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
