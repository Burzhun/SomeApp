<?
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Тип изделий' ,
);

$this->pageTitle="Тип иделий  - ". Yii::app()->name; ?>

<h1>Тип иделий</h1>
<? $this->widget('zii.widgets.grid.CGridView', array(
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
			'updateButtonUrl'=>'"/admin/goodtype/update/id/".$data->idgoodtype',
			'template'=>'{update}',
		),
	),
));