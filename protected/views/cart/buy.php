<?$this->pageTitle = "Оформление заказа - ".$this->pageTitle; ?>

<div class="l-main"><div class="w-main">



                <p class="bread_crumbs"><? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
    'links'=>array(
        'Корзина' => array("/cart/view"),
		'Оформить заказ',
    ),
	'tagName' => 'bread_crumbs',
));
?></p>
<h1>Оформить заказ</h1>
		<?if (count($model)>0) { ?>
		
<?php echo $this->renderPartial('_form', array('model'=>$order)); ?>


		
		<? } else
			{
			?>Ваша корзина пуста!<?
			}?>	
            </div><!-- #content-->

        </div><!-- #container-->