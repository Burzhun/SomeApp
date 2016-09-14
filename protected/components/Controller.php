<?php

class Controller extends CController
{

	public $layout='//layouts/column2';

	public $themeId;
	public $siteName;

	public $menu=array();
	public $menu2=array();
	public $menu3=array();

	public $userForm=array();

	public $categoryModels=array();
	public $group=array();

	public $activeCatalog=array();
	public $activeCatalogId;

	public $breadcrumbs=array();


	public $cart;


	public $pageKeywords;
	public $pageDescription;

	public $yii_admin;

	public function init()
	{
		if($_SERVER['SERVER_NAME'] == 'www.kubachinka.ru'){

			Yii::app()->name = 'Кубачинка';
			
			switch($_SERVER['REQUEST_URI']){
				case "/catalog.html?subcat=28": $this->redirect('/catalog/kubachi-collection/kubachi/braslet',true,301);break;
				case "/catalog.html?cat=4": $this->redirect('/catalog/silver-collection',true,301);break;
			}

			$this->themeId = 1;
			Yii::app()->theme = 'roznica';
			$this->menu = Menu::model()->cache(40000)->findByPk(6)->cache(40000)->mainChilds;
			$this->menu2 = Menu::model()->cache(40000)->findByPk(5)->cache(40000)->mainChilds;
			$this->menu3 = Menu::model()->cache(40000)->findByPk(7)->cache(40000)->mainChilds;

			if($this->id == 'site'){

			}

			$this->pageTitle = Config::model()->cache(100000)->findByPk(25)->value;
			$this->pageDescription = Config::model()->cache(100000)->findByPk(24)->value;
			$this->pageKeywords = Config::model()->cache(100000)->findByPk(23)->value;

		}else{
			$this->themeId = 0;
			$this->pageTitle = Config::model()->cache(100000)->findByPk(7)->value;
			$this->pageDescription = Config::model()->cache(100000)->findByPk(8)->value;
			$this->pageKeywords = Config::model()->cache(100000)->findByPk(9)->value;

		}

		//if(Yii::app()->user->isAdmin){


		//}

		//MailBackup::run();
	}
}