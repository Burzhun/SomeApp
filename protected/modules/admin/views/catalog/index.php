<?php
$this->breadcrumbs=$breadcrumbs;


$this->pageTitle="Категории  - ". Yii::app()->name;
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

    $str_js1 = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
        
        $('#project-grid1 table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#project-grid1 table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
               
                $.ajax({
                    'url': '".Yii::app()->baseUrl."/admin/Item/sort',
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
    Yii::app()->clientScript->registerScript('sortable-project1', $str_js1);

?>


<?

$linkcreate = (isset($_GET['parent_id'])) ? '/admin/catalog/create/parent_id/'.$_GET['parent_id'] : '/admin/catalog/create' ;
$labelcreate =  (!isset($_GET['parent_id'])) ? "Добавить категорию" : "Добавить подкатегорию" ;
	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>$linkcreate,
		'type'=>'warning',
		'icon'=>'plus white',
		'label'=>$labelcreate)
	); 
?>
<?
$labelcreate =  (!isset($_GET['parent_id'])) ? "категории" : "подкатегории" ;
?>
<h2>Каталог, <?=$labelcreate?></h2>
<? 
$id = (isset($_GET['parent_id'])) ? $_GET['parent_id'] : 0 ;
if(count(Catalog::model()->findAll('parent_id = '.$id))>0) { ?>
	<i>Вы можете изменить порядок следования категорий в меню, перетаскивая их мышью</i>
<?
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$dataProvider,
    'summaryText' => 'Всего категорий: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		
        array(
           'name'=>'Картинка',
           'type'=>'image',
           'value'=>'"/uploads/$data->image"',
        ),

        array(


			'class' => 'CLinkColumn',
			'header'=>'Название',
			'labelExpression'=>'$data->name',
			'urlExpression'=> '"/admin/catalog/index/parent_id/".$data->id',
		),
	/*			array(
			'class' => 'CLinkColumn',
			'header'=>'Товары',
			'labelExpression'=>'"Товары: ".count($data->Items)',
			'urlExpression'=> '"/admin/item/view/catalog_id/".$data->id',
		),
	*/			array(
                        'name' => 'actions',
                        'header' => 'Количество товаров всего',
                        'value' => '$data->count',
                        'filter' => false,
    ),

        array(
                        'name' => 'actions',
                        'header' => 'Количество товаров',
                        'value' => '$data->itemsCount',
                        'filter' => false,
    ),
	
			array(
                        'name' => 'actions',
                        'header' => 'Количество подкатегорий',
                        'value' => 'count($data->Sub)',
                        'filter' => false,
    ),
		array(
			'header' => 'Операции',
			'class' => 'CButtonColumn', 
		    'template'=>'{update}{delete}',
			
		),
	),

));

 } else {
	echo 'Подкатегорий в этой категории нет<hr>';
}
?>
<?

if(!empty($_GET['parent_id'])) {

?>

<?


	$this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('/admin/item/create', 'catalog_id'=>$_GET['parent_id']),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить товар в эту категорию')
	);  ?><h2>Товары в этой категории:</h2>
    <i>Здесь отображаются только те товары, у которых главная категория - <?=$model->name?></i>
<br>Товар также может обображаться в нескольких категориях на сайте
<br>
<? if(count(Item::model()->findAll('catalog_id = '.$_GET['parent_id']))>0) { ?> 
	<i>Вы можете изменить порядок следования товаров на сайте перетаскивая их мышью</i>
<?php 

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid1',
	'dataProvider'=>$itemProvider,
    'summaryText' => 'Всего товаров: {count}',
    'rowCssClassExpression'=>'"items[]_{$data->id}"',
    'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		array(
			'class' => 'CLinkColumn',	
			'header' => 'Название',
			'labelExpression' => '$data->name',
			'urlExpression'=> '"/admin/item/update/id/".$data->id',
		),
		'price',
	//	'country.name_ru',
	//	'manufacter.natcasesort(array)me',
			array(
			'class' => 'CLinkColumn',
			'header'=>'Фото',
			'labelExpression'=>'(!empty($data->images[0]->filename)) ? "<img src = /uploads/small_".$data->images[0]->filename.">" : "Добавить фото" ',
			'urlExpression'=> '"/admin/item/update/id/".$data->id',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
      array(
      	'header' => 'операции',
            'class'=>'CButtonColumn',
         'template'=>'{update}{delete}',
                    'updateButtonUrl'=>'"/admin/item/update/id/".$data->id',
                    'deleteButtonUrl'=>'"/admin/item/delete/id/".$data->id',
                    
        ),
	),
));
 } else {
	echo 'Товаров в этой категории нет<hr>';
}
}

?>
