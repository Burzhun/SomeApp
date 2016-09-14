<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, категории' => array('/admin/catalog'),
	"Подкатегории: $model->name");
$this->pageTitle="Подкатегории: $model->name - ". Yii::app()->name;
$str_js = "var fixHelper = function(e, ui) {
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
                    'url': '".Yii::app()->baseUrl."/admin/Catalog/sort',
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
    Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js');
    Yii::app()->clientScript->registerScript('sortable-project', $str_js);
	
	?>
	<h1><?  echo "Подкатегории: $model->name";?></h1>
	<?
	
	if(isset($_GET['parent_id'])) 
	$buttonlabel = "Добавить подкатегорию";
	 else
	$buttonlabel = "Добавить категорию";
		$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create', 'parent_id' => $model->id),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>$buttonlabel)
	); 

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего подкатегорий: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		array(
			'class' => 'CLinkColumn',
			'header'=>'Название',
			'labelExpression'=>'$data->name',
			'urlExpression'=> '"/admin/item/view/catalog_id/".$data->id',
		),
		      
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',

		),
	),

));
?>



 ?>