<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, металлы' => array('/admin/metal'),
	'Добавить',
);


?>

<h1>Добавить металл</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>