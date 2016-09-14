<?php

$this->breadcrumbs+=array(
	'Создать',
);

?>

<h3>Создать "<?=$this->name;?>"</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>