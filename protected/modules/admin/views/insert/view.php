<?php
$this->breadcrumbs=array(
	'Manufacters'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Manufacter', 'url'=>array('index')),
	array('label'=>'Create Manufacter', 'url'=>array('create')),
	array('label'=>'Update Manufacter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Manufacter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Manufacter', 'url'=>array('admin')),
);
?>

<h1>View Manufacter #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'position',
	),
)); ?>
