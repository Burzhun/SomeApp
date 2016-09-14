<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Заказы'=>array('admin'),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Заказы</h1>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name' => 'date',
			'value'=> 'date("d.m.Y H:i:s",$data->date)',
		),
        array(
            'header' => 'Статус',
            'name' => 'status',
            'filter' => Order::statusList(),
            'value' => '$data->statusText',
        ),
		'name',
		'address',
		array(
			'header' => 'Сумма заказа',
			'value'=> '$data->getTotalPrice()',
		),
        array(
            'header' => 'Товары',
            'value' => '$data->itemlist',
            'type' => 'raw',
            ),
		'email',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
