<?
defined('YII_DEBUG') or define('YII_DEBUG', $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ? true : false);

if(!YII_DEBUG) {
	if (substr_count($_SERVER['SERVER_NAME'], 'www.') == 0)
		Header("Location: http://www." . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);

	if ($_SERVER['SERVER_NAME'] == 'kubachinka.ru') {

		$uri = $_SERVER['REQUEST_URI']; // текущий URL

		if (strstr($uri, "index.php"))
			Header("Location: http://www.kubachinka.ru");

		if ($uri != "/") {
			if (substr($uri, -1) == "/")
				Header("Location: " . substr($uri, 0, -1));
		}

	} else {
		if (substr_count($_SERVER['SERVER_NAME'], 'agra.v.shared.ru') != 0)
			Header("Location: http://www.agra-gold.ru", TRUE, 301);

		$uri = $_SERVER['REQUEST_URI']; // текущий URL

		if (strstr($uri, "index.php"))
			Header("Location: http://www.agra-gold.ru");

		if ($uri != "/") {
			if (substr($uri, -1) == "/")
				Header("Location: " . substr($uri, 0, -1));
		}
	}
}


/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/

error_reporting(1);
// change the following paths if necessary
define("DS", "/");
$yii=dirname(__FILE__).'/yii1114/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();