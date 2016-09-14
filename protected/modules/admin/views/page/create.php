<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление страницами' => array('/admin/page'),
	'Добавить',
);



?>

<h1>Добавить страницу</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>