<?php
/* @var $this CollectionController */
/* @var $model Collection */

$this->breadcrumbs=array(
	'Коллекции'=>array('index'),
	$model->name.' - Редактировать',
);

$this->menu=array(
	array('label'=>'List Collection', 'url'=>array('index')),
	array('label'=>'Create Collection', 'url'=>array('create')),
	array('label'=>'View Collection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Collection', 'url'=>array('admin')),
);
?>

<h3>Редактировать коллекцию <?php echo $model->name; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>