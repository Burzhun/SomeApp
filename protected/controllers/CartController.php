<?php

class CartController extends Controller
{

	public $multiplier = 1;

	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				 'maxLength'=> 3,
				'minLength'=> 2,
			),
		);
	}

	public $layout='//layouts/column2';

	public function actionUpdateAjax()
	{
		print_r($_POST);
		$es = new EditableSaver('Cart');
		$es->update();
	}

	public function actionAdd()
	{
		$good = $_GET['id'];
		$quantity = $_POST['quantity'];
		if(!$quantity)
			$quantity=1;
		$comment = $_POST['comment'];
		$size = $_POST['size'];
		$stone = $_POST['stonekod'];
		$weight = $_POST['weight'];
		$serialkod = $_POST['serialkod'];

		Cart::addToCart($good, $quantity, $comment, $size, $stone, $weight, $serialkod);
		//$all = Cart::getOrderItems();
		echo $this->widget('application.components.CartWidget',array(),true);
		//print_r($_GET);
	}

	public function actionMultyAdd()
	{
		$multyAdd=$_POST;
		foreach ($multyAdd as $key => $value) {
			$multy=explode("|", $value, -1);
				foreach ($multy as $key=>$val) {
					$m=explode(";", $val);
					$good = $m[0];
					$quantity = 1;
					$comment = $_POST['comment'];
					$size = $m[1];
					$stone = $m[2];
					Cart::addToCart($good,$quantity,$comment,$size,$stone);
					$all = Cart::getOrderItems();
				}
			}
		echo $this->widget('application.components.CartWidget',array(),true);
		//print_r($multy);
	}

	public function actionView()
	{
		$sum=$price=0;
		$all = Cart::getOrderItems();


		if(Yii::app()->user->isGuest)
			$model = new Order('orderGuest');
		else
		{
			$user = User::model()->findByPk(Yii::app()->user->id);

			$model = new Order('orderAuth');
			$model->passport = $user->passport;
			$model->transport = $user->transport;
			$model->address = $user->address;
			$model->email = $user->email;
			$model->name = $user->name;
			$model->sname = $user->sname;
			$model->lname = $user->lname;
			$model->region = $user->region;
			$model->phone = $user->phone;
			$model->user_id = $user->id;
		}

		if(Yii::app()->theme->name == 'roznica')
			$model->scenario = 'roznica';


		// Обрабатываем форму входа
		$login = new LoginForm;
		if(isset($_POST['LoginForm']))
		{
			$login->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($login->validate() && $login->login())
				{
					Flash::success('Вход выполнен!');
					$this->refresh();
				}
		}
		// Обработали


		if(isset($_POST['Order']))
		{
			//параметры по умолчанию для всех
			$model->attributes=$_POST['Order'];
			$model->status = "0";
			$model->date = time();
			$model->ip = Functions::getIp();
			$model->user_agent = $_SERVER['HTTP_USER_AGENT'];

			if($model->scenario == "orderAuth")
			{

			}

			$adminEmail = Yii::app()->theme->name == 'roznica' ? 'info@kubachinka.ru' : Yii::app()->params['email'];

			if($model->scenario == "orderGuest")
			{
				//если все верно, email уникальный, capcha
				if($model->validate())
				{
					$newUser=new User('register');
					$newUser->salt = PassHelper::salt();
					$newUser->password=rand(100000,999999);
					$newUser->email=$model->email;
					$newUser->hash = PassHelper::hash($newUser->password,$newUser->salt);
					$newUser->attributes = $model->attributes;

					if($newUser->save())
					{
						$login = new LoginForm;

						$login->username = $newUser->email;
						$login->password = $newUser->password;
						$login->validate();
						$login->login();

						$mailer           = Yii::app()->mail;
						$mailer->From     = $adminEmail;
						$mailer->FromName = Yii::app()->name;
						$mailer->Subject  = "Регистрация";
						$mailer->Body     = "Ваш пароль: $newUser->password";
						$mailer->AddAddress($model->email);
						$mailer->isHtml(1);
						$mailer->send();
					}
					$model->scenario = "orderAuth";
					$model->user_id = $newUser->id;
				}
			}

			if($model->save())
			{
				//уведомляем админа
				$mailer           = Yii::app()->mail;
				$mailer->From     = 'info@agra-gold.ru';
				$mailer->FromName = Yii::app()->name;
				$mailer->Subject  = "Новый заказ";
				$mailer->Body     = $this->renderPartial('message', array('items' => $all, 'order' => $model), true);
				$mailer->AddAddress('agra-gold@mail.ru');
				$mailer->AddAddress('info@kubachinka.ru');
				//$mailer->AddAddress('burjunov@yandex.ru');
				//$mailer->AddAddress("mustafa.urg@yandex.ru");
				$mailer->isHtml(1);
				$mailer->send();
				Cart::makeOrder($model->id);
				OrderManager::create($model->id, $model->manager);

				/*$render = $this->renderPartial('message', array('items' => $all, 'order' => $model), true);
				echo $render;
				die();*/

				Flash::success("Заказ оформлен!");
				$this->redirect(array('site/thanks', 'id'=>$model->id, 'h'=>md5("1aA1%ы2ъН4"+$model->id)));
			}
		}

		$this->render('view',array(
			'login'=>$login,
			'model'=>$all,
			'order'=>$model,
		));
	}

	/*public function actionTest(){
		$all = Cart::model()->findAll('session_id="lkcmpfqbmidtqqv5ri9bns2vl2"');
		$model = Order::model()->findByPk(4);
		$this->renderPartial('message', array('items' => $all, 'order' => $model));
	}*/


	public function actionSuccess()
	{
		$this->render('success',array());
	}

	public function actionAdditem($id)
	{
		$id = $_GET['id'];
		$size = $_GET['size'];
		$stone = $_GET['stone'];
		$serialkod = $_GET['serialkod'];

		Cart::addToCart($id, 1, false, $size, $stone, false, $serialkod);
		$sum = 0;
		$price = 0;

		$all = Cart::getOrderItems();
		foreach ($all as $good)
		{
			$sum+= $good->num;
			$price+=$good->num*$good->price;
		}

		$price*=$this->multiplier;

		$json_cart = $this->widget('application.components.CartWidget', array(), true);

		$array = array(
			'cart' => $json_cart,
			'cart_total' => Functions::numberformat($price),
		);

		echo CJSON::encode($array);
	}

	public function actionDeleteitem($id)
	{
		$id = (int) $_GET['id'];
		$size = $_GET['size'];
		$stone = $_GET['stone'];
		$serialkod = $_GET['serialkod'];

		$cart= Cart::model()->findByPk($id);

		if($cart->num>1)
		{
			$cart->num--;
			$cart->save();
			if($cart->num == 0)
			{
				$cart->delete();
			}
		}
		$sum = 0;
		$price = 0;
		$all = Cart::getOrderItems();

		foreach ($all as $good)
		{
			$sum+= $good->num;
			$price+=$good->num*$good->price;
		}

		$price*=$this->multiplier;

		$json_cart = $this->widget('application.components.CartWidget', array(), true);
		$array = array(
			'cart' => $json_cart,
			'cart_total' => number_format($price,0,""," "),
		);

		echo CJSON::encode($array);
	}

	public function actionDeleteall($id)
	{
		$id = (int)$_GET['id'];
		$cart= Cart::model()->findByPk($id);
		$cart->delete();

		$sum = 0;
		$price = 0;
		$all = Cart::getOrderItems();

		foreach ($all as $good) {
			$sum+= $good->num;
			$price+=$good->num*$good->price;
		}

		$price*=$this->multiplier;

		$json_cart = $this->widget('application.components.CartWidget', array(), true);
		$array = array(
			'cart' => $json_cart,
			'cart_total' => Functions::numberformat($price),
		);

		echo CJSON::encode($array);
	}

	public function actionClear()
	{
		$session=new CHttpSession;
		$session->open();
		$sess = $session->getsessionID();
		Cart::model()->deleteAll(array('condition' => "session_id = '$sess'"));
		$this->redirect(array('cart/view'));
	}
}