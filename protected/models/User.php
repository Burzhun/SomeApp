<?php

class User extends CActiveRecord
{
	public $password;
	public $password_form;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{user}}';
	}

	public function rules()
	{
		return array(
			array('email, password, name, lname, sname', 'required', 'on' => 'register'),
			array('admin', 'unsafe', 'on' => 'register'),
			array('name', 'safe'),
			array('email', 'email'),
			array('email','unique', 'attributeName' => 'email', 'className' => 'User', 'on' => 'register',
				'message' => 'Пользователь с адресом <b>{value}</b> уже существует!'),
			
			array('v8name, email, password, seehidden, password_form, salt, name, created, updated,activkey', 'safe'),

			array('sname, lname, region, phone, type, inn, kpp, name_ur, active, address, passport, transport', 'safe'),

		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Электропочта',
			'password' => 'Пароль',
			'password_form' => 'Новый пароль',
			'salt' => 'Salt',
			'name' => 'Имя',
			'created' => 'Дата',
			'updated' => 'Дата изменения',
			'admin' => 'Администратор',
			'active' => 'Подтвержденный',
			'seehidden' => 'Видит скрытый товар',
			'type' => 'Юридическое лицо',
			'inn' => 'ИНН',
			'kpp' => 'КПП',
			'name_ur' => 'Название',

			'phone' => 'Телефон',
			'address' => 'Адрес доставки',
			'passport' => 'Паспортные данные',
			'transport' => 'Способ доставки',
			'sname' => 'Фамилия',
			'lname' => 'Отчество',
			'region' => 'Регион',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('name',$this->name);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('admin',$this->admin);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			),
		));
	}

	public function beforeSave()
	{
		if ($this->isNewRecord)
			$this->created = time();
		else
			$this->updated = time();

		return parent::beforeSave();
	}

	public function ordercount()
	{
		return count(Order::model()->findAll(array('condition'=>"user_id='".$this->id."'")));
	}

	public static function getUserKod($id){
		$user = User::model()->findByPk($id);
		return $user->v8name;
	}

	public static function minSum()
	{
		if(Yii::app()->user->isGuest)
		{
			return 20000;
		}else{
			$user_id = Yii::app()->user->id;
			$user = User::model()->findByPk($user_id);
			$userordercount = $user->ordercount();

			if($userordercount == 0)
			{
				return 10000;
			}else{
				return 0;
			}
		}

	}

	 public static function SendMail($email,$subject,$message){

        $mailer           = Yii::app()->mail;
		$mailer->From     = Yii::app()->params['email'];
		$mailer->FromName = Yii::app()->name;
		$mailer->Subject  = $subject;
		$mailer->Body     = $message;
		$mailer->AddAddress($email);
		$mailer->isHtml(1);
		//ob_start(); //Буферизация тут нужна только для того чтобы предотвратить вывод в браузер ошибки при отправке почты, так как возникает ошибка при редиректе
		$mailer->send();
		//ob_get_contents(); 	
		//ob_end_clean();
    }

    public function generateRandomPassword(){
		return rand(1000000,9999999);
	}
}