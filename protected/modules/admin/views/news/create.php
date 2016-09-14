<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление новостями' => array('/admin/news'),
	'Добавить',
);



?>

<h1>Добавить новость</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>