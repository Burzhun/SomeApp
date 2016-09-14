<?php
Yii::setPathOfAlias('editable', dirname(__FILE__) . '/../extensions/x-editable');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Агра голд',
	'language' => 'ru',
	'preload'=>array(
		'log',
	),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'editable.*' //easy include of editable classes
	),
	'defaultController'=>'site',
	'modules'=>array(
		'admin',
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			'ipFilters'=>array('*'),
		),*/
	),

	'components'=>array(
		'ih'=>array(
			'class'=>'CImageHandler',
		),

		'editable' => array(
			'class' => 'editable.EditableConfig',
			'form' => 'plain', //form style: 'bootstrap', 'jqueryui', 'plain'
			'mode' => 'inline', //mode: 'popup' or 'inline'
			'defaults' => array( //default settings for all editable elements
				'emptytext' => 'Отсутствует'
			)
		),

		'mail'=>array(
			'class'=>'ext.mailer.EMailer',
			'CharSet'=>'UTF-8'
		),
		'simpleImage'=>array(
			'class' => 'ext.resizeImage.CSimpleImage'
		),
		'image'=>array(
			'class'=>'application.extensions.image.CImageComponent',
			'driver'=>'GD',
			'params'=>array('directory'=>'D:/Program Files/ImageMagick-6.4.8-Q16'),
		),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
		),
		'db'=>require_once(
		YII_DEBUG ? dirname(__FILE__) . '/db_dev.php' : dirname(__FILE__) . '/db.php'
		),
		'user'=>array(
			'class' => 'WebUser',
			'allowAutoLogin'=>true,
		),

		'cache'=>array(
			'class'=>'system.caching.CFileCache',
		),

		'iwi' => array(
			'class' => 'application.extensions.iwi.IwiComponent',
			// GD or ImageMagick
			'driver' => 'GD',
			// ImageMagick setup path
			//'params'=>array('directory'=>'C:/ImageMagick'),
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'class'=>'UrlManager',
			/*'useStrictParsing'   => true,
			'urlSuffix'          => '/',*/
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(

				'robots.txt' => 'site/getRobotsFile',
				'collection/<alias:.+>'=>'collection/view',
				//'gii'=>'gii',
				'/' => 'site/index',
				//'robots.txt' => array('site/getRobotsFile', 'urlSuffix'=>'.txt'),
				'search' => 'search/index',
				'site/password' => 'site/password',
				'thanks' => 'site/thanks',
				'office' => 'site/office',
				'discount' => 'site/discount',
				'review' => 'site/review',
				'profile' => 'site/profile',
				'login' => 'site/login',
				'logout' => 'site/logout',
				'register' => 'site/register',

				'api/getgoods'=> 'api/getgoods',				

				'category'=> 'category/index',
				'category/<alias:.+>'=> 'category/view',

				'catalog/'=>'catalog/index',
				'catalog/new'=>'catalog/new',
				'catalog/getGroup'=>'catalog/getGroup',
				'catalog/getType'=>'catalog/getType',
				'catalog/discount'=>'catalog/discount',
				'catalog/popular'=>'catalog/popular',
				'catalog/SetDefaultPrice' => 'catalog/SetDefaultPrice',

				/*'catalog/<name:[А-Яа-яЁё]+>'=>'catalog/season',
				'catalog/<idgoodtype:\d+>/<idGroup:\d+>'=>'catalog/viewGroup',
				'catalog/<idgoodtype:\d+>'=>'catalog/view',*/

				'catalog/<collection:[a-zA-Z0-9\-]+>'=>'catalog/group',
				'catalog/novelty'=>'catalog/novelty',
				//'catalog/<collection:[a-zA-Z0-9\-]+>/store'=>'catalog/collectionStore',
				'catalog/<collection:[a-zA-Z0-9\-]+>/store'=>'catalog/store',
				'catalog/<collection:[a-zA-Z0-9\-]+>/<group:[a-zA-Z0-9\-]+>'=>'catalog/groupItem',

				'catalog/<collection:[a-zA-Z0-9\-]+>/<group:[a-zA-Z0-9\-]+>/store'=>'catalog/store',
				'catalog/<collection:[a-zA-Z0-9\-]+>/<group:[a-zA-Z0-9\-]+>/<goodtype:[a-zA-Z0-9\-]+>'=>'catalog/viewGroup',
				//'catalog/<collection:[a-zA-Z0-9\-]+><group:[a-zA-Z0-9\-]+><rubrik:[a-zA-Z0-9\-]+><goods:\d+>'=>'',

				'goods/getliketoo'=>'goods/getLiketoo',
				'goods/getlastgoods'=>'goods/getLastGoods',
				'goods/price'=>'goods/price',
				'goods/<kod:\w+>-<alias:.+>'=>'goods/view',
				'goods/<kod:\w+>'=>'goods/view',

				'news/'=>'news/index',
				'news/<id:\d+>/<translit>'=>'news/view',

				'article/'=>'article/index',
				'article/<id:\d+>/<translit>'=>'article/view',

					'shops/'=>'shops/index',

				'service/<id:\d+>/<translit>'=>'service/view',
				'cart/'=>'cart/view',
				'tires/'=>'tire/index',
				'page/<id:\d+>'=>'page/index',
				'manufacter/<id:\d+>'=>'manufacter/index',
				'admin/'=>'admin/default',
				'question/'=>'question/index',
				'announcement/'=>'announcement/index',

				//статические страницы
				'sitemap.xml' => 'site/sitemap',
				'export.xml' => 'site/export',
				'<url:\w+>'=>'page/viewbyurl',

			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'enabled'=>true,
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'application.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
					'ipFilters'=>array('176.120.219.49', '81.163.41.11'),
				),
			),
		),
	),

	'params'=>require(dirname(__FILE__).'/params.php'),
);