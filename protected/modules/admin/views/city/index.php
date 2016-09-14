<?php
$this->breadcrumbs+=array(
	$this->name,
);
?>

<h3><?=$this->name;?></h3>

<?$this->widget('bootstrap.widgets.TbButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить '.$this->name)
	);?>

<? $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'project-grid',
	//'dataProvider'=>$dataProvider,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'summaryText' => 'Всего: {count}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(

		'id',
		'name',

		array(
			'header' => 'Операции',
			'class' => 'bootstrap.widgets.TbButtonColumn', 
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
Yii::app()->clientScript->registerScript('sortable-project', $str_js);
