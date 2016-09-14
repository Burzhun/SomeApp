<?php
$this->breadcrumbs+=array(
	//$this->name,
);
?>

<h3><?=$this->name;?></h3>

<?$this->widget('bootstrap.widgets.TbButton', 
	array(
		'url'=>(!Yii::app()->request->getParam('pid')) ? array('create') : array('category/create/?pid='.Yii::app()->request->getParam('pid')),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить '.$this->name)
	);?>

<? $this->widget('zii.widgets.grid.CGridView', array(
	//'type'=>'striped bordered condensed',
	'id'=>'project-grid',
	//'dataProvider'=>$dataProvider,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => 'Всего: {count}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
	/* array( 
			'class' => 'editable.EditableColumn',
			'header'=>'Изменить цену',
			'name' => 'updatePrice',
			'value' => '0',
			//'headerHtmlOptions' => array('style' => 'width: 100px'),
			'editable' => array(
				'title' => 'Изменить',
				'type'     => 'text',
				'model'     => $data,
        		'attribute' => 'updatePrice',
				//'source'  => array(1 => 'Да', 0 => 'Нет'),
				'url'      => $this->createUrl('category/updatePrice'),
				'success'   => 'js: function(data) {
			        alert(data);
			    }'
			),
			'filter' => false,
		),

	 array( 
			'class' => 'editable.EditableColumn',
			'header'=>'Изменить цену(%)',
			'name' => 'updatePricePercent',
			'value' => '0',
			//'headerHtmlOptions' => array('style' => 'width: 100px'),
			'editable' => array(
				'title' => 'Изменить',
				'type'     => 'text',
				'model'     => $data,
        		'attribute' => 'updatePricePercent',
				//'source'  => array(1 => 'Да', 0 => 'Нет'),
				'url'      => $this->createUrl('category/updatePricePercent'),
				'success'   => 'js: function(data) {
			        alert(data);
			    }'
			),
			'filter' => false,
		),*/
		'id',
		array(	
			'name' => 'name',
			'type' => 'raw', 
			'value' => 'CHtml::link($data->name,"/admin/category/index?pid=".$data->id)'
		),
		'url',
		'full_url',
		//'parent_id',
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
			'template'=>'{update}{delete}',
			
		),
	),

));

$str_js = "
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	
	$('#project-grid table.items tbody').sortable({
		forcePlaceholderSize: true,
		forceHelperSize: true,
		items: 'tr',
		update : function () {
			serial = $('#project-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
		   
			$.ajax({
				'url': '".Yii::app()->baseUrl."/admin/".Yii::app()->controller->id."/sort',
				'type': 'post',
				'data': serial,
				'success': function(data){
				},
				'error': function(request, status, error){
					alert('К сожалению при сортировке возникает ошибка.Попробуйте снова!!!');
				}
			});
		},
		helper: fixHelper
	}).disableSelection();
";
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScript('sortable-project', $str_js);?>

<br><br>
<?/*
if(Yii::app()->request->getParam('pid')){
$this->widget('bootstrap.widgets.TbButton', 
	array(
		'url'=>array('item/create/?pid='.Yii::app()->request->getParam('pid')),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить товар')
	);


 $this->widget('zii.widgets.grid.CGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'item-grid',
	//'dataProvider'=>$dataProvider,
	'dataProvider'=>$itemModel->search(),
	'filter'=>$itemModel,
	'summaryText' => 'Всего: {count}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(

		'id',
		'name',
		//'category_id',
		'alias',
		'price',
		'article',
		//'hidden',
		array(	
			'header' => 'Изображение ',
			//'name'=>'image',
			'type'=>'image',
			'filter'=>false,
			'value'=>'$data->images ? Yii::app()->iwi->load($data->images[0]->dir.$data->images[0]->image)->resize(100,100)->cache() : ""',
		),
		
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
			'template'=>'{update}{delete}',
			'updateButtonUrl'=>'"/admin/item/update/".$data->id."?pid=".$data->category_id',
			'deleteButtonUrl'=>'"/admin/item/delete/".$data->id',
			
			
		),
	),

));

$str_js2 = "
	var fixHelper = function(e, ui) {
		ui.children().each(function() {
			$(this).width($(this).width());
		});
		return ui;
	};
	
	$('#item-grid table.items tbody').sortable({
		forcePlaceholderSize: true,
		forceHelperSize: true,
		items: 'tr',
		update : function () {
			serial = $('#item-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
		   
			$.ajax({
				'url': '".Yii::app()->baseUrl."/admin/item/sort',
				'type': 'post',
				'data': serial,
				'success': function(data){
				},
				'error': function(request, status, error){
					alert('К сожалению при сортировке возникает ошибка.Попробуйте снова!!!');
				}
			});
		},
		helper: fixHelper
	}).disableSelection();
";

Yii::app()->clientScript->registerScript('sortable-project', $str_js2);

}*/
?>