

<? $title = "";


	/*foreach ($breadcrumbs as $key => $value) {
		$title .=$key." / ";
}*/?>
<? if(!empty($model->seotitle))
		$this->pageTitle = $model->seotitle;
	else
		$this->pageTitle = $model->name." - $model->article / купить оптом | ".$this->pageTitle;

	if(!empty($model->seokeywords))
	$this->pageKeywords = $model->seokeywords;

	if(!empty($model->seodescription))
	$this->pageDescription = $model->seodescription;
?>

	<script type="text/javascript">
		$(document).ready(function (){
			$('.stone span').click(function(){
				$('#stone-description').text($(this).data('description'));
				$('.stone span').removeClass('stone_active');
				$(this).addClass('stone_active');
			})
			$('.item_size span').click(function(){
				$('.item_size span').removeClass('item_size_active');
				$(this).addClass('item_size_active');
			})
			$(".complect_items" ).click(function() {
				var sum = 0;
				$('#tab1 input[type=checkbox]:checked').each(function(index){
					sum += +$(this).val();
				})
				$("#complect_price").html(sum + " р.");
			});
		});

		$("#complect_to_cart").click(function(){
		});

	</script>

	<div class='item_box'>
		<?/* $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Главная', array('site/index')),
			'separator' => ' / ',
			'links'=>$breadcrumbs,
		));*/?>

		<div class="breadcrumbs">
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
			<? } ?>
		</div>

		<h1><?=$model->name;?></h1>

		<div class='item_left'>
			<div class='zoom'>
				<script type="text/javascript">
					$(document).ready(function() {
						$('.jqzoom').jqzoom({
								zoomType: 'standard',
								lens:true,
								preloadImages: false,
								alwaysOn:false
							});

						$('.empty_img').click(function(e){ e.preventDefault(); });
					});
				</script>

				<div class="clearfix" id="contents" style=" height:415px;width:530px;" >
					<div class="clearfix" style='float:right'>
						<a href='<?=Yii::app()->iwi->load("uploads/watermark/".$model->image)->resize(800,800)->cache();?>' <? if(file_exists("uploads/watermark/".$model->image))  { echo "class=jqzoom"; } else { echo "class=empty_img"; } ?> rel='gal1'  title="<?=$model->name;?>" <? //title="triumph" ?> >
							<? // Если существует картинка-оригинал, ?>
							<? if(file_exists("uploads/".$model->image)){ ?>
								<?//создаем картинку с вотермарком если ее не существует?>
								<?$model->ImageUpdateInWatermark();?>
								<?//создаем картинку?>
								<img src="<?=Yii::app()->iwi->load("uploads/watermark/".$model->image)->resize(800,800)->cache();?>"  title="<?=$model->name;?>" <? //title="triumph" ?>  style = "max-width: 380px;max-height: 390px;" >
							<? }
							else // Иначе показываем картинки по умолчанию.
							{ ?>
								<img src="/images/site/cache/73/76/7376c481cb4a1b48cdea592a67e7a5d2.png"  title="triumph"  style = "width: 384px; height: 384;" >
							<? } ?>
						</a>
					</div>

					<div class="clearfix " style='float:left; height:349px;position:relative;padding-top:31px;' >
						<button class="prev nav_display  disabled">&lt;&lt;</button>
						<button class="next nav_display">&gt;&gt;</button>

						<div class='lastItems'>
							<ul id="thumblist" class="clearfix mini_zoom" >
								<?if(count($model->images)!=1){?>
								<script type="text/javascript" src="/js/jcarousellite_1.0.1.pack.js"></script>
								<script type="text/javascript">
									$(function() {
										$(".lastItems").jCarouselLite({
											btnNext: ".next",
											btnPrev: ".prev",
											visible: 3,
											circular:false,
											vertical:true
										});
									});
								</script>
									<? foreach ($model->images as $image) { ?>
										<?//$img100x100 = Yii::app()->iwi->load("uploads/".$model->image)->resize(100,100)->cache();?>
										<?$img100x100 = Yii::app()->iwi->load("uploads/watermark/".$image->filename)->resize(100,100)->cache();

										$img380x380 = Yii::app()->iwi->load("uploads/watermark/".$image->filename)->resize(380,380)->cache();?>
										<?$img800x800 = Yii::app()->iwi->load("uploads/watermark/".$image->filename)->resize(800,800)->cache();?>
										<li>
											<a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?=$img380x380;?>',largeimage: '<?=$img800x800;?>'}">
												<img src='<?=$img100x100?>'>
											</a>
										</li>
									<?}?>
								<?}?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="example-two">
				<div id="example-two">
					<ul class="nav">
						<li class="nav-one"><a href="#tab1" class="current">Характеристики</a></li>
						<li class="nav-two"><a href="#tab2">Доставка</a></li>
						<!-- <li class="nav-three"><a href="#tab3">Наличие</a></li> -->
					</ul>
					<div class="list-wrap">
						<div id="tab1">
							<table>
								<tr>
									<td><strong>Вес</strong></td>
									<td><?=substr_replace($model->weight_ap, '', -1, 1);?></td>
								</tr>
								<tr>
									<td><strong>Проба</strong></td>
									<td><?=$model->hm->name;?></td>
								</tr>
								<tr>
									<td><strong>Описание вставки</strong></td>
									<td id="stone-description"><?=$stone->st->description;?></td>
								</tr>
							</table>
						</div>
							<ul id="tab2" class="hide">
								<?=Page::viewContent(6);?>
							</ul>
					</div>
				</div> <!-- END List Wrap -->
			</div>
		</div>

		<div class='item_right'>
			<div class='nav_item'>
				<? if($prev): ?>
				<a href='<?=$prev->createUrl;?>' class='nav_item_next'>&lt;-- предыдущее</a>
				<? endif; ?>
				<h2>Артикул <?=$model->marking;?> </h2>
				<? if($next): ?>
				<a href='<?=$next->createUrl;?>' class='nav_item_prev'> следующее --&gt;</a>
				<? endif; ?>
			</div>

			<div class='item_discrip'>
				<?=$model->description;?>
			</div>
			<!--<div class='old_price'>
				Старая цена: <strike>35 000 р.</strike>
			</div> -->

			<?//if(!Yii::app()->user->isGuest){?>
				<div class='item_price'>
					Цена: <span id = "price"><?=$model->getCalculatedPrice();?></span>
				</div>
			<?//}?>

			<div class='stone'>
				<? if($stones = $model->getStones()){ ?>
					Выберите цвет центральной вставки (камня)<br>

					<? foreach ($stones as $i => $stone) { ?>

						<?if($i==0) {?>
							<script>
								$(function() {
									//setStone('<?=$stone->stonekod;?>', 0);
								});
							</script>
						<?}?>

						<span onClick = "setStone('<?=$stone->stonekod;?>');" data-description="<?=$stone->description;?>" data-stonekod = "<?=$stone->stonekod;?>"  class='<?if($stone->default) echo "stone_active";?>'>
							<img title = "<?=$stone->st->name;?>" style = "max-width: 35px; max-height: 35px; min-width: 35px; min-height: 35px;" src="/uploads/<?=$stone->st->imageStone->filename;?>">
						</span>
					<? } ?>
				<? } ?>
			</div>

			<? if($model->getSizes()) {?>
				<div class='item_size'>
					Размер:<br>
					<? foreach ($model->getSizes() as $size) { ?>
						<span onClick = "setSize('<?=$size->size;?>');" data-i="<?print_r($size)?>" data-size = "<?=$size->size;?>" class='item_size_in_stock  <?if($size->default) echo "item_size_active";?> '><?$n = number_format($size->size, 1);if($n - (int) $n){echo $n;}else{echo (int) $n;}?></span>
					<? }?>
				</div>
			<?}?>

			<script>
				function updatePrice(defaultStone)
				{
					stone = $('#stonekod').val();
					kod = '<?=$model->kod?>';
					size = $('#size').val();

					$.ajax({
						type: "GET",
						url: "/goods/price/",
						data: "kod="+kod+"&stone="+stone+"&size="+size+"&checkStone=1",
						success: function(msg){
							$('#price').html(msg);
						}
					});
				}

				function setStone(stone, defaultStone)
				{
					$('#stonekod').val(stone);
					updatePrice(defaultStone);
				}
				function setSize(size)
				{
					$('#size').val(size);
					updatePrice();
				}


				$(window).load(function () {
					$('#stone-description').text($('.stone_active').data('description'));
				});
			</script>

			<div>
				<form>
					<div class='item_count'>
						Количество:<br>
						<div class="number">
							<span class="minus"></span>
							<input name = "quantity" type="text" value="1">
							<span class="plus"></span>
						</div>
						<input id = "stonekod" name = "stonekod" type="hidden" value="<?=$model->getDefaultStone()->stonekod;?>">
						<input id = "weight" name = "weight" value="<?=$model->weight_ap;?>" type="hidden">
						<input id = "size"  name = "size" type="hidden" value="<?=$model->getDefaultSize()->size;?>">
					</div>
					<?
					if($model->collection_id != 1) {
						if(Yii::app()->user->isGuest){
							echo CHtml::ajaxSubmitButton(
								"",
								array("cart/add/id/$model->id"),
								array(
									'update'=>'.bascet',
									'beforeSend'=>'js:function(data){
										return false;
									}',
								),
								array(
									'class' => 'item_to_cart',
									'onClick' => !Yii::app()->user->isGuest ? "addToBasket('$model->name $model->article','',$model->id);  return false" : "openPop();  return false")
								);
						}else{
							echo CHtml::ajaxSubmitButton(
								"",
								array("cart/add/id/$model->id"),
								array(
									'update'=>'.bascet',
								),
								array(
									'class' => 'item_to_cart',
									'onClick' => "addToBasket('$model->name $model->article','',$model->id);  return false")
								);
						}
					}
					?>
					<?/*</a>*/?>
				</form>
			</div>

			<? $storeItems = Goodstore::model()->cache(10000)->findAll(array('condition'=>"goodkod = '".$model->kod."'"));?>

			<? if(count($storeItems)) { ?>
				<div id='instockTabs' class="instockTabs">
					<table>
						<tr class='nohover'>
							<th>Размер</th>
							<th>Вес</th>
							<th>Вставка</th>
							<th>Количество</th>
							<th>Цена</th>
							<th></th>
						</tr>
						<?foreach ($storeItems as $item) { ?>
							<tr>
								<td><?= $item->goodsize == "0.00" ? "" : $item->goodsize;?></td>
								<td><?=$item->weight;?></td>
								<td><?//=$item->stonekod;?>
									<?$_stone = Stone::model()->cache(40000)->find(array("condition"=>"kod='".$item->stonekod."'"));
									$_stone_img = $_stone->imageStone;
									$file_stone_img = $_stone_img->filename;?>
									<?if($file_stone_img) { ?>
										<img title = "<?=$_stone->name;?>" src="/uploads/<?=$file_stone_img;?>" style="max-width:35px;max-height:35px;margin-bottom:-13px;" title="<?=$item->stonekod?>">
									<? } ?>
								</td>
								<td>
									<div class="qualit">
										<span class="minus"></span>
										<span class="qualit-count" data-max = '<?=$item->kolvo;?>'><?=$item->kolvo;?></span>
										<span class="plus"></span>
									</div>
								</td>
								<td><?=$model->getCalculatedPrice(array("serialkod"=>$item->serialkod));?></td>
								<td>
									<form>
										<input type="hidden" name = "size" value="<?=$item->goodsize;?>">
										<input type="hidden" name = "stonekod" value="<?=$item->stonekod;?>">
										<input type="hidden" name = "weight" value="<?=$item->weight;?>">
										<input type="hidden" name = "serialkod" value="<?=$item->serialkod;?>">
										<input name = "quantity" type="hidden" class='quan' value="<?=$item->kolvo;?>">
										<?
										if($model->collection_id != 1) {
											if(Yii::app()->user->isGuest){
												echo CHtml::ajaxSubmitButton(
													"В корзину",
													array("cart/add?id=".$model->id."&size=".$item->goodsize."&weight=".$item->weight."&stonekod=".$item->stonekod."&serialkod=".$item->serialkod."&kolvo=".$item->kolvo),
													array(
														'update'=>'.bascet',
														'beforeSend'=>'js:function(data){
															return false;
														}',
													),
													array(
														'class' => 'to_cart',
														'onClick' => !Yii::app()->user->isGuest ? "addToBasket('$model->name $model->article','',$model->id);  return false" : "openPop();  return false")
													);
											}else{
												echo CHtml::ajaxSubmitButton(
													"В корзину",
													array("cart/add?id=".$model->id."&size=".$item->goodsize."&weight=".$item->weight."&stonekod=".$item->stonekod."&serialkod=".$item->serialkod."&kolvo=".$item->kolvo),
													array(
														'update'=>'.bascet',
													),
													array(
														'class' => 'to_cart',
														'onClick' => "addToBasket('$model->name $model->article','',$model->id);  return false",
													)
												);
											}
										}
										?>
									</form>
								</td>
							</tr>
						<? } ?>
					</table>
					<?/*<li><a href="http://css-tricks.com/anythingslider-jquery-plugin/">Anything Slider jQuery Plugin</a></li>
					<li><a href="http://css-tricks.com/moving-boxes/">Moving Boxes</a></li>
					<li><a href="http://css-tricks.com/simple-jquery-dropdowns/">Simple jQuery Dropdowns</a></li>
					<li><a href="http://css-tricks.com/creating-a-slick-auto-playing-featured-content-slider/">Featured Content Slider</a></li>
					<li><a href="http://css-tricks.com/startstop-slider/">Start/Stop Slider</a></li>
					<li><a href="http://css-tricks.com/banner-code-displayer-thing/">Banner Code Displayer Thing</a></li>
					<li><a href="http://css-tricks.com/highlight-certain-number-of-characters/">Highlight Certain Number of Characters</a></li>
					<li><a href="http://css-tricks.com/auto-moving-parallax-background/">Auto-Moving Parallax Background</a></li>*/?>
				</div>
			<? } ?>
		</div>
	</div>

	<br><br>

	<?
	/*if(!is_numeric(trim($model->marking))) { // в артикуле удаляем пробелы и проверяем не является ли полученная строка числовой
		//если не число
		$cut_artikul_model = (int) $model->marking;// удаляем буквы
		$complect_goods = Goods::model()->cache(100000)->findAll(array('condition'=>"publ = 0 AND marking LIKE '%".$cut_artikul_model."%'")); //ищем как строку
	} else {
		$complect_goods = Goods::model()->cache(100000)->findAll(array('condition'=>"publ = 0 AND marking = '".trim($model->marking)."'"));//иначе ищем как число
	}*/
	$art = (int) trim($model->marking);
	$complect_goods = Goods::model()->cache(100000)->findAll(array('condition'=>"publ = 0 AND marking LIKE '%".$art."%'")); //ищем как строку
	?>

	<div id="example-one" <?if(count($complect_goods) == 1) echo "style='display:none;'";  ?> >
		<ul class="nav">
			<?if(count($complect_goods) > 1){?>
				<li class="nav-one">
					<a href="#tab1" class="current">Комплектация <img class='arrow' src='/img/arrow.png'></a>
				</li>
			<? } ?>
			<li class="nav-two"><a href="#tab2" id="liketo" <?if(count($complect_goods) <= 1){?>class="current"<? } ?>>Вам также может понравиться <img class='arrow' src='/img/arrow.png'></a></li>
			<li class="nav-three"><a href="#tab3"  id="see" >Вы недавно смотрели <img class='arrow' src='/img/arrow.png'></a></li>
		</ul>

		<div class="list-wrap">
			<?if(count($complect_goods) > 1) {?>
				<div id="tab1">
					<form id="collection_form" name="collection_form" method="post">
						<ul class='goods complect'>
							<?$inc = 0;$sum = 0;
							foreach ($complect_goods as $good) {?>
								<? if($inc++!=0){?>
									<div class='complectPlus'></div>
								<? } ?>
								<?$price_item = $good->getCalculatedPrice(array("forCreateOrder"=>false, "withoutRub"=>true));?>


								<? $defaulSize = 0;
								foreach ($good->getSizes() as $size) {
									if($size->default)
										$defaulSize = $size->size;
								}?>

								<? $defaultStone = 0;
								foreach ($good->getStones() as $i => $stone) {
									if($stone->default)
										$defaultStone = $stone->st->kod;
								} ?>
								<li>
									<a href='<?=$good->createUrl;?>'>
										<span class='goods_img'>

											<img title="<?=$good->name;?>"  src='<?=Yii::app()->iwi->load("uploads/".$good->image)->adaptive(170,170)->cache();?>'>
											<div class='checkboxDiv'><input class="complect_items" id="<?=$good->id?>" type='checkbox' checked value='<?=$price_item?>' data="<?=$good->id?>;<?=$defaulSize?>;<?=$defaultStone?>"></div>
										</span>
										<div class='goods_title'><?=$good->name;?> Артикул: <?=$good->marking;?></div>
									</a>
								</li>
								<?/*<input class="collection_item" name="check[]" id="<?=$good->id?>" value="<?=$good->id?>;<?=$price_item?>;<?=$defaulSize?>;<?=$defaultStone?>" type="hidden">*/?>
								<?$sum += $price_item;?>
							<? } ?>

							<div class='complectRavno'>
								<?//if(!Yii::app()->user->isGuest){?>
									<div id="complect_price" class='complectPrice'><?=number_format($sum,0,',',' ')?> р.</div>
								<?//}?>

								<?if($model->collection_id != 1) { ?>
									<?if(Yii::app()->user->isGuest){?>
										<div class=" item_to_cart" <?=Yii::app()->user->isGuest ? "onClick='openPop();  return false'" : "";?>></div>
									<?}else{?>
										<input class="complect_to_cart item_to_cart" type="submit" value="">
									<?}?>
								<? } ?>
								<!--<input class="item_to_cart" id="items_to_cart" type="submit" value="">
								-->
								<?/* echo CHtml::ajaxSubmitButton(
								"",
								array("cart/multiAdd"),
								array(
									'type' => 'POST',
									'update'=>'.bascet',
									'success'=>'js:function(data){
										alert(data);
									}',
									'data'=>'js:$("input[name=\'check[]\']:checked",#collection_form).serialize();',
								),
								array(
									'type' => 'submit',
									'class' => 'item_to_cart',
									//'onClick' => "addToBasket('$model->name $model->article','',$model->id);  return false")
								));*/?>
							</div>
						</ul>
					</form>
				</div>
			<? } ?>

			<noindex>
				<?if(count($complect_goods) > 1){?>
					<script>

					
						$('#liketo').on('click',function(){
							if(!$('.tab2Last').find('li').length)
								$.ajax({
									type: "POST",
									url: "/goods/getliketoo",
									data: 'model_id=' + <?=$model->id;?> + '&catalog_id=' + <?=$model->catalog->id;?>,
									success: function(data){
										$('.tab2Last').html(data);
									}
								});
						});
					</script>
				<?}else{?>
					<script type="text/javascript">
						$.ajax({
							type: "POST",
							url: "/goods/getliketoo",
							data: 'model_id=' + <?=$model->id;?> + '&catalog_id=' + <?=$model->catalog->id;?>,
							success: function(data){
								$('.tab2Last').html(data);
							}
						});
					</script>
				<?}?>
				<?/*$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$dataProvider,
					'itemView'=>'../catalog/_view',
					'viewData' => array('model' => $model),
					'itemsCssClass' => 'goods',
					'itemsTagName' => 'ul',
					'summaryText'=>false,
					'emptyText'=>false,
					'template'=>'{items}',
					//'pagerCssClass'=>'nav',
					'pager'=>array(
					'class' => 'myPager')
				));*/?>
			</noindex>

			<div id="tab2" class="tab2Last <?if(count($complect_goods) > 1){?>hide<? } ?>">
			</div>

			<ul id="tab3" class="tab3Last hide">
				<script>
				$('#see').on('click',function(){
					$.ajax({
						type: "POST",
						url: "/goods/getlastgoods",
						success: function(data){
							$('.tab3Last').html(data);
						}
					});
				});
				</script>
				<?/*$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$dataProviderLast,
					'itemView'=>'../catalog/_view',
					'viewData' => array('model' => $model),
					'itemsCssClass' => 'goods',
					'itemsTagName' => 'ul',
					'summaryText'=>false,
					'emptyText'=>false,
					'pagerCssClass'=>'nav',
					'pager'=>array(
					'class' => 'myPager')
				));*/?>
			</ul>
		</div>
	</div> <!-- END List Wrap -->

	<div id="container">
		<div id="content">
		</div><!-- #content-->
	</div><!-- #container-->

	<div class="sidebar" id="sideLeft"></div><!-- .sidebar#sideLeft -->

	<script>
		$(".complect_to_cart").on("click", function(){
			get_data = '';
			$("#collection_form input:checked").each(function(index){
				get_data += $(this).attr('data')+ "|";
			});
			$.ajax({
				type: "POST",
				url: "/cart/multyAdd",
				data: 'get_data=' + get_data,
				success: function(msg){
					$('.bascet').html(msg);
				}
			});
			addToBasket('Комплект','',<?=$model->id?>);
			return false;
		});
	</script>