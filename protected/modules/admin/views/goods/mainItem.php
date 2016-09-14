<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Товары',
);

?>

<style type="text/css">
    .link-column img{
        max-width: 100px;
    }
</style>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$this->themeId ? $model->searchMainItem() : $model->search(),
	'filter'=>$model,
	'columns'=>array(
		'kod',
	
			array(
			'class' => 'CLinkColumn',
			'header'=>'Фото',
			'labelExpression'=>'(!empty($data->images[0]->filename)) ? "<img src = /uploads/".$data->images[0]->filename.">" : "Добавить фото" ',
			'urlExpression'=> '"/admin/goods/update/kod/".$data->kod',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
 
 
 
 
 
		array(
			'class'=>'CButtonColumn',
			'deleteButtonUrl' => '"/admin/goods/deleteMainItem/kod/".$data->kod',
			'template'=>'{delete}',
		),
	),
)); ?>
