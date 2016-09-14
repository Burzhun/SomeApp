<?php

$this->breadcrumbs=array(
	'Админка'=>array('/index'),
	$this->name => array('admin') ,
);


?>

<h1><? echo $this->name." - добавить"?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>