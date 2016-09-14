<?$this->pageTitle = " $year - ".$this->pageTitle; ?>
<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
        'separator' => ' / ',
    'links'=>array($year),
//    'tagName' => 'bread_crumbs',
));
?>

<h1  ><?=$year?> </h1>
 


<? if(!$dataProvider->totalItemCount):?>
<article class="l-bg-box product">
<h3>Нет товаров в данном каталоге!<h3>
<br>
    
</article>
<? else: ?>
 <div class="goods">
<? $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'viewData' => array('model' => $model),
   'itemsCssClass' => 'goods',
    'itemsTagName' => 'ul',

            'summaryText'=>'', //summary text
                'emptyText'=>'',
//          'template'=>',, {items} and {pager}.', //template
            'pagerCssClass'=>'nav',//contain class
                            'pager'=>array(
                    'class' => 'myPager',
                // 'cssFile'=>false,//disable all css property
                // 'header'=>'',//text before it
                // 'firstPageLabel'=>'',//overwrite firstPage lable
                // 'lastPageLabel'=>'',//overwrite lastPage lable
                // 'nextPageLabel'=>'&nbsp',//overwrite nextPage lable
                // 'prevPageLabel'=>'<li class="prev"><a href="#" title="">&nbsp</a></li>',

            )
));  ?>
</div>
<? endif; ?>

  