<style type="text/css">
    .link-column img{
        max-width: 100px;
    }
</style>


<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Товары',
);

?>
<h1>Товары</h1>

	<?php $this->widget('bootstrap.widgets.BootButton', 
	array(
		'url'=>array('createitem'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить товар')
	);  ?> 

<p>Поля ввода в таблице предназначены для быстрой фильтрации, к примеру, ввод в название слова <b>Сереб</b> выведет все товары в которых это слово содержится, прим: <b>Сереб</b>ряный чайник, Ружье с <b>сереб</b>ом и т.п</p>
<p>В полях с числовым значением вы можете использовать условия прим <b>>1000, <500 </b><p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=> $model->search(),
	'filter'=>$model,
	'columns'=>array(
		'kod',
	
			array(
			'class' => 'CLinkColumn',
			'header'=>'Фото',
			'labelExpression'=>'(!empty($data->images[0]->filename)) ? "<img src = /uploads/".$data->images[0]->filename.">" : "Добавить фото" ',
			'urlExpression'=> '"/admin/goods/update/kod/".$data->kod',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
 
		array(
			'class'=>'CButtonColumn',
			'updateButtonUrl' => '"/admin/goods/update/kod/".$data->kod',
		),
	),
)); ?>
