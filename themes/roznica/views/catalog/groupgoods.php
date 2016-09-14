
<?


$this->pageTitle = $groupM->seotitle ? $groupM->seotitle : $this->pageTitle; ?>
<?$this->pageKeywords = $groupM->seokeywords ? $groupM->seokeywords : $this->pageKeywords; ?>
<?$this->pageDescription = $groupM->seodescription ? $groupM->seodescription : $this->pageDescription; ?>

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
				<h1><?=$groupM->name;?></h1>
				
					<? $this->widget('zii.widgets.CListView', array(
						'id'=>'user-list',
						'dataProvider'=>$dataProvider,
						'itemView'=>'../catalog/_view', 
						'itemsCssClass' => 'goods',
						'itemsTagName' => 'ul',
						'summaryText'=>false,  
						'emptyText'=>false,

						'sortableAttributes'=>array('price'),
						'sorterCssClass'=>'sorter',
						'sorterHeader'=>'<span class="filter">Сортировать по:</span>',


						'pagerCssClass'=>'nav',
						'pager'=>array(
							'cssFile'=>false,

							'header'=>'',
							//'firstPageLabel'=>false,
							//'lastPageLabel'=>false,
							'nextPageLabel'=>'&#8250;',
							'prevPageLabel'=>'&#8249;',
						)
					));?>
				
			  	


		 	<?/*<div class="nav">
		 		<ul id="yw1" class="yiiPager"><li class="first hidden"><a href="/category/krossovki">&lt;&lt; Первая</a></li>
					<li class="previous hidden"><a href="/category/krossovki">‹</a></li>
					<li class="page selected"><a href="/category/krossovki">1</a></li>
					<li class="page"><a href="/category/krossovki?Item_page=2">2</a></li>
					<li class="page"><a href="/category/krossovki?Item_page=3">3</a></li>
					<li class="next"><a href="/category/krossovki?Item_page=2">›</a></li>
					<li class="last"><a href="/category/krossovki?Item_page=3">Последняя &gt;&gt;</a></li>
				</ul>
			</div>*/?>


		<div class='catalogText'>
		<?=$groupM->description;?>

		</div>

			