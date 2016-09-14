<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Управление товарами, категории' => array('/admin/catalog'),
	$catalog->name => array("/admin/catalog/view", 'parent_id' =>$catalog->id ),
	$subcatalog->name => array("/admin/item/view", 'catalog_id' =>$subcatalog->id ),
	$modelitem->name => array("/admin/item/view", 'catalog_id' =>$subcatalog->id ),
	'Добавить фотографию'
	);


?>

<h1>Добавить фотографию к товару: <?=$modelitem->name?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>