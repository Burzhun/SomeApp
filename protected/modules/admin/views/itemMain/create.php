<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Товары на главной' => array('/admin/itemMain'),
	'Добавить '
	);


?>

<h1>Добавить товар на главную</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>