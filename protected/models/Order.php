<?php
 
class Order extends CActiveRecord
{
	public $multiplier=1;
	public $verifyCode;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{order}}';
	}
 
	public function rules()
	{
		return array(
			array('name, phone, email, address', 'required', 'on' => 'roznica'),
			//array('verifyCode', 'captcha', 'message' => "Неверный код с картинки", 'on' => 'orderGuest'),
			array('email','unique', 'attributeName' => 'email', 'className' => 'User', 'on' => 'orderGuest',
				'message' => 'Пользователь с адресом <b>{value}</b> уже существует!'),
			array('name, sname, lname, email, address, phone', 'required', 'message' => "Поле <b>{attribute}</b> необходимо заполнить!", 'on' => 'orderGuest'),
			array('name, sname, lname, address, phone', 'required', 'message' => "Поле <b>{attribute}</b> необходимо заполнить!", 'on' => 'orderAuth'),
			array('email','email'),
			array('date, status', 'numerical', 'integerOnly'=>true),
			array('name,sname,lname,region', 'length', 'max'=>100),
			array('address, email, user_agent', 'length', 'max'=>255),
			array('phone, ip', 'length', 'max'=>15),
			array('info', 'length', 'max'=>999),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, address, passport, user_id, transport', 'safe', 'on' => 'admin'),
			array('id, index, transport, manager', 'safe'),
		);
	}

	public static function statusList ()
	{
		return 	array(
			'Новый',
			'Завершен',
			'Отменен'
		);
	}

	public function getStatusText()
	{
		/*$array = Order::statusList();
		return $array[$this->status];*/
		$orderStatus = $this->orderv8->v8_status;
		$status = V8Status::model()->cache(60000)->find(array("condition"=>"kod='".$orderStatus."'"));
		return $status->name;
	}

	public function getitemlist($more=true)
	{
		$text;
		foreach ($this->orderitems as $orderitem)
		{
			$text.= '<span style="font-size:9px;">';
			
			$text.=CHtml::image(Yii::app()->iwi->load("uploads/".$orderitem->item->images[0]->filename)->resize(100,100)->cache(), "",array('height' => 50, 'width' => 50))."";
			$text.= '<br>'.CHtml::link($orderitem->item->article,$orderitem->item->createurl, array('target' => '_blank', 'style'=>'font-size:9px;'))."&nbsp".$orderitem->price."&nbspруб.";
			if($orderitem->size)
				$text.= '<br>Размер '.$orderitem->size;
			if($orderitem->stonekod)
			{
				$qwer = StoneImage::model()->cache()->find(array("condition"=>"stonekod='".$orderitem->stonekod."'"));
				$text.= '<br>Камень '.'<img src="/uploads/'.$qwer->filename.'" width="15px;">';
			}
			if($orderitem->num)
				$text.= '<br>Кол '.$orderitem->num;
			
			$text.= '</span>';
		}

		if($more)
			$text.= CHtml::link("<br>Подробнее","/admin/orderItem/view/id/$this->id")."";

		return $text;
	}

	public function getitemlistoffice()
	{
		$text = "";
		foreach ($this->orderitems as $orderitem) {
			$text.="<div style= 'float:left; padding: 2px;'>";
			$text.=CHtml::image(Yii::app()->iwi->load("uploads/".$orderitem->item->images[0]->filename)->adaptive(60,60)->cache(), "",array('height' => 60, 'width' => 60))."";
			$text.= "</div>";
			$text.="<div style= 'margin-left:90px;'>";
			$text.= CHtml::link($orderitem->item->name."<br>Артикул: <b>".$orderitem->item->article."</b>",$orderitem->item->createurl, array('target' => '_blank'))."<br>";
			
			if($orderitem->size){
				$text.= "Размер: ".$orderitem->size;
			}
			if($orderitem->stonekod){
				$text.= "<p>Камень:".CHtml::image("/uploads/".StoneImage::model()->find(array('condition'=>"stonekod='".$orderitem->stonekod."'"))->filename,"",array('style'=>'float:right; margin-right:100px; width:20px; height:20px;'))."</p>";
			}
			$orderitemprice = $orderitem->serialkod ? $orderitem->item->getCalculatedPrice(array("serialkod"=>$orderitem->serialkod, "withoutRub"=>true)) : $orderitem->price;
			$text.= "<br>".$orderitem->num."x".$orderitemprice." = <b>".Functions::numberformat($orderitem->num*$orderitemprice)." руб.</b>";
			$text.= "</div>";
			$text.="<div style= 'clear:both; float:none;'>";
			$text.= "<hr>";
			$text.="<div style= 'clear:left;'>";
		}
		return $text;
	}
	
	public function getTotalPrice($format=true)
	{
		$price = 0;

		foreach ($this->orderitems as $orderitem) {
			$orderitemprice = $orderitem->serialkod ? $orderitem->item->getCalculatedPrice(array("serialkod"=>$orderitem->serialkod, "withoutRub"=>true)) : $orderitem->price;
			$price+=$orderitemprice*$orderitem->num;
		}

		$price=	$price*$this->multiplier;
		if($format)
			return Functions::numberformat($price);
		else
			return $price;
	}

	public function relations()
	{
		return array(
			'orderitems'=>array(self::HAS_MANY, 'OrderItem', 'order_id'),
			'orderv8'=>array(self::HAS_ONE, 'Orders', 'id'),
		);
	}

 
	public function attributeLabels()
	{
		return array(
			'id' => 'Номер',
			'date' => 'Дата',
			'status' => 'Статус',
			'name' => 'Имя',
			'address' => 'Адрес',
			'phone' => 'Телефон',
			'index' => 'Индекс',
			'sname' => 'Фамилия',
			'lname' => 'Отчество',
			'region' => 'Регион',
			'info' => 'Комментарий',
			'email' => 'E-mail',
			'passport' => 'Паспортные данные',
			'transport' => 'Способ доставки',
			'ip' => 'IP адрес',
			'verifyCode' => 'Код проверки',
			'user_agent' => 'User Agent',
			'manager' => 'Менеджер',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

		$criteria=new CDbCriteria;
		$criteria->order = "id DESC";
		$criteria->compare('id',$this->id);
		$criteria->compare('date',$this->date);
		$criteria->compare('status',$this->status);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('manager',$this->manager,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,'pagination' => array('pagesize' => 100)
		));
	}

	public function getmanagerName()
	{
		$ordMan = OrderManager::model()->find(array('condition'=>"order_id='".$this->id."'"));
		if($ordMan)
			return UserManager::model()->find(array('condition'=>"manager_v8name = '".$ordMan->manager_v8name."'"))->manager_name;
		else
			return "";
	}
}