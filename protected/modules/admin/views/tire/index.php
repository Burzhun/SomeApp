<?php
/* @var $this TireController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tires',
);

$this->menu=array(
	array('label'=>'Create Tire', 'url'=>array('create')),
	array('label'=>'Manage Tire', 'url'=>array('admin')),
);
?>

<h1>Tires</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
