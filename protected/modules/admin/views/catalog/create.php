<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, категории' => array('/admin/catalog'),
	"Добавить категорию");
$this->pageTitle="Добавить категорию - ". Yii::app()->name;
	
		$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('index'),
		'type'=>'primary',
		'icon'=>'eye-open white',
		'label'=>'Управление категориями')
	); 

?>

<h1>Добавить категорию</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>