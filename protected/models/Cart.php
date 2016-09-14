<?php

class Cart extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{cart}}';
	}


	public function rules()
	{
		return array(
			array('item_id, session_id, num, date', 'required'),
			array('session_id', 'length', 'max'=>255),
			array('id, item_id, comment, session_id, num, date, weight, serialkod', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'item'=>array(self::BELONGS_TO, 'Goods', 'item_id'),
			'good'=>array(self::BELONGS_TO, 'Goods', 'item_id'),
		);
	}

	/*public function getItem(){
		return Goods::model()->cache()->find('kod=:item_id',array(':item_id'=>$this->item_id));
	}

	public function getGood(){
		return Goods::model()->cache()->find('kod=:item_id',array(':item_id'=>$this->item_id));
	}*/

	public static function addToCart($item_id, $num=1, $comment = false, $size=false, $stone = false, $weight=false, $serialkod = "")
	{
		$session=new CHttpSession;
		$session->open();
		$sess = $session->getsessionID();

		$criteria=new CDbCriteria;
		$criteria->addCondition("`item_id` = '$item_id'");
		if($size)
			$criteria->addCondition("`size` = '$size'");
		if($weight)
			$criteria->addCondition("`weight` = '$weight'");
		if($stone)
			$criteria->addCondition("`stonekod` = '$stone'");

		$criteria->addCondition("`serialkod` = '$serialkod'");

		if(Yii::app()->user->id)
		{
			$criteria->addCondition("`session_id` = '$sess' OR `user_id` = ".Yii::app()->user->id);
		} else {
			$criteria->addCondition("`session_id` = '$sess'");
		}

		$cart = Cart::model()->find($criteria);

		if (count($cart) == 0)
		{
			$add = new Cart;
			$add->item_id = $item_id;
			$add->session_id =$sess;
			$add->user_id = Yii::app()->user->id ? Yii::app()->user->id : 0;
			$add->size = $size;
			$add->stonekod = $stone;
			$add->weight = $weight;
			$add->serialkod = $serialkod;


			if($add->size == "")
				$add->size = $add->good->getDefaultSize()->size;
			if($add->stonekod == "")
				$add->stonekod = $add->good->getDefaultStone()->stonekod;


			$checkStone = $add->good->getDefaultStone()->stonekod != $add->stonekod ? 1 : 0;

			$item = Goods::model()->findByPk($item_id);
			
			if(Yii::app()->theme->name == 'roznica')//если мы на кубачинке
				$add->price = str_replace(" ", "", $item->defaultPrice());//то выводим округленную цену
			else
				$add->price = str_replace(" ", "", $item->getCalculatedPrice(array("stone"=>$add->stonekod,"size"=>$add->size, "forCreateOrder"=>true, "checkStone"=>$checkStone, 'serialkod'=>$add->serialkod)));//иначе выводим точные цены для агры
			
			$add->price = str_replace(",", ".", $add->price);//колдуем для бомбовости
			//echo $add->price;
			$add->num = $num;
			$add->date = time();
			$add->save();
		} else
		{
			if($serialkod)
			{
				$store = Goodstore::model()->find(array('condition' => "serialkod = '".$serialkod."'"));
				if($store->kolvo > $cart->num + $num)
				{
					$cart->user_id = Yii::app()->user->id ? Yii::app()->user->id : 0;
					$cart->num = $cart->num+$num;
					$cart->save();
				} else {
					return false;
				}
			} else {
				$cart->user_id = Yii::app()->user->id ? Yii::app()->user->id : 0;
				$cart->num = $cart->num+$num;
				$cart->save();
			}
		}
	}


	public static function getOrderItems()
	{
		$session=new CHttpSession;
		$session->open();
		$sess = $session->getsessionID();

		if(Yii::app()->user->id)
			$all = Cart::model()->findAll(array('condition' => "session_id = '$sess' OR user_id = ".Yii::app()->user->id, 'order' => 'item_id'));
		else
			$all = Cart::model()->findAll(array('condition' => "session_id = '$sess'", 'order' => 'item_id'));

		return $all;
	}

	public static function deleteOrderItems()
	{
		$session=new CHttpSession;
		$session->open();
		$sess = $session->getsessionID();

		/*if(Yii::app()->user->id)
		{
			Cart::model()->deleteAll("session_id = '$sess' OR user_id = ".Yii::app()->user->id);
		} else {*/
			Cart::model()->deleteAll("session_id = '$sess'");

			if(Yii::app()->user->id){
				Cart::model()->deleteAll("user_id = :id", array(':id' => Yii::app()->user->id));
			}
		//}
	}

	public static function getTotalPrice ()
	{
		$price = 0;
		$all = Cart::getOrderItems();
		foreach ($all as $good) {
			$price+=$good->num*$good->price;
		}
		return $price;
	}

	public static function makeOrder($order_id)
	{
		$all = Cart::getOrderItems();

		foreach($all as $item)
		{
			$orderitem = new OrderItem;
			$orderitem->item_id = $item->item_id;
			$orderitem->size = $item->size;
			$orderitem->stonekod = $item->stonekod;
			$orderitem->num = $item->num;
			$orderitem->comment = $item->comment;
			$orderitem->price = $item->price;
			$orderitem->order_id = $order_id;
			$orderitem->weight = $item->weight;
			$orderitem->serialkod = $item->serialkod;
			$orderitem->save();
		}


		//   переносим в 1с
		$order = new Orders;
		$order->orderdate = new CDbExpression('NOW()');
		$order->goodcount = count($all);
		$order->sum = Cart::getTotalPrice();
		$order->id = $order_id;
		$order->save();

		foreach($all as $item)
		{
			$orderitem = new Ordergood;
			$orderitem->orderkod = $order->kod;
			$orderitem->goodkod = $item->item_id;
			$orderitem->size = $item->size;
			$orderitem->stonetype = $item->stonekod;
			$orderitem->price = $item->price;
			$orderitem->count = $item->num;
			$orderitem->sum =  $item->num * $item->price;
			$orderitem->serialkod = $item->serialkod;
			$orderitem->pricemetal = $item->num * $item->item->getCalculatedPrice(array("stone"=>$item->stonekod, "size"=>$item->size, "forCreateOrder"=>true, "withoutRub"=>true, "getMetalPrice"=>false, "getWorkPrice"=>true, 'serialkod' => $item->serialkod));
			$orderitem->pricework = $item->num * $item->item->getCalculatedPrice(array("stone"=>$item->stonekod, "size"=>$item->size, "forCreateOrder"=>true, "withoutRub"=>true, "getMetalPrice"=>true, 'serialkod' => $item->serialkod));
			$orderitem->save();
		}

		Cart::deleteOrderItems();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'session_id' => 'Session',
			'num' => 'Num',
			'date' => 'Date',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('date',$this->date);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}