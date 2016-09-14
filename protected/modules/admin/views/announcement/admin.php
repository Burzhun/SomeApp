<?php

$this->breadcrumbs=array(
	'Админка'=>array('/index'),
	$this->name,
);

?>

<h1><?=$this->name?></h1>
<?
	$assetsDir = dirname(__FILE__).'/../assets'; 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tire-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
'id',
'text',
'price',
'contacts',
array(
	'header' => 'Фото',
   'class' => 'EImageColumn',
   'imagePathExpression' => '$data->imagePath("small")',
   'emptyText' => '—',
   'imageOptions' => array(
       'width' => 100,
   ),
),


		          array(       
            'name'=>'date',
            'value'=>'date("d.m.y H:i", $data->date)',
        ),
		array(
		'name' => 'status',
		'value' => 'Functions::YesNo($data->status)',
		'filter' => array(0 => 'Нет', 1 => 'Да'),
		),	
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
