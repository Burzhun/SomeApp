<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Коллекции' ,
);
$this->pageTitle="Коллекции  - ". Yii::app()->name; ?>

<?$this->widget('bootstrap.widgets.TbButton', 
	array(
		'url'=>(!Yii::app()->request->getParam('pid')) ? array('create') : array('kubachinkaCollection/create/?pid='.Yii::app()->request->getParam('pid')),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить '.$this->name)
	);?>

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
		array(
           'name'=>'alias',
           'type'=>'raw',
           'value'=>'"http://www.kubachinka.ru/collection/$data->alias"',
        ),
	    array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
		),
	),
));
}?>
