<?php
$this->pageTitle="Добавить баннер - ". Yii::app()->name;
$this->breadcrumbs=array(
	'Управление баннерами'=>array('index'),
	'Добавить баннер',
);
	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('index'),
		'type'=>'primary',
		'icon'=>'eye-open white',
		'label'=>'Управление баннерами')
	); 
?>

<h1>Добавить баннер</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>