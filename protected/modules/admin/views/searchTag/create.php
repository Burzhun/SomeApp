<?php
/* @var $this SearchTagController */
/* @var $model SearchTag */

$this->breadcrumbs=array(
	'Теги поиска'=>array('index'),
	'Создать',
);

?>

<h1>Создать тег</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>