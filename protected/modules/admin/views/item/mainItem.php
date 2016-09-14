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
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
	
			array(
			'class' => 'CLinkColumn',
			'header'=>'Фото',
			'labelExpression'=>'(!empty($data->images[0]->filename)) ? "<img src = /uploads/small_".$data->images[0]->filename.">" : "Добавить фото" ',
			'urlExpression'=> '"/admin/item/update/id/".$data->id',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
	'name',
	'article',
				array(
			'class' => 'CLinkColumn',
			'header'=>'Категория',
			'labelExpression'=>'$data->catalog->name',
			'urlExpression'=> '"/admin/catalog/index/parent_id/".$data->catalog->id',
			//'linkHtmlOptions'=>array('target'=>'_self'),
		),
			array(
			'class' => 'CLinkColumn',
			'header'=>'Просмотреть',
			'labelExpression'=>'"Просмотреть на сайте"',
			'urlExpression'=> '"/item/".$data->id',
			'linkHtmlOptions'=>array('target'=>'_blank'),
		),				
		'price',
		array(
			'name' => 'in_stock',
			'filter' => array('Нет', 'Да'),
			'value' => 'Functions::YesNo($data->in_stock)',
			),
		'count',
		'discount',
		/*
		'country_id',
		'photo_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'updateButtonUrl' => '"/admin/item/updateitem/id/".$data->id',
		),
	),
)); ?>
