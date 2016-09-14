<?php
/* @var $this TireManufacterController */
/* @var $model TireManufacter */

$this->breadcrumbs=array(
	'Админка'=>array('/index'),
	$this->name,
);
?>


<h1><?=$this->name?></h1>
	<? $this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=> $this->name." - добавить")
	); 
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tire-manufacter-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',

		'position',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
