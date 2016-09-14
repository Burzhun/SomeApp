<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Настройка меню' => array('/admin/menu'),
	$model->menu->name => array("/admin/MenuItem/view", 'id' => $model->menu->id),
	"Изменить $model->name"
	);

$this->menu=array(
	array('label'=>'List MenuItem', 'url'=>array('index')),
	array('label'=>'Create MenuItem', 'url'=>array('create')),
	array('label'=>'View MenuItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MenuItem', 'url'=>array('admin')),
);
?>

<h1>Изменить пункт меню <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>