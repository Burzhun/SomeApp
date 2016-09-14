 
<?
$this->pageTitle = "Отзывы - ".$this->pageTitle;
$breadcrumbs = array('Мои данные');
$this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
'separator' => ' / ',
'links'=>array('Отзывы')));
?> 
<div class="l-main"><div class="w-main">
<h1>Отзывы</h1><div class="w-products w-products-index">
</div>

<? 
$this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'_comment',
'viewData' => array('model' => $model),
'itemsCssClass' => 'reviews_list',
'itemsTagName' => 'ul',
'summaryText'=>false,  
'emptyText'=>false,
'pagerCssClass'=>'nav', 
 
'pager'=>array(
'class' => 'myPager')
));  ?> 

 


</div>
</div> 