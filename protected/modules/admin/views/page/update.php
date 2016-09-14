<?php
$this->breadcrumbs=array(
	'Админка'=>array('/index'),
	'Управление страницами'=>array('index'),
	$model->name=>array('index'),
	'Изменить',
);
?>

<h1>Изменить страницу <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>