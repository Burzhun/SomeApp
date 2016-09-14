<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Завершенные заказы' => array('/admin/order/completed'),
);


$this->pageTitle="Заказы  - ". Yii::app()->name;

	

	?>



<h1>Завершенные заказы</h1>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'id',
'name',
'phone',
'address',
'info',
   array( 'class'=>'CLinkColumn',
                        'header'=>'Товары',
                        'labelExpression'=>'"Просмотр"',
                        'urlExpression'=>'Yii::app()->createUrl("/admin/orderItem/view", array("id"=>$data["id"]))',
                ),


    array(            // display 'create_time' using an expression
            'name'=>'date',
            'value'=>'date("d.m.Y H:i", $data->date)',
        ),  
'ip',


		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
