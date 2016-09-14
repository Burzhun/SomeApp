<?
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Настройка меню' => array('/admin/menu'),
	$menu->name
	);
	
	
$this->pageTitle="Настройка меню: $menu->name - ". Yii::app()->name;

?>
<h1> <?=$menu->name?>  - пункты</h1>
<?
	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create', 'menu_id'=>$_GET['id']),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить пункт меню')
	); 

?>

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
                    'url': '".Yii::app()->baseUrl."/admin/menuItem/sort',
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



    Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js');
 
    Yii::app()->clientScript->registerScript('sortable-project', $str_js);
?>
 
<?php 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => '',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		 array(
            'name' => 'name',
            'value' =>  '(empty($data->parent_id)) ? $data->name : "&nbsp&nbsp&rarr;&nbsp".$data->name',
            'type' => 'raw',
            ),
		'link',
		'menu.name',
       array(
        'name' => 'parent.name',
        'header' => 'Родитель',
        ),

			
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
		),
	),
));
?>