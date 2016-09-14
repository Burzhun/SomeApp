<?php
$this->breadcrumbs=array(
	'Item Images',
);

$this->menu=array(
	array('label'=>'Create ItemImage', 'url'=>array('create')),
	array('label'=>'Manage ItemImage', 'url'=>array('admin')),
);
?>

<h1>Item Images</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
