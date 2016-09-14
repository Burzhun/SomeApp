<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление новостями' => array('/admin/news'),
);


$this->pageTitle="Новости  - ". Yii::app()->name;
  	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить новость')
	); 
	

	?>



<h1>Новости</h1>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего новостей: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'title',
'short',
    array(            // display 'create_time' using an expression
            'name'=>'date',
            'value'=>'date("Y-m-d H:i:s", $data->date)',
        ),
		    array(	
			'header' => 'Изображение ',
                        'name'=>'image',
                        'type'=>'image',
                        'value'=>'Yii::app()->request->baseUrl."/uploads/small_".$data->image'
                        ),	  

		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
