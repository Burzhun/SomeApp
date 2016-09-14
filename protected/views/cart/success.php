<?$this->pageTitle = "Оформление заказа - ".$this->pageTitle; ?>

<div class="l-main"><div class="w-main">
<p class="bread_crumbs"><? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
    'links'=>array(
        'Корзина',
		'Оформить заказ',
    ),
	'tagName' => 'bread_crumbs',
));
?></p>

<article class="l-bg-box product" itemscope="" itemtype="http://schema.org/Product">


<h1>Заказ оформлен!</h1>
<h2 style = "margin: 15px;">Спасибо, ваш заказ оформлен, с вами свяжутся наши менеджеры</h2>
<?=CHtml::link("Вернуться на главную страницу", array('site/index'))?>
            </div><!-- #content-->

</article>
        </div><!-- #container-->