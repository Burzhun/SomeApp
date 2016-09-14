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
		'email',
		'address',
		'phone',
		array(
			'name' => 'admin',
			'value' => 'Functions::YesNo($data->admin)',
			'filter' => array("Нет", "Да"),	
			),	
		// array(
		// 	'name' => 'active',
		// 	'value' => 'Functions::YesNo($data->active)',
		// 	'filter' => array("Нет", "Да"),	
		// 	),
		array(
	'name' => 'created',
	'value' => 'date("d-m-Y",$data->created)',
	'type' => 'raw',
			),

		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>
