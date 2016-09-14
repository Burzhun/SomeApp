<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление баннерами'=>array('index'),
	'Изменить',
);
$this->pageTitle="Изменить баннер $model->name - ". Yii::app()->name;
?>
	<?php $this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Создать баннер')
	);  ?> 

	<?php	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('index'),
		'type'=>'primary',
		'icon'=>'eye-open white',
		'label'=>'Управление баннерами')
	); ?>



<h1>Изменить баннер <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>