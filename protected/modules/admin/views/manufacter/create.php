<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, производители' => array('/admin/manufacter'),
	'Добавить',
);


?>

<h1>Добавить производителя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>