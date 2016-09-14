<?php

class GoodsController extends Controller
{
	public $layout='/layouts/column2';

	public function actionAjaxUpdate(){
		$kod = Yii::app()->request->getParam('id');
		$model = $this->loadModel($kod);

		$info = ItemInfo::model()->find('item_id=:id',array(':id'=>$model->kod));
		if(!$info){
			$info = new ItemInfo;
			$info->item_id = $model->kod;
		}

		$data['list'] = $this->renderPartial('updateAjax',array(
			'model'=>$model,
			'info'=>$info,
		), true, false);
		//$data['list'] = 'ds';
		echo CJSON::encode($data);
		die();

	}

	public function actionAjaxUpdateItem(){

		if(isset($_POST['Goods'])){
			$id = $_POST['Goods']['id'];
			if($id){
				$model = $this->loadModel($id);
 				$model->attributes = $_POST['Goods'];

 				$info = ItemInfo::model()->find('item_id=:id',array(':id'=>$model->kod));
				if(!$info){
					$info = new ItemInfo;
					$info->item_id = $model->kod;
				}
 				$info->attributes = $_POST['ItemInfo'];
 				$info->save(false);

 				$model->kubachiCollection = $_POST['Goods']['kubachiCollection'];

 				if($model->save(false)){
 					echo 'Данные сохранены';
 					die();
 				}else{
 					echo 'Не прошла валидацию';
 					die();
 				}
			}
 		}

	}

 	public function actionUpdate($kod)
 	{
 		$model = $this->loadModel($kod);

 		$info = ItemInfo::model()->find('item_id=:id',array(':id'=>$model->kod));
		if(!$info){
			$info = new ItemInfo;
			$info->item_id = $model->kod;
		}

 		if(isset($_POST['Goods']) || isset($_POST['ItemInfo']))
 		{
 			$model->attributes = $_POST['Goods'];
 			$info->attributes = $_POST['ItemInfo'];

 			$info->save(false);


				$files = CUploadedFile::getInstancesByName('files');
			if(!empty($files))
			{

				foreach($_FILES['files']['name'] as $key=>$filename)
				{
					$itemimg = new Goodimage;
					$name    = ImageFuck::save($_FILES['files']['tmp_name'][$key]);
					$itemimg->filename = $name;
					$itemimg->good = $kod;
					$itemimg->save(false);
				}
				Yii::app()->user->SetFlash('success', "Фото добавлены!");
			}

			//$model->main = 1;

			$model->kubachiCollection = $_POST['Goods']['kubachiCollection'];

			if($model->save(false))
			{
				$this->redirect(array('/admin/goods/admin'));
			}
 		}

		$dataProvider=new CActiveDataProvider('Goodimage',array(
										'criteria'=>array(
											'condition'=>'good =  "'.$kod.'"',
											'order' => 'position, id DESC',
										),
										'pagination'=>array(
											'pageSize'=>100,
										),));




		$this->render('update',array(
			'breadcrumbs'=>$breadcrumbs,
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'info'=>$info,
		));
	}


	public function actionSort()
	{
	  if (isset($_POST['items']) && is_array($_POST['items']))
	  {
        $i = 1;
        foreach ($_POST['items'] as $item)
        {

            $model = Goodimage::model()->findByPk($item);
            $model->position = $i;
            $model->save();
			$i++;
        }
      }
	}

	public function actionDeleteImage($id)
	{
		$img = Goodimage::model()->findByPk($id);
		$img->delete();
	}

	public function actionDeleteMainItem($kod){
		if(Yii::app()->controller->themeId == 1){
			$good = ItemInfo::model()->find('item_id=:kod',array(':kod'=>$kod));
			$good->main = 0;
			$good->save(false);
		}else{
			echo $kod;
			$good = Goods::model()->find('kod=:kod',array(':kod'=>$kod));
			$good->main = 0;
			$good->save(false);
		}
	}

	public function actionAdmin()
	{
		$model=new Goods('search');
		$model->unsetAttributes();
		if(isset($_GET['Goods']))
			$model->attributes=$_GET['Goods'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionMainItem()
	{
		$model=new Goods('searchMainItem');
		$model->unsetAttributes();
		if(isset($_GET['Goods']))
			$model->attributes=$_GET['Goods'];

		$this->render('mainItem',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Goods::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}