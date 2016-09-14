<?php
/* @var $this TireManufacterController */
/* @var $model TireManufacter */

$this->breadcrumbs=array(
	'Tire Manufacters'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TireManufacter', 'url'=>array('index')),
	array('label'=>'Create TireManufacter', 'url'=>array('create')),
	array('label'=>'Update TireManufacter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TireManufacter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TireManufacter', 'url'=>array('admin')),
);
?>

<h1>View TireManufacter #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'position',
	),
)); ?>
