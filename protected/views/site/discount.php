<?
$this->pageTitle = "Скидки - ".$this->pageTitle;

$breadcrumbs = array('Скидки');

$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('Главная', array('site/index')),
	'separator' => ' / ',
	'links'=>$breadcrumbs));
?>
<div class="private-office">
	<h1>ЛИЧНЫЙ КАБИНЕТ</h1>
	<div class="private-office-nav">
		<div class="priv-nav-block">
			<a href="/profile" >Мои данные</a>
			<a href="/office">Мои заказы</a> 
			<a href="/discount" class="active-nav-private" >Скидки</a>
			<a href="/cart"   >Корзина</a> 
		</div> 
	</div>
	<?if($models) { ?>
		<table>
			<?foreach ($models as $data) { ?>
				<?if($data->groupkod == '000000004' || $data->groupkod == '000000002') continue;?>
				<tr>
					<td><div style="font-size:18px;display:inline-block;"><?=Goodgroup::model()->find(array('condition'=>"kod='".$data->groupkod."'"))->name?></div></td>
					<td><div style="font-size:18px;display:inline-block;color:#f9c241;"><?=$data->discount?>%</div></td>
					<script>
						console.log('<?print_r($data->userkod);?>');
					</script>
				</tr>
			<? } ?>
		</table>
	<? } else { ?>
		<h2>У вас нет скидок</h2>
	<? } ?>
</div>