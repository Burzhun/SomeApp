<?php

/**
 * This is the model class for table "user_manager".
 *
 * The followings are the available columns in table 'user_manager':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property integer $name
 * @property integer $created
 * @property integer $updated
 * @property integer $admin
 */

class UserManager extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_manager';
	}


	public function rules()
	{
		return array(
			array('sname, user_v8name, manager_v8name, manager_name', 'unsafe'),
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
			'user_v8name' => 'ID пользователя',
			'manager_v8name' => 'ID менеджера',
			'manager_name' => 'Имя менеджера',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_v8name',$this->user_v8name);
		$criteria->compare('manager_v8name',$this->manager_v8name);
		$criteria->compare('manager_name',$this->manager_name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			),
		));
	}


	public static function getList()
	{
		$model = self::model()->findAll(array('order'=>'manager_v8name'));
		$arr = array();
		foreach ($model as $m) {
			$arr["".$m->manager_v8name] = "".$m->manager_name;
		}
		return $arr;
	}
}