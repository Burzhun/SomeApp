<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, вставки' => array('/admin/insert'),
	'Добавить',
);


?>

<h1>Добавить вставку</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>