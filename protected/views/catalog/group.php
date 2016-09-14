<?/* if(Yii::app()->session->get("admin") != 1) 
	{?>

	<?if($collection->seo_title)
		$this->pageTitle = $collection->seo_title; ?>
	<?if($collection->seo_keywords)
		$this->pageKeywords = $collection->seo_keywords; ?>
	<?if($collection->seo_description)
		$this->pageDescription = $collection->seo_description; ?>

	<? $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>array(
			'Коллекции' => array('/catalog'),
			$collection->name,
		),
	)); ?>

	<ul class='category' style="text-align:left;">
		<?foreach ($groups as $data) {?>
			<li>
				<a href ='<?=$data->createUrl();?>'>
					<span class='category_img'>
						<img src='<?=$data->image;?>'>
						<div class='img_border'></div>
					</span>
					<div class='category_text'><?=$data->name?></div>
				</a>
			</li>
		<?}?>
	</ul>

	<br>
	<br><br>
	<div>
		<?=$collection->description;?>
	</div>

<? } else { */?>

	<?if($collection->seo_title)
		$this->pageTitle = $collection->seo_title; ?>
	<?if($collection->seo_keywords)
		$this->pageKeywords = $collection->seo_keywords; ?>
	<?if($collection->seo_description)
		$this->pageDescription = $collection->seo_description; ?>

	<?// $this->pageTitle = $collection->name; ?>
	<?/* $this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('Главная', array('site/index')),
			'separator' => ' / ',
			'links'=>array(
				'Коллекции' => array('/catalog'),
				$collection->name,
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
	<div class="h1-substrate"></div>
	<div id="container">
		<div id="content">
			<div class="h1_box">
				<h1><?=$collection->name?></h1>
			</div>
			<div style="float:right; margin:0 40px 20px 0;">
				<?php	// считываем настройку
					$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
				?>
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
				<?php
					echo CHtml::dropDownList('sort',
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
					'class' => 'myPager',
				)
			));  ?>
			
			<h2 style="text-align:center"><?=$collection->name;?></h2>
			<div class="catalog_text"><?=$collection->description;?></div>
			<?//=Page::viewContent(5);?>
		</div><!-- #content-->
	</div>
	<div class="sidebar" id="sideLeft">
		<div class="category_head">
			<?=$collection->name?>
		</div>
		<ul class="category_nav">
			<? foreach ($groups as $parent) { ?>
				<?//$parentSize = $parent->countZet();
				if(/*$parentSize || true && */$parent->id != 6 && $parent->id != 5){?>
					<li>
						<a href="/catalog/<?=$collection->alias?>/<?=$parent->alias?>" title="<?=$parent->name;?>. Купить оптом">
							<?=$parent->name?>
						</a> 
						<span class="category_count"><?//=$parentSize;?></span>
					</li>
				<? } ?>
			<? } ?>
			<li><a href="/catalog/<?=$collection->alias?>/novelty" title="Новинки <?=$collection->name?>. Купить оптом">Новинки коллекции</a> <span class="category_count"><?//=$parentSize;?></span></li>
		</ul>
		<?=Page::viewContent(4);?>
	</div>
	<div class="catalog_right"></div>
<?// } ?>