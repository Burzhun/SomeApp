<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<? if(Yii::app()->controller->id == "site" AND Yii::app()->controller->action->id == "index")
	{
		$this->pageTitle = Config::model()->cache(10000)->findByPk(17)->value;;
		$this->pageDescription = Config::model()->cache(10000)->findByPk(18)->value;;
		$this->pageKeywords = Config::model()->cache(10000)->findByPk(19)->value;;
	}
	?> 
	<title><?=$this->pageTitle?></title>
	<meta name="keywords" content="<?=$this->pageKeywords?>" />
	<meta name="description" content="<?=$this->pageDescription?>" />
	<meta name="google-site-verification" content="B3g-QNa2QZgtYZQDj0gaQz-q2LwenEsj_VBYzvg94l0" />

	<link href="/js/zoom/jquery.jqzoom.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen, projection" />
	<link href="/font/stylesheet.css" rel="stylesheet" type="text/css">
	<link href="/js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css">
	
	<?/*<script type="text/javascript" language="javascript" src="/js/jquery-1.9.1.min.js"></script>*/?>
	<script src="/js/jquery.js"></script>
	<script src="/js/jquery-animate-css-rotate-scale.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/jquery-css-transform.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/zoom/jquery.jqzoom-core-pack.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/organictabs.jquery.js"></script>
	<script src="/js/jquery.plaxmove.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/fancybox/script.js"></script>
	<script src="/js/fancybox/jquery.fancybox.js"></script>
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>

	<script src="/js/popBox.js"></script>
	
	<script type="text/javascript">
		$(function() {
			if ( $(".lastItems li").length<4)
			{
				$(".zoom button").hide(0);
			}
		});
	</script>

	<?/*Select с картинками*/?>
	 <script type="text/javascript">

	 /*function formatPrice(n){

		n.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
		n.toFixed(2).replace(/./g, function(c, i, a) {
			return i && c !== "." && !((a.length - i) % 3) ? ',' + c : c;
		});
	 }*/

	 $(function(){
		 $('body').on('click', '.openPop', function(event) {
			event.preventDefault();
			$('.popBox').openPop("#fff",true,true);
		});
	 })

	 function openPop(){
	 	$('.popBox').openPop("#fff",true,true);
	 }

	function FormatPrice(Num,Delim) {
	  Num+='';
	  for (var i= Num.length -  3, Res= ''; i >= 0; i -= 3)
		 Res= Num.substr(i, 3) + (Res ? Delim + Res : '');
	  if (i < 0 && i > -3)
		 Res= Num.substr(0, 3+i) + (Res ? Delim + Res : '');
	  return Res;
	}


	function updateGoodsPrice(stone, kod, size){

		$.ajax({
			type: "GET",
			url: "/goods/price/",
			data: "kod="+kod+"&stone="+stone+"&size="+size+"&checkStone=1",
			success: function(msg){
				$('#price'+kod).html(msg);
				updateTotalPrice(kod);
			}
		});
	}

	function updateTotalPrice(id){
		var item = $('#item'+id);
		var price = $('#price'+id).text();
			price = price.replace('р.','');
			price = price.replace(/\s+/g,'');
		var count = item.find('.count').val();
			price = FormatPrice(parseInt(count)*parseInt(price)+' р.',' ');
			item.find('.totalPrice').text(price);
	}

	$(function(){
		$('.selectclick').on('click',function(){
			var siblings = $(this).siblings('.select');
			$('.select').not(siblings).slideUp(0);
			$(this).siblings('.select').stop(true,true).slideToggle('fast').toggleClass('active');
		});

		$('.option').on('click',function(){
			var img = $(this).find('img');
			var src = img.attr('src');
			var kod = $(this).data("stonekod");
				kod = kod.substr(1, kod.length );
			$(this).parent().parent().find('.selectclick>img').attr('src',src);
			$(this).parent().parent().find('.select').stop(true,true).slideToggle('fast').toggleClass('active');
			$(this).parent().parent().find('#stonek').val(kod);

			var size = $(this).parent().parent().parent().find('.sizeSelect').val();
			var goodkod = $(this).parent().parent().parent().parent().find('.goodkod').val();
			updateGoodsPrice(kod, goodkod, size);
		});

		$('.sizeSelect').on('change',function(){
			var size = $(this).val();
			var id = $(this).parent().attr("data-id");
			var goodkod = $(this).parent().parent().parent().find('.goodkod').val();
			var stonekod = $(this).parent().parent().parent().find('#stonek').val();
			updateGoodsPrice(stonekod, goodkod, size);

		})

	})
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();

				var id=$(this).parent().attr("data-id");
				updateTotalPrice(id);
				return false;
			});

			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();

				var id=$(this).parent().attr("data-id");
				updateTotalPrice(id);
				return false;
			});
		});
	</script>

	<script>
		$(function() {
				$("#example-two").organicTabs({
					"speed": 100
				});
				$("#example-one").organicTabs({
					"speed": 100
				});
		});
	</script>

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
	<script type="text/javascript">
		$(document).ready(function (){

			$(function(){
				$('.layer1').plaxmove({ratioH:0.05,ratioV:0.003})
				$('.layer2').plaxmove({ratioH:0.03,ratioV:0.005})
				$('.layer3').plaxmove({ratioH:0.01,ratioV:0.008})
			});

			$('.category a').hover(function(){
				$('.img_border',this).animate({borderWidth: "5px"},200)
				// $('img',this).animate({scale: "0.9"},50)
			},function(){
				$('.img_border',this).animate({borderWidth: "0px"},200)
				//$('img',this).animate({scale: "1"},50)
			})
		})
	</script>
	<base href="http://www.agra-gold.ru">
</head>

<body>
<?if(isset($_GET['1'])){?>
<?=$this->id." - ".$this->action->id;?>
<?}?>
<div id="freeow" class="freeow freeow-top-right" style = "text-color: #fff;"></div>
<div id="wrapper"  <? if($this->id != "site") { echo 'class="no_fon"'; }?>  >
	<?if(isset($_GET['1'])){?>
		<?=$this->id." - ".$this->action->id?>
	<?}?>


	<div id="header">
		<div class='header_box_left'>
			<div class='tel'>+7 (8722) 93-15-50<br>+7 (906) 481-72-72</div>
			<div class='search_box'>
				<form action="/search" method="get">
					<input name="query" type="text" placeholder="Поиск по артикулу" class='search' value='<?php echo Yii::app()->request->getParam('query');?>'>
					<input id="searchSubmit" type="submit" class='searh_button'>
					<br>
				</form>
			</div>
		</div>
		<a href='/'><img src='/img/logo.png' class='logo'></a>
		<div class='header_box_right'>
			<div class='user_box'>
				<?//Если мы не авторизованный?>
				<? if(Yii::app()->user->isGuest) { ?>
					<a href='/login' rel="nofollow">Вход</a><a href='/register'>Регистрация</a>
				<? } else {// иначе если мы авторизовались ?>
					<?$pName = User::model()->findByPk(Yii::app()->user->id); echo " ".$pName->sname;echo " ".$pName->name;?>
					<br>
					<div style="padding-top:5px;">
						<a href='/office' rel="nofollow">Личный кабинет</a><a href='/logout' rel="nofollow">Выход</a>
						<? if(Yii::app()->user->isAdmin) { //если мы админ, то?>
							<a href='/admin' rel="nofollow">Админка</a>
						<? } ?>
					</div>
				<? } ?>
			</div>

			<div class='cart_box'>
				
				<img src='/img/cart_img.png'></BR>
				<div class = "bascet">
					<?php $this->widget('application.components.CartWidget'); ?> 
					<!-- <a href='#' class='count_tocart'>1 товар в корзине</a> -->
				</div>
			</div>
		</div>
	</div><!-- #header-->

	<ul class = "top_menu">
		<? $path = "/".Yii::app()->getRequest()->getPathInfo();
		$menus = MenuItem::model()->cache(100000)->findAll(array('condition' => 'menu_id = 1 AND parent_id < 1',
			'order' => 'position, id DESC'  )); ?>
		<? foreach ($menus as $menu) { ?>
			<? $str = "";
			if(strstr($path,$menu->link)) {
				if(!empty($menu->link) && $menu->link != "/")
					$str = "class = 'active_link'";
			}

			if($path == "/" && $menu->link == "/")
				$str = "class = 'active_link'";  ?>

			<li <?=$str?>>
				<a href="<?=$menu->link?>"><?=$menu->name;?></a>
				<?if(!empty($menu->cache(100000)->childs)){?>
					<ul>
						<?foreach ($menu->cache(100000)->childs as $child) {?>
							<li>
								<?if($child->link == 'www.kubachinka.ru'){?>
									<a href="http://<?=$child->link?>" target="_blank"><?=$child->name?></a>
								<?}else{?>
									<a href="<?=$child->link?>"><?=$child->name?></a>
								<?}?>
							</li>
						<?}?>
					</ul>
				<?}?>
			</li>
		<? }?>
	</ul>

	<? if($this->id === "site" && $this->action->id  == "index") { ?>

		<div class='layer_box'>
			<div class="layer1" style="top: 8.615000000000009px; left: 12.694999999999993px;"></div>
			<div class="layer2" style="top: 10.844999999999999px; left: 16.08499999999998px;" ></div>
			<div class="layer3" style="top: -18.07499999999999px; left: 25.475000000000023px;" ></div>
		</div>
 
		<div class='menu_border_bottom'></div>
		<div id="middle" style="    padding: 0;">
			<div id="container">
				<div id="content">
					<?php $this->widget('application.components.NewItemWidget'); ?>
				</div>
			</div>
			<div class="sidebar" id="sideLeft">
				<?php $this->widget('application.components.LeftSidebarWidget'); ?>
			</div>

		</div>
		<br>
		<h1 style="text-align:center">Ювелирный завод «Агра» - производство ювелирных украшений</h1>
		<div class="catalog_text" style="margin:0 auto;width:1050px;"><?=Page::viewContent(1);?></div>
	<? } ?>
		<div id="middle">
			<?=$content;?>
			<div class="sidebar" id="sideLeft">
			</div><!-- .sidebar#sideLeft -->
			
			<? if($this->id == "site")Page::viewContent(1);?>

		</div><!-- #middle-->

	</div><!-- #wrapper -->

	<div id="footer">
		<div class='footer_content'>
			<div class='footer_box'>
				<?=Config::model()->cache(10000)->findByPk(5)->value;?><br> 
				<?=Config::model()->cache(10000)->findByPk(1)->value;?><br>
				E-mail: <?=Config::model()->cache(10000)->findByPk(11)->value;?><br>
			</div>
			<div class='footer_box_right'>
				<a href="http://dekartmedia.ru" target = "_blank"><img src="/img/dekart.png" class="dekart_logo"></a><br>
				<!-- Yandex.Metrika informer -->
				<a href="https://metrika.yandex.ru/stat/?id=826792&amp;from=informer"
				target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/826792/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
				style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:826792,lang:'ru'});return false}catch(e){}"/></a>
				<!-- /Yandex.Metrika informer -->
				
				<!-- Yandex.Metrika counter -->
				<script type="text/javascript">
				var yaParams = {/*Здесь параметры визита*/};
				</script>
				
				<script type="text/javascript">
				(function (d, w, c) {
					(w[c] = w[c] || []).push(function() {
						try {
							w.yaCounter826792 = new Ya.Metrika({id:826792,
									webvisor:true,
									clickmap:true,
									trackLinks:true,
									accurateTrackBounce:true,
									trackHash:true,params:window.yaParams||{ }});
						} catch(e) { }
					});
				
					var n = d.getElementsByTagName("script")[0],
						s = d.createElement("script"),
						f = function () { n.parentNode.insertBefore(s, n); };
					s.type = "text/javascript";
					s.async = true;
					s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
				
					if (w.opera == "[object Opera]") {
						d.addEventListener("DOMContentLoaded", f, false);
					} else { f(); }
				})(document, window, "yandex_metrika_callbacks");
				</script>
				<noscript><div><img src="//mc.yandex.ru/watch/826792" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
				<!-- /Yandex.Metrika counter -->
				
				<!-- Рейтинг сайтов ювелирной сети , code for http://agra-gold.ru -->
				  <script type="text/javascript">java="1.0";java1=""+"refer="+escape(document.referrer)+"&page="+escape(window.location.href); document.cookie="astratop=1; path=/"; java1+="&c="+(document.cookie?"yes":"now");</script>
				  <script type="text/javascript1.1">java="1.1";java1+="&java="+(navigator.javaEnabled()?"yes":"now")</script>
				  <script type="text/javascript1.2">java="1.2";java1+="&razresh="+screen.width+'x'+screen.height+"&cvet="+(((navigator.appName.substring(0,3)=="Mic"))? screen.colorDepth:screen.pixelDepth)</script>
				  <script type="text/javascript1.3">java="1.3"</script>
				  <script type="text/javascript">java1+="&jscript="+java+"&rand="+Math.random(); document.write("<a href='http://top.uvelir.info/?fromsite=50'><img "+" src='http://top.uvelir.info/img.php?id=50&"+java1+"&' border='0' alt='Рейтинг сайтов ювелирной сети' width='88' height='31'><\/a>");</script>
				  <noscript><a href="http://top.uvelir.info/?fromsite=50" target="_blank"><img src="http://top.uvelir.info/img.php?id=50" border="0" alt="Рейтинг сайтов ювелирной сети" width="88" height="31"></a></noscript>
				<!-- /Рейтинг сайтов ювелирной сети -->
	  
				
				<!--LiveInternet counter--><script type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t54.1;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) +";h"+escape(document.title.substring(0,80)) +  ";" + Math.random() + "' border=0 width=88 height=31 alt='' title='LiveInternet: показано число просмотров и посетителей за 24 часа'><\/a>")</script><!--/LiveInternet-->

				<script>
				  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				  ga('create', 'UA-26599611-13', 'auto');
				  ga('send', 'pageview');

				</script>
				<img src="/img/2.png" class="dekart_logo">
			</div>
		</div>  
	</div><!-- #footer -->
	<? // <script type="text/javascript"
		//src="http://consultsystems.ru/script/16174/" charset="utf-8">
	// </script> ?>
	<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'NpVpVZ6e1O';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<div class="popBox">
	<div class="block-content">
		<span>
			Воспользоваться корзиной вы можете при входе или зарегистровавшись<br><br>
		</span>
		<a href="/login">Вход</a>
		<a href="/register">Регистрация</a><br><br>
		<a href="http://www.kubachinka.ru/" target="_blank">Купить в розничном интернет магазине</a>
	</div>
</div>
</body>
</html>