<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Настройка меню' => array('/admin/menu'),
	'Добавить'
);


?>

<h1>Добавить меню</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>