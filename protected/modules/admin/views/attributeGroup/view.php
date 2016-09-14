<?php
/* @var $this AttributeGroupController */
/* @var $model AttributeGroup */

$this->breadcrumbs=array(
	'Attribute Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AttributeGroup', 'url'=>array('index')),
	array('label'=>'Create AttributeGroup', 'url'=>array('create')),
	array('label'=>'Update AttributeGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AttributeGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AttributeGroup', 'url'=>array('admin')),
);
?>

<h1>View AttributeGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'position',
	),
)); ?>
