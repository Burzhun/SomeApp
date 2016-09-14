<?php
$this->breadcrumbs=array(
	'Item Mains'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ItemMain', 'url'=>array('index')),
	array('label'=>'Create ItemMain', 'url'=>array('create')),
	array('label'=>'Update ItemMain', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ItemMain', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItemMain', 'url'=>array('admin')),
);
?>

<h1>View ItemMain #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item_id',
	),
)); ?>
