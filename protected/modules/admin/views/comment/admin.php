<?
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	$this->name,
);

?>

<h1><?=$this->name?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		array(
			'header' => 'Объект',
			'value' => '$data->item',
			'type' => 'raw',
		),
		'email',
		'comment',
		          array(       
            'name'=>'created',
            'value'=>'date("d.m.y H:i", $data->created)',
        ),
		array(
			'name' => 'status',
			'filter' => array('Нет', 'Да'),
			'value' => 'Functions::YesNo($data->status)',
			),
		'phone',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
