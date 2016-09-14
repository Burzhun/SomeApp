<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title><?=$this->pageTitle?></title>
	<meta name="keywords" content="<?=$this->pageKeywords?>" />
	<meta name="description" content="<?=$this->pageDescription?>" />

	<link href="/themes/roznica/img/favicon.png" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet/less" type="text/css" href="/themes/roznica/css/style.less" />
	<link rel="stylesheet" type="text/css" href="/themes/roznica/css/animate.css" />
	<?//Yii::app()->clientScript->registerCoreScript('jquery');?>
	<script src="/themes/roznica/js/jquery.js" type="text/javascript"></script>
	<script src="/themes/roznica/js/popBox.js" type="text/javascript"></script>
	<link rel="apple-touch-icon" sizes="57x57" href="/touch-icon-iphone.png">
	 <link rel="apple-touch-icon" sizes="76x76" href="/touch-icon-ipad.png">
	 <link rel="apple-touch-icon" sizes="120x120" href="/touch-icon-iphone-retina.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/touch-icon-ipad-retina.png">
	 <script src="/themes/roznica/js/less-1.7.5.min.js" type="text/javascript"></script>
	 <script src="/themes/roznica/js/mainScript.js"></script>
	 <script src="/themes/roznica/js/fancybox/script.js"></script>
	 <script src="/themes/roznica/js/fancybox/jquery.fancybox.js"></script>
	 <link href="/themes/roznica/js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
	 <script src="/themes/roznica/js/popBox.js" type="text/javascript"></script>

	 <script type="text/javascript" src="/themes/roznica/js/scriptbreaker-multiple-accordion-1.js"></script>

	 <link rel="stylesheet" type="text/css" href="/css/freeow.css" />
	<script src="/js/jquery.freeow.js"></script>
	<script type="text/javascript">
		function addToBasket(title, header,id) {
		$("#freeow").freeow("Товар: "+"<b>"+title+" </b>",header ="  добавлен <a href = '/cart'>в корзину</a>", {
				classes: ["gray", "error"],
				autoHide: true,
				autoHideDelay: 2520,
			});
		}
	</script>

	<link rel="stylesheet" type="text/css" href="/assets/d2f9baa3/select2.css">
	<script type="text/javascript" src="/assets/d2f9baa3/select2.js"></script>

</head>

<body>
<div class="popBox"></div>
<div id="freeow" class="freeow freeow-top-right" style = "text-color: #fff;"></div>
<div class="wrapper">

	<header class="header">
		 <div class="headerTop">
		 	<div class="mainBox">
		 	 

		 		 	



		 		

				 <img src="/themes/roznica/img/icon2.png" alt="" class='headerIcon'>
				  <!-- <span style="width: 350px;
vertical-align: middle;
display: inline-block;"><?=Config::model()->findByPk(22)->value;?></span>   -->
				
				<span class="topCity">
					<span class="topCityActive">Москва</span> <strong>ул.Большая Тульская, д.44, соор.1</strong>
					<div class="topCityDropBox">
						<a href="" data-address='г.Москва ул.Большая Тульская, д.44, соор.1'>Москва</a>
						<a href="" data-address='г.Махачкала, ул.И.Казака 41А, ТЦ Каспий'>Махачкала</a>
					</div>
				</span>

				 <div class="userLink">
					<?if(Yii::app()->user->isGuest){?>
						<a href="/register" class="user_link1">РЕГИСТРАЦИЯ</a>
						<a href="/login" class="user_link12">ВХОД</a>
					<?}else{?>
						<a href="/office" class="user_link1">ЛИЧНЫЙ КАБИНЕТ</a>
						<?if(Yii::app()->user->isAdmin){?>
							<a href="/admin" class="user_link12">АДМИНКА</a>
						<?}?>
						<a href="/logout" class="user_link12">ВЫХОД</a>
					<?}?>
				 </div>
		 	</div>

		 </div>
		 <div class="mainBox headerMainBox">
		 		<div class="logoBox">
		 			<a href="/" class="logo"><img src="/themes/roznica/img/logo.png" alt=""></a>
		 			<span class="logoText">
		 					ЮВЕЛИРНЫЙ ИНТЕРНЕТ-МАГАЗИН

		 			</span>

		 		</div>

		 		<div class="headerPhone">
		 			Позвоните нам
		 			<span><?=Config::model()->findByPk(20)->value;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?=Config::model()->findByPk(21)->value;?></span>
		 			или 

		 			<div class="header_box_link callback">
						<span class="callbackLink">  <a class="callback"  > заказывайте обратный звонок</a></span>
						<div class="pop_callback"  >
							<form id="formcall">
								<label class="callback">Телефон:<br>
								<input class="callback" name="phone" id="phone" type="text"></label><br><br>
								<label class="callback">Ваше имя:<br>
								<input class="callback" name="name" type="text"></label><br><br>

								<input class="callback" id="buttcall" type="button" onclick="callback()" value="Перезвоните"><br>
							</form>
						</div>

						<script>

	function callback(){
if($('#phone').val() == "")
  alert("Введите телефон!");
else
{
  $.ajax({
      type : 'POST',
      url : '/site/call',
      data : $('#formcall').serialize() ,
      success: function(msg){
        $("#formcall").html("<p >Ждите звонка!</p>");
      }
  });
}
}


$('body').click(function(){
if( event.target.className != "pop_callback"&&event.target.className != "callback"&&event.target.className != "formcall")
{
  $('.pop_callback').hide()
}
  })
$('.header_box_link span a').click(function(){
  $('.pop_callback').toggle()

 })




	</script>

				 </div>
		 			
		 		</div>


				<div class="headerSearch">

		 		<form action="/search" method="get" class="searchForm">
					<input class="search_field" name="text" type="text" placeholder="Поиск по сайту..." value="">
					<input id="searchSubmit" type="submit" value='Искать' class="search_button">

				</form>

				<?$randomWord = SearchTag::getRandomWord()?>
				<span>например: <a href="/search?text=<?=$randomWord?>"><?=$randomWord?></a></span>
				</div>

				<div class="header_cart_box">
					<a href="/cart"><img src="/themes/roznica/img/icon3.png"></a>
					<div class="bascet">

						<?php $this->widget('application.components.CartWidget'); ?>

				<?/*<a href="/cart"><span>0</span> товаров </a>
				<a href="/cart"><span>0</span> Руб. </a> */?>
					</div>
				</div>

				<!-- <div class="headerRightBox">
						<a href="/cart" class="btn">оформить</a>
						<a href="/cart" class='fs11px'><strong>перейти в корзину</strong></a>

				</div> -->
		 </div>
	</header><!-- .header-->

	<div class="middle">


			<?=$content?>


<?if($this->id == 'site' && $this->action->id == 'index'){?>

		<script type="text/javascript">

			$(function(){

				$('#SearchForm_collection').on('change', function(){
					var id = $(this).val();
					$.ajax({
						type: "POST",
						url: '/catalog/getGroup',
						data: {id:id},
						beforeSend: function(request){
							//$('.item.vis').hide();
						},
						success: function(list){
							//var list= $.parseJSON(list);
							$('#SearchForm_group').html(list);
						}
					});
				});

				$('#SearchForm_group').on('change', function(){
					var id = $(this).val();
					var cid = $('#SearchForm_collection').val();
					$.ajax({
						type: "POST",
						url: '/catalog/getType',
						data: {gid:id, cid:cid},
						beforeSend: function(request){
							//$('.item.vis').hide();
						},
						success: function(list){
							//var list= $.parseJSON(list);
							$('#SearchForm_type').html(list);
						}
					});
				});

			});
		</script>

		<?=$this->renderPartial('//site/_formSearch', array(),true, true)?>


				<?$banners = Carousel::getByType(2);?>
				<?if($banners){?>
					<ul class="cat2">
						<?foreach ($banners as $data) {?>
							<li><a href="<?=$data->url?>">

								<img src='/uploads/<?=$data->image;?>'  alt="" class='cat2Img'>

								<span class='cat2Title'>
									<strong><?=$data->name?></strong>
									<?=$data->description?>
									<img src="/themes/roznica/img/arrow1.png" class='arrow1' alt="">
								</span>
							</a></li>
						<?}?>
					</ul>
				<?}?>

				<?$newgoods = Goods::getNewGoodStore();?>
				<?if($newgoods){?>
					<p class="pH1">Новинки</p>
					<ul class="goods goodsOnmain goodnews">
						<?foreach ($newgoods as $data) {?>
							<?=$this->renderPartial('//catalog/_view', array('data'=>$data), true, true);?>

						<?}?>
					</ul>
				<?}?>




				<div class="filterOnMain">

		<form action="/" method="POST">
			<span class="filterOnMainHead">Подпишитесь сейчас и получайте скидки!</span>
			<span>
				<?=CHtml::activeTextField($this->userForm, 'name');?>
				<?/*<input name="User['name']" type="text" placeholder='Ваше имя'>*/?>
			</span>
			<span class="filterOnMainArrow"></span>
			<?=CHtml::activeTextField($this->userForm, 'email', array('placeholder'=>'Ваш E-mail'));?>
			<?/*<input type="text" name="User['email']" placeholder='Ваш E-mail'>*/?>
			<span class="filterOnMainArrow"></span>


			<input type="submit" value="Подписаться">
			<div class="errorMessage" style="margin-left: 610px;">

				<?foreach ($this->userForm->errors as $data => $value) {?>
					<span><?=$value[0]?></span>
				<?} ?>
			</div>

		</form>



		</div>

		<?=Page::viewContent(19)?>

<?}?>
	</div><!-- .middle-->

</div><!-- .wrapper -->

<footer class="footer">
 	<div class="mainBox">

 			<?if($this->menu){?>
				<ul class='footerMenu'>
					<strong>О нас</strong>
					<?foreach ($this->menu as $data) {?>
						<li><a href="<?=$data->link?>"><?=$data->name?></a></li>
					<?}?>
				</ul>
			<?}?>

			<?if($this->menu2){?>
				<ul class='footerMenu2'>
					<strong>Для покупателей</strong>
					<?foreach ($this->menu2 as $data) {?>
						<li><a href="<?=$data->link?>"><?=$data->name?></a></li>
					<?}?>
				</ul>
			<?}?>

			<?if($this->menu3){?>
				<ul class='footerMenu3'>
					<strong>Информация</strong>
					<?foreach ($this->menu3 as $data) {?>
						<li><a href="<?=$data->link?>"><?=$data->name?></a></li>
					<?}?>
				</ul>
			<?}?>

 			<a href="http://www.dekartmedia.ru" target="_blank" class="dekart-link" title="Создание сайтов в Махачкале: качественно, эффективно и недорого">
			<strong>Создание сайта</strong> <span>Декарт Медиа</span></a>
			<br><br><br>
			<!--LiveInternet counter--><script type="text/javascript">document.write("<a href='//www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t54.1;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) +";h"+escape(document.title.substring(0,80)) +  ";" + Math.random() + "' border=0 width=88 height=31 alt='' title='LiveInternet: показано число просмотров и посетителей за 24 часа'><\/a>")</script><!--/LiveInternet-->
			<!-- Yandex.Metrika counter --><div style="display:none;"><script type="text/javascript">(function(w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter11659111 = new Ya.Metrika({id:11659111, enableAll: true, webvisor:true}); } catch(e) { } }); })(window, "yandex_metrika_callbacks");</script></div><script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script><noscript><div><img src="//mc.yandex.ru/watch/11659111" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->


 	</div>
</footer><!-- .footer -->
<!--<script type="text/javascript" src="http://consultsystems.ru/script/17696/" charset="utf-8"></script>-->

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'd10MmVnvtA';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<script type="text/javascript" src="/assets/62b20b97/jquery.ba-bbq.js"></script>
<script type="text/javascript">
	$(function(){

		//$.fn.yiiListView.update('user-list');

		$('body').on('click','.updateItem', function(){

			var id = $(this).data('id');

			$.ajax({
				type: "POST",
				url: '/admin/goods/ajaxUpdate',
				data: {id:id},
				beforeSend: function(request){
					//$('.item.vis').hide();
				},
				success: function(list){
					var list= $.parseJSON(list);
					$('.popBox').html(list.list);
					$("#Goods_kubachiCollection").select2();
					$(".popBox").openPop();

				}
			});
			return false;
		});

		$('body').on('click','.updateItemSubmit', function(){

			var id = $(this).data('id');
			var form = $('#updateItemForm').serialize();

			$.ajax({
				type: "POST",
				url: '/admin/goods/ajaxUpdateItem',
				data: form,
				beforeSend: function(request){
					//$('.item.vis').hide();
				},
				success: function(list){
					$.fn.yiiListView.update("user-list");
					$('.closePop').click();
					//$(".popBox").closePop();
					/*var list= $.parseJSON(list);
					$('.popBox').html(list.list);
					$(".popBox").openPop();*/

				}
			});
			return false;
		});


	})



$(document).ready(function(){
  $(document).on("click", ".ajaxitem", function(){
          var url = '/goods/ajax/id/'+ $(this).data('id');


           

           // alert(nextItem);
           // alert($(this).data('itemid'));
          	
          
           
         
          $.ajax({
              url:url,
              type:"post",
              success: function(data){
                  $(".itemPopBox .itemPopBoxContent").html(data);
					// var itemIdLeft=$(".popLeft ").attr("id")
					// var itemIdRight=$(".popRight ").attr("id")
					// if(itemIdLeft=="")
					// {
					// 	$(".popLeft ").addClass("popButtonNone")	
					// }


					// if(itemIdRight=="")
					// {
					// 	$(".popRight ").addClass("popButtonNone")	
					// }
		          $(".itemPopBox").openPop({
		          	"width":"800"
		          });

		          
              }
          });
          
         


	
          
          return false;
      });
  
});

  


			$('body').on('click','.toCart', function(){
				var name = $(this).data("name")
				var article = $(this).data("article")
				var id = $(this).data("id")
			$.ajax({
				type: "POST",
				url: "/cart/add?id="+id,
				data: $(".left_items form").serialize(),
				beforeSend: function(request){
					//$('.item.vis').hide();
				},
				success: function(list){
					addToBasket(name+' '+article,'',id);
					jQuery(".bascet").html(list)
				}
			});
			return false;
		});


	</script>


	<div class="itemPopBox">
		<div class="itemPopBoxContent">
			
		</div>
	</div>
</body>
</html>