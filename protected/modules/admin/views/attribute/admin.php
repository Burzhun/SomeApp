<?php

$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
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
	$assetsDir = dirname(__FILE__).'/../assets'; 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tire-grid',
	'ajaxUpdate' => false,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
			'id',
			'name',
			array(
			'header' => 'Группа',
			'name' => 'group_id',
			'value' => '$data->group->name',			
			'filter' => AttributeGroup::listData(),				
	),		
			'unique',
			'required',
			array(
			'name' => 'type',
			'value' => 'Attribute::getTypesList($data->type)',
			'filter' => Attribute::getTypesList(),		
				),
			'position',

		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
