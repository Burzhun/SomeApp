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
	'id'=>'attribute-group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'description',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
