<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <script type="text/javascript" language="javascript" src="/js/jquery-1.9.1.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="language" content="ru" /> 
  <title><?=$this->pageTitle?></title>
  <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>

<body <?if($this->id=='shops'){?> onload="initialize()" <?}?>>

<div class="container" id="page">

	<div id="header">

	</div><!-- header -->


<?if(Yii::app()->theme->name != 'roznica'){?>

	<?php $this->widget('bootstrap.widgets.BootNavbar', array(
		'fixed'=>false,
		'brand'=>"Админка",
		'brandUrl'=>'/admin',
		'collapse'=>false, // requires bootstrap-responsive.css
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.BootMenu',
				'items'=>array(
					//array('label'=>'Заказы +'.Order::model()->count(array('condition' => 'status = 0')), 'url'=>'/admin/order/admin' 
					//),
					//array('label'=>'Пользователи', 'url'=>'/admin/user/admin', 'active'=>$this->id=='user'),
					array('label'=>'Каталог товаров', 'url'=>'#', 'items'=>array(
						array('label'=>'Товары', 'url'=>'/admin/goods/admin', 'active'=>$this->id=='goods'),
						array('label'=>'Камни', 'url'=>'/admin/stone/admin', 'active'=>$this->id=='stone'),
						//array('label'=>'Категории', 'url'=>'/admin/catalog', 'active'=>$this->id=='catalog'),
						//array('label'=>'Обновить счетчики', 'url'=>'/admin/catalog/count' ),
						//array('label'=>'Бренды', 'url'=>'/admin/manufacter' , 'active'=>$this->id=='manufacter'),
						//array('label'=>'Товары на главной', 'url'=>'/admin/itemMain', 'active'=>$this->id=='itemMain'),
						//array('label'=>'   - - - ',),
						//array('label'=>'Производители шин', 'url'=>'/admin/tireManufacter/admin'),
						//array('label'=>'Шины', 'url'=>'/admin/tire/admin'),
					)),
					array('label'=>'Контент сайта', 'url'=>'#', 'items'=>array(
						//array('label'=>'Вопрос ответ + '.Question::model()->count('status=0'), 'url'=> array('/admin/question/admin') , 'active'=>Yii::app()->controller->id=='question'),
						//array('label'=>'Комментарии + '.Comment::model()->count('status=0'), 'url'=> array('/admin/comment/admin') , 'active'=>Yii::app()->controller->id=='comment'),
						array('label'=>'Баннеры', 'url'=> array('/admin/carousel'), 'active'=>Yii::app()->controller->id=='carousel'),
						array('label'=>'Новости', 'url'=> array('/admin/news') , 'active'=>Yii::app()->controller->id=='news'),
						array('label'=>'Страницы', 'url'=> array('/admin/page'), 'active'=>Yii::app()->controller->id=='page'),
						array('label'=>'Статьи', 'url'=> array('/admin/article'), 'active'=>Yii::app()->controller->id=='article'),
						//array('label'=>'Услуги', 'url'=> array('/admin/service'), 'active'=>Yii::app()->controller->id=='service'),
						array('label'=>'Магазины', 'url'=> array('/admin/shops'), 'active'=>Yii::app()->controller->id=='shops'),
						array('label'=>'Города для магазинов', 'url'=> array('/admin/city'), 'active'=>Yii::app()->controller->id=='city'),
						//array('label'=>'   - - - ',),
						//array('label'=>'Производители шин', 'url'=>'/admin/tireManufacter/admin'),
						//array('label'=>'Шины', 'url'=>'/admin/tire/admin'),
					)),                  

					//array('label'=>'Объявления', 'url'=> array('/admin/announcement/admin'), 'active'=>Yii::app()->controller->id=='announcement'),
				
					array('label'=>'Коллекции', 'url'=> array('/admin/collection'), 'active'=>Yii::app()->controller->id=='collection'),
					array('label'=>'Группы', 'url'=> array('/admin/group'), 'active'=>Yii::app()->controller->id=='group'),
					array('label'=>'Тип товаров', 'url'=> array('/admin/goodtype'), 'active'=>Yii::app()->controller->id=='goodtype'),
					
					array('label'=>'Настройки сайта', 'url'=>'#', 'items'=>array(
						array('label'=>'Очистить кеш', 'url'=> array('/admin/default/ClearCache'), 'active'=>Yii::app()->controller->id=='menu'),
						array('label'=>'В наличии', 'url'=> array('/admin/default/goodstore')),
						array('label'=>'Камни', 'url'=> array('/admin/default/goodstone')),
						//array('label'=>'Цвета', 'url'=> array('/admin/color/admin'), 'active'=>Yii::app()->controller->id=='color'),
						//array('label'=>'Сезоны', 'url'=> array('/admin/season/admin'), 'active'=>Yii::app()->controller->id=='season'),
						array('label'=>'Элементы меню', 'url'=> array('/admin/menu'), 'active'=>Yii::app()->controller->id=='menu'),
						//array('label'=>'Теги поиска', 'url'=> array('/admin/searchTag'), 'active'=>Yii::app()->controller->id=='searchTag'),
						array('label'=>'Другие настройки сайта', 'url'=> array('/admin/config'),'active'=>Yii::app()->controller->id=='config'),
						array('label'=>'Атрибуты товаров', 'url'=> array('/admin/attribute/admin'),'active'=>Yii::app()->controller->id=='attribute'),
						array('label'=>'Группы атрибутов', 'url'=> array('/admin/attributeGroup/admin'),'active'=>Yii::app()->controller->id=='attributeGroup'),
						//array( 'label'=>'Размерные ряды', 'url'=> array( '/admin/size/admin' ), 'active'=>Yii::app()->controller->id=='size' ),
					)),
					//array('label'=>'Рассылки', 'url'=>'#', 'items'=>array(
					//array('label'=>'База Email', 'url'=> array('/admin/email/admin'), 'active'=>(Yii::app()->controller->id=='email' && Yii::app()->controller->action->id=='admin')  ),
					//array('label'=>'Разослать сообщение', 'url'=> array('/admin/email/send'),'active'=>(Yii::app()->controller->id=='email' && Yii::app()->controller->action->id=='send') ),
					//)),
				),
			),
			array(
				'class'=>'bootstrap.widgets.BootMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(
					'---',
					array('label'=>'Выход', 'url'=>'/'),
					'---',
				),
			),
		),
	)); ?>
<? } else { ?>
	<?php $this->widget('bootstrap.widgets.BootNavbar', array(
		'fixed'=>false,
		'brand'=>"Админка",
		'brandUrl'=>'/admin',
		'collapse'=>false, // requires bootstrap-responsive.css
		'items'=>array(
			array(
				'class'=>'bootstrap.widgets.BootMenu',
				'items'=>array(
					//      
					array('label'=>'Каталог товаров', 'url'=>'#', 'items'=>array(
						array('label'=>'Товары', 'url'=>'/admin/goods/admin', 'active'=>$this->id=='goods' && $this->action->id!='mainItem'),
						array('label'=>'Камни', 'url'=>'/admin/stone/admin', 'active'=>$this->id=='stone'),
						array('label'=>'Товары на главной', 'url'=>'/admin/goods/mainItem', 'active'=>$this->action->id=='mainItem'),
					)),
					array('label'=>'Контент сайта', 'url'=>'#', 'items'=>array(
						array('label'=>'Баннеры', 'url'=> array('/admin/carousel'), 'active'=>Yii::app()->controller->id=='carousel'),
						array('label'=>'Новости', 'url'=> array('/admin/news') , 'active'=>Yii::app()->controller->id=='news'),
						array('label'=>'Страницы', 'url'=> array('/admin/page'), 'active'=>Yii::app()->controller->id=='page'),
						array('label'=>'Статьи', 'url'=> array('/admin/article'), 'active'=>Yii::app()->controller->id=='article'),
						//array('label'=>'Услуги', 'url'=> array('/admin/service'), 'active'=>Yii::app()->controller->id=='service'),
					)),
					array('label'=>'Категории', 'url'=>'#', 'items'=>array(
						array('label'=>'Категории', 'url'=> array('/admin/category'), 'active'=>Yii::app()->controller->id=='category'),
						array('label'=>'Коллекции кубачинки', 'url'=> array('/admin/kubachinkaCollection'), 'active'=>Yii::app()->controller->id=='categoryKubachinka'),
					)),
					//array('label'=>'Коллекции', 'url'=> array('/admin/collection'), 'active'=>Yii::app()->controller->id=='collection'),
					array('label'=>'Группы', 'url'=> array('/admin/group'), 'active'=>Yii::app()->controller->id=='group'),
					array('label'=>'Тип товаров', 'url'=> array('/admin/goodtype'), 'active'=>Yii::app()->controller->id=='goodtype'),

					array('label'=>'Настройки сайта', 'url'=>'#', 'items'=>array(
						array('label'=>'Очистить кеш', 'url'=> array('/admin/default/ClearCache'), 'active'=>Yii::app()->controller->id=='menu'),
						array('label'=>'Элементы меню', 'url'=> array('/admin/menu'), 'active'=>Yii::app()->controller->id=='menu'),
						array('label'=>'Теги поиска', 'url'=> array('/admin/searchTag'), 'active'=>Yii::app()->controller->id=='searchTag'),
						array('label'=>'Другие настройки сайта', 'url'=> array('/admin/config'),'active'=>Yii::app()->controller->id=='config'),
						//  array('label'=>'Атрибуты товаров', 'url'=> array('/admin/attribute/admin'),'active'=>Yii::app()->controller->id=='attribute'),
						//  array('label'=>'Группы атрибутов', 'url'=> array('/admin/attributeGroup/admin'),'active'=>Yii::app()->controller->id=='attributeGroup'),
					)),
				),
			),
			array(
				'class'=>'bootstrap.widgets.BootMenu',
				'htmlOptions'=>array('class'=>'pull-right'),
				'items'=>array(
					'---',
					array('label'=>'Выход', 'url'=>'/'),
					'---',
				),
			),
		),
	)); ?>
<? } ?>


<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
	 'homeLink' => CHtml::link('Главная страница', Yii::app()->homeUrl),
		'links'=>$this->breadcrumbs,
)); ?>
<!-- breadcrumbs -->
<div id = "flash">
<? $this->renderPartial('/layouts/_flashes'); ?>
</div>
	<?php echo $content; ?>

	<div id="footer" align = "center">
		&copy; <?php echo date('Y'); ?> Декарт медиа.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>