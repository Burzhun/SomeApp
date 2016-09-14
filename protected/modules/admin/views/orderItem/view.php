<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	"Заказ № $order->id" => array('/admin/order'),
	'Товары'
);


$this->pageTitle="Заказы  - ". Yii::app()->name;

	

	?>



<h1>Заказанные товары</h1>
<p>Заказчик: <?=$order->name?></p>
<p>Адрес: <?=$order->address?></p>
<p>Телефон: <?=$order->phone?></p>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
	   array( 'class'=>'CLinkColumn', //here is the link column
                        'header'=>'Товар',
                        'labelExpression'=>'$data->item->name',
                        'urlExpression'=>'Yii::app()->createUrl("/item/index", array("id"=>$data->item->id))',
						'linkHtmlOptions' => array('target' => '_blank')
                ),
	
					array(
			'class' => 'CLinkColumn',
			'header'=>'Фото',
			'labelExpression'=>'(!empty($data->item->images[0]->filename)) ? "<img src = /uploads/small_".$data->item->images[0]->filename.">" : "Добавить фото" ',
			'urlExpression'=> '"/admin/item/update/id/".$data->item->id',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
				
	   array( 'class'=>'CLinkColumn', //here is the link column
                        'header'=>'Категория',
                        'labelExpression'=>'$data->item->catalog->name',
                        'urlExpression'=>'Yii::app()->createUrl("/catalog/view", array("id"=>$data->item->catalog->id))',
						'linkHtmlOptions' => array('target' => '_blank')
				),
				
	'comment',
	'num',
     array(
	 'header' => 'Цена',
	 'value' => '$data->num."x".$data->item->endprice."x8"."=".$data->num*$data->item->endprice*8',
	 ),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
