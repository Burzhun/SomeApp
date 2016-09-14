
<li>
	<div class="goodimage">
		<a href="<?=$data->createurl?>" title='<?=$data->name?>'>
			<img title='<?=$data->name?>' src="<?=Yii::app()->iwi->load("uploads/".$data->image)->adaptive(250,250)->cache();?>" />
		</a>
	</div>
	<div class="goodstore">
		<a href="<?=$data->createurl?>">
			<div class=><?=$data->name?></div>
		</a>
		<hr>
		<?

		$stores = $data->stores();?>
		<?if($stores){?>

			<table>
				<tr class='nohover'>
					<th>Размер</th>
					<th>Вес</th>
					<th>Вставка</th>
					<th>Количество</th>
					<th>Цена</th>
					<th>Сумма</th>
					<th></th>
				</tr>
			<?foreach ($stores as $stor) {?>
				<tr>
					<td><?=$stor->goodsize;?></td>
					<td><?=$stor->weight;?></td>
					<td>
						<?$_stone = Stone::model()->cache(40000)->find(array("condition"=>"kod='".$stor->stonekod."'"));
						$_stone_img = $_stone->imageStone;
						$file_stone_img = $_stone_img->filename;?>
						<?if($file_stone_img) { ?>
							<img src="/uploads/<?=$file_stone_img;?>" style="max-width:35px;max-height:35px;margin-bottom:-13px;" title="<?=$stor->stonekod?>">
						<? } ?>
					</td>
					<td>
						<div class="qualit">
							<span class="minus"></span>
							<span class="qualit-count" data-max = '<?=$stor->kolvo;?>'><?=$stor->kolvo;?></span>
							<span class="plus"></span>
						</div>
					</td>
					<?// if(!Yii::app()->user->isGuest){ ?>
						<td><?=$data->getCalculatedPrice(array("serialkod"=>$stor->serialkod));?></td>
						<td><?=Functions::numberformat($data->getCalculatedPrice(array("serialkod"=>$stor->serialkod, "withoutRub"=>true))*$stor->kolvo);?> р.</td>
					<?// } ?>
					<td>
						<form>

							<input id = "size" type="hidden" name = "size" type="text" value="<?=$stor->goodsize;?>">
							<input id = "stonekod" type="hidden" name = "stonekod" type="text" value="<?=$stor->stonekod;?>">
							<input id = "weight" type="hidden" name = "weight" type="text" value="<?=$stor->weight;?>">
							<input id = "serialkod" type="hidden" name = "serialkod" type="text" value="<?=$stor->serialkod;?>">
							<input name = "quantity" type="hidden" class='quan' value="<?=$stor->kolvo;?>">
							<?
							if(Yii::app()->user->isGuest){
								echo CHtml::ajaxSubmitButton(
									"В корзину",
									array("cart/add?id=".$data->id."&size=".$stor->goodsize."&weight=".$stor->weight."&stonekod=".$stor->stonekod."&serialkod=".$stor->serialkod."&kolvo=".$stor->kolvo),
									array(
										'update'=>'.bascet',
										'beforeSend'=>'js:function(data){
											return false;
										}',
									),
									array(
										'class' => 'to_cart',
										'onClick' => !Yii::app()->user->isGuest ? "addToBasket('$data->name $data->article','',$data->id);  return false" : "openPop();  return false")
									);
							}else{
								echo CHtml::ajaxSubmitButton(
									"В корзину",
									array("cart/add?id=".$data->id."&size=".$stor->goodsize."&weight=".$stor->weight."&stonekod=".$stor->stonekod."&serialkod=".$stor->serialkod."&kolvo=".$stor->kolvo),
									array(
										'update'=>'.bascet',
									),
									array(
										'class' => 'to_cart',
										'onClick' => "addToBasket('$data->name $data->article','',$data->id);  return false")
									);
							}?>
						</form>
					</td>
				</tr>
			<?}?>
			</table>
		<?}?>
	</div>
		<div style="clear:both;"></div>
</li>
