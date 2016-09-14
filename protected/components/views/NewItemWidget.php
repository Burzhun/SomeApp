<h2>Новинки</h2>
<? Yii::app()->controller->widget('zii.widgets.CListView', array(
	'id'=>'user-list',
	'dataProvider'=>$noveltyDataProvider,
	'itemView'=>'/catalog/_view',
	'itemsCssClass' => 'goods',
	'itemsTagName' => 'ul',
	'summaryText'=>false,
	'emptyText'=>false,
	'pagerCssClass'=>'nav',
	'pager'=>array(
		'cssFile'=>'',
		'class' => 'myPager'
	)
)); ?>