<?php
/* @var $this SearchTagController */
/* @var $model SearchTag */

$this->breadcrumbs=array(
	'Теги поиска'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Редактировать',
);

?>

<h1>Редактировать <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>