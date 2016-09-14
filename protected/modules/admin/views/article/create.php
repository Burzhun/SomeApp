<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление статьями' => array('/admin/article'),
	'Добавить',
);



?>

<h1>Добавить статью</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>