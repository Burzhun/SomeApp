<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление услугами' => array('/admin/article'),
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
                    'url': '".Yii::app()->baseUrl."/admin/Article/sort',
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
$this->pageTitle="Статьи  - ". Yii::app()->name;
  	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить услугу')
	); 
	

	?>



<h1>Услуги</h1>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего статей: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
'title',
'short',
    array(            // display 'create_time' using an expression
            'name'=>'date',
            'value'=>'date("d.m.Y h:i:s", $data->date)',
        ),
		    array(	
			'header' => 'Изображение ',
                        'name'=>'image',
                        'type'=>'image',
                        'value'=>'Yii::app()->request->baseUrl."/uploads/small_".$data->image'
                        ),	  

		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));
