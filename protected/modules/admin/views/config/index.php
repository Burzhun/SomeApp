<?php
$this->breadcrumbs=array(
	'Админка' => array('/admin'),
	'Настройки сайта',
);
$this->pageTitle="Настройки сайта - ". Yii::app()->name;

?>

<h1>Настройки сайта</h1>


<?php echo $this->renderPartial('_form', array('models'=>$models)); ?>