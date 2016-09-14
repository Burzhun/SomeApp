<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление баннерами',
);

$this->pageTitle="Баннеры - ". Yii::app()->name;

	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Создать баннер')
	); 


?>

<h1>Управление баннерами</h1>

<?php 

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
                    'url': '".Yii::app()->baseUrl."/admin/Carousel/sort',
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
    Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js');
    Yii::app()->clientScript->registerScript('sortable-project', $str_js);






 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Показаны с  {start} по {end}, всего: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		'name',
		array(
		   'name'=>'Картинка',
		   'type'=>'image',
		   'value'=>'"/uploads/$data->image"',
		),
        array(
           'name'=>'type',
           'type'=>'raw',
           'value'=>'$data->typeText',
        ),        
		'url',
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn',
			'template'=>'{update}{delete}',
		),
	
	),
));

?>
