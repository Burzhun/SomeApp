<?
$this->pageTitle = "Мои заказы - ".$this->pageTitle;

$breadcrumbs = array('Мои заказы');

$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('Главная', array('site/index')),
	'separator' => ' / ',
	'links'=>$breadcrumbs));
?>

<?$agent = User::model()->findByPk(Yii::app()->user->id);?>

<div class="private-office">
	<h1>ЛИЧНЫЙ КАБИНЕТ</h1>
	<div class="private-office-nav">
		<div class="priv-nav-block">
			<a href="/profile" >Мои данные</a>
			<a href="/office" class="active-nav-private" >Мои заказы</a>
			<?php if(Yii::app()->theme->name != 'roznica') { ?><a href="/discount">Скидки</a> <?php } ?>
			<a href="/cart"   >Корзина</a> 
		</div> 
	</div>   
	<table>
		<tr class="priv-head">
			<td>Заказ</td>
			<td>Дата заказа </td>
			<td>Товары </td>

			<td>Сумма к оплате </td>
			<td>Статус заказа</td>
			<td>Дополнительная информация</td>
		</tr>
		<? foreach ($models as $model) { ?>
			<tr>
				<td style = "width: 40px;"><span><?=$model->id?></span></td>
				<td style = "width: 80px;"><?=date("d.m.Y",$model->date)?></td>
				<td style = "width: 200px;"><?=$model->itemlistoffice;?></td>

				<td style = "width: 60px;"><?=$model->TotalPrice;?> руб.</td>
				<td style = "width: 70px;">
					<?$orderStatus = V8OrderStatus::model()->find(array('condition'=>"orderid='".$model->id."'"));?>
					<?$orderStatusItems = V8OrderStatusItem::model()->findAll(array('condition'=>"id_v8_order_status='".$orderStatus->id."'", "order"=>"position ASC"));

					foreach ($orderStatusItems as $osi) { ?>
						<p class='orderItemStatus'  >
						<? if($osi->done)
						{
							echo "<img src='/img/checkStatus.png'>&nbsp;";
						} else {
							echo "<img src='/img/uncheckStatus.png'>&nbsp;";
						}
						$statusName = V8Status::model()->cache(60000)->find(array('condition'=>"kod='".$osi->v8_status_kod."'"));?>
						<span class="status_name_span" data-idd="1<?echo $statusName->kod;?>" style=""><?echo $statusName->name;?></span>
						<br><br>
						<span id="status_discription_1<?echo $statusName->kod;?>" data-i="1<?echo $statusName->kod;?>" style="display:none;color:#aaa"><?=$statusName->description?></span>
						</p>
					<? } ?>
					<?//=$model->statusText?>
				</td>
				<td style = "width: 140px;">
					<b>ФИО: </b><?=$model->name?><br><br>
					<b>Менеджер: </b><?=$model->managerName?><br><br>
					<b>Транспортная компания: </b><?=$model->transport?><br><br>
					<?if($model->passport){?><b>Паспортные данные: </b><?=$model->passport?><br><br><?}?>
					<b>Адрес: </b><?=$model->address?><br><br>
					<b>Телефон: </b><?=$model->phone?><br><br>
				</td>
			</tr>
		<? } ?>
	</table>
</div>


<style>
	.status_name_span {
		border-bottom:1px dashed #888;
		cursor: pointer;
	}

	.status_name_span:hover {
		border-bottom:1px;
	}
</style>
<script>
	$(".status_name_span").click(function(){
		var target = "#status_discription_" + String($(this).data('idd'));
		
		$(target).toggle();
	})
</script>