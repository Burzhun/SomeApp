<?php
$this->breadcrumbs=array(
	'Админка'=>array('index'),
	'Заказы'=>array('/admin/order'),
	"Заказ номер № ".$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'View Order', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>Изменить заказ <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>