<?
$this->breadcrumbs=$breadcrumbs;
	
	
$this->pageTitle="Товары: $catalog->name / $subcatalog->name - ". Yii::app()->name;

?>
<h1>Товары в подкатегории <?=$model->name?></h1>
<?
	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('create', 'catalog_id'=>$_GET['catalog_id']),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить товары в эту категорию')
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
    Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js');
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
		'name',
		'price',
	//	'country.name_ru',
	//	'manufacter.name',
        array(
            'class' => 'CLinkColumn',
            'header'=>'Фото',
            'labelExpression'=>'(!empty($data->images[0]->filename)) ? "<img src = /uploads/medium_".$data->images[0]->filename.">" : "Добавить фото" ',
            'urlExpression'=> '"/admin/itemImage/view/id/".$data->id',
            //'linkHtmlOptions'=>array('target'=>'_self'),
        ),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
		),
	),
));
?>