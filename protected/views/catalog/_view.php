<? $calculatedPrice = $data->getCalculatedPrice();?>

<?/*if(Yii::app()->user->id==1091){?>
 <li>
	<a href="<?=$data->createurl?>">
		<div class="goods_title"><?=$data->name?></div>
		<span class="goods_img">
			<img src="<?=Yii::app()->iwi->load("uploads/".$data->image)->adaptive(250,250)->cache();?>" />
		</span>
	</a>

	<div class="price_box">
		<?=$data->weight_avg;?> гр. <span class="price" id="price<?=$data->id;?>"><?=$calculatedPrice;?></span>
	</div>

	<div class="cart">
		<div class="count_popup">
			<span class="count_head">количество</span>
			<div class="number">
				<span class="minus"></span>
				<input type="text" value="1">
				<span class="plus"></span>
			</div>
		</div>
		<? echo CHtml::ajaxLink(
			"В корзину",
			array("cart/add/id/$data->id"),
			array(
				'update'=>'.bascet',
			),
			array(
				'class' => 'to_cart',
				'onClick' => "addToBasket('$11data->name $data->article','',$data->id);  return false")
			);
		?>
	</div>
</li>
<?}else{*/?>

	<li id="item<?=$data->id;?>">
		<a href="<?=$data->createurl?>" title='<?=$data->name?>' <?=$data->kod?>>
			<div class="goods_title"><?=$data->name_full ? $data->name_full : $data->name; ?></div>
			<span class="goods_img">
				<img title='<?=$data->name?>' src="<?=Yii::app()->iwi->load("uploads/".$data->image)->adaptive(250,250)->cache();?>" />
			</span>
		</a>
		<div class="price_box">
			<?=substr_replace($data->weight_ap, '', -1, 1);?> гр. <span class="price" id="price<?=$data->id?>" ><?=$calculatedPrice;?></span>
		</div>

		<div class="cart">
			<form>
			<div class="count_popup1" style="display:block;">
				<input class='goodkod' value='<?=$data->id?>' type='hidden'>
				<input type="hidden" name='weight' value="<?=$data->weight_ap;?>" id="weight">
				<?if(!Yii::app()->user->isGuest){?>
					<div style="min-height:90px;">
				<?}else{?>
					<div style="min-height:60px;">
				<?}?>

				<?if(!Yii::app()->user->isGuest){?>
					<div style="margin: 9px 0 3px;">
						<span class="count_head">Количество</span>
						<div class="number" data-id = '<?=$data->id;?>'>
							<span class="minus"></span>
							<input type="text" name="quantity" value="1" class="count">
							<span class="plus"></span>
						</div>
					</div>

						<div style="margin: 9px 0 0px;height:20px;">
							<span class="count_head">Сумма</span>
							<div class="number totalPrice" >
								<?=$calculatedPrice;?>
							</div>
						</div>
				<?}?>
					<?if($sizes = $data->getSizes()){
						foreach ($sizes as $datasize) {
							if($datasize->default){
								$dafault = $datasize->size;
							}
						}?>
					<div class="goodsize-item" data-id = '<?=$data->id;?>'>
						<span>размер</span><br>
						<?=CHtml::dropDownList('size',$dafault, CHtml::ListData($sizes,'size','size'),array('class'=>'sizeSelect'));?>
					</div>
					<?}?>

					<?if($stones = $data->getStones()){
						foreach ($stones as $datasize) {
							if($datasize->default){
								$default = $datasize;
							}
						}?>
						<div class="goodcolor-item">
							<span>цвет вставки</span><br>
							<input type="hidden" name='stonekod' value="<?=$default->stonekod;?>" id="stonek">
							<div class="selectclick">
								<img title = "<?=$default->cache(100000)->st->name;?>" style = "max-width: 20px; max-height: 20px; min-width: 20px; min-height: 20px;" src="/uploads/<?=$default->cache(100000)->st->imageStone->filename;?>">
							</div>
							<div class="select">
								<?foreach ($stones as $stone) {?>
								<div class="option" data-stonekod="a<?=$stone->stonekod;?>">
									<img title = "<?=$stone->cache(100000)->st->name;?>" style = "max-width: 20px; max-height: 20px; min-width: 20px; min-height: 20px;" src="/uploads/<?=$stone->cache(100000)->st->imageStone->filename;?>">
								</div>
								<?}?>
								<?//=CHtml::dropDownList('size','size', CHtml::ListData($data->getStones(),'size','size'),array('id'=>'sizeSelect'));?>
							</div>
						</div>
						</div>
					<?}?>
				</div>
				<div style="clear:both;margin-bottom:10px;"></div>

			<?
			if($data->collection_id != 1) {
				if(Yii::app()->user->isGuest){
					echo CHtml::ajaxSubmitButton(
						"В корзину",
						array("cart/add/id/$data->id"),
						array(
							'update'=>'.bascet',
							'beforeSend'=>'js:function(data){
								return false;
							}',
						),
						array(
							'class' => 'to_cart popOpen',
							'onClick' => !Yii::app()->user->isGuest ? "addToBasket('$data->name $data->article','',$data->id);  return false" : "openPop();  return false",
						)
					);
				}else{
					echo CHtml::ajaxSubmitButton(
						"В корзину",
						array("cart/add/id/$data->id"),
						array(
							'update'=>'.bascet',
						),
						array(
							'class' => 'to_cart popOpen',
							'onClick' => "addToBasket('$data->name $data->article','',$data->id);  return false",
						)
					);
				}
			}
			?>
			</form>
		</div>
	</li>
<?//}?>