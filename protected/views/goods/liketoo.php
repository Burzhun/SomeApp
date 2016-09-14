<?$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'../catalog/_view',
	//'viewData' => array('model' => $model),
	'itemsCssClass' => 'goods',
	'itemsTagName' => 'ul',
	'summaryText'=>false,  
	'emptyText'=>false,
	'template'=>'{items}',
	//'pagerCssClass'=>'nav',
	'pager'=>array(
	'class' => 'myPager')
));?>