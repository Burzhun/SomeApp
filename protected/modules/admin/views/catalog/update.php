<?php


$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, категории' => array('/admin/catalog'),
	"Изменить категорию: $model->name");


?>
	<?php $this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Создать категорию')
	);  ?> 

	<?php	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('index'),
		'type'=>'primary',
		'icon'=>'eye-open white',
		'label'=>'Управление категориями')
	); ?>
<h1><?php echo "Изменить категорию: $model->name"; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>