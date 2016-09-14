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
	'ajaxUpdate'=>false,
	'columns'=>array(
 
		 'name',
		 'kod',
                  array(
            'name'=>'image',
            'type'=>'raw',
            'value' => 'isset($data->imageStone) ? "<img src = /uploads/".$data->imageStone->filename.">" : ""',
            'htmlOptions'=>array('style'=>'max-width:50px;'),
            ),
   
                //                    array(
                //         'name'=>'type_id',
                //         'filter'=>CHtml::dropDownList(Tire::model()->types()),
                //       'value'=>'Tire::model()->typeLabel($data->type_id)',
                // ),
             

		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}',
			'updateButtonUrl' => '"/admin/stone/update/kod/".$data->kod',
			'deleteButtonUrl' => '"/admin/stone/delete/kod/".$data->kod',
		),
	),
)); ?>
