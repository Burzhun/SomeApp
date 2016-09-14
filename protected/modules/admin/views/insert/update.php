<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, вставки' => array('/admin/insert'),
	$model->name => array('/admin/insert'),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List Manufacter', 'url'=>array('index')),
	array('label'=>'Create Manufacter', 'url'=>array('create')),
	array('label'=>'View Manufacter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Manufacter', 'url'=>array('admin')),
);
?>

<h1>Изменить вставку  <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>