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

 

<style>
	.sorter a {
		color: #333;
	}
</style>
 
	
	
	 

<? if(!empty($model->Sub)){?> 
	<? foreach ($model->Sub as $parent) { ?>
		<? if($parent->count){?>
			<?=CHtml::link($parent->name, $parent->createurl)?>   (<?=$parent->items()?>)  <br>  
		<? } ?>
	<? } ?> 
<? } ?>


<? if(!$dataProvider->totalItemCount){?>

	<h1>Нет товаров</h1>

<? }else{ ?>

	<?php	// считываем настройку
		$sort=Yii::app()->user->getState('sort',Yii::app()->params['defaultSort']);		
		$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
	?>
	<div style="text-align:right;padding-right:150px;padding-bottom:7px;">
		
		<form  style="display:inline;">
		Показывать на странице:
		<?=CHtml::dropDownList(
					'pageSize',
					$pageSize,
					array(10=>10,20=>20,50=>50,100=>100),
					array('onchange'=>"this.form.submit()")
				);?>
		</form>

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
	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'../catalog/_view',
		'viewData' => array('model' => $model),
		'itemsCssClass' => 'goods',
		'itemsTagName' => 'ul',
		'summaryText'=>false,  
		'emptyText'=>false,
		'pagerCssClass'=>'nav',
		'pager'=>array(
			'cssFile'=>'',
			'class' => 'myPager',
		)
	));?>
<? } ?>

<? if(!empty($model->description)){ ?> 
	<?=$model->description;?>
<? } ?>