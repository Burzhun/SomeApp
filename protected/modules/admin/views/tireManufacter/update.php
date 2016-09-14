<?php
/* @var $this TireManufacterController */
/* @var $model TireManufacter */

$this->breadcrumbs=array(
	'Tire Manufacters'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TireManufacter', 'url'=>array('index')),
	array('label'=>'Create TireManufacter', 'url'=>array('create')),
	array('label'=>'View TireManufacter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TireManufacter', 'url'=>array('admin')),
);
?>

<h1>Update TireManufacter <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>