<?$minSum = User::minSum();?>

<style type="text/css">
.goods>li{
	padding: 10px;
	width: 100%;
	display: block;
	background: #151520;
}
.goodimage{
	float: left;
	width: 180px;
	height: 170px;
}
.goodstore{
	padding-left: 5px;
	width: 100%;
	margin-left: 180px;
}

.goodstore hr{
	width: 70%;
	margin: 3px 0 15px;
}
.goodstore a{
	text-decoration: none;
}
.goodstore>a:hover{
	color:#fac95a
}

.goodstore ul{
	width: 78%;
}
.nohover:hover{
	background: none;
}

.goodstore .to_cart{
	display: inline-block;
	width: 90px;
}
.qualit{
	min-width: 30px;
	cursor: pointer;
	display: inline-block;
	padding: 4px 0px 2px;
	background: #00010d;
	border-radius: 10px;
	border: 1px solid #534949;
}
.qualit-count{
	cursor: pointer;
	display: inline-block;
}
.minus1{
	background: url(/img/minus.png) center no-repeat;
	cursor: pointer;
	width: 12px;
	height: 12px;
	display: inline-block;
	vertical-align: -3px;
	margin-right: -3px;
	display: inline-block;
	padding: 2px 4px 1px 10px;
}
.plus2{
	background: url(/img/plus.png) center no-repeat;
	cursor: pointer;
	width: 12px;
	height: 12px;
	display: inline-block;
	vertical-align: -3px;
	margin-right: 3px;
	display: inline-block;
	padding: 2px 12px 0px 0px;

}

table{
	text-align: center;
	width: 78%;
}

table td{
	vertical-align: top;
	padding: 10px 3px 7px;
}

table tr:hover{
	background: #3D3939;
}

table th{
	color: #fac95a;
}
img{
	margin: 0;
	float: none;
}

</style>

<?
	$this->pageTitle = "Корзина - ".$this->pageTitle;
	$breadcrumbs = array('Корзина');
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>$breadcrumbs));
?>

<script>
	function minSumChecked(_cart_total)
	{
		if(Number(_cart_total.replace(" ", "")) < "<?=$minSum;?>")
		{
			jQuery("#ordering").css("display", "none");
			jQuery("#moneyIsTight").css("display", "block");
		}else{
			jQuery("#ordering").css("display", "block");
			jQuery("#moneyIsTight").css("display", "none");
		}
	}


	$(function(){
		x = '';
		$('.autosave').keypress(function(){   // вызываем по keypress
			clearTimeout(x); // сбрасываем вызываемые ранее таймеры
			comment  = $(this).val();
			pk =  $(this).attr('pikabu');
			x = setTimeout(function(){  // заводим таймер
				$.post("/cart/updateAjax",
				{ pk: pk, name: "comment", value: comment }
				);
			}, 1000);
		});
	});

	var multiplier = <?=$this->multiplier?>;
	
	function number_format( number, decimals, dec_point, thousands_sep ) {
		var i, j, kw, kd, km;
		if( isNaN(decimals = Math.abs(decimals)) ){
			decimals = 2;
		}

		if( dec_point == undefined ){
			dec_point = ",";
		}

		if( thousands_sep == undefined ){
			thousands_sep = ".";
		}

		i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
		
		if( (j = i.length) > 3 ){
			j = j % 3;
		} else{
			j = 0;
		}
		km = (j ? i.substr(0, j) + thousands_sep : "");
		kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
		kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
		return km + kw + kd;
	}

</script>

<? if(!Yii::app()->user->isGuest) { ?>
<h1>ЛИЧНЫЙ КАБИНЕТ</h1>
	<div class="private-office-nav">
		<div class="priv-nav-block">
			<a href="/profile" >Мои данные</a>
			<a href="/office"  >Мои заказы</a> 
			<a href="/discount" >Скидки</a>
			<a href="/cart"  class="active-nav-private"  >Корзина</a> 
		</div>
	</div>
<? } ?>

<div id = "cart-container">

	<? if(count($model)>0) { ?>

		<? $all = 0; ?>

		<h1>КОРЗИНА</h1>
		<p class="cart-text">Здравствуйте. Вы выбрали товары, осталось только оформить заказ!</p>
		<p class="all-goods">Всего товаров: <span id="cart-count"><?=count($model)?></span></p>
		<br><br>
		<ul class="cart_list">
			<? foreach ($model as $item) {
				if(!empty($item->item->images[0]->filename))
					$image = Yii::app()->iwi->load("uploads/".$item->item->images[0]->filename)->adaptive(153,153)->cache();
				else
					$image = "/images/empty.png";?> 

					<li id = "cart_<?=$item->id?>">
						<div class="goodimage">
					 		<a href="/goods/<?=$item->item->id?>">
								<img src="<?=$image;?>" width="153"/>
							</a>
					 	</div>
					 	<div class="goodstore">
					 		<a href="/goods/<?=$item->item->id?>">
								<div class=><?=$item->item->name?></div>
							</a>
							<hr>
							<table>
								<tr class='nohover'>
									<?if($item->size){?>
										<th>Размер</th>
									<?}?>
									<?if($item->weight){?>
										<th>Вес</th>
									<?}?>
									<th>Количество</th>
									<?if($item->stonekod){?>
										<th>Камень</th>
									<?}?>
									<?//if(!Yii::app()->user->isGuest){?>
										<th>Цена</th>
									<?//}?>
									<th></th>
								</tr>
								<tr>
									<? $goodsize = $item->size ? "&size=".$item->size : "";?>
									<? $goodstone = $item->stonekod ? "&stone=".$item->stonekod : "";?>
									<? $serialkod = $item->serialkod ? "&serialkod=".$item->serialkod : "";?>
									<? $checkStone = $item->good->getDefaultStone()->stonekod == $item->stonekod ? "&checkStone=0" : "&checkStone=1"?>
									
									<?if($item->size){?>
										<td>
											<p><?=$item->size?></p>
										</td>
									<?}?>
									
									<?if($item->weight){?>
										<td><?=$item->weight?></td>
									<?}?>
									
									<td>
										<div class="qualit">
											<?if(!$item->serialkod) { //если товар выбран из ниличия (serialkod != "") то не даем возможность менять количество?>
												<?=CHtml::ajaxLink('  ',
													array("cart/deleteitem?id=$item->id".$goodsize.$goodstone.$serialkod.$checkStone),
													array('complete' => "js:numDel($item->id)",
														'success'=>'js:reCount',
													),
													array('class' => 'minus1',)
												);?>
											<? } ?>
											<p class="qualit-count" style="display:inline;" id = "num_<?=$item->id?>"><?=$item->num?></p>
											<?/*<span class="qualit-count" data-max = '<?=$stor->kolvo;?>'><?=$stor->kolvo;?></span>*/?>
										  	<?if(!$item->serialkod) { //если товар выбран из ниличия (serialkod != "") то не даем возможность менять количество?>
											  	<?=CHtml::ajaxLink(' ',
													array("cart/additem?id=".$item->item->id.$goodsize.$goodstone.$serialkod.$checkStone),
													array(
														'complete' => "js:numAdd($item->id)",
														'success'=>'js:reCount'
													),
													array('class' => 'plus2',)
												); ?>
											<? } ?>
									  	</div>
									</td>
									
									<?if($item->stonekod){?>
										<td>
											<p> <img src="/uploads/<?=Stone::model()->find(array('condition'=>"kod='".$item->stonekod."'"))->imageStone->filename;?>" width="30px;"></p>
										</td>
									<?}?>
									<?//if(!Yii::app()->user->isGuest){?>
									
									<td><?//Yii::app()->cache->flush();?>
										<p><span><span id = "sum_one_<?=$item->id?>"><?=Functions::numberformat($item->item->getCalculatedPrice(array("serialkod"=>$item->serialkod, "withoutRub"=>true,"stone"=>$item->stonekod,'size'=>$item->size, 'checkStone'=>1)));?></span></span> руб.</p> <?//=$item->stonekod;?>
										<p class="order-amount">Сумма: <span  ><span id = "sum_of_<?=$item->id?>"><?=Functions::numberformat($item->item->getCalculatedPrice(array("serialkod"=>$item->serialkod, "withoutRub"=>true, "stone"=>$item->stonekod,'size'=>$item->size, 'checkStone'=>1))*$item->num*$this->multiplier)?></span> </span>руб.</p>                  
									</td>
									
									<?//}?>
									
									<td>
										<?=CHtml::ajaxLink('Удалить заказ',
											array("cart/deleteall/id/$item->id"),
											array('success'=>'js:reCount',	
											'complete' => "js:totalUpdate($item->id)"),
											array('class' => 'cancel-order delete_from_cart')
										);?>
									</td>
								</tr>
							</table>
					 	</div>
						<?/*<div class="cart_img">
							Артикул: <a href="/goods/<?=$item->item->id?>"><?=$item->item->marking?></a>
							<br><br>
							<img src="<?=$image;?>" width="153" />
						</div>*/?>

						<?/*<div class="cart_right">
							<div class='count-block'>
								<?/*=CHtml::ajaxLink('-',
								array("cart/deleteitem/id/$item->id"),
								array('complete' => "js:numDel($item->id)",
									'success'=>'js:reCount',
								),
								array('class' => 'minus1',)
								);?>
								<p style="display:inline;" id = "num_<?=$item->id?>"><?=$item->num?></p>
								
								<?=CHtml::ajaxLink('+',
								array("cart/additem/id/".$item->item->id),
								array('complete' => "js:numAdd($item->id)",
								'success'=>'js:reCount'),
								array('class' => 'plus2',));
								*/?>

						<?/*		<? $goodsize = $item->size ? "&size=".$item->size : "";?>
								<? $goodstone = $item->stonekod ? "&stone=".$item->stonekod : "";?>
								<?=CHtml::ajaxLink('-',
								array("cart/deleteitem?id=$item->id".$goodsize.$goodstone),
								array('complete' => "js:numDel($item->id)",
									'success'=>'js:reCount',
								),
								array('class' => 'minus1',)
								);?>
								<p style="display:inline;" id = "num_<?=$item->id?>"><?=$item->num?></p>
								
								<?=CHtml::ajaxLink('+',
								array("cart/additem?id=".$item->item->id.$goodsize.$goodstone),
								array('complete' => "js:numAdd($item->id)",
								'success'=>'js:reCount'),
								array('class' => 'plus2',));
								?>

							</div>
							<?if($item->size){?><p>Размер <?=$item->size?></p><?}?>
							<?if($item->stonekod){?><p>Камень <img src="/uploads/small_<?=Stone::model()->find(array('condition'=>"kod='".$item->stonekod."'"))->imageStone->filename;?>" width="30px;"></p><br><?}?>
							<?if(!Yii::app()->user->isGuest){?>
								<p>Цена: <strong><span id = "sum_one_<?=$item->id?>"><?=$item->price;?></span></strong> руб.</p> 
								<p class="order-amount">Сумма: <strong  ><span id = "sum_of_<?=$item->id?>"><?=Functions::numberformat($item->price*$item->num*$this->multiplier)?></span> </strong>руб.</p>                  
							<? } ?>
							<div class="goods-rightside">

								<?=CHtml::ajaxLink('Удалить заказ',
									array("cart/deleteall/id/$item->id"),
									array('success'=>'js:reCount',	
									'complete' => "js:totalUpdate($item->id)"),
									array('class' => 'cancel-order delete_from_cart')
								);?>
							</div>
						</div>*/?>
					</li>
				<? $all+=$item->num*$item->price; ?>
			<? } ?>
		</ul>      
		<? Yii::app()->clientScript->registerScript('scriptname','
			function reCount(data, textStatus, jqXHR){
				var obj = jQuery.parseJSON(data);
				jQuery(".bascet").html(obj.cart);
				minSumChecked(obj.cart_total);
				jQuery("#cart_total").html(obj.cart_total + " руб.");
			}
		');?>
		
		<script>
			function numAdd(id)
			{

				var value = jQuery('#num_'+id).html();
				value++;

				<?//if(!Yii::app()->user->isGuest){?>
					var sum = jQuery('#sum_one_'+id).html();
					var sumNumber=sum.replace(" ","");
					//
					sumNumber*=multiplier;
					//

					sumNumber = number_format(sumNumber*value,0,false, " ");
					jQuery('#sum_of_'+id).html(sumNumber);
				<?// } ?>
				jQuery('#num_'+id).html(value);

			}
			
			function numDel(id)
			{
				var value = jQuery('#num_'+id).html();
				if(value!=1)
				value--;
				
				<?//if(!Yii::app()->user->isGuest){?>
					var sum = jQuery('#sum_one_'+id).html();
					var sumNumber=sum.replace(" ","");
					sumNumber*=multiplier;
					sumNumber = number_format(sumNumber*value, 0, false, " ");
					jQuery('#sum_of_'+id).html(sumNumber);
				<?// } ?>
				jQuery('#num_'+id).html(value);
			}

			function totalUpdate(id)
			{
				var value = jQuery('#cart-count').html();
				if(value!=1) {
					value--;
					jQuery('#cart_'+id).hide();
					jQuery('#cart-count').html(value);
				} else
					jQuery('#cart-container').html("<br><h1>Ваша корзина пуста!</h1><a href = '/'>На главную</a>");
			}

		</script>

		<?//if(!Yii::app()->user->isGuest){?>
			<div class="itog_box">
				<h2>Итого</h2>  
				<p class="sum">СУММА: <span id = "cart_total" ><span><?echo $totalSumInStart = Functions::numberformat($all*$this->multiplier)?></span> руб.</span></p>
			</div>
		<?// } ?>
		
		<div style = "clear: both"></div>
		
		<div id="ordering">
			<a name="order"></a>
			<h1 class='order_link'>ОФОРМИТЬ ЗАКАЗ</h1>

			<? if(count($login->getErrors())+count($order->getErrors())>0){?>
				<script>
					$(document).ready(function() {
						window.location.hash="order"; 
					});
				</script>
			<? } ?>

			<? if(Yii::app()->user->isGuest){?>
				<b>Вы уже заказывали раньше на нашем сайте?</b>&nbsp;&nbsp;&nbsp; 
				<a id = "yes"><span class="reg-button">Да</span>, я уже заказывал</a> &nbsp;&nbsp;
				<a id = "no"><span class="reg-button">Нет</span>, я заказываю впервые</a>
				
				<script>
					$(function() {
						$("#yes").click(function() {
							$('#unreg_form').hide();
							$('#login').show();
						});
						$("#no").click(function() {
							$('#unreg_form').show();
							$('#login').hide();
						});
					});
				</script>
			<? } ?>
			
			<br>



			<div id = "login"  <? if(!count($login->getErrors())){?> style="display:none;"<? } ?> >
				<div class="order-form">
					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'cart-login-form',
					)); ?>

						<h1>Выполните вход на сайт</h1>
						<div>
							<div class="row" style='width:250px;'>
								<?php echo $form->labelEx($login,'username'); ?> 
								<?php echo $form->textField($login,'username'); ?>
								<?php echo $form->error($login,'username'); ?>
							</div>
						</div>
						
						<div>
							<div class="row" style='width:250px;'>
								<?php echo $form->labelEx($login,'password'); ?> 
								<?php echo $form->passwordField($login,'password'); ?>
								<?php echo $form->error($login,'password'); ?>
							</div>
						</div>
						<div>
							<div class="row buttons">
								<div>
									<button type="submit" class='reg_button' >Вход</button>
								</div>
							</div>
						</div>
					<?php $this->endWidget(); ?>
				</div>
			</div>

	 
			<div id = "unreg_form" 
				<? if(count($order->getErrors())){ ?> 
					style="display:block;"
				<? }else{ ?>
					<? if(Yii::app()->user->isGuest){ ?> 
						style="display:none;"
					<? } ?>
				<? } ?>>
				<?php echo $this->renderPartial('_form', array('model'=>$order)); ?>
			</div>
		</div>
		<div id="moneyIsTight">
			<br>
			<span style="color:#C42121;font-size:22px;">Минимальная сумма заказа <?=$minSum?> р. Добавьте в карзину еще товар и вы сможете оформить заказ.</span>
			<br>
			<span style="font-size:20px;">Или купите эти товары в нашем розничном интернет-магазине <a href="http://www.kubachinka.ru" target="_blank">www.kubachinka.ru</a> без ограничений!</span>

		</div>
	<? } else { ?>
		<br>
		
		<h1>Ваша корзина пуста!</h1>
		<?=CHtml::link('Вернуться на главную страницу',array('site/index'))?>
	<? }?>
</div>

<script>
	minSumChecked("<?=$totalSumInStart?>");
</script>