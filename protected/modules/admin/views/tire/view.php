<?php
/* @var $this TireController */
/* @var $model Tire */

$this->breadcrumbs=array(
	'Tires'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Tire', 'url'=>array('index')),
	array('label'=>'Create Tire', 'url'=>array('create')),
	array('label'=>'Update Tire', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tire', 'url'=>array('admin')),
);
?>

<h1>View Tire #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'size',
		'manufacter.name'
		'pr',
		'type',
		'image',
		'models',
	),
)); ?>
