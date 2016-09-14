<?php
$this->breadcrumbs+=array(
	'Редактировать - '.$model->name,
);
?>

<h3>Редактировать -  <?php echo $model->name; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?/*
<h3>Уже добавленные фото:</h3>
<i>В каталоге в качестве главного фото выступает первая фотография, вы можете изменить их порядок, перетаскивая мышью фотографии</i>
<?$str_js = "
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
					'url': '".Yii::app()->baseUrl."/admin/category/sortImage',
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
	

 $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
	'summaryText' => 'Всего : {count}',
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		'name',
		array(	
			'header' => 'Изображение ',
			'name'=>'image',
			'type'=>'image',
			'value'=>'Yii::app()->iwi->load($data->dir.$data->image)->resize(100,100)->cache()'
		),	
			
		array(
			'header' => 'Операции',
			'class' => 'bootstrap.widgets.TbButtonColumn', 
			'template'=>'{delete}',
			'deleteButtonUrl' => '"/admin/category/deleteImage/id/".$data->id',
		),
	),
));*/?>