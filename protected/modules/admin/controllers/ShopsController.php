<?php

class ShopsController extends Controller
{
	public $layout='//layouts/column1';
	public $name = 'Магазины';

	public function actionCreate(){
		$this->breadcrumbs[$this->name]='/admin/shops'; 

		$model=new Shops;
		//$model->date = date('d-m-Y',time());

		if(isset($_POST['Shops'])){
			$model->attributes=$_POST['Shops'];

			//$model->date = strtotime($model->date);

			// Если загружается картинка
			/*$model->file=CUploadedFile::getInstance($model,'file');
			if($model->validate()){
				if($model->file){
					$name = md5(mt_rand()+time()).'.'.$model->file->extensionName;
					$model->file->saveAs($model->dir.$name);
					$model->image = $name;
				}
			}else{
				$model->date = date('d-m-Y',$model->date);
			}*/

			if($model->save()){
				Yii::app()->user->setFlash('success', 'Пункт <b>'.$model->name.'</b> успешно добавлен');
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id){
		$this->breadcrumbs[$this->name]='/admin/shops'; 
		$model=$this->loadModel($id);

		/*$model->date = date('d-m-Y',$model->date);
		$oldImage = $model->image;*/

		if(isset($_POST['Shops'])){
			$model->attributes=$_POST['Shops'];

			//$model->date = strtotime($model->date);
			//$model->file=CUploadedFile::getInstance($model,'file');

			// Если загружается картинка
			/*if($model->validate()){
				if($model->file){
					$name = md5(mt_rand()+time()).'.'.$model->file->extensionName;
					$model->file->saveAs($model->dir.$name);
					$model->image = $name;
					$model->removeImage = $oldImage; // если загрузили новую картинку, то удаляем старую
				}else{
					if($model->removeImage){
						$model->image = '';
					}else{
						$model->image = $oldImage;
					}
				}
			}else{
				$model->date = date('d-m-Y',$model->date);
			}	*/

			if($model->save()){
				Yii::app()->user->setFlash('success', 'Пункт <b>'.$model->name.'</b> успешно изменен');
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id){
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex(){
		/*$dataProvider=new CActiveDataProvider('Shops');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		$model=new Shops('search');
		$model->unsetAttributes();  
		if(isset($_GET['Shops']))
			$model->attributes=$_GET['Shops'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionView($id){
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function loadModel($id){
		$model=Shops::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='shops-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSort(){
	    if (isset($_POST['items']) && is_array($_POST['items'])) {
	        $i = 0;
	        foreach ($_POST['items'] as $item) {
	            $model = Shops::model()->findByPk($item);
	            $model->position = $i;
	            $model->save();
	            $i++;
	        }
	    }
	}
}
