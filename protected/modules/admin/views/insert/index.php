<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, вставки' => array('/admin/insert'),
);


$this->pageTitle="Вставки  - ". Yii::app()->name;
  
	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить')
	); 
	

	?>



<h1>Вставки</h1>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'name',
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
