<?$this->pageTitle = "Новости - ".$this->pageTitle; ?>
<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
    'links'=>array(
        'Новости',
    ),
//	'tagName' => 'bread_crumbs',
));
?>
<div class="h1-substrate">
<h1><strong>НОВОСТИ    <? if(Yii::app()->session->get("admin") == 1):?>
                          
                       <a href = "/admin/news" target= "_blank">    
                        <img src = "/images/edit.png">
                       </a>
                       <? endif; ?></strong></h1>
</div>
 
<ul class="news">



<? $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
		    'summaryText'=>'', //summary text
				'emptyText'=>'Нет новостей',
//		    'template'=>',, {items} and {pager}.', //template
  			'pagerCssClass'=>'pagers',//contain class

				'pager'=>array(
					'cssFile'=>false,
					'class' => 'myPager',
	 //   		'cssFile'=>false,//disable all css property
			    'header'=>'',//text before it
			    // 'firstPageLabel'=>'',//overwrite firstPage lable
			    // 'lastPageLabel'=>'',//overwrite lastPage lable
			    // 'nextPageLabel'=>'&nbsp',//overwrite nextPage lable
			    // 'prevPageLabel'=>'<li class="prev"><a href="#" title="">&nbsp</a></li>',

		    )
));  ?>
  </ul>


