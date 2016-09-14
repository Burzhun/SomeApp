<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, производители' => array('/admin/manufacter'),
	$model->name => array('/admin/manufacter'),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List Manufacter', 'url'=>array('index')),
	array('label'=>'Create Manufacter', 'url'=>array('create')),
	array('label'=>'View Manufacter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Manufacter', 'url'=>array('admin')),
);
?>

<h1>Изменить производителя  <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>