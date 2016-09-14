<?php

class ApiController extends Controller
{

	/**
	 * проверяет доступ к апи
	 * @param key string ключ к api
     * @param client string адрес сайта с которого отправлятеся запрос
	 * @return boolean
	 */
	public function checkAccess()
	{

		$key = Yii::app()->request->getParam('key');
		$client = Yii::app()->request->getParam('client');

		$array = array(
			'3aae920197bfd4a83c3354e765e74d6de804022f' => 'kubachi-kknp.ru',
			'4798131dd3eb70103acd143b01a2a4decc27540d' => 'alania-gold.ru',
			'61641025c711db91d24a7bd1494d7582776d772f' => 'silversale.ru',
			'0eb150ca0766106c43b816baf6538c42b35dbba2' => 'kubachinka.ru',
			'8ca06c46b28107b50a5bb33b20e16bac41f6536d' => 'kizasilver.ru',
			'8ca06c46b11107b50a5bb33b20e16bac41f6536d' => 'globalsilver.ru',
			'e5e2a032ace42d17aebea328ac3c2499b08f1b55' => 'jewellight.ru',
		);

		if(!empty($key) && !empty($client))
		{
			if(array_key_exists($key, $array) && $array[$key] == $client)
			{
				return true;
			}
		}
		return false;
	}

	//возможно не используется
	
	public function actionOrder(){
		
		$json = CJSON::decode($_POST['json']);

		$order = new Order('orderGuest');
		$order->name=$json['name'];
		$order->address=$json['address'];
		$order->phone=$json['phone'];
		$order->email=$json['email'];
		$order->info=$json['info'];
		$order->status = "0";
		$order->date = time();
		//$order->save();

		if($order->save(false)){
			foreach ($json['items'] as $data) {
				$orderitem = new OrderItem;
				$orderitem->item_id = $data['kod'];
				$orderitem->size =  $data['size'];
				$orderitem->stonekod = $data['stonekod'];
				$orderitem->num = $data['num'];
				$orderitem->price = $data['price'];
				$orderitem->order_id = $order->id;
				$orderitem->save(false);
			}
		}
	}


/**
 * Возвращает все товары с полной информацией 
 * в формате json
 * @param collections string - id коллекции через запятую (необязательный параметр)
 * @param types string - id коллекции через запятую (необязательный параметр)
 * @param groups string - id коллекции через запятую (необязательный параметр)
 * @return json
 */

	public function actionGetGoods()
	{
		header('Content-Type: application/json');
		if($this->checkAccess())
		{
			$collections = Yii::app()->request->getParam('collections');
			$types = Yii::app()->request->getParam('types');
			$groups = Yii::app()->request->getParam('groups');

			//header('Content-Type: application/xml; charset=utf-8');
			$criteria = new CDbCriteria();

			if($collections)
			{
				$criteria->addInCondition('collection_id', explode(',', $collections), 'AND');
			}
			if($types)
			{
				$criteria->addInCondition('goodtype', explode(',', $types), 'AND');
			}
			if($groups)
			{
				$criteria->addInCondition('groupkod', explode(',', $groups), 'AND');
			}

			$criteria->addCondition('publ=0');
			$goods = Goods::model()->findAll($criteria);// TODO нужно сделать через обычный SQL


			$arr = array();
			$stoneArr = array();
			$arr['count'] = count($goods);
			$arr['goodsblock'] = array();

			foreach ($goods as $good) {
				$arr_good = array();
				$arr_good['kod'] = $good->kod;
				$arr_good['name'] = $good->name;
				$arr_good['article'] = $good->marking;
				$arr_good['hallmark'] = $good->hm->name;
				$arr_good['weight'] = $good->weight_avg;
				$arr_good['price'] = $good->getCalculatedPrice(array('withoutRub'=>1), true);
				$arr_good['collection'] = $good->collection_id;
				$arr_good['group'] = $good->groupkod;
				$arr_good['goodtype'] = $good->goodtype;
				$arr_good['collection'] = $collections[0];
				$arr_good['group'] = $good->group->id;
				
				$arr_good['stoneblock'] = array();
				$goodStones = Goodstone::model()->cache(40000)->findAll(array('condition'=>'goodkod = "'.$good->kod.'" AND can_choose=1'));
				foreach ($goodStones as $goodStone) {
					$arr_good_stone = array();
					$arr_good_stone['stonekod'] = $goodStone->stonekod;
					$arr_good_stone['position'] = $goodStone->numpos;
					$arr_good_stone['count'] = $goodStone->count;
					$arr_good_stone['default'] = $goodStone->default;
					$arr_good_stone['mainstone'] = $goodStone->mainstone;
					$arr_good_stone['price'] = $good->getCalculatedPrice(array('withoutRub'=>1, 'stone' => $goodStone->stonekod, 'checkStone' => 1), true);
					$arr_good['stoneblock'][] = $arr_good_stone;
				}
				//$arr['goodsblock'][] = $arr_good;

				$arr_good['imagesblock'] = array();
				$goodImage = Goodimage::model()->findAll(array('condition'=>'good = "'.$good->kod.'"'));
				foreach ($goodImage as $image) {
					$arr_good_image = array();
					$arr_good_image['filename'] = $image->filename;
					$arr_good['imagesblock'][] = $arr_good_image;
				}

				$arr_good['sizesblock'] = array();
				$goodSize = Goodsize::model()->cache(40000)->findAll(array('condition'=>'goodkod = "'.$good->kod.'"'));
				foreach ($goodSize as $size) {
					$arr_good_size = array();
					$arr_good_size['position'] = $size->numpos;
					$arr_good_size['size'] = $size->size;
					$arr_good_size['default'] = $size->default;
					$arr_good['sizesblock'][] = $arr_good_size;
				}

				$arr_good['storesblock'] = array();
				$goodStore = Goodstore::model()->cache(40000)->findAll(array('condition'=>'goodkod = "'.$good->kod.'"'));
				foreach ($goodStore as $store) {
					$arr_good_store = array();
					$arr_good_store['goodkod'] = $store->goodkod;
					$arr_good_store['goodsize'] = $store->goodsize;
					$arr_good_store['kolvo'] = $store->kolvo;
					$arr_good_store['weight'] = $store->weight;
					$arr_good_store['serialkod'] = $store->serialkod;
					$arr_good_store['stonekod'] = $store->stonekod;
					$arr_good_store['price'] = $store->price;
					$arr_good['storesblock'][] = $arr_good_store;
				}

				$arr['goodsblock'][] = $arr_good;
			}
			echo json_encode($arr);
		} else {
			echo 'Access dined';
		}
	}



/**
 * Возвращает все товары в наличии
 * в формате json
 * @param collections string - id коллекции через запятую (необязательный параметр)
 * @param types string - id коллекции через запятую (необязательный параметр)
 * @param groups string - id коллекции через запятую (необязательный параметр)
 * @return json
 */

	public function actionGetStore()
	{
		if($this->checkAccess())
		{
			$collections = preg_replace('/[^,0-9]/', '', Yii::app()->request->getParam('collections'));
			$types = preg_replace('/[^,0-9]/', '', Yii::app()->request->getParam('types'));
			$groups = preg_replace('/[^,0-9]/', '', Yii::app()->request->getParam('groups'));

			$criteria = new CDbCriteria();
			$cmd = Yii::app()->db;
			$sql = 'SELECT goodkod, goodsize, kolvo, weight, serialkod, goodstore.price, stonekod
					FROM goodstore
					INNER JOIN goods ON goodstore.goodkod = goods.kod
					WHERE 1=1 ';
			
			if($collections)
			{
				$sql .= ' AND goods.collection_id IN ('.$collections.')';
			}
			if($types)
			{
				$sql .= ' AND goods.goodtype IN ('.$types.')';
			}
			if($groups)
			{
				$sql .= ' AND goods.groupkod IN ('.$groups.')';
			}

			$goodstore = $cmd->createCommand($sql)->queryAll();

			$arr = array();
			$arr['count'] = count($goodstore);
			$arr['storeblock'] = array();

			foreach ($goodstore as $goods) {
				$arr_goods = array();
				$arr_goods['goodkod'] = $goods['goodkod'];
				$arr_goods['size'] = $goods['goodsize'];
				$arr_goods['count'] = $goods['kolvo'];
				$arr_goods['weight'] = $goods['weight'];
				$arr_goods['serialkod'] = $goods['serialkod'];
				$arr_goods['price'] = $goods['price'];
				$arr_goods['stonekod'] = $goods['stonekod'];
				$arr['storeblock'][] = $arr_goods;
			}
			echo json_encode($arr);
		} else {
			echo 'Access dined';
		}
	}

/**
 * возвращает все коллекции товаров
 * @return json
 */
	public function actionGetCollections()
	{
		if($this->checkAccess())
		{
			$criteria = new CDbCriteria();

			$collections = Collection::model()->cache(40000)->findAll();
			
			$arr = array();
			$arr['count'] = count($collections);
			$arr['collections'] = array();

			foreach ($collections as $collection) {
				$arr_collection = array();
				$arr_collection['id'] = $collection->id;
				$arr_collection['name'] = $collection->name;
				$arr['collections'][] = $arr_collection;
			}
			echo json_encode($arr);
		} else {
			echo 'Access dined';
		}
	}

/**
 * возвращает все типы товаров
 * @return json
 */
	public function actionGetTypes()
	{
		if($this->checkAccess())
		{
			//header('Content-Type: application/xml; charset=utf-8');
			$criteria = new CDbCriteria();

			$types = Goodtype::model()->cache(40000)->findAll();

			$arr = array();
			$arr['count'] = count($types);
			$arr['types'] = array();

			foreach ($types as $type) {
				$arr_type = array();
				$arr_type['id'] = $type->idgoodtype;
				$arr_type['name'] = $type->name;
				$arr['types'][] = $arr_type;
			}
			
			echo json_encode($arr);
		} else {
			echo 'Access dined';
		}
	}


/**
 * возвращает все группы товаров
 * @return json
 */

	public function actionGetGroups()
	{
		if($this->checkAccess())
		{
			$criteria = new CDbCriteria();

			$groups = Group::model()->cache(40000)->findAll();

			$arr = array();
			$arr['count'] = count($collections);
			$arr['groups'] = array();

			foreach ($groups as $group) {
				$arr_group = array();
				$arr_group['id'] = $group->id;
				$arr_group['collection_id'] = $group->collection_id;
				$arr_group['name'] = $group->name;
				$arr['groups'][] = $arr_group;
			}

			echo json_encode($arr);
		} else {
			echo 'Access dined';
		}
	}


/**
 * возвращает все камни
 * @return json
 */
	public function actionGetStones()
	{
		if($this->checkAccess())
		{
			$criteria = new CDbCriteria();

			$stones = Stone::model()->cache(40000)->findAll();

			$arr = array();
			$arr['count'] = count($stones);
			$arr['stones'] = array();
			foreach ($stones as $stone) {
				$arr_stone = array();
				$arr_stone['kod'] = $stone->kod;
				$arr_stone['name'] = $stone->name;
				$arr_stone['shape'] = $stone->shape;
				$image = StoneImage::model()->cache(40000)->find('stonekod='.$stone->kod);
				$arr_stone['image'] = $image->filename;
				$arr['stones'][] = $arr_stone;
			}

			echo json_encode($arr);
		} else {
			echo 'Access dined';
		}
	}
}