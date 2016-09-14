<?$this->pageTitle = " Поиск - ".$this->pageTitle; ?>
<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
        'separator' => ' / ',
    'links'=>array('Поиск'),
//    'tagName' => 'bread_crumbs',
));
?>

<script>
$(function () {
pFrom = <?=(!empty($_GET['pFrom'])) ? intval($_GET['pFrom']) : "''" ;?>;
pTo = <?=(!empty($_GET['pTo'])) ? intval($_GET['pTo']) : "''" ;?>;
ColorID = <?=(!empty($_GET['ColorID'])) ? intval($_GET['ColorID']) : "''" ;?>;
Custom = <?=(!empty($_GET['Custom'])) ? intval($_GET['Custom']) : "''" ;?>;
m = <?=(!empty($_GET['m'])) ? '"'.$_GET['m'].'"' : "''" ;?>;

if(m)
{
$('input[data-marat="'+m+'"]').prop('checked', true);   
}

if(Custom) {
$('.link24[data-custom="'+Custom+'"]').addClass('selected');
$('#Custom').val(Custom);
}
if(ColorID)
{$('.color_shoes[data-colorID="'+ColorID+'"]').addClass('selected');
$('#ColorID').val(ColorID);
}
$('#pFrom').val(pFrom);
$('#pTo').val(pTo);

});



</script>


<h1  >Поиск </h1>
 


<? if(!$dataProvider->totalItemCount):?>
<article class="l-bg-box product">
<h3>Нет товаров в данном каталоге!<h3>
<br>
    
</article>
<? else: ?>
 <div class="goods">
<? $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'../catalog/_view',
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

  