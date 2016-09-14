<?$this->pageTitle = "Скидки - ".$this->pageTitle; ?>
<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
        'separator' => ' / ',
    'links'=>array('Товары со скидкой'),
//    'tagName' => 'bread_crumbs',
));
?>

<h1 style = "color: #fff;"><?=$model->name?>


</h1>


<? if(!empty($model->Sub)):?>
<article class="l-bg-box product">
<? foreach ($model->Sub as $parent) { ?>
<? if($parent->count):?>
<?=CHtml::link($parent->name, $parent->createurl)?>   (<?=$parent->count?>)  <br>  
<? endif; ?>
<? } ?>
</article>
<? endif;?>


<? if(!$dataProvider->totalItemCount):?>
<article class="l-bg-box product">
<h3>Нет товаров в данном каталоге!<h3>
<br>
<br>
<br>
    <a class="back" href="javascript:history.go(-1);">назад</a>

</article>
<? else: ?>
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

<? endif; ?>

<div style="clear: both"></div>

<? if(!empty($model->description)): ?>
<article class="l-bg-box product">
<?=$model->description;?>
</article>
<? endif; ?>

