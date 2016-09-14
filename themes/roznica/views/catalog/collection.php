
<?$this->pageTitle = $groupM->seo_title ? $groupM->seo_title : $this->pageTitle; ?>
<?$this->pageKeywords = $groupM->seo_keywords ? $groupM->seo_keywords : $this->pageKeywords; ?>
<?$this->pageDescription = $groupM->seo_description ? $groupM->seo_description : $this->pageDescription; ?>

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
</div>		<h2>Популярное</h2>
			
			<? $this->widget('zii.widgets.CListView', array(
				'id'=>'user-list',
				'dataProvider'=>$popularDataProvider,
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
			<p>&nbsp;</p>

			<h2>Новинки</h2>
			
			<? $this->widget('zii.widgets.CListView', array(
				'id'=>'user-list',
				'dataProvider'=>$noveltyDataProvider,
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

			