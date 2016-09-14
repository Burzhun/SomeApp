<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление страницами' => array('/admin/page'),
);

$this->pageTitle="Страинцы  - ". Yii::app()->name;
  	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить страницу')
	); 
?>

<h1>Страницы</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего стрраниц: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'id',
'name',
'url',
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
