<?php
$this->breadcrumbs=array(
	'Админка'=>array('/admin'),
	'Настройка меню' => array('/admin/menu'),
	$menu->name => array("/admin/menuItem/view", 'id' => "$menu->id"),
	'Добавить  пункт'
	);

?>

<h1><?=$menu->name?>: добавить пункт меню</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>