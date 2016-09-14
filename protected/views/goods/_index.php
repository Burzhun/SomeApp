<? 
$title = "";
foreach ($breadcrumbs as $key => $value) {
	$title .=$key." / ";
}?>
<? if(!empty($item->seotitle))
		$this->pageTitle = $item->seotitle;
	else
		$this->pageTitle = "$item->name - $item->article / $title ".$this->pageTitle;

	if(!empty($item->seokeywords))
		$this->pageKeywords = $item->seokeywords;

	if(!empty($item->seodescription))
		$this->pageDescription = $item->seodescription;	 ?>
	<? $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
		'links'=>$breadcrumbs,
	));?>

	<script type="text/javascript" src="/js/jcarousellite_1.0.1.pack.js"></script>


	<link href="/js/zoom/jquery.jqzoom.css" rel="stylesheet" type="text/css" />


	<link href="/js/zoom/jquery.jqzoom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/js/zoom/jquery.jqzoom-core.js"></script>
 
	<h1>Изумрудные серьги с итальянским замком “Название”</h1>
	<div class='item_box'>
		<div class='item_box_img'>
			<div class='item_img'>
				<div class="clearfix" id="contentzoom" style="height:500px;width:450px;" >
					<div class="clearfix" id="content2" style=" height:500px;width:450px;" >
						<div class="clearfix">
							<a href="/uploads/<?=$item->images[0]->filename;?>" title='<?=$item->name?>' class="jqzoom" rel='gal1' <? // title="triumph" ?>  >
								<img src="/uploads/<?=$item->images[0]->filename;?>" title='<?=$item->name?>' title="triumph" >
							</a>
						</div>
						<br/>

						<div class='mini_list_box'>
							<button class="leftt nav_display  disabled">&lt;&lt;</button>
							<button class="rightt nav_display">&gt;&gt;</button>
							<div class="clearfix mini_list" >
								<ul id="thumblist" class="clearfix mini_zoom" >
									<? foreach ($item->images as $image) { ?>
										<li>
											<a  href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '/uploads/large_<?=$image->filename;?>',largeimage: '/uploads/large_<?=$image->filename;?>'}">
												<img src='/uploads/large_<?=$image->filename;?>'>
											</a>
										</li>
									<?}?>

									
								</ul>
							</div>
						</div>
					</div>				
					<div class="clearfix" style="margin-left:100px"></div>
				</div>
				<script type="text/javascript">

					$(document).ready(function() {
						$('.jqzoom').jqzoom({
											zoomType: 'reverse',
											lens:true,
											preloadImages: false,
											alwaysOn:false
									});
						//$('.jqzoom').jqzoom();
					});
				</script>

			</div>
			<? if($item->in_stock): ?>
				<p class='in_stock'>Товар есть в наличии</p>
			<? endif; ?>
		</div>

		<div class='item_info'><br>

		<div class='item_nav'>
			<? if($prev): ?>
				<a href='<?=$prev->createurl?>'>|←Предыдущее</a>&nbsp;&nbsp;&nbsp; 
			<? endif; ?>
			Изделие № <?=$item->id;?>   &nbsp;&nbsp;&nbsp; 
			<? if($next): ?>
				<a href='<?=$next->createurl?>'>Следующее →|</a>
			<? endif; ?>
		</div>
		<div class='item_title'>Артикул: <?=$item->article?></div>
			<ul class='item_attr'>
				<? $attr = $item->getEavAttributes();
				$groups = AttributeGroup::model()->findAll(); ?>

				<? foreach ($groups as $group) {
					$lastgroup = "";
					foreach ($group->attr as $a) {

						if(!empty($attr[$a->unique])) {
							if($lastgroup != $group->name)
								echo " <strong>".$group->name."</strong><br>";
							$lastgroup = $group->name;
							if($a->type==1)
								echo " ".$a->name." : "." ".$attr[$a->unique] ;
							else
								echo" ". $a->name." ";
							echo " ";
						}
					}
				}?> 
			</ul>

			<strong class='price'>Цена: <?=$item->formattedprice;?></strong>

			<? echo CHtml::ajaxLink(
				'Купить',
				array("cart/add/id/$item->id"),
				array(
					'update'=>'.bascet',
				),
				array(
					'style' => 'border:none; cursor: pointer;',
					'class' => 'to_buy',
					'onClick' => "addToBasket('$item->name $item->article','',$item->id);return false"
				)
			);
			?> 
		</div>
	</div>

	<div style='clear:both'></div>
	<br>
	<p class='head3'>Похожие товары</p>
	<div class="lastItems">
		<button class="prevv   disabled">&lt;&lt;</button>
		<button class="nextt ">&gt;&gt;</button>

		<ul class='goods'>
			<? $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProvider,
				'itemView'=>'../catalog/_view',
				'viewData' => array('model' => $model),
				'itemsCssClass' => 'goods',
				'itemsTagName' => 'ul',
				'summaryText'=>false,  
				'emptyText'=>false,
				'pagerCssClass'=>'nav', 
				 
				'pager'=>array(
					'class' => 'myPager'
				)
			)); ?>
		</ul>
	</div>

	<p class='head3'>Недавно просмотренные товары</p>

	<div class="lastItems2">
		<button class="prevvvv   disabled">&lt;&lt;</button>
		<button class="nextttt ">&gt;&gt;</button>
		<ul class='goods'>

			<? $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$dataProviderLast,
				'itemView'=>'../catalog/_view',
				'viewData' => array('model' => $model),
				'itemsCssClass' => 'goods',
				'itemsTagName' => 'ul',
				'summaryText'=>false,  
				'emptyText'=>false,
				'pagerCssClass'=>'nav', 

				'pager'=>array(
					'class' => 'myPager'
				)
			)); ?>
		</ul>
	</div>
	<br><br><br>
	<img src="/img/brend_border.png" class='bottom_border'>