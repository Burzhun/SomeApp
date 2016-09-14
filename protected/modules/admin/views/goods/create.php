<?php
$this->breadcrumbs=$breadcrumbs;
	

	
$this->pageTitle="Добавить товар $catalog->name / $subcatalog->name - ". Yii::app()->name;


$this->menu=array(
	array('label'=>'List Item', 'url'=>array('index')),
	array('label'=>'Manage Item', 'url'=>array('admin')),
);
?>

<h1>Добавить товар</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>


