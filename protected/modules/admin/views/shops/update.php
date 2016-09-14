<?php
$this->breadcrumbs+=array(
	'Редактировать - '.$model->name,
);
?>

<h3>Редактировать -  <?php echo $model->name; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>