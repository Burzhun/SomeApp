<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Группы'=>array('index'),
	$model->name.' - Редактирование',
);?>

<h3>Редактирование - <?php echo $model->name; ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>