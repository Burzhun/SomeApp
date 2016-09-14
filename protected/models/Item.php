<?php


class Item extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

function behaviors() {

	    return array(

		'CTimestampBehavior' => array(
			'class' => 'zii.behaviors.CTimestampBehavior',
			'createAttribute' => 'created',
			'updateAttribute' => 'updated',
		),

    	'ESaveRelatedBehavior' => array(
         'class' => 'application.components.ESaveRelatedBehavior'),
        'eavAttr' => array(
            'class' => 'ext.eav.EEavBehavior',
            // Имя таблицы для аттрибутов (обязательное свойство)
            'tableName' => 'tbl_item_eav',
            // Имя столбца где хранится ид объекта.
            // По умолчанию 'entity'
            'entityField' => 'entity',
            // Имя столбца где хранится имя атрибута.
            // По умолчанию 'attribute'
            'attributeField' => 'attribute',
            // Имя столбца где хранится значение атрибута.
            // По умолчанию 'value'
            'valueField' => 'value',
            // Имя внешнего ключа модели.
            // По умолчанию берется primaryKey из свойста таблицы
            'modelTableFk' => primaryKey,
            // Массив разрешенных атрибутов, если не указано разрешаются любые атрибуты
            // По умолчанию не указано.
            //'safeAttributes' => array(),
            // Префикс для атрибутов. Если для разных моделей используется одна таблица.
            // По умолчанию не указано.
            'attributesPrefix' => '',
        )
    );
}
	public function getCreateUrl()
	{

return $this->catalog->createurl."/".$this->id."-".$this->alias;
	}
	public function getCreateAbsoluteUrl()
	{
return Yii::app()->createAbsoluteUrl('item/index', array('id' => $this->id));
	}	

 

	public function getEndPrice()
	{

		if($this->discount) {
			$discount = $this->discount/100;
			return round($this->price-$this->price*$discount);
		}
		else
			return $this->price;
	}

	public function getFormattedPrice ($discount = true)
	{	

		//return Functions::numberformat($this->endprice);	
		return number_format($this->endprice,2,",","");
	}


		public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])
			$comment->status=0;
		else
			$comment->status=1;

		$comment->object= get_class($this);
		$comment->pk = $this->id;
		
		return $comment->save();
	}


	public function tableName()
	{
		return '{{item}}';
	}

	public function getCustom_Size()
	{
		return 1;
	}

	public function rules()
	{

$re = "~        #delimiter
    ^           # start of input
    -?          # minus, optional
    [0-9]+      # at least one digit
    (           # begin group
        \.      # a dot
        [0-9]+  # at least one digit
    )           # end of group
    ?           # group is optional
    $           # end of input
~xD";
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('name, catalog_id', 'required'),
			array('catalog_id, manufacter_id, price, country_id, position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>9999),
	//		array('', 'match', 'pattern'=> $re, 'message' => 'Ошибка. Введите число с точкой. Пример: <b>3.123</b>'),
			// The following rule is used by search().
			array('in_stock,count,discount,created,updated', 'numerical', 'integerOnly'=>true),
			// Please remove those attributes that should not be searched.
			array('id,alias,year,popular,popular_main,color_id,season_id,inserts,metals, name, article,description, weight, views, catalog_id, manufacter_id, price, country_id, position,seotitle,seokeywords,seodescription,custom_size,hidden,size_id', 'safe'),
		);
	}


	public function relations()
	{

		return array(
		'eav'=>array(self::HAS_MANY, 'ItemEav', 'entity'),
		'country'=>array(self::BELONGS_TO, 'Country', 'country_id'),
		'catalog'=>array(self::BELONGS_TO, 'Catalog', 'catalog_id'),
		'manufacter'=>array(self::BELONGS_TO, 'Manufacter', 'manufacter_id'),
		'images'=>array(self::HAS_MANY, 'ItemImage', 'item_id', 'order' => 'position, id ASC'),
		'sizes'=>array(self::HAS_MANY, 'ItemSize', 'item_id', 'order' => 'size ASC'),
		  'catalogs'=>array(self::MANY_MANY, 'Catalog',
                'tbl_item_catalog(item_id, catalog_id)'),

        'comments' => array(self::HAS_MANY, 'Comment', 'pk',
            'condition'=>'comments.status=1 AND object  LIKE \'Item\'',
            'order'=>'comments.created DESC'),
        'commentCount' => array(self::STAT, 'Comment', 'pk',
            'condition'=>'status=1 AND object  LIKE \'Item\''),
     'size'=>array(self::BELONGS_TO, 'Size', 'size_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название товара',
			'description' => 'Описание',
			'catalog_id' => 'Категория',
			'manufacter_id' => 'Производитель',
			'price' => 'Цена',
			'article' => 'Артикул',
			'country_id' => 'Страна',
			'color_id' => 'Цвет',
			'year' => 'Год',
			'season_id' => 'Сезон',
			'position' => 'Позиция в категории',
			'views' => 'Просмотров товара',
			'weight' => 'Вес',
			'alias' => 'Алиас',
			'seotitle' => 'Заголовок страницы',
			'seokeywords' => 'Ключевые слова',
			'seodescription' => 'Описание (meta)',
			'in_stock' => 'На складе',
			'count' => 'Количество коробок',
			'created' => 'Дата создания',
			'custom_size' => 'Разбивается по размерам',
			'size_id' => 'Размерный ряд',
			'updated' => 'Дата изменения',
			'discount' => 'Скидка %',
			'hidden' => 'Новинка',
			'popular' => 'Популярный',
			'popular_main' => 'На главной',
 
		);
	}

	public static function ImageUpdateInWatermark(){
		if($this->images){
			if(!file_exists($this->watermarkDir.$this->images[0]->image)){
				foreach ($this->images as $data) {
					if(!file_exists($watermarkDir.$data->image)){
						Yii::app()->ih
						    ->load($_SERVER['DOCUMENT_ROOT'].'/'.$data->dir.$data->image)
						    ->watermark($_SERVER['DOCUMENT_ROOT'] . '/img/watermark.png', 10, 10, CImageHandler::CORNER_LEFT_TOP, 0.3)
						    //->thumb(200, 200)
						    ->save($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->image);
					}
				}
			}
		}
	}



	 




	public function getIsHide()
	{
	$hide = ($this->hidden) ? true : false;
		if(Yii::app()->user->seeHidden)
			$hide = false;
	return $hide;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('catalog_id',$this->catalog_id);
		$criteria->compare('manufacter_id',$this->manufacter_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('position',$this->position);
		$criteria->compare('views',$this->views);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('popular',$this->popular);
		$criteria->compare('popular_main',$this->popular_main);
		
		$criteria->compare('in_stock',$this->in_stock);
		$criteria->compare('count',$this->count);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);
		$criteria->compare('discount',$this->discount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
							'pagination'=>array(
												'pageSize'=>100,
											),
		));
	}


	

		protected function afterDelete()
{

parent::afterDelete();
Functions::dbupdate();
ItemMain::model()->deleteAll('item_id='.$this->id);
ItemImage::model()->deleteAll('item_id='.$this->id);
	
}



}