<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Заказы'=>array('/admin/order'),
	"Заказ № ".$model->order->id=>array('/admin/order'),
	"Товары" =>array('/admin/order'),
	"Изменить ".$model->item->name,
);


?>

<h1>Изменить товар <?php echo $model->item->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>