<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Статьи'=>array('/admin/article'),
	$model->title => ' ',
	'Изменить',
);

$this->menu=array(
	array('label'=>'List News', 'url'=>array('index')),
	array('label'=>'Create News', 'url'=>array('create')),
	array('label'=>'View News', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage News', 'url'=>array('admin')),
);
?>

<h1>Изменить статью <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>