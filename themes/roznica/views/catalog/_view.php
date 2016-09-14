<?//if($data->image != "null.png"){?>
	<li class='goodsLi' data-itemid='<?=$data->id?>'>

		<?if(Yii::app()->user->isAdmin){?>
			<a href="#" class="updateItem" data-id="<?=$data->kod?>">Редактировать</a>
		<?}?>
		
		<?// $calculatedPrice = $data->getCalculatedPrice(array("serialkod"=>$data->pricesInStock[0]));?>
		<? $calculatedPrice = $data->defaultPrice();?>
		<div class="goodsImg">
			<a href="<?=$data->createurl?>">
				<img data-id='<?=$data->id?>' data-itemid='<?=$data->id?>' src="<?=Yii::app()->iwi->load("uploads/".$data->image)->adaptive(250,250)->cache();?>" alt="" class='ajaxitem'>
			</a>
		</div>
		<a href='<?=$data->createurl?>' class="goodsTitle">
			<?=$data->fullName?>
		</a>
		<div class="goodsArticle">Артикул: <span><?=$data->article?></span></div>
		<div class="goodsPrice"><?=number_format((int)$calculatedPrice,0,',',' ').' руб.';?></div>
		<?/*<a href="#" class="toCart">купить</a>*/?>
	</li>
<?//}?>