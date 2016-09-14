<?php
$this->breadcrumbs=$breadcrumbs;

$this->pageTitle="Фото товара: $modelitem->name / $subcatalog->name - ". Yii::app()->name;


?>

<h1>Фото к товару <?php echo $modelitem->name; ?></h1>


<?


$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create', 'id'=>$_GET['id']),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить фото')
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
                    'url': '".Yii::app()->baseUrl."/admin/itemimage/sort',
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
	

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => '',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		'name',
		array(
        'type'=>'image',
        'value'=> '"/uploads/medium_$data->filename"'),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{delete}',
		),
	),
));
?>