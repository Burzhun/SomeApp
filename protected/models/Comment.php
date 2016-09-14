<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $object
 * @property integer $pk
 * @property integer $created
 * @property integer $updated
 * @property integer $status
 * @property string $phone
 */
class Comment extends CActiveRecord
{

	public function behaviors ()
	{
		return array(
		'CTimestampBehavior' => array(
			'class' => 'zii.behaviors.CTimestampBehavior',
			'createAttribute' => 'created',
			'updateAttribute' => 'updated',
		)
			);
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, comment', 'required'),
			array('pk, created, updated, status', 'numerical', 'integerOnly'=>true),
			array('name, email, object', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, object,comment, pk, created, updated, status, phone,stars', 'safe' ),
		);
	}

public function getItem()
{
if($this->object == "Item")
{
	$model = Item::model()->findByPk($this->pk);
	return CHtml::link($model->name,array('/item/index','id' => $model->id), array('target' => '_blank'));
}
}
 

public function countNew()
{
	$comments=Model::model()->findAll('status=:param', array(':param'=>0)); 
	return count($comments);
}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'product'=>array(self::BELONGS_TO, 'Item', 'pk'),
			'good'=>array(self::BELONGS_TO, 'Item', 'pk'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Имя',
			'email' => 'Email',
			'object' => 'Класс',
			'comment' => 'Комментарий',
			'pk' => 'Ключ',
			'created' => 'Дата создания',
			'updated' => 'Дата обновления',
			'status' => 'Статус',
			'phone' => 'Телефон',
		);
	}


	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('object',$this->object,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('pk',$this->pk);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('status',$this->status);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}