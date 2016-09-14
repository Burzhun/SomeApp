<?php
/* @var $this TireManufacterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tire Manufacters',
);

$this->menu=array(
	array('label'=>'Create TireManufacter', 'url'=>array('create')),
	array('label'=>'Manage TireManufacter', 'url'=>array('admin')),
);
?>

<h1>Tire Manufacters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
