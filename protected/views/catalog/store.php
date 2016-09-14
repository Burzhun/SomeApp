<?$this->pageTitle = $group->name." в наличии. Ювелирные изделия оптом в наличии | Агра - ювелирный завод"; ?>

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
		display: inline-block;
		padding: 4px 0px 2px;
		background: #00010d;
		border-radius: 10px;
		border: 1px solid #534949;
	}
	.qualit-count{
		display: inline-block;
	}
	.minus{
		margin-right: -3px;
		display: inline-block;
		padding: 2px 4px 1px 10px;
	}
	.plus{
		margin-right: 3px;
		display: inline-block;
		padding: 2px 12px 0px 0px;

	}

	table{
		text-align: center;
		width: 78%;
	}

	table td{
		padding: 10px 3px 7px;
	}

	table tr:hover{
		background: #3D3939;
	}

	table th{
		color: #fac95a;
	}


	.selectclick.filter-stone {
		margin:-16px 0px 0px 0px;
		width: 18px;
		height: 30px;
	}

	.selectclick.filter-stone span, .select.filter-stone span {
		color: black;
	}

	.select.filter-stone {
		width: 50px;
		height: 30px;
		margin-left: -75px;
	}

	.option.filter-stone {
		display: table-row;
	}

	.selectclick:after {
		content: none;
	}

	.select.filter-stone {
		left: 0;
		margin-left: 0;
	}
</style>

<script type="text/javascript">
	$(function(){
		$('.plus').on('click',function(){
			var max = $(this).siblings('.qualit-count').data('max');
			var count = $(this).siblings('.qualit-count').text();
			if(count>=max){
				return false;
			}else{
				count++;
				$(this).siblings('.qualit-count').text(count);
				$(this).parent().parent().parent().find('.quan').val(count);
				return true;
			}
		});
		$('.minus').on('click',function(){
			var count = $(this).siblings('.qualit-count').text();
			if(count<=1){
				return false;
			}else{
				count--;
				$(this).siblings('.qualit-count').text(count);
				$(this).parent().parent().parent().find('.quan').val(count);
				return true;
			}
		})
	})
</script>



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

<h1><?=$group->name." в наличии оптом"?></h1>
<p>Здесь представлены ювелирные украшения из серебра, которые есть в наличии в нашем фирменном магазине или на складе. 
	В случае заказа из товаров в наличии, вы можете получить их уже через несколько дней!<br><br></p>

<?//делаем выборку всех камней которые есть в наличии
$stonesstore = Stone::getAllStoneInStore($model->id);?>

<form method="GET">
	<b>	ПОИСК: </b><label>Артикул<input name="filterArticul" id="filterArticul" type="text" value="<?=$_GET['filterArticul']?>"></label>
	&nbsp;&nbsp;
	Размер от <?=CHtml::dropDownList("filter-size-start", $_GET['filter-size-start'], array(" - ", "15.00"=>"15.00", "15.50"=>"15.50", "16.00"=>"16.00", "16.50"=>"16.50", "17.00"=>"17.00", "17.50"=>"17.50", "18.00"=>"18.00", "18.50"=>"18.50", "19.00"=>"19.00", "19.50"=>"19.50", "20.00"=>"20.00", "20.50"=>"20.50", "21.00"=>"21.00", "21.50"=>"21.50"));?>
	до <?=CHtml::dropDownList("filter-size-end", $_GET['filter-size-end'], array(" - ", "15.00"=>"15.00", "15.50"=>"15.50", "16.00"=>"16.00", "16.50"=>"16.50", "17.00"=>"17.00", "17.50"=>"17.50", "18.00"=>"18.00", "18.50"=>"18.50", "19.00"=>"19.00", "19.50"=>"19.50", "20.00"=>"20.00", "20.50"=>"20.50", "21.00"=>"21.00", "21.50"=>"21.50"));?>
	
	<?//if(Yii::app()->session->get("admin") == 1) { ?>
		&nbsp;&nbsp;&nbsp;&nbsp; 
			 цвет вставки &nbsp;&nbsp;
		<div class="goodcolor-item">
			<input type="hidden" name='filter-stonekod' value="<?=$_GET['filter-stonekod'];?>" id="stonek">
			<?//if(isset($_GET['stonekod']))?>
			<div class="selectclick filter-stone">
				<?$selectedStone = Stone::model()->find(array('condition'=>"color LIKE '%".$_GET['filter-stonekod']."%'"))?>
				<img title = "<?=$selectedStone->color;?>" style = "max-width: 20px; max-height: 20px; min-width: 20px; min-height: 20px; margin:3px 4px 10px 5px;" src="<?=$selectedStone->getImageStone();?>">
			</div>
			<div class="select filter-stone">
				<?foreach ($stonesstore as $stonekod) {?>
					<div class="option filter-stone" data-stonekod="a<?=$stonekod->color;?>">
						<img title = "<?=$stonekod->color;?>" style = "max-width: 20px; max-height: 20px; min-width: 20px; min-height: 20px; margin:3px 4px 10px 5px;" src="<?=$stonekod->getImageStone();?>">
					</div>
				<?}?>
				<?//=CHtml::dropDownList('size','size', CHtml::ListData($data->getStones(),'size','size'),array('id'=>'sizeSelect'));?>
			</div>
		</div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		<label>Цена от <input name="filterPriceFrom" id="filterPrice" size='5' type="text" value="<?=$_GET['filterPriceFrom']?>"> до <input name="filterPriceTo" id="filterPrice" size='5' type="text" value="<?=$_GET['filterPriceTo']?>"></label>
		&nbsp;&nbsp;
	<?// } ?>
	<?=CHtml::hiddenField('group',$group->alias);?>
	<input type="submit" value="Найти">
</form>

<? if(!$dataProvider->totalItemCount){?>

	<h1>Нет товаров</h1>

<? }else{ ?>

	<? $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'../catalog/_viewstore',
		'viewData' => array('model' => $model),
		'itemsCssClass' => 'goods',
		'itemsTagName' => 'ul',
		'summaryText'=>false,  
		'emptyText'=>false,
		'pagerCssClass'=>'nav',
		'pager'=>array(
			'cssFile'=>'',
			'class' => 'myPager',
		)
	));?>
<? } ?>

<style type="text/css">
	.goodcolor-item{
		float: none;
		position: relative;
		display: inline-block;
		vertical-align: 6px;
		margin-bottom: -20px;
	}
	.selectclick.filter-stone{
		position: relative;
		margin: 0;
	}
	.select.filter-stone{
		height: 160px;
		overflow: auto;
	}
</style>