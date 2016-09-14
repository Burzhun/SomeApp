<?$this->pageTitle = $model->name." - ".$group->name." - продажа оптом | ".$this->pageTitle;//$model->seo_title ? $model->seo_title : $this->pageTitle; ?>
<?$this->pageKeywords = $model->seo_keywords ? $model->seo_keywords : $this->pageKeywords; ?>
<?$this->pageDescription = $model->seo_description ? $model->seo_description : $this->pageDescription; ?>

<?// $breadcrumbs[$model->name] = $model->createUrl;?>

<?/* $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
				'separator' => ' / ',
		'links'=>$breadcrumbs, 
));*/?>

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

<div class="h1-substrate">
	<h1><?=$model->name?>
		<? if(Yii::app()->user->isAdmin){?>
			<a href = "/admin/catalog/update/id/<?=$model->id?>" target = "_blank">    
				<img src = "/images/edit.png">
			</a>
		<? } ?>
	</h1>
</div>

<? $this->widget('zii.widgets.CListView', array(
	'id'=>'user-list',
	'dataProvider'=>$dataProvider,
	'itemView'=>'../catalog/_view', 
	'itemsCssClass' => 'goods',
	'itemsTagName' => 'ul',
	'summaryText'=>false,  
	'emptyText'=>false,
	'pagerCssClass'=>'nav',

	'sortableAttributes'=>array('price'),
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
));?>