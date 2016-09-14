
<?$this->pageTitle = $groupM->seo_title ? $groupM->seo_title : $this->pageTitle; ?>
<?$this->pageKeywords = $groupM->seo_keywords ? $groupM->seo_keywords : $this->pageKeywords; ?>
<?$this->pageDescription = $groupM->seo_description ? $groupM->seo_description : $this->pageDescription; ?>

<?/* $this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('Главная', array('site/index')),
	'separator' => ' / ',
	'links'=>array(
		//'Каталог' => array('/catalog'),
		'Коллекции' => array('/catalog'),
		$collection->name => array($collection->createUrl()),
		$groupM->name,// => array('/catalog/groupItem/id/'.$groupM->id),
	),
)); */?>

<div class="breadcrumbs">
	<?foreach ($breadcrumbs as $bread) { ?>
		<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
			<?if($bread['link']) { ?>
				<a href="<?=$bread['link'];?>" itemprop="url" title='<?=$bread["title"];?>'>
					<span itemprop="title"><?=$bread['name']?></span>
				</a>
			<? } else { ?>
				<span itemprop="title"><?=$bread['name']?></span>
			<? } ?>
		</span>
		 / 
	<? } ?>
</div>

<div class="h1-substrate"></div>
<div id="container">
	<div id="content">
		<div class="h1_box">
			<h1><?=$groupM->name;?></h1>
		</div>
		<div style="float:right; margin:0 40px 20px 0;">
			<?// считываем настройку
				$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); ?>
			<form  style="display:inline;">
				Показывать на странице:
				<?=CHtml::dropDownList(
			                'pageSize',
			                $pageSize,
			                array(8=>8,20=>20,50=>50,100=>100),
			                array('onchange'=>"this.form.submit()")
				);?>
		    </form>
			<?php	// считываем настройку
				$sort=Yii::app()->user->getState('sort',Yii::app()->params['defaultSort']);		
			?>
			<form  style="display:inline; " onchange="">
				Сортировать по:
				<? echo CHtml::dropDownList('sort',
					$sort, 
					array('kod.desc'=>'Новизне','marking.asc'=>'Артикулу'),
					array('onchange'=>"this.form.submit()"));
				?>
			</form>
		</div>

		<div style = "clear:both;"></div>

		<? $this->widget('zii.widgets.CListView', array(
			'id'=>'user-list',
			'dataProvider'=>$dataProvider,
			'itemView'=>'../catalog/_view', 
			'itemsCssClass' => 'goods',
			'itemsTagName' => 'ul',
			'summaryText'=>false,  
			'emptyText'=>false,
			'pagerCssClass'=>'nav',
			'pager'=>array(
				'cssFile'=>'',
				'class' => 'myPager'
			)
		)); ?>
		<br>
		<br><br>


		<?=$groupM->description;?>
		<?//=Page::viewContent(5);?>

	</div><!-- #content-->
</div>

<div class="sidebar" id="sideLeft">
	<div class="category_head">
		КАТАЛОГ ПРОДУКЦИИ
	</div>
	<ul class="category_nav">
		<? foreach ($models as $parent) { ?>
			<?$parentSize = $parent->countGoods($groupM->id);
			if($parentSize){?>
				<li><a href="<?=$parent->createUrl();?>"><?=$parent->name?></a> <span class="category_count"><?=$parentSize;?></span></li>
			<?}?>	
		<?}?>
		<?$instock = $parent->countInStock($groupM->id);
		if($instock){?>
			<li><a href="/catalog/<?=$groupM->collection->alias?>/<?=$groupM->alias?>/store">В наличии</a> <span class="category_count"><?=$instock;?></span></li>
		<?}?>
	</ul>
	<?=Page::viewContent(4);?>
</div>

<div class="catalog_right"></div>