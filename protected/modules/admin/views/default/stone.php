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
<h1>Товары в наличии</h1>

	<?php $this->widget('bootstrap.widgets.BootButton',
	array(
		'url'=>array('createitem'),
		'type'=>'primary',
		'icon'=>'plus white',
		'label'=>'Добавить товар')
	);  ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'goodkod',
		//'numpos',
		'count',
		'stonekod',
		array(
            'name'=>'stonekod',
            'header'=>'Картинка камня',
            'type'=>'raw',
            'value' => 'isset($data->st->imageStone) ? "<img src = /uploads/".$data->st->imageStone->filename.">" : ""',
            'htmlOptions'=>array('style'=>'max-width:50px;'),
            'filter'=>false,
           ),
		//'can_choose',
		//'default',
		//'mainstone',
		//'id',
		//'description',
	),
)); ?>
