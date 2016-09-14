<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Коллекции' ,
);

    
$this->pageTitle="Коллекции  - ". Yii::app()->name;
 ?>

<h1>Коллекции</h1>
<?

if(!$this->themeId){
	 $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'project-grid',
		'dataProvider'=>$dataProvider,
	    'summaryText' => 'Всего коллекции: {count}',
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

}else{
	

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего коллекции: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'id',
'name',
array(
	'header'=>'Описание',
	'name'=>'description_roz',
	'value'=>$data->description_roz,
	),
    //'description',
    array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}',
			
		),
	),

));
}?>
