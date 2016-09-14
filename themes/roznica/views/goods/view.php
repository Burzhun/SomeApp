
<?
$category = Category::model()->findByPk($model->categoryId);
$this->breadcrumbs = Category::getBreadcrumbs($model->categoryId, false);
$this->breadcrumbs += array($category->name=>$category->full_url);
$this->breadcrumbs += array($model->name);
?>


<style type="text/css">
	.zoomPad{
		display: inline-block !important;
	}
</style>
<?

	$title = "";
	/*foreach ($breadcrumbs as $key => $value) {
		$title .=$key." / ";
}*/?>
<? if(!empty($model->seotitle))
		$this->pageTitle = $model->seotitle;
	else
		$this->pageTitle = $model->name." - $model->article / ".$this->pageTitle;

	if(!empty($model->seokeywords))
	$this->pageKeywords = $model->seokeywords;

	if(!empty($model->seodescription))
	$this->pageDescription = $model->seodescription;
?>

			<?/*	<div class="breadcrumbs">
			<?foreach ($breadcrumbs as $bread) { ?>
				<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
					<?if($bread['link']) { ?>
						<a href="<?=$bread['link'];?>" itemprop="url" title='<?=$bread["title"];?>'>
							<span itemprop="title"><?=$bread['name']?></span>
						</a>
					<? } else { ?>
						<span itemprop="title"><?=$bread['name']?></span>
					<? } ?>
				</span>
				 /
			<? }
		</div>*/?>
		
				<h1><?=$model->fullName;?></h1>

<link href="/themes/roznica/js/zoom/jquery.jqzoom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/themes/roznica/js/zoom/jquery.jqzoom-core.js"></script>
<script type="text/javascript" src="/themes/roznica/js/jcarousellite_1.0.1.pack.js"></script>





	<div class="slide2">
		<div class="clearfix" id="contentzoom" style="width:480px;" >
			<div class="clearfix" id="content2" style="width:480px;" >
				<div class="clearfix">
					<?if(file_exists("uploads/".$model->image)) { ?>
						<?$model->ImageUpdateInWatermark();?>
						<a style='text-align:center;' href="<?=Yii::app()->iwi->load("uploads/watermark/".$model->image)->resize(1000,1000)->cache();?>" class="jqzoom" rel='gal1'  title="triumph" >
							<img src="<?=Yii::app()->iwi->load("uploads/watermark/".$model->image)->resize(800,800)->cache();?>"  title="triumph"  style = "max-width: 380px;max-height: 390px;" >
						</a>
					<?}else{?>
						<a style='text-align:center;' href="/images/empty.png" class="jqzoom" rel='gal1'  title="triumph" >
							<img src="/images/empty.png"  title="triumph"  style = "max-width: 380px;max-height: 390px;" >
						</a>
					<?}?>
					<?/*<a href="/themes/roznica/img/item1.png" class="jqzoom" rel='gal1'  title="triumph" >
						<img src="/themes/roznica/img/item1.png"  title="triumph">
					</a>*/?>

				</div>
			  <br/>

				<?if(count($model->images)!=1) { ?>
					<div class='mini_list_box'>
						<button class="prevvv nav_display  disabled">&lt;&lt;</button>
						<button class="nexttt nav_display">&gt;&gt;</button>
						<div class="clearfix mini_list" >
							<ul id="thumblist" class="clearfix mini_zoom" >
								<? foreach ($model->images as $image) { ?>
									<?//$img100x100 = Yii::app()->iwi->load("uploads/".$model->image)->resize(100,100)->cache();?>
									<?$img100x100 = Yii::app()->iwi->load("uploads/watermark/".$image->filename)->resize(100,100)->cache();
									$img380x380 = Yii::app()->iwi->load("uploads/watermark/".$image->filename)->resize(380,380)->cache();
									$img800x800 = Yii::app()->iwi->load("uploads/watermark/".$image->filename)->resize(800,800)->cache();?>
									<li>
										<a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?=$img380x380;?>',largeimage: '<?=$img800x800;?>'}">
											<img src='<?=$img100x100?>'>
										</a>
									</li>
								<? } ?>
								<?/* <li><a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '/themes/roznica/img/item1.png',largeimage: '/themes/roznica/img/item1.png'}"><img src='/themes/roznica/img/item1.png'></a></li>
								<li><a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '/themes/roznica/img/item2.png',largeimage: '/themes/roznica/img/item2.png'}"><img src='/themes/roznica/img/item2.png'></a></li>
								<li><a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '/themes/roznica/img/item3.png',largeimage: '/themes/roznica/img/item3.png'}"><img src='/themes/roznica/img/item3.png'></a></li>
								<li><a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '/themes/roznica/img/item4.png',largeimage: '/themes/roznica/img/item4.png'}"><img src='/themes/roznica/img/item4.png'></a></li>
								<li><a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '/themes/roznica/img/item5.png',largeimage: '/themes/roznica/img/item5.png'}"><img src='/themes/roznica/img/item5.png'></a></li>*/?>
							</ul>
						</div>
					</div>
				<?}?>
			</div>
			<div class="clearfix" style="margin-left:100px">
			</div>
		</div>
		<script type="text/javascript">

		$(document).ready(function() {
		$('.jqzoom').jqzoom({
		zoomType: 'standard',
		lens:true,
		preloadImages: false,
		alwaysOn:false
		});
		//$('.jqzoom').jqzoom();
		});


		</script>

		<script type="text/javascript">


		/*  $(function() {
		$(".mini_list").jCarouselLite({
		btnNext: ".nexttt",
		btnPrev: ".prevvv",
		visible: 4,
		circular:false,
		vertical:false
		});


		if( $(".mini_zoom li").length<5)
		{
		$(".mini_list_box button").addClass('disabled')
		}
		});*/

		</script>
	</div>

	<script type="text/javascript">
		$(function(){
			$('.plus').on('click', function(){
				var value = $('#num_<?=$model->id?>').html();
				value++;
				$('#num_<?=$model->id?>').html(value);
				//$('#count').val(value);
				$('#formquantity').val(value);
				return false;
			});

			$('.minus').on('click',function(){
				var value = $('#num_<?=$model->id?>').html();
				if(value!=1)
						value--;
				$('#num_<?=$model->id?>').html(value);
				//$('#count').val(value);
				$('#formquantity').val(value);
				return false;
			});
		});
	</script>

	<? $isstore = Goods::isStore($model->kod);?>

	<div class="left_items">
		<ul class="items_info">
			<li><strong>Артикул: </strong>  <?=$model->article?>      </li>
			<li><strong>Вес: </strong>  <?=substr_replace($model->weight_ap, '', -1, 1);?> гр.  </li>
			<li><strong>Проба: </strong>  <?=$model->hm->name;?>    </li>
			<?if($isstore){?>
				<li style="color:green;"><strong>• Есть в наличии</strong></li>
			<?}?>
			<?if($stone->st->description){?>
			<li><strong>Описание вставки: </strong>  <?=$stone->st->description;?>    </li>
			<?}?>

			<?$stonekod = $model->stoneInStock;?>
			<?//if(!$stonekod){$stonekod = $model->sizeInStock;} //TODO закоментировал, так как он для браслетов предлагал выбрать вставку?>
			<li>&nbsp;</li>
			<li class="priceItem" id="priceItem" style="display:inline-block;"><strong>Цена: </strong> 
			<span class="cena1"><?=number_format((int)$model->defaultPrice(),0,',',' ').' руб.';;?> </span></li>
			<?/*foreach ($model->storeGoods as $data) {$ii++?>
				<?if($ii==1){?>
					<li class="priceItem" id="priceItem<?=$data['serialkod']?>" style="display:inline-block;"><strong>Цена: </strong>  <span class="cena1"><?=$model->getCalculatedPrice(array("serialkod"=>$data['serialkod'], "withoutRub"=>true));?> руб </span></li>
				<?}else{?>
					<li class="priceItem" id="priceItem<?=$data['serialkod']?>" ><strong>Цена: </strong>  <span class="cena1"><?=$model->getCalculatedPrice(array("serialkod"=>$data['serialkod'], "withoutRub"=>true));?> руб </span></li>
				<?}?>
			 <?}*/?>

			<li>&nbsp;</li>
			<li>
				<strong>Количество:</strong>
				<div class="count-block">
					<a class="minus" href="#" data-id="<?=$model->id?>">&#9668;</a>
					<p id="num_<?=$model->id?>">1</p>
					<a class="plus" href="#" data-id="<?=$model->id?>">&#9658;</a>
				</div>
			</li>
		</ul>

		<?/*<span class='inStockText'> <img src="/themes/roznica/img/arrow9.png" alt=""> Есть в наличии</span>*/?>

		<?//$stonekod = $model->stoneInStock;?>
		<?if($stonekod) { ?>
			<div class="itemHead">Выберите цвет центральной вставки (камня)</div>
			<div class="kamenBox">
			<div class="popup_text" id="gg">Выберите камень<div class="closePopup">x</div></div>
			<?foreach ($stonekod as $data) { ?>
				<?if($data['stonekod']) { ?>
					<?if($prev != $data['stonekod']) { ?>
						<label data-id="<?=$data['stonekod']?>"><input  type="radio" name='stone'>
							<img src="/uploads/<?=$data['filename'];?>" style="max-width:35px;max-height:35px;" title="<?=Stone::model()->cache(40000)->findByPk($data['stonekod'])->name;?>">
						</label>
					<?$prev = $data['stonekod']; } ?>
				<?}?>
			<?}?>
				<?/*<label  ><input  type="radio" name='1'><img src="/themes/roznica/img/img1.png" alt=""></label>
				<label  ><input  type="radio" name='1'><img src="/themes/roznica/img/img1.png" alt=""></label>*/?>
			</div>
		<? } ?>

		<br>

		<?if(!$stonekod) { $stonekod = $model->sizeInStock;$notKame =1; } ?>

		<?if($stonekod) { ?>

			<div class="itemHead" id="sizeRing">Размер <?=$isRing ? 'кольца' : '';?>:</div>
		<? } ?>

	<div>
	<?if($notKame != 1) { ?>
		<?foreach ($stonekod as $data) { ?>
			
			<?if($data['goodsize']!='0.00') {
				$style = '';
				$hidden = 1;
			} else {
				$style = 'style="display:none;"';
			} ?>
			<?if(substr($data['goodsize'], -1)=='0'){
				$dataSize = mb_substr($data['goodsize'], 0, -1);
			}else{
				$dataSize = $data['goodsize'];
			}?>

				<?if($prevSize != $data['stonekod']){
					$stonekodArray = '';
					$stonekodArray[] = $data['goodsize'];
					?>
					</div>
					<div class="kamenBoxSize size" id="ss<?=$data['stonekod']?>" style='display:none;'>
					<label <?=$prevSize?>1 class='radioBut' <?=$style?>  data-size="<?=$data['goodsize']?>" data-serialkod="<?=$data['serialkod']?>"><input  type="radio" name='2'><strong><?=$dataSize?></strong></label>
					<?$prevSize = $data['stonekod'];?>
				<?}else{
					if(!in_array($data['goodsize'], $stonekodArray)){
						$stonekodArray[] = $data['goodsize']?>
						<label  class='radioBut' <?=$prevSize?> <?=$style?> data-size="<?=$data['goodsize']?>" data-serialkod="<?=$data['serialkod']?>" ><input  type="radio" name='2'><strong><?=$dataSize?></strong></label>
					<?}?>
				<?}?>
		<?}?>
	<?}else{?>
		<script type="text/javascript">
		$(function(){
			$('.kamenBoxSize label').first().click();
		});
		</script>
		<div class="kamenBoxSize size" id="ss">
		<?foreach ($stonekod as $data) {
			?>
			<?if($data['goodsize']!='0.00'){
				$style = '';
				$hidden = 1;
			}else{
				$style = 'style="display:none;"';
			}?>
				<?if(substr($data['goodsize'], -1)=='0'){
					$dataSize = mb_substr($data['goodsize'], 0, -1);
				}else{
					$dataSize = $data['goodsize'];
				}?>


				<?if(!in_array($data['goodsize'], $stonekodArray)){
					$stonekodArray[] = $data['goodsize']?>
					<label <?=$prevSize?> <?=$style?> data-size="<?=$data['goodsize']?>" data-serialkod="<?=$data['serialkod']?>" ><input  type="radio" name='2'><strong><?=$dataSize?></strong></label>
				<?}?>
				<?$stonekodArray[] = $data['goodsize'];?>
		<?}?>
	<?}?>
	</div>
	<br>

	<script type="text/javascript">
	$(window).load(function(){
		<?if(!$hidden){?>
			$('#sizeRing').hide();
			<?}?>
	});
</script>

	<?if($isstore){?>
		<form>
			<?$item = Goodstore::model()->cache(40000)->find(array('condition'=>"goodkod = '".$model->kod."'"));?>
			<input type="hidden" id="formsize" name = "size" value="<?=$item->goodsize;?>">
			<input type="hidden" id="formstonekod" name = "stonekod" value="<?=$item->stonekod;?>">
			<input type="hidden" id="formweight" name = "weight" value="<?=$item->weight;?>">
			<input type="hidden" id="formserialkod" name = "serialkod" value="<?=$item->serialkod;?>">
			<input  id="formquantity" name = "quantity" type="hidden" class='quan' value="<?=$item->kolvo;?>">
			<?echo CHtml::ajaxSubmitButton(
				"в корзину",
				array("cart/add?id=".$model->id),
				array(
					'update'=>'.bascet',
					'beforeSend'=>"js:function(data){
						if(!isChooseStone()){
							return false;
						}else{
							addToBasket('$model->name $model->article','',$model->id);
						}
					}",
				),
				array(
					'class' => 'to_cart btn itemCart',
					'onClick' => "")
				);?>
		</form>
	<?}?>


	<?/*<a href="#" class="btn toCart itemCart" >в корзину</a>*/?>
	  </div>
		<div style='clear:both'></div>
			<br>
			<br>
			<br>
<div class="catalogText">

<?=$model->fullDescription?>
<?//=$model->description_main?>
	<?/*	<h2>Кубачинка – серебро во всем его великолепии</h2>
				 Много ли в Москве магазинов, готовых предложить вам широкий ассортимент серебряных украшений и
изделий по доступной стоимости? Можно не сомневаться, что лишь немногие из нас смогут вспомнить
адреса и названия таких магазинов. Ведь украшения из благородных металлов тем и привлекательны,
что они дорого стоят, хотя зачастую их цена неоправданно завышена.Самое удивительно, что в столице
 теперь есть такое место, где любой из нас может приобрести серебряное украшение или столовое серебро
 по цене, которую не предложит больше никто! Это – магазин на Большой Тульской улице д. 44, и интерне
т-магазин «Кубачинка», обладающий целым рядом достоинств и преимуществ.Что такое «Кубачинка»?<br><br>

Широкий ассортимент серебряных и золотых украшений, а также столового серебраСтоимость всех
товаров ниже средней по Москве и по России. Убедиться в этом легко – просто посетите магазин!
   Оптимальные условия оплаты и доставки заказа по Москве и России.Бонусная система и гибкая ценовая
 политика для постоянных покупателей.Эксклюзивность и высокое качество всех изделий.Но самое главное, <br><br>

«Кубачинка» - это серебряные и золотые изделия, созданные мастерами прославленного дагестанского аула
Кубачи. Все серебро и золото, представленное в магазине, выполнено в уникальном и неповторимом
 кубачинском стиле, чарующем взгляд и завоевывающем сердца с первого взгляда.
*/?>
		</div>