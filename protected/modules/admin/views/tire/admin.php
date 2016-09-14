<?php

$this->breadcrumbs=array(
	'Админка'=>array('/index'),
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
	'id'=>'tire-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                  array(
            'name'=>'image',
            'type'=>'raw',
            'value' => '"<img src = /uploads/".$data->image.">"',

        ),
                //                    array(
                //         'name'=>'type_id',
                //         'filter'=>CHtml::dropDownList(Tire::model()->types()),
                //       'value'=>'Tire::model()->typeLabel($data->type_id)',
                // ),
       array(
      'name'=>'type_id',
      'type'=>'raw',
'value'=>'Tire::model()->typeLabel($data->type_id)',
      'filter'=>Tire::model()->types(), //this is the focus of your code
       
   ),              
		'size',
		'pr',
		'type',
  		'manufacter.name',

		'models',
		'description',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
