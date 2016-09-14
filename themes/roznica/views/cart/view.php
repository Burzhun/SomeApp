 <?$minSum = User::minSum();
 
 ?>

<?
	$this->pageTitle = "Корзина - ".$this->pageTitle;
	$breadcrumbs = array('Корзина');
$this->breadcrumbs = $breadcrumbs;
	/*$this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>$breadcrumbs));*/
?>
<script>
	/*function minSumChecked(_cart_total)
	{
		if(Number(_cart_total.replace(" ", "")) < "<?=$minSum;?>")
		{
			jQuery("#ordering").css("display", "none");
			jQuery("#moneyIsTight").css("display", "block");
		}else{
			jQuery("#ordering").css("display", "block");
			jQuery("#moneyIsTight").css("display", "none");
		}
	}*/


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
	<div class="private-office-nav">
		<div class="priv-nav-block">
			<a href="/profile">Мои данные</a> 
			<a href="/office">Мои заказы</a>
			<?php /*?><a href="/discount" >Скидки</a><?php */?>
			<a href="/cart"  class="active-nav-private">Корзина</a> 
		</div> 
	</div>
<? } ?>


<h1>Корзина</h1>


<div id="cart-container">

	<? if(count($model)>0) { ?>
		<? $all = 0; ?>

		<p class="all-goods">Всего товаров: <span id="cart-count"><?=count($model)?></span></p>

			<ul class="cartList">
				<? foreach ($model as $item) {
					if(!empty($item->item->images[0]->filename))
					$image = Yii::app()->iwi->load("uploads/".$item->item->images[0]->filename)->adaptive(153,153)->cache();
				else
					$image = "/images/empty.png";?> 

				<li id = "cart_<?=$item->id?>">
					<div class="cartIndex"><?$j++?>.</div>

					<div class="cartImg">
						<a href="/goods/<?=$item->item->id?>">
							<img src="<?=$image;?>" width="167"/>
						</a>
						<?/*<img src="/uploads/cache/r27020946086a3c6e0933c7873ea9fa8ad9d30b.jpg" width="167">*/?>
					</div>
			<div class="cartName">
				<a href="/goods/<?=$item->item->id?>">
					<?=$item->item->name?>
				</a>

				<? $goodsize = $item->size ? "&size=".$item->size : "";?>
				<? $goodstone = $item->stonekod ? "&stone=".$item->stonekod : "";?>
				<? $serialkod = $item->serialkod ? "&serialkod=".$item->serialkod : "";?>
				<? $checkStone = $item->good->getDefaultStone()->stonekod == $item->stonekod ? "&checkStone=0" : "&checkStone=1"?>
				 
			</div> 
			<div class="cartSize">
				<?if($item->size){?>
					<?=$item->size?>
				<?}?>
			</div> 
			<div class="cartCount">

				<div class="count-block">

					<?if(!$item->serialkod) { //если товар выбран из ниличия (serialkod != "") то не даем возможность менять количество?>
						<?=CHtml::ajaxLink('  ',
							array("cart/deleteitem?id=$item->id".$goodsize.$goodstone.$serialkod.$checkStone),
							array('complete' => "js:numDel($item->id)",
								'success'=>'js:reCount',
							),
							array('class' => 'minus1 mainMinus',)
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
							array('class' => 'plus2  mainPlus',)
						); ?>
					<? } ?>

					<?/*<a class="mainMinus" href="#" id="yt0">-</a>
					<p id="num_116">1</p>
					<a class="mainPlus" href="#" id="yt1">+</a>*/?>
				</div> 
			</div> 

			<?if($item->stonekod){?>
				<div style="width:32px;display:inline-block;position:relative;top: 10px;">
					<img src="/uploads/<?=Stone::model()->find(array('condition'=>"kod='".$item->stonekod."'"))->imageStone->filename;?>" width="30px;">
				</div>
				
			<?}?>


			<div class="cartPrice">
			<?$priceItem = $item->item->defaultPrice();?>
				<span id = "sum_one_<?=$item->id?>"><?=$priceItem?></span></span>
				<?/*<span id = "sum_one_<?=$item->id?>"><?=$item->item->getCalculatedPrice(array("serialkod"=>$item->serialkod, "withoutRub"=>true));?></span></span> руб.*/?>
				<?/*<p class="order-amount">Сумма: <span  ><span id = "sum_of_<?=$item->id?>"><?=Functions::numberformat($item->item->getCalculatedPrice(array("serialkod"=>$item->serialkod, "withoutRub"=>true))*$item->num*$this->multiplier)?></span> </span>руб.</p>*/?>
			<?/*<span id="sum_one_116">

				245 
				</span>
				руб.
			<div class="itogPrice">
				<span id="sum_of_116">
					245 
				</span>
					руб.</div>
			</div> */?></div>


			<?/*<a class="cancel-order delete_from_cart btnOther cartDelete" href="#" id="yt2">
			<img src="/img/cartDelete.png">
			</a>*/?>

			<?=CHtml::ajaxLink('<img src="/themes/roznica/img/cartDelete.png">',
					array("cart/deleteall/id/$item->id"),
					array('success'=>'js:reCount',	
					'complete' => "js:totalUpdate($item->id)"),
					array('class' => 'cancel-order delete_from_cart btnOther cartDelete')
				);?>				
			

			</li>
			<?// $all+=$item->num*$item->price; 
			
			$all+=$item->num*(int)str_replace(' ', '', $priceItem);
			?>    
			<? } ?>

		</ul>

		<? Yii::app()->clientScript->registerScript('scriptname','
			function reCount(data, textStatus, jqXHR){
				var obj = jQuery.parseJSON(data);
				jQuery(".bascet").html(obj.cart);
				//minSumChecked(obj.cart_total);
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

		<div class="itog_box">
			<h2 style="display:inline-block">Итого</h2>  
			<p class="sum" style="display:inline-block">: <span id = "cart_total" ><span><?echo $totalSumInStart = Functions::numberformat($all*$this->multiplier)?></span> руб.</span></p>
		</div>

		<div style="clear:both"></div>

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
				<a id = "yes" style="cursor:pointer;"><span class="reg-button">Да</span>, я уже заказывал</a> &nbsp;&nbsp;
				<a id = "no" style="cursor:pointer;"><span class="reg-button">Нет</span>, я заказываю впервые</a>
				<br>
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
								<?php echo $form->error($login,'username', array('style'=>'margin-left:0px')); ?>
							</div>
						</div>
						
						<div>
							<div class="row" style='width:250px;'>
								<?php echo $form->labelEx($login,'password'); ?> 
								<?php echo $form->passwordField($login,'password', array('style'=>'vertical-align: middle;
display: inline-block;

background: #fff;
border: 1px solid #c0c0c0;')); ?>
								<?php echo $form->error($login,'password', array('style'=>'margin-left:0px')); ?>
							</div>
						</div>
						<div>
							<div class="row buttons">
								<div>
									<button type="submit" class='reg_button' style="float:left;">Вход</button>
								</div>
							</div>
						</div>
						<br><br>
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
		<?/*<div id="moneyIsTight">
			<br>
			<span style="color:#C42121;font-size:22px;">Минимальная сумма заказа <?=$minSum?> р. Добавьте в карзину еще товар и вы сможете оформить заказ.</span>
		</div>*/?>

	<? } else { ?>
		<br>
		
		<h1>Ваша корзина пуста!</h1>
		<?=CHtml::link('Вернуться на главную страницу',array('site/index'))?>
	<? }?>
	<div style="clear:both"></div>
</div>	

<script>
	minSumChecked("<?=$totalSumInStart?>");
</script>	




