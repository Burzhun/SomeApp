<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Группы' ,
);

    
$this->pageTitle="Группы  - ". Yii::app()->name;
 ?>

<h1>Группы</h1>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего групп: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'id',
'name',
    'description',
    array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}',
			
		),
	),

));
