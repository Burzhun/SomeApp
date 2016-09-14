 <h1>Поиск</h1>
 <?php if(empty($dataProvider->data)){?>
		<b>К сожалению ничего не найдено</b>
	<?php }?>

<? 
$this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'../catalog/_view',	
'viewData' => array('model' => $model),
'itemsCssClass' => 'goods',
'itemsTagName' => 'ul',
'summaryText'=>false,  
'emptyText'=>false,
'pagerCssClass'=>'nav', 
'pager'=>array(
		'cssFile'=>false,

		'header'=>'',
		//'firstPageLabel'=>false,
		//'lastPageLabel'=>false,
		'nextPageLabel'=>'&#8250;',
		'prevPageLabel'=>'&#8249;',
	)
));?>