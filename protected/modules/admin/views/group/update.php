<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Группы'=>array('index'),
	$model->name.' - Редактировать',
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'Create Group', 'url'=>array('create')),
	array('label'=>'View Group', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Group', 'url'=>array('admin')),
);
?>

<h3>Редактировать группу <?php echo $model->name; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>