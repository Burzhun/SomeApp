<?php
/* @var $this QuestionController */
/* @var $model Question */

$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	$this->name=>array('admin'),
);

?>

<h1><?=$this->name;?></h1>




<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'question-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'question',
		'answer',
		'email',
		array(
	'name' => 'status',
	'filter' => Question::statuses(),
	'value' =>  '$data->statusLabel()',
			),
		array(
	'name' => 'date',
	'value' => 'date("d-m-Y",$data->date)',
	'type' => 'raw',
			),

		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
