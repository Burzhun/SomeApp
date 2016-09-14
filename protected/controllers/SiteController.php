<?php

class SiteController extends Controller
{
	public $layout='//layouts/column2';

	public function actionIndex()
	{
		$this->userForm = new User;
		if(isset($_POST['User'])){

			$this->userForm->attributes =$_POST['User'];
			$user = User::model()->find('email=:email', array(':email'=>$this->userForm->email));
			if($this->userForm->validate()){
				if(!$user){
					if($this->userForm->save()){
					}
						$this->userForm = new User;
				}
			}
		}
		$this->render('index');
	}


	public function actionMailTest()
	{

		$mailer           = Yii::app()->mail;
		$mailer->From     = Yii::app()->params['email'];
		$mailer->FromName = Yii::app()->name;
		$mailer->Subject  = "Вы зарегистрированы!";
		$mailer->Body     = "Спасибо за регистрацию!  <br>";
		$mailer->Body.= "<br>Ваш логин (Email): <b</b><br>";
		$mailer->AddAddress('dergesus@ya.ru');
		$mailer->isHtml(1);
		$mailer->send();
		echo "ok";
	}

	public function actionSin(){


		/*Yii::app()->cache->flush();
		$goods = Goods::model()->findAll();*/

		$catalogAgra = 5;
		$catalogKKNP = 94;
		$goods = Goods::CategoryGoods($catalogAgra);
		foreach ($goods as $key => $model) {
	        $rows[] = $model->attributes;
	        $rows[$key]['hm'] = $model->hm->name;
	        $rows[$key]['price'] = $model->defaultPrice(true);
	        $stonekod = $model->stoneInStock;
	        if(!$stonekod){
	        	$stonekod = $model->sizeInStock;
	        }
	        $rows[$key]['stoneInStock'] = $stonekod;
	        $rows[$key]['weight'] = substr_replace($model->weight_ap, '', -1, 1);
	        $rows[$key]['image'] = $model->image;
	        $rows[$key]['catalog'] = $catalogKKNP;

	    }



	  	$catalogAgra = 6;
		$catalogKKNP = 95;
		$goods = Goods::CategoryGoods($catalogAgra);
		foreach ($goods as $key => $model) {
		    $rows1[] = $model->attributes;
		    $rows1[$key]['hm'] = $model->hm->name;
		    $rows1[$key]['price'] = $model->defaultPrice(true);
		    $stonekod = $model->stoneInStock;
		    if(!$stonekod){
		    	$stonekod = $model->sizeInStock;
		    }
		    $rows1[$key]['stoneInStock'] = $stonekod;
		    $rows1[$key]['weight'] = substr_replace($model->weight_ap, '', -1, 1);
		    $rows1[$key]['image'] = $model->image;
		    $rows1[$key]['catalog'] = $catalogKKNP;
		}



		$catalogAgra = 12;
		$catalogKKNP = 96;
		$goods = Goods::CategoryGoods($catalogAgra);
		foreach ($goods as $key => $model) {
		    $rows2[] = $model->attributes;
		    $rows2[$key]['hm'] = $model->hm->name;
		    $rows2[$key]['price'] = $model->defaultPrice(true);
		    $stonekod = $model->stoneInStock;
		    if(!$stonekod){
		    	$stonekod = $model->sizeInStock;
		    }
		    $rows2[$key]['stoneInStock'] = $stonekod;
		    $rows2[$key]['weight'] = substr_replace($model->weight_ap, '', -1, 1);
		    $rows2[$key]['image'] = $model->image;
		    $rows2[$key]['catalog'] = $catalogKKNP;
		}

		$rowall = array_merge($rows, $rows1,$rows2);

		

		$a = CJSON::encode($rowall);

		$myCurl = curl_init();
		curl_setopt_array($myCurl, array(
		    CURLOPT_URL => 'http://www.kubachi-kknp.ru/site/sin',
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => http_build_query(array('json'=>$a))
		));
		$response = curl_exec($myCurl);
		curl_close($myCurl);

		echo "Ответ на Ваш запрос: ".$response;

		/*$data = '1111';
		$ch = curl_init( 'http://www.kubachi-kknp.ru/site/test' );
		# Setup request to send json via POST.
		$payload = json_encode( array( "customer"=> $data ) );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		curl_close($ch);
		# Print response.
		echo "<pre>1$result</pre>";*/
	}


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	public function actionGetRobotsFile(){

		if($this->themeId){
			$filename = 'robotsKyba.txt';
		}else{
			$filename = 'robotsAgra.txt';
		}

		$fd=fopen($filename, "r");
		$contents=fread($fd, filesize ($filename));

		/* заменяем переносы строки в файле на тег BR. заменить можно что угодно */
		$contents=str_replace("\r\n","<br>",$contents);
		// закрываем
		fclose ($fd);
		// выводим содержимое
		echo '<pre>';
		print $contents;
		die();

	}


	public function actionSwitch897546(){

	    if(isset($_POST['user'])){
	        $user = User::model()->findByPk($_POST['user']);

	        //$_SESSION[Yii::app()->user->stateKeyPrefix.'__id'] = $user->id;

	        $newIdentity = new UserIdentity( $user->email, 'nopass' );
	        Yii::app()->user->login( $newIdentity );
	        Yii::app()->user->id = $user->id;
	        $this->redirect('/');
	    }

	    echo CHtml::beginForm();
	    echo CHtml::dropDownList('user',false,CHtml::listData(User::model()->findAll(),'id','email'));
	    echo CHtml::submitButton('Авторизироваться');
	    echo CHtml::endForm();
	}


	public function actionSitemap()
	{
		$cache = Yii::app()->cache->get('sitemap'.$this->themeId);

		if(empty($cache)) {
			$sitemap = new Sitemap();
			$sitemap->addItem(new SitemapItem(
				$_SERVER['SERVER_NAME'],
				time(),
				SitemapItem::daily,
				0.7
			));


			$collections = Collection::model()->findAll();
			foreach($collections as $collection)
			{
				$sitemap->addItem(new SitemapItem(
					$_SERVER['SERVER_NAME']."/catalog/group/id/".$collection->id,
					time(),
					SitemapItem::daily,
					0.7
				));
			}


			$groups = Group::model()->findAll();
			foreach($groups as $group)
			{
				$sitemap->addItem(new SitemapItem(
					$_SERVER['SERVER_NAME']."/catalog/groupItem/id/".$group->id,
					time(),
					SitemapItem::daily,
					0.7
				));
			}

			if($this->themeId){
				$goods = Goods::StoreGoodsAR();
			}else{
				$goods = Goods::model()->findAll();
			}
			foreach($goods as $good){
				$sitemap->addItem(new SitemapItem(
					$_SERVER['SERVER_NAME'].$good->createurl,
					SitemapItem::weekly,
					0.7
				));
			}

			if($this->themeId){
				$pages = Page::model()->findAll('theme=1');
			}
			else {
				$pages = Page::model()->findAll('theme=0');
			}
			foreach($pages as $cat){
				$sitemap->addItem(new SitemapItem(
					$_SERVER['SERVER_NAME'].$cat->url,
					time(),
					SitemapItem::weekly,
					0.7
				));
			}

			$cache = $sitemap->generate();
			Yii::app()->cache->set('sitemap'.$this->themeId,$cache,600);
		}
		echo $cache;
	}

	public function actionExport()
	{
		$model = Goodstore::model()->findAll();
		$this->renderPartial('export', array('model'=>$model));
	}



	public function actionError()
	{


		if($error=Yii::app()->errorHandler->error)
		{

			if($error['code']==404)
			{
				$data= "***********************";
				$data.= "\r\n";
				$data.= date("d.m.Y H:i:s");
				$data.= "\r\n";
				$data.= "URL:".Yii::app()->request->url;
				$data.= "\r\n";
				$data.= "UA: ".Yii::app()->request->userAgent;
				$data.= "\r\n";
				$data.= "Referrer: ".Yii::app()->request->urlReferrer;
				$data.= "\r\n";
				$data.= "IP: ".Yii::app()->request->getUserHostAddress();
				$data.= "\r\n";
				$data.= "Browser: ".Yii::app()->request->browser;
				$data.= "\r\n";

				$filename = "404.txt";
				$fh = fopen($filename, "a+");
				fwrite($fh, $data);
				fclose($fh);


			}


			if($_SERVER['SERVER_NAME'] == 'kubachinka.ru'){
				$this->themeId = 1;
				Yii::app()->theme = 'roznica';
			}


			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}


	public function actionSearch()
	{
		$this->render('search');
	}


	public function actionRedirect ()
	{
		$this->redirect("/");
	}


	public function actionPromo ()
	{
		$this->layout ='//layouts/column3';
		$this->render("promo500rub");
	}



	public function actionLogin()
	{
		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				Flash::success('Добро пожаловать!');
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionRegister()
	{

		$model=new User('register');
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			$model->salt = PassHelper::salt();
			$model->hash = PassHelper::hash($model->password,$model->salt);
			if($model->save())
			{
				$login = new LoginForm;
				$login->username = $model->email;
				$login->password = $model->password;
				$login->validate();
				$login->login();

				$mailer           = Yii::app()->mail;
				$mailer->From     = Yii::app()->params['email'];
				$mailer->FromName = Yii::app()->name;
				$mailer->Subject  = "Вы зарегистрированы!";
				$mailer->Body     = "Спасибо за регистрацию!  <br>";
				$mailer->Body.= "<br>Ваш логин (Email): <b>$model->email</b><br>";
				$mailer->Body.= "Ваш пароль: <b>$model->password</b><br>";
				$mailer->AddAddress($model->email);
				$mailer->isHtml(1);
				$mailer->send();

				// $mailer           = Yii::app()->mail;
				// $mailer->From     = Yii::app()->params['email'];
				// $mailer->FromName = Yii::app()->name;
				// $mailer->Subject  = "Зарегистрировался пользователь!";
				// $mailer->Body     = "Вам необходимо проверить учетную запись!<br> ".CHtml::link('Перейти в админку', $this->createAbsoluteUrl('/admin/user/update/id/'.$model->id));
				// $mailer->Body.= "Email: <b>$model->email</b><br>";
				// $mailer->Body.= "ФИО: <b>$model->name</b><br>";

				// $mailer->AddAddress(Yii::app()->params['email']);
				// $mailer->isHtml(1);
				// $mailer->send();


				Flash::success('Вы зарегистрированы!');
				$this->redirect('/');
			}
		}

		$this->render('register',array(
			'model'=>$model,
		));
	}

	public function actionOffice()
	{
		$user_id = Yii::app()->user->id;
		if(!$user_id)
		{
			Flash::error("Но но но!");
			$this->redirect("/login");
			exit;
		}

		$criteria=new CDbCriteria;
		$criteria->condition="user_id = :param";
		$criteria->order = "id DESC";
		$criteria->params=array(
		  ':param' => $user_id,
		  //':user_id' => $user_id,
		);

		$models = Order::model()->findAll($criteria);

		$this->render('office',array(
			'models'=>$models,
		));
	}

	public function actionDiscount()
	{
		$user_id = Yii::app()->user->id;
		if(!$user_id)
		{
			Flash::error("Но но но!");
			$this->redirect("/login");
			exit;
		}
		$userkod = User::getUserKod($user_id);
		$models = UserGoodgroup::getDiscount($userkod);

		$this->render('discount',array(
			'models'=>$models,
		));
	}

	public function actionProfile()
	{
		$user_id = Yii::app()->user->id;
		if(!$user_id)
		{
			Flash::error("Но но но!");
			$this->redirect("/login");
			exit;
		}

		$model = User::model()->findByPk($user_id);
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];

			if($model->password_form)
			{
				$model->salt = PassHelper::salt();
				$model->hash = PassHelper::hash($model->password_form,$model->salt);
			}

			if($model->save())
			{
				Flash::success("Данные сохранены");
				$this->refresh();
			}
		}



		$this->render('profile',array(
			'model'=>$model,
		));
	}

	public function actionReview()
	{
		$criteria= new CDbCriteria;
		$criteria->order = "id DESC";

		$dataProvider=new CActiveDataProvider( Comment, array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>100,
				), ) );

		$this->render( 'review',
			array( 'dataProvider' => $dataProvider )
		);
	}

	public function actionSearchFilter()
	{
		$criteria = new CDbCriteria;

		if ( Yii::app()->request->getParam( 'pFrom', 0 ) )
			$criteria->addCondition( "price>=". (int)Yii::app()->request->getParam( 'pFrom', 0 ) );

		if ( Yii::app()->request->getParam( 'pTo', 0 ) )
			$criteria->addCondition( "price<=".(int)Yii::app()->request->getParam( 'pTo', 0 ) );



		// if($_GET['m'])
		// $ids = 	Yii::app()->db->createCommand()->select('entity')->from('{{item_eav}}')->where("attribute='".$_GET['m']."'")->queryColumn();
		//	$criteria->addInCondition('id',$ids);

		$dataProvider=new CActiveDataProvider( Item, array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>100,
				), ) );

		$this->render( 'searchFilter',
			array( 'dataProvider' => $dataProvider )
		);

	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}




	public function actionCall()
	{


		if($this->themeId == 1){
			$adminEmail = Yii::app()->params->emailKubachinka;
			$name = 'Кубачинка';
		}else{
			$adminEmail = Yii::app()->params->email;
			$name = Yii::app()->name;
		}

		$message = " <b>Имя:</b> ".$_POST['name']."<br>".
					//" <b>Адрес:</b> ".$_POST['address']."<br>".
					//" <b>Email:</b> ".$_POST['email']."<br>".
					" <b>Телефон:</b> ".$_POST['phone']."<br>";
					//" <b>Название компании:</b> ".$_POST['companyName']."<br>".
					//" <b>Чем занимается компания:</b> ".$_POST['aboutCompany'];

		$mailer = Yii::app()->mail;
		$mailer->From = $adminEmail;

		$mailer->AddAddress($adminEmail);
		$mailer->FromName = $name;
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = "Перезвонить";
		$mailer->Body = $message;
		$mailer->isHtml();
		$mailer->Send();
	}


	public function actionVacancycall()
	{
		$message = " <b>Имя:</b> ".$_POST['name']."<br>"." <b>Город/село:</b> ".$_POST['city']."<br>"." <b>Должность:</b> ".$_POST['doljnost']."<br>"." <b>Телефон:</b> ".$_POST['phone']."<br>"." <b>Email:</b> ".$_POST['email']."<br>"." <b>О себе:</b> ".$_POST['about'];
		$mailer = Yii::app()->mail;
		$mailer->From = Yii::app()->params->email;

		$mailer->AddAddress(Yii::app()->params->email);
		$mailer->FromName = Yii::app()->name;
		$mailer->CharSet = 'UTF-8';
		$mailer->Subject = "Резюме с сайта";
		$mailer->Body = $message;
		$mailer->isHtml();
		$mailer->Send();
	}

	public function actionThanks()
	{
		if(md5("1aA1%ы2ъН4"+$_GET['id']) == $_GET['h'])
		{
			$this->render('thanks');
		} else {
			throw new CHttpException(404,'Запрашиваемой страницы не найдено!');
		}
	}

	public function actionTestquery()
	{

	}

	// Изменить пароль
	public function actionChangePassword(){

		$model = new ChangePasForm;
		if (Yii::app()->user->isGuest){
			Flash::error('Вы не авторизованы!');
			$this->redirect("/");
		}
		if ($_POST['ChangePasForm']){
			$model->attributes = $_POST['ChangePasForm'];
			if($model->validate()){
				$user = User::model()->findbyPk(Yii::app()->user->id);

				$user->salt = PassHelper::salt();
				$user->hash = PassHelper::hash($model->password,$user->salt);

				//$user->hash = $user->hashPassword($model->password);
				$user->save(false);
				Flash::success('Пароль успешно изменен!');
				$this->redirect("/profile");
			}
		}

		$this->render('changepassword',array('model'=>$model));
	}

	// Восстановление пароля
	public function actionPassword(){
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id){
			//Flash::error('Вы авторизованы!');
			$this->redirect("/");
		}else{
			$email = ((isset($_GET['email'])) ? $_GET['email'] : '');
			$activkey = ((isset($_GET['activkey']))?$_GET['activkey']:'');

			if ($email&&$activkey){
				$find = User::model()->findByAttributes(array('email'=>$email));

				if(isset($find)&&$find->activkey==$activkey){

					$find->password = $find->generateRandomPassword();
					$find->salt = PassHelper::salt();
					$find->hash = PassHelper::hash($find->password,$find->salt);

					//$find->hash = $find->hashPassword($find->password);
					//$find->recover_password_time = time();
					$find->activkey = "";
					$find->save();

					$subject = "Новый пароль на  ".Yii::app()->name;
					$message = "Ваш логин (email): ".$find->email;
					$message.= "<br>Ваш пароль: ".$find->password;
					User::sendMail($find->email,$subject,$message);
					Yii::app()->user->setFlash('success','Пароль выслан на почту ');

					$this->redirect("/site/login");
				}else{
					Flash::error('Ошибка! Неверная ссылка! Повторите попытку заново');
					$this->redirect("/site/password");

				}
			}else{
				if(isset($_POST['UserRecoveryForm'])){
					$form->attributes=$_POST['UserRecoveryForm'];
					if($form->validate()){
						$user = User::model()->findByPk($form->user_id);
						$user->activkey = md5(uniqid()).sha1(uniqid());
						$user->save(false);
						$activation_url = 'http://' . $_SERVER['HTTP_HOST'].$this->createUrl('site/password',array("activkey" => $user->activkey, "email" => $user->email));

						$subject = Yii::t('ru',"Восстановление пароля на {site_name}",
								array(
									'{site_name}'=>Yii::app()->name,
								));
						$message =Yii::t('ru',"Восстановление пароля на {site_name}. Чтобы получить новый пароль перейдите по ссылке <a href = '{activation_url}'>{activation_url}</a>.",
								array(
									'{site_name}'=>Yii::app()->name,
									'{activation_url}'=>$activation_url,
								));
						User::sendMail($user->email,$subject,$message);
						//Yii::app()->user->setFlash('success','Инструкции отправлены вам на почту');
						Flash::success('Инструкции отправлены вам на почту ');
						$this->refresh();
					}
				}
				$this->render('password',array('form'=>$form));
			}
		}
	}

	public function actionSetDefaultPrice(){
		set_time_limit(0);
		ini_set('memory_limit',"700M");
		$goods = GoodsTest::model()->findAll();
		foreach ($goods as $key => $g) {
			$g->price = str_replace(" ", '', str_replace(".", "", str_replace('р', '', $g->getCalculatedPrice())));
			if(!$g->save(false)){
				print_r($g->errors);
				die();
			}
		}
		echo "Ok";
	}

	public function actionCopyStoneImage(){
		set_time_limit(0);
		ini_set('memory_limit',"700M");
		$stone = StoneImage::model()->findAll();
		foreach ($stone as $k => $s) {
			echo $i++."<br>";
			if(!empty($s->filename)){
				if(file_exists('uploads/'.$s->filename)){
					copy('uploads/'.$s->filename, 'stoneimage/'.$s->filename);
				}
			}
		}
	}
}