<?php

$this->breadcrumbs=array(
	'Админка'=>array('/index'),
	$this->name,
);

?>

<h1><?=$this->name?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'email-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'phone',
		array(
			'name' => 'item.name',
			'value' => 'CHtml::link($data->item->name,$data->item->createurl, array("target" => "_blank"))',
			'type' => 'raw',
			),
		array(
			'name' => 'time',
			'value' => 'date("d.m.Y H:i",$data->time)',
			),
		array(
			'name' => 'page',
			'value' => 'CHtml::link($data->page,$data->page, array("target" => "_blank"))',
			'type' => 'raw',
			),
		array(
			'class'=>'CButtonColumn',
			'template' => '{delete}'
		),
	),
)); ?>
