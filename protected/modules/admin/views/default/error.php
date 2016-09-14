<?php
$this->pageTitle=Yii::app()->name . " - Ошибка ".$code;
$this->breadcrumbs=array(
	"Ошибка $code",
);
?>
<div align = "center">
<h2></h2></div>

<?php echo CHtml::encode($message); ?>
