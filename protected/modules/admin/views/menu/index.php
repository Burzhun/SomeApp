<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Настройка меню',
);


$this->pageTitle="Настройка меню  - ". Yii::app()->name;
   

	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить меню')
	); 
	
	?>



<h1>Список меню</h1>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего категорий: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		array(
			'class' => 'CLinkColumn',
			'header'=>'Название',
			'labelExpression'=>'$data->name',
			'urlExpression'=> '"/admin/MenuItem/view/id/".$data->id',
		),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
