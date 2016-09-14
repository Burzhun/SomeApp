<?php $this->beginContent('//layouts/main'); ?>






<div class="container">
			<main class="content">
			<?if($this->id != 'site'){?>
				<div class='h1Box'>
					<?$this->widget('zii.widgets.CBreadcrumbs', array(
					'homeLink'=>false,
						'separator' => ' / ',
						'links'=>array('Главная'=>'/') + $this->breadcrumbs,
					));?>
				</div>
			<?}?>
			<?=$content?>
			</main><!-- .content -->
		</div><!-- .container-->

		<script type="text/javascript">
			$(window).load(function(){

					$('.dropCat li.active_menu').each(function(){
						$(this).parent().parent().addClass('active_menu');
					});
					$('.left_menu.dropdown>li.active_menu>a').click();
			});
		</script>
		<?
		if($this->activeCatalog){
			$active = $this->activeCatalog;
		}else{
			$active = explode('?',Yii::app()->request->url);
				$active = $active[0];
		}
		?>
		<?if($this->id != 'catalog'||$this->action->id == 'collection'||$this->action->id == 'group'||$this->action->id == 'index'){?>
		<aside class="left-sidebar">
			<ul class="left_menu dropdown" id="left_menu">


			<?//if(Yii::app()->user->isAdmin){
				?>
				<?$tree = Category::model()->Tree();

					// если открыта страница товара, то чтоб вычислить активность категори
					$controllerId = $this->id;
					if($this->id=='item'){
						$arr = explode('/',Yii::app()->request->requestUri);
						$activeAdd = '/'.end($arr);
					}

				if($tree){
					function renderTree($tree,$activeAdd){
						foreach ($tree as $data){?>
							<li id="item<?=$data['id']?>"
								<?
								$url = explode("?",Yii::app()->request->requestUri);
								if($data['full_url'].$activeAdd==$url[0] ){?>
									class="active_menu"
								<?}?>>
								<?/*<a href="<?=$data['level']==1 ? '#' : $data['full_url']?>" <?if($data['full_url']==Yii::app()->request->requestUri){?> class="active_menu"<?}?>><?=$data['name']?></a>*/?>
								<a href="<?=$data['full_url']?>" ><?=$data['name']?></a>
								<?if(isset($data['children'])){?>

										<ul class='dropCat'>
											<?renderTree($data['children'],$activeAdd);?>
										</ul>

								<?}?>
							</li>
						<?}?>
					<?}?>


					<?foreach ($tree as $data) {
						renderTree($data,$activeAdd);
					}?>
				<?}?>

				<?if($this->id != 'site'&&$this->id != 'goods'&&$this->id == 'category'&&$this->action->id == 'view'){?>
					<br>
					<br>
					<br>
					<p class="filterHead" <?=$this->id?>>ЦЕНА УКРАШЕНИЯ</p>
					 <link rel="stylesheet" href="/themes/roznica/css/jslider.css" type="text/css">
					<link rel="stylesheet" href="/themes/roznica/css/jslider.blue.css" type="text/css">
					<script type="text/javascript" src="/themes/roznica/js/tmpl.js"></script>
					<script type="text/javascript" src="/themes/roznica/js/jquery.dependClass-0.1.js"></script>
					<script type="text/javascript" src="/themes/roznica/js/draggable-0.1.js"></script>
					<script type="text/javascript" src="/themes/roznica/js/jquery.slider.js"></script>


					<div class="sliderBox">
						<form method='GET'>

							<?$price = explode(';',Yii::app()->request->getParam('price'));?>
							<?$priceFrom = $price[0];?>
							<?$priceTo = $price[1];?>
							<input id="Slider" type="slider" name="price" value="<?=$priceFrom ? $priceFrom : Goods::getMinPrice($this->activeCatalogId)?>;<?=$priceTo ? $priceTo : Goods::getMaxPrice($this->activeCatalogId)?>" /><br><br><br>
							<input type="submit" value="Найти" />

						</form>
					</div>

					 <script type="text/javascript" charset="utf-8">
					 var val=[];
						jQuery("#Slider").slider({
							from: <?=Goods::getMinPrice($this->activeCatalogId)?>,
							to: <?=Goods::getMaxPrice($this->activeCatalogId)?>,
							//heterogeneity: ['50/10000', '101/509800'],

							limits: false,
							step: 100,
							dimension: '&nbsp;р',

							callback: function( value ){ console.dir( this );
						}});
					</script>
				<?}?>

			<?/*}else{?>

				<li <?=$active == '/catalog/silver-collection' ? "class='active_menu'" : ""?>>
					<a href="/catalog/silver-collection" title="Серебряная коллекция продажа оптом - Агра-голд">Серебряная коллекция</a>

					<ul class='dropCat'>
						<li <?=$active == '/catalog/silver-collection/silver-fianit' ? "class='active_menu'" : ""?>><a href="/catalog/silver-collection/silver-fianit" title="Серебро с фианитами продажа оптом - Агра-голд">Серебро с фианитами</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/silver-collection/silver-yellow' ? "class='active_menu'" : ""?>><a href="/catalog/silver-collection/silver-yellow" title="Серебро с желтым покрытием продажа оптом - Агра-голд">Серебро с желтым покрытием</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/silver-collection/silver-red' ? "class='active_menu'" : ""?>><a href="/catalog/silver-collection/silver-red" title="Серебро с красным покрытием продажа оптом - Агра-голд">Серебро с красным покрытием</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/silver-collection/silver-semiprecious-stones' ? "class='active_menu'" : ""?>><a href="/catalog/silver-collection/silver-semiprecious-stones" title="Серебро с полудрагоценными камнями продажа оптом - Агра-голд">Серебро с полудрагоценными камнями</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/silver-collection/novelty' ? "class='active_menu'" : ""?>><a href="/catalog/silver-collection/novelty" title="Новинки в коллекции серебра продажа оптом - Агра-голд">Новинки коллекции</a> <span class="category_count"></span></li>
					</ul>

				</li>

				<li <?=$active == '/catalog/gold-collection' ? "class='active_menu'" : ""?>>

					<a href="/catalog/gold-collection" title="Золотая коллекция продажа оптом - Агра-голд">Золотая коллекция</a>
					<ul class='dropCat'>
						<li <?=$active == '/catalog/gold-collection/gold-fianit' ? "class='active_menu'" : ""?> ><a href="/catalog/gold-collection/gold-fianit" title="Золото с фианитами продажа оптом - Агра-голд">Золото с фианитами</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/gold-collection/gold-diamond' ? "class='active_menu'" : ""?> ><a href="/catalog/gold-collection/gold-diamond" title="Золото с бриллиантами продажа оптом - Агра-голд">Золото с бриллиантами</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/gold-collection/gold-semiprecious-stones' ? "class='active_menu'" : ""?> ><a href="/catalog/gold-collection/gold-semiprecious-stones" title="Золото с полудрагоценными вставками продажа оптом - Агра-голд">Золото с полудрагоценными вставками</a> <span class="category_count"></span></li>
						<li <?=$active == '/catalog/gold-collection/novelty' ? "class='active_menu'" : ""?> ><a href="/catalog/gold-collection/novelty" title="Новинки в коллекции золото продажа оптом - Агра-голд">Новинки коллекции</a> <span class="category_count"></span></li>
					</ul>
				</li>

				<li <?=$active == '/catalog/exclusive-collection/gold-exclusive' ? "class='active_menu'" : ""?>>
					<a href="/catalog/exclusive-collection/gold-exclusive" title="Коллекция эксклюзив продажа оптом - Агра-голд">Коллекция эксклюзив</a>
				</li>

				<li <?=$active == '/catalog/kubachi-collection/kubachi' ? "class='active_menu'" : ""?>>
					<a href="/catalog/kubachi-collection/kubachi" title="Кубачинская коллекция продажа оптом - Агра-голд">Кубачинская коллекция</a>
				</li>


				<?/*<li class="active_menu" >
					<a href="/category/zimnyaya-obuv-komfort">Серебряные украшения</a>
			 	</li>*/?>
			<?/*}*/?>
			</ul>
		</aside><!-- .left-sidebar -->
		<?}else{?>
			<aside class="left-sidebar">
			<?/*<div class="category_head">
				КАТАЛОГ ПРОДУКЦИИ
			</div>*/?>

			<ul class="left_menu dropdown" id="left_menu">
				<? foreach ($this->categoryModels as $parent) { ?>
					<?//$parentSize = $parent->countGoods($this->group->id);
					$parentSize = $parent->countInStockType($this->group->id, $parent->id);
					if($parentSize){?>
						<li <?=$active == $parent->createUrl() ? "class='active_menu'" : ""?>><a href="<?=$parent->createUrl();?>"><?=$parent->name?> (<?=$parentSize;?>)</a></li>
					<?}?>
				<?}?>
				<?/*$instock = $parent->countInStock($groupM->id);
				if($instock){?>
					<li><a href="/catalog/<?=$groupM->collection->alias?>/<?=$groupM->alias?>/store">В наличии</a> <span class="category_count"><?=$instock;?></span></li>
				<?}*/?>
			</ul>

			<p class="filterHead">ЦЕНА УКРАШЕНИЯ</p>
			 <link rel="stylesheet" href="/themes/roznica/css/jslider.css" type="text/css">
			<link rel="stylesheet" href="/themes/roznica/css/jslider.blue.css" type="text/css">
			<script type="text/javascript" src="/themes/roznica/js/tmpl.js"></script>
			<script type="text/javascript" src="/themes/roznica/js/jquery.dependClass-0.1.js"></script>
			<script type="text/javascript" src="/themes/roznica/js/draggable-0.1.js"></script>
			<script type="text/javascript" src="/themes/roznica/js/jquery.slider.js"></script>
			<div class="sliderBox">
				<form method='GET'>

					<?$price = explode(';',Yii::app()->request->getParam('price'));?>
					<?$priceFrom = $price[0];?>
					<?$priceTo = $price[1];?>
					<input id="Slider" type="slider" name="price" value="<?=$priceFrom ? $priceFrom : '0'?>;<?=$priceTo ? $priceTo : '100000'?>" /><br><br><br>
					<input type="submit" value="Найти" />

				</form>
			</div>

			 <script type="text/javascript" charset="utf-8">
			 var val=[];
				jQuery("#Slider").slider({
					from: 0,
					to: 100000,
					//heterogeneity: ['50/10000', '101/509800'],

					limits: false,
					step: 100,
					dimension: '&nbsp;р',

					callback: function( value ){ console.dir( this );
				}});
			</script>

			</aside><!-- .left-sidebar -->
		<?}?>



















<?php $this->endContent(); ?>