<?php


class Category extends CActiveRecord
{
	public $updatePrice;
	public $updatePricePercent;
	public $files;
	public $dir='uploads/category/';
	public $imageValidate;
	

	public function tableName(){
		return '{{category}}';
	}

	public function rules(){

		return array(
			array('name', 'required'),
			array('url','ext.LocoTranslitFilter','translitAttribute'=>'name','setOnEmpty'=>false), 
			array('parent_id, position, discount, main', 'numerical', 'integerOnly'=>true),
			array('name, url, full_url, seokeywords, seotitle, seodescription', 'length', 'max'=>255),
			array('description, updatePrice, updatePricePercent', 'length', 'max'=>9999),
			
			//array('imageValidate', 'EImageValidator','allowEmpty'=>true, 'maxWidth'=>3000, 'maxHeight'=>3000, 'types'=>'jpg,jpeg,gif,png', 'maxSize'   => 3145728),
			//array('files', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png'),
			array('updatePrice, id, name, url, full_url, parent_id, description, seokeywords, seotitle, seodescription, position', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'images'=>array(self::HAS_MANY, 'CategoryImages', 'category_id', 'order' => 'position ASC'),
			'item'=>array(self::HAS_ONE, 'Item', 'category_id'),
			'items'=>array(self::HAS_MANY, 'Item', 'category_id'),
			'extraCategory'=>array(self::HAS_MANY, 'CategoryItem', 'category_id'),
		);
	}

	public function attributeLabels(){
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'url' => 'Url',
			'discount' => 'Скидка(%)',
			'full_url' => 'Полный Url',
			'parent_id' => 'Родитель',
			'description' => 'Описание',
			'main' => 'На главную',
			'seokeywords' => 'Ключевые слова(SEO)',
			'seotitle' => 'Заголовок(SEO)',
			'seodescription' => 'Описание(SEO)',
			'position' => 'Позиция в списке',
		);
	}

	public function search(){
		$this->parent_id = !Yii::app()->request->getParam('pid') ? 0 : Yii::app()->request->getParam('pid');
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('full_url',$this->full_url,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('seokeywords',$this->seokeywords,true);
		$criteria->compare('seotitle',$this->seotitle,true);
		$criteria->compare('seodescription',$this->seodescription,true);
		$criteria->compare('position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
       'pageSize'=>30,),
          
			'sort' => array(
				'defaultOrder' => 'position ASC',
			),
		));
	}


	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	// выборка всех предков
	public function ancestors(){
		$parent_id = $this->parent_id;
		$ancestors = array();
		while ($parent_id != 0){
			$parentCategory = Category::model()->findByPk($parent_id);
			$ancestors[] = $parentCategory;
			$parent_id = $parentCategory->parent_id;
		}
		$an = array_reverse($ancestors);
		return $an;
	}

	// выборка прямых потомков
	public function children(){
		$parent_id = $this->id;
		$children = Category::model()->cache(40000)->findAll('parent_id=:parent', array(':parent'=>$parent_id));
		
		return $children;
	}

	// картинка для категории
	public function getChildrenImage(){
		$parent_id = $this->id;
		$children = Goods::getCategoryGoodAR($parent_id);
		//$children = Goods::model()->cache(40000)->find('category_id=:parent', array(':parent'=>$parent_id));
		if($children->images){
			$image = Yii::app()->iwi->load('uploads/'.$children->images[0]->filename)->resize(250,250)->cache();
		}else{
			$image = '/images/empty.png';
		}
		return $image;
	}

	// выборка корневых
	public function roots(){
		$roots = Category::model()->cache(40000)->findAll('parent_id=0');
		return $roots;
	}

	// хлебные крошки
	public static function getBreadcrumbs($id, $admin = true){

		if($admin){
			$breadcrumbs = array();
			if($id){
				$breadcrumbs['Категории'] = '/admin/category/index';
				$category = self::model()->findByPk($id);
				$categoryes = $category->ancestors();
				if($categoryes){
					foreach ($categoryes as $data) {
						$breadcrumbs[$data->name] = '/admin/category/index?pid='.$data->id;
					}
				}
			}
		}else{
			$breadcrumbs = array();
			if($id){
				$breadcrumbs['Коллекции'] = '/category';
				$category = self::model()->findByPk($id);
				$categoryes = $category->ancestors();
				if($categoryes){
					foreach ($categoryes as $data) {
						$breadcrumbs[$data->name] = $data->full_url;
					}
				}
			}			
		}
		return $breadcrumbs;
	}

	// создание дерева (рекурсивно!)
	public function createTree(&$list, $parent, $level){
	    $tree = array();
	    foreach ($parent as $k=>$l){
	        $l['level'] = $level+1;
	        $l['full_url'] = self::getCategoryCreateUrlModel($l['id']);
	        if(isset($list[$l['id']])){
	            $l['children'] = $this->createTree($list, $list[$l['id']], $l['level']);
	        }
	        $tree[] = $l;
	    } 
	    return $tree;
	}

	// Извлечение дерева категории
	public function Tree(){
		$arr = Yii::app()->db->cache(30000)->createCommand('SELECT id, parent_id, name, url, full_url FROM tbl_category ORDER BY position ASC')
														->queryAll();
		$new = array();
		foreach ($arr as $a){
		    $new[$a['parent_id']][] = $a;
		}
		$parent = Yii::app()->db->cache(30000)->createCommand('SELECT id, parent_id, name, url, full_url FROM tbl_category WHERE parent_id=0  ORDER BY position ASC')
														->queryAll();
		foreach ($parent as $key) {
			$tree = $this->createTree($new, array($key), 0);
			$trees[] = $tree;
		}
		return $trees;
	}

	// полный путь к категории
	public function getCategoryCreateUrl(){
		$url='';
		$parents = $this->ancestors();
		if($parents){
			foreach ($parents as $data) {
				$url = $url.'/'.$data->url;
			}
		}
		if($this){
			$url = $url.'/'.$this->url;
		}
		return Yii::app()->createUrl('category'.$url);
	}

	// полный путь к категории
	public static function getCategoryCreateUrlModel($id){
		$cat = self::model()->findByPk($id);
		$url='';
		$parents = $cat->ancestors();
		if($parents){
			foreach ($parents as $data) {
				$url = $url.'/'.$data->url;
			}
		}
		$cat->full_url = $url;
		$cat->save();
		if($cat){
			$url = $url.'/'.$cat->url;
		}
		return Yii::app()->createUrl('category'.$url);
	}

	public static function getCategoryByFullUrl($full_url){
		return Category::model()->find('full_url=:full_url',array(':full_url'=>$full_url));
	}

	public static function getCategoryList(){
		return CHtml::ListData(Category::model()->findAll(),'id','name');
	}

	/*public function updateChieldsFullUrl(){
		$cats = array_filter(explode(',',$this->chields));

		if($cats){
			foreach ($cats as $data) {
				$category = Category::model()->findByPk($data);
				$category->full_url = $category->getCategoryCreateUrl();
				$category->save();
			}
		}
	}*/

	public static function listData(){
	    return CHtml::listData(self::model()->findAll(), 'id', 'name');
	}

	protected function beforeSave(){
		//$this->updateChieldsFullUrl();
		if(parent::beforeSave() === false) {
		    return false;
		}
		$this->full_url = $this->getCategoryCreateUrl();
		return true;
	}

	// сохранение изображении товара
	public function saveCategoryImages(){

		$files=CUploadedFile::getInstancesByName('files');
		if($files){
			foreach ($files as $file) {
				$name = md5(mt_rand()+time()).'.'.$file->extensionName;
				$this->imageValidate = $file;
				if($this->validate()){
					$file->saveAs($this->dir.$name);
					$itemImage = new CategoryImages;
					$itemImage->category_id = $this->id;
					$itemImage->image = $name;
					$itemImage->save();
				}else{
					$error = true;
				}
			}
		}

		if($error){
			return false;			
		}else{
			return true;
		}
	}

	/*protected function afterSave(){
		parent::afterSave();
		$this->full_url = '1s';//Category::getCategoryCreateUrl($this->id);
		$this->save(false);
	}*/

	protected function afterDelete(){
		CategoryImages::model()->deleteAllImages($this->id);
		return parent::afterDelete();
	}
}
