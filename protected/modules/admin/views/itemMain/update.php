<?php
$this->breadcrumbs=array(
	'Item Mains'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemMain', 'url'=>array('index')),
	array('label'=>'Create ItemMain', 'url'=>array('create')),
	array('label'=>'View ItemMain', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ItemMain', 'url'=>array('admin')),
);
?>

<h1>Update ItemMain <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>