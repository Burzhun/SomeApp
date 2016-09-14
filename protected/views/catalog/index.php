<?$this->pageTitle = "Каталог товаров - ".$this->pageTitle; ?>
<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>array(
				'Каталог' => array('/catalog'),
		),
));
?> 
<div class="h1-substrate"></div>
<div id="container">
	<div id="content">
		<div class="h1_box">
			<h1> КАТАЛОГ ПРОДУКЦИИ</h1>
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
									    array('kod.desc'=>'Новизне','marking.desc'=>'Артикулу'),
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
		));  ?>
		<?=Page::viewContent(5);?>
	</div><!-- #content-->
</div>
<?if($group){?>

	<div class="sidebar" id="sideLeft">
		<div class="category_head">
			КАТАЛОГ ПРОДУКЦИИ
		</div>
		<ul class="category_nav">
			<? foreach ($models as $parent) { ?>
			<li>
				<a href="<?=$parent->createurl?>" title="<?=$parent->name." продажа оптом - Агра"?>">
					<?=$parent->name?>
				</a>
				<span class="category_count">
					<?=$parent->countZet();?>
				</span>
			</li>
			<? } ?>
		</ul>
		<?=Page::viewContent(4);?>
	</div>
<?}else{?>
		<div class="sidebar" id="sideLeft">
			<div class="category_head">
				КАТАЛОГ ПРОДУКЦИИ
			</div>
			<ul class="category_nav">
				<? foreach ($models as $parent) { ?>
					<?$parentSize = $parent->countZet();
					if($parentSize){?>
						<li>
							<a href="<?=$parent->createurl?>" title="<?=$parent->name." продажа оптом - Агра"?>">
								<?=$parent->name?>
							</a>
							<span class="category_count">
								<?=$parentSize;?>
							</span>
						</li>
					<? } ?>
				<? } ?>
			</ul>
			<?=Page::viewContent(4);?>
		</div>
<?}?>
<div class="catalog_right"></div>

