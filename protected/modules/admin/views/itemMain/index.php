<?php
$this->breadcrumbs=array(
	'Админка' => '/admin',
	'Товары на главной',
);


$this->pageTitle="Товары на главной  - ". Yii::app()->name;
   

	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить товар')
	); 

	
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
                    'url': '".Yii::app()->baseUrl."/admin/itemMain/sort',
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

<h1>Товары на главной	</h1>

<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего категорий: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'item.name',
			array(
			'class' => 'CLinkColumn',
			'header'=>'Фото',
			'labelExpression'=>'(!empty($data->item->images[0]->filename)) ? "<img src = /uploads/small_".$data->item->images[0]->filename.">" : "Добавить фото" ',
			'urlExpression'=> '"/admin/item/update/id/".$data->item->id',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{delete}',
			
		),
	),

));