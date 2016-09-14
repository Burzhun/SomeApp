<?
/*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProviderLast,
	'itemView'=>'../catalog/_view',
	//'viewData' => array('model' => $model),
	'itemsCssClass' => 'goods',
	'itemsTagName' => 'ul',
	'summaryText'=>false,  
	'emptyText'=>false,
	'pagerCssClass'=>'nav',
	'pager'=>array(
	'class' => 'myPager')
));*/?>
<div id="ttt22"></div>
<script>
	$.ajax({
		type: "POST",
		url: "/goods/getlastgoods",
		success: function(data){ 
			$('#ttt22').html(data);
		}
	});
</script>