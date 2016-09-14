<?php
$this->breadcrumbs=array(
	'Item Images'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemImage', 'url'=>array('index')),
	array('label'=>'Create ItemImage', 'url'=>array('create')),
	array('label'=>'View ItemImage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ItemImage', 'url'=>array('admin')),
);
?>

<h1>Update ItemImage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>