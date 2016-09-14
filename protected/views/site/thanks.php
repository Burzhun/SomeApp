<?
$this->pageTitle = "Удачная покупка - ".$this->pageTitle;

/*$breadcrumbs = array('Мои заказы');

$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('Главная', array('site/index')),
	'separator' => ' / ',
	'links'=>$breadcrumbs));
*/?>
<div class="private-office">
	<h1>СПАСИБО, ВАШ ЗАКАЗ ОФОРМЛЕН!</h1>
	<div class="private-office-nav">
		<div class="priv-nav-block">
			<a href="/profile" >Мои данные</a>
			<a href="/office">Мои заказы</a> 
			<a href="/discount">Скидки</a>
			<a href="/cart">Корзина</a> 
		</div> 
	</div>
	<div style="font-size:20px;">
		В близжайшее время время с вами свяжется наш менеджер для уточнения деталей заказа.<br><br>
		Быстрые ссылки:<br>
		<ul>
			<li><a href="/profile">Мои данные</a></li>
			<li><a href="/office">Мои заказы</a></li>
			<li><a href="/catalog">Коллекции ювелирных изделий</a></li>
		<ul>
	</div>
</div>