
<h1><?=$collection->name?></h1>
<div style="float:right; margin:0 40px 20px 0;overflow:hidden;">
	<?php	// считываем настройку
		$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
	?>
	<form  style="display:inline;">
	Показывать на странице:
	<?=CHtml::dropDownList(
                'pageSize',
                $pageSize,
                array(20=>20,60=>60,100=>100),
                array('onchange'=>"this.form.submit()")
            );?>
    </form>
	<?php	// считываем настройку
		$sort=Yii::app()->user->getState('sort',Yii::app()->params['defaultSort']);
	?>
	<form  style="display:inline; " onchange="">
	Сортировать по:
	<?php
		echo CHtml::dropDownList('sort',
								$sort,
							    array('kod.desc'=>'Новизне','marking.desc'=>'Артикулу'),
							    array('onchange'=>"this.form.submit()"));
	?>
	</form>
</div>
<div style="clear:both;"></div>
<br><br>

<? $this->widget('zii.widgets.CListView', array(
	'id'=>'user-list',
	'dataProvider'=>$dataProvider,
	'itemView'=>'../catalog/_view',
	'itemsCssClass' => 'goods',
	'itemsTagName' => 'ul',
	'summaryText'=>false,
	'emptyText'=>false,
	'pagerCssClass'=>'nav',
	'ajaxUpdate'=>false,


	/*'sortableAttributes'=>array('marking'),
	'sorterCssClass'=>'sorter',
	'sorterHeader'=>'<span class="filter">Сортировать по:</span>',*/

	'pager'=>array(
		'cssFile'=>false,

		'header'=>'',
		//'firstPageLabel'=>false,
		//'lastPageLabel'=>false,
		'nextPageLabel'=>'&#8250;',
		'prevPageLabel'=>'&#8249;',
	)
));?>




