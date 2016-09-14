<?if(!empty($category->seotitle))
	$this->pageTitle = $category->seotitle;
else
	$this->pageTitle = "$category->name / Каталог / ".$this->pageTitle;

if(!empty($category->seokeywords))
	$this->pageKeywords = $category->seokeywords;
if(!empty($category->seodescription))
	$this->pageDescription = $category->seodescription;?>



<?/*<h1><?=$category->name?><?if(Yii::app()->user->isAdmin){?>
	<a href="/admin/category/index?pid=<?=$category->id?>" class="updatePage" target="_blank">
		<img src="/img/pencil.png">
	</a>
<?}?>
</h1>*/?>

<?/*if($chields){
	echo $this->renderPartial('index', array('categoryes'=>$chields), false, false).'<br><br><br><br><br>';
}*/?>



<?/*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>'Товаров не найдено',
	'ajaxUpdate' => false,
	//'viewData' => array('model' => $model, 'catalogName'=> $model->name),
	'itemsCssClass' => 'goods',
	'itemsTagName' => 'ul',
	'summaryText'=>false,
	'emptyText'=>false,
	'cssFile'=>false,
	'pagerCssClass'=>'nav',
	'template' => "{sorter}{items}\n{pager}",

	'sortableAttributes'=>array('name','price','created','article'),
	'sorterCssClass'=>'sorter',
	'sorterHeader'=>'<span class="filter">Сортировать по:</span>',

	'pager'=>array(
		'cssFile'=>false,

		'header'=>'',
		//'firstPageLabel'=>false,
		//'lastPageLabel'=>false,
		'nextPageLabel'=>'&#8250;',
		'prevPageLabel'=>'&#8249;',
	)
));*/?>

<h1><?=$category->name?></h1>

<ul class="goods">
	<?foreach ($chields as $data) {?>
		<li class="disItem" >
			<div class="goodsImg">
				<a href="<?=$data->full_url?>" class="disItemImg">
					<img src="<?=$data->getChildrenImage()?>">
				</a>
			</div>
			<a href="<?=$data->full_url?>" class="disItemTitle"><?=$data->name?></a>
		</li>
	<?}?>
</ul>

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



<div style=''>

	<?=$category->description?>
</div>

