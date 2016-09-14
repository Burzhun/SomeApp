<?/* $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>array(
				'Коллекции' => array('/catalog'),
		),
));
*/?>

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

<div id="container">
	<div id="content">
		<div class="h1_box">
		<?if(!$collection){?>
			<h1>Каталог ювелирных украшений</h1>
			<?$this->pageTitle = "Коллекции ювелирных изделий - ".$this->pageTitle; ?>
		<?}else{?>
			<?$this->pageTitle = $collection->name." - ".$this->pageTitle; ?>
			<h1><?=$collection->name?></h1>
		<?}?>
		</div>
		<div style="clear:both;"></div>
		<div id="user-list" class="list-view">
			<div class="summary"></div>

<?if(!$collection){?>
			<h2>Популярное</h2>
			
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
		
<?}else{?>
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
<?}?>
</div>
		<br>
		<br><br>
	</div><!-- #content-->
</div>
<div class="sidebar" id="sideLeft">
	<?php $this->widget('application.components.LeftSidebarWidget'); ?>

	<p>&nbsp;</p><p>&nbsp;</p>
	<div class="left_contact_box">
		Телефон:<br>
		<span class="left_tel">+7 (906) 481-72-72</span><br>
		<br>
		Представительство во Владикавказе:<br>
		<span class="left_tel">+7 (906) 494-44-40</span><br>
		<br>
		Представительство в Москве:<br>
		<span class="left_tel">+7 (903) 736-82-67</span>
	</div>

	<div class="banner">
		<img src="/img/banner.png">
	</div>
</div>