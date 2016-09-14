<?php

/**
 * This is the model class for table "goods".
 *
 * The followings are the available columns in table 'goods':
 * @property string $kod
 * @property string $name
 * @property string $marking
 * @property string $hallmark
 * @property string $goodtype
 * @property string $measure
 * @property double $weight_avg
 * @property double $weight_wp
 * @property double $weight_wm
 * @property double $weight_ap
 * @property double $weight_bh
 * @property integer $vellum1
 * @property integer $vellum2
 * @property integer $vellum3
 * @property integer $usevellum
 * @property double $vellummaking_ag
 * @property double $moulding_ag
 * @property double $halmarking_ag
 * @property double $beforehallmarking_ag
 * @property double $polishing_ag
 * @property double $rhodiumplating_w_ag
 * @property double $vellummaking_au
 * @property double $vellumalloying_au
 * @property double $moulding_au
 * @property double $moulding_otk_au
 * @property double $beforehallmarking_au
 * @property double $hallmarkingtransport_au
 * @property double $rent_au
 * @property double $hallmarking_au
 * @property double $polishing_au
 * @property double $rhodiumplating_m_au
 * @property double $rhodiumplating_w_au
 * @property double $item_otk_au
 * @property double $waste_au
 */
class Goods extends CActiveRecord
{

	public $categoryId; // категория товара(используется для сайта Кубачинка)
	public $primaryKey  = array( 'kod' );
	static $noveltiLeftTime = 15465600;//6 месяцев     6*2592000-60*60*24*1



	public function primaryKey()
	{
		return array('kod');
	}

	public function getFullName(){
		$info = ItemInfo::model()->find('item_id=:id',array(':id'=>$this->kod));
		if($info->name){
			$name = $info->name;
		}else{
			$name = $this->name;
		}
		return $name;
	}

	public function getFullDescription(){
		$info = ItemInfo::model()->find('item_id=:id',array(':id'=>$this->kod));
		if($info->description){
			$description = $info->description;
		}else{
			$description = $this->description_main;
		}
		return $description;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getcreateUrl(){
		return Yii::app()->controller->createUrl('goods/view', array('kod' => trim($this->kod),'alias'=>Functions::makeUrl($this->fullName)));
	}

	public function getCreateAbsoluteUrl()
	{
		return Yii::app()->controller->createUrl('goods/view', array('kod' => $this->kod));
	}

	public function tableName()
	{
		return 'goods';
	}

	public function getId()
	{
		return $this->kod;
	}
	public function getArticle()
	{
		return $this->marking;
	}

	/**
	*
	*	$forCreateOrder - используется при создании суммы в заказе
	*	$withoutRub - используется при создании цены за комплект внутри товара, снизу
	*
	**/
	//public function getCalculatedPrice($stone = 0, $size = 0, $forCreateOrder = false, $withoutRub = false, $getMetalPrice = false, $getWorkPrice = false, $checkStone = 0)
	public function getCalculatedPrice($_params = array(), $api = false)
	{
		$weight = !empty($_params['weight']) ? $_params['weight'] : 0;
		$stone = !empty($_params['stone']) ? $_params['stone'] : 0;
		$size = !empty($_params['size']) ? $_params['size'] : 0;
		$forCreateOrder = $_params['forCreateOrder'] ? $_params['forCreateOrder'] : false;
		$withoutRub = $_params['withoutRub'] ? $_params['withoutRub'] : false;
		$getMetalPrice = $_params['getMetalPrice'] ? $_params['getMetalPrice'] : false;
		$getWorkPrice = $_params['getWorkPrice'] ? $_params['getWorkPrice'] : false;
		$checkStone = $_params['checkStone'] ? $_params['checkStone'] : 0;
		$serialkod = $_params['serialkod'] ? $_params['serialkod'] : 0;
		$isGuest = Yii::app()->user->isGuest ? "" : Yii::app()->user->id;

		$cache_id = "getCalculatedPrice".$this->id.$isGuest.$weight.$stone.$size.$forCreateOrder.($withoutRub ? 0 : 1).$getMetalPrice.$getWorkPrice.$checkStone.$serialkod;
		$return=Yii::app()->cache->get($cache_id);
		if($return===false)
		{
			$vellummaking = 0;
			$vellumalloying = 0;
			$sizemarkup = 0;
			$moulding = 0;
			$moulding_otk = 0;
			$beforehallmarking = 0;
			$hallmarking_transport = 0;
			$hallmarking = 0;
			$polishing = 0;
			$rhodium_good = 0;
			$rhodium_work = 0;
			$waste = 0;
			$equipment = 0;
			$metal = 0;
			$stones = 0;
			$profitability = 0;
			$otk_item = 0;
			$price = 0;

			$velluminstall = 0;
			$iteminstall = 0;
			$stone1 = 0;
			$stone11 = 0;
			$stone12 = 0;
			$stone2 = 0;
			$stone21 = 0;
			$stone22 = 0;

			$pricemetal = 0;
			$pricework = 0;

			//=====================Входящие переменные==================
			// $goodkod = "0000335";
			// $goodcount = 1;
			// $goodsize = 15.5;
			// $stonename = "";
			//==========================================================

			//=====================Входящие переменные==================
			$goodkod = $this->kod;
			$goodcount = 1;
			//==========================================================


			if($stone==0)
			{
				$stone = $this->getDefaultStone();
				$stonename = $stone->name;
				$stone = $stone->stonekod;

			}
			else
			{
				//$stone=Stone::model()->findByPk($stone);
				$stonename = $stone->name;
			}

			if(!$size==0)
			{
				$goodsize = $size;
			}
			else
			{
				$sizeModel = $this->getDefaultSize();
				$goodsize = $sizeModel->size;
			}


			$con = mysql_connect("localhost","agra_dbu","AopXjSGhx3y");
			mysql_select_db("agra_db");
			/*$sqlgood = mysql_query("select * from goods where kod = '".$goodkod."'");
			$sqlGoodRow = mysql_fetch_assoc($sqlgood);*/
			$sqlGoodRow = Yii::app()->db->cache(100000)->createCommand()
							->from('goods')
							->where('kod=:goodkod', array(':goodkod'=>$goodkod))
							->queryRow();


			//$sqlsizes = mysql_query("select * from goodsize where goodkod = '".$goodkod."'");
			$sqlsizes = Yii::app()->db->cache(100000)->createCommand()
							->from('goodsize')
							->where('goodkod=:goodkod', array(':goodkod'=>$goodkod))
							->queryAll();
			$countsizes = count($sqlsizes);


			//$sql = mysql_query("select hm.name from hallmark hm left join goods g on hm.kod = g.hallmark where g.kod = '".$goodkod."'");
			$sql = "select hm.name, hm.price_gr from hallmark hm left join goods g on hm.kod = g.hallmark where g.kod = '".$goodkod."'";
			///$sqlRow = mysql_fetch_assoc($sql);
			//$hallmarkname = mysql_result($sql,0,name);
			$sqlRow = Yii::app()->db->cache(100000)->createCommand($sql)->queryRow();
			$hallmarkname = $sqlRow['name'];

			$pos = strpos($hallmarkname, "Ag");
			if($pos == true)
			{
				$works = Work::model()->cache(200000)->findAll();
				foreach ($works as $work) {
					switch($work->kod)
					{
						case "000000003":	$vellumalloying = $work->value;
											break;
						case "000000004":	$sizemarkup = $work->value;
											break;
						case "000000006":	$moulding_otk = $work->value;
											break;
						case "000000008":	$hallmarking_transport = $work->value;
											break;
						case "000000012":	$rhodium_good = $work->value;
											break;
						case "000000014":	$otk_item = $work->value;
											break;
						case "000000015":	$waste = $work->value;
											break;
						case "000000016":	$profitability = $work->value;
											break;
						case "000000017":	$equipment = $work->value;
											break;
					}
				}

				/*$vellumalloying = mysql_result(mysql_query("select * from work where kod = '000000003'"),0,value);
				$sizemarkup = mysql_result(mysql_query("select * from work where kod = '000000004'"),0,value);
				$moulding_otk = mysql_result(mysql_query("select * from work where kod = '000000006'"),0,value);
				$hallmarking_transport = mysql_result(mysql_query("select * from work where kod = '000000008'"),0,value);
				$rhodium_good = mysql_result(mysql_query("select * from work where kod = '000000012'"),0,value);
				$otk_item =  mysql_result(mysql_query("select * from work where kod = '000000014'"),0,value);
				$waste = mysql_result(mysql_query("select * from work where kod = '000000015'"),0,value);
				$profitability = mysql_result(mysql_query("select * from work where kod = '000000016'"),0,value);
				$equipment = mysql_result(mysql_query("select * from work where kod = '000000017'"),0,value);*/

				$vellummaking = $sqlGoodRow['vellummaking_ag'];
				$moulding = $sqlGoodRow['moulding_ag'];
				$beforehallmarking = $sqlGoodRow['beforehallmarking_ag'];
				$rhodium_work = $sqlGoodRow['rhodiumplating_w_ag'];
				$hallmarking = $sqlGoodRow['halmarking_ag'];
				$polishing = $sqlGoodRow['polishing_ag'];
			}
			$pos1 = strpos($hallmarkname, "Au");

			if($pos1 == true)
			{
				$works = Work::model()->cache(200000)->findAll();
				foreach ($works as $work) {
					switch($work->kod)
					{
						case "000000004":	$sizemarkup = $work->value;
											break;
						case "000000017":	$equipment = $work->value;
											break;
					}
				}

				/*$sizemarkup = mysql_result(mysql_query("select * from work where kod = '000000004'"),0,value);
				$equipment = mysql_result(mysql_query("select * from work where kod = '000000017'"),0,value);*/

				$vellumalloying = $sqlGoodRow['vellumalloying_au'];
				$moulding_otk = $sqlGoodRow['moulding_otk_au'];
				$hallmarking_transport = $sqlGoodRow['hallmarkingtransport_au'];
				$rhodium_good = $sqlGoodRow['rhodiumplating_m_au'];
				$otk_item = $sqlGoodRow['item_otk_au'];
				$waste = $sqlGoodRow['waste_au'];
				$profitability = $sqlGoodRow['rent_au'];

				$vellummaking = $sqlGoodRow['vellummaking_au'];
				$moulding = $sqlGoodRow['moulding_au'];
				$beforehallmarking = $sqlGoodRow['beforehallmarking_au'];
				$rhodium_work = $sqlGoodRow['rhodiumplating_w_au'];
				$hallmarking = $sqlGoodRow['hallmarking_au'];
				$polishing = $sqlGoodRow['polishing_au'];
			}
// die();
			$vellummaking = $vellummaking * $sqlGoodRow['vellum1'];

			if($sqlGoodRow['usevellum'] == 1)
			{
				$vellumalloying = $vellumalloying * $goodcount;
			}
			else
			{
				$vellumalloying = 0;
			}

			if($countsizes > 0)
			{
				if($sqlGoodRow['goodtype'] == "3")
				{
					for($i=0;$i<$countsizes;$i++)
					{
						if(/*mysql_result($sqlsizes, $i, "default")*/$sqlsizes[$i]['default'] == 1)
						{
							$sqlgoodsize = /*mysql_result($sqlsizes, $i, size)*/$sqlsizes[$i]['size'];
							if($sqlgoodsize != $goodsize)
							{
								$sizemarkup = $sizemarkup;
							}
							else
							{
								$sizemarkup = 0;
							}
						}
					}
				}
			}
			else
			{
				$sizemarkup = 0;
			}

			$moulding = $moulding * $sqlGoodRow['weight_avg'];
			$moulding_otk = $moulding_otk * ($sqlGoodRow['weight_wp']-$sqlGoodRow['weight_wm']);
			$beforehallmarking = $beforehallmarking * $sqlGoodRow['weight_bh'];
			$hallmarking_transport = $hallmarking_transport * $sqlGoodRow['weight_avg'];
			$hallmarking = $hallmarking * $goodcount;
			$polishing = $polishing * $sqlGoodRow['weight_ap'];
			$rhodium_good = $rhodium_good * $sqlGoodRow['weight_ap'];
			$rhodium_work = $rhodium_work * $sqlGoodRow['weight_ap'];
			$waste = ($waste * 1.05) * $sqlGoodRow['weight_ap'];
			$equipment = $equipment * $sqlGoodRow['weight_ap'];
			$metal = ($sqlGoodRow['weight_wp']-$sqlGoodRow['weight_wm'])*$sqlRow['price_gr'];
			//$sqlstones = mysql_query("select * from goodstone where goodkod = '".$goodkod."'");
			$sqlStonesRow = Goodstone::model()->cache(100000)->findAll(array('condition'=>"goodkod = '".$goodkod."'"));//mysql_fetch_assoc($sqlstones);
			$countstones = count($sqlStonesRow);


			for($i=0;$i<$countstones;$i++)
			{
				$stoneForCilc = Stone::model()->cache(100000)->find(array('condition'=>"kod='".$sqlStonesRow[$i]['stonekod']."'"));
				if(!$sqlStonesRow[$i]['can_choose'] == 1)
				{
					if($pos == true)
					{
						$velluminstall = $stoneForCilc->price1;
						$iteminstall = $stoneForCilc->price2;
					}

					if($pos1 == true)
					{
						$velluminstall = $stoneForCilc->price3;
						$iteminstall = $stoneForCilc->price4;
					}

					$stone1 = $stone1 + ($stoneForCilc->cost * $sqlStonesRow[$i]['count']);
					$stone11 = $stone11 + ($velluminstall * $sqlStonesRow[$i]['count']);
					$stone12 = $stone12 + ($iteminstall * $sqlStonesRow[$i]['count']);
				}


				if($checkStone == 0)
				{
					//echo "check =0";
					if(($sqlStonesRow[$i]['can_choose'] == 1)&&(($sqlStonesRow[$i]['default'] == 1)))
					//&&($sqlStonesRow[$i]['stonekod'] == (mysql_result(mysql_query("select kod from stone where name = '".$stonename."'"),0,kod))))
					{
						if($pos == true)
						{
							$velluminstall = $stoneForCilc->price1;
							$iteminstall = $stoneForCilc->price2;
						}
						if($pos1 == true)
						{
							$velluminstall = $stoneForCilc->price3;
							$iteminstall = $stoneForCilc->price4;
						}

						$stone2 = $stone2 + ($stoneForCilc->cost * $sqlStonesRow[$i]['count']);
						$stone21 = $stone21 + ($velluminstall * $sqlStonesRow[$i]['count']);
						$stone22 = $stone22 + ($iteminstall * $sqlStonesRow[$i]['count']);
					}
				}

				if($checkStone == 1)
				{
					//echo "<br>";
					//echo "check = 1";
					if(($sqlStonesRow[$i]['can_choose'] == 1)&&($sqlStonesRow[$i]['stonekod'] == $stone))
					//(mysql_result(mysql_query("select kod from stone where name = '".$stonename."'"),0,kod))))
					{
						if($pos == true)
						{
							$velluminstall = $stoneForCilc->price1;
							$iteminstall = $stoneForCilc->price2;
						}
						if($pos1 == true)
						{
							$velluminstall = $stoneForCilc->price3;
							$iteminstall = $stoneForCilc->price4;
						}

						$stone2 = $stone2 + ($stoneForCilc->cost * $sqlStonesRow[$i]['count']);
						$stone21 = $stone21 + ($velluminstall * $sqlStonesRow[$i]['count']);
						$stone22 = $stone22 + ($iteminstall * $sqlStonesRow[$i]['count']);
					}
				}
			}

			$stones = $stone1+$stone2+$stone11+$stone12+$stone21+$stone22;

			$price =
			$vellummaking +
			$vellumalloying +
			$sizemarkup +
			$moulding +
			$moulding_otk +
			$beforehallmarking +
			$hallmarking_transport +
			$hallmarking +
			$polishing +
			$rhodium_good +
			$rhodium_work +
			$waste +
			$equipment +
			$metal +
			$stones;

			$pricemetal = $metal;
			$pricework = $vellummaking +
			$vellumalloying +
			$moulding +
			$moulding_otk +
			$beforehallmarking +
			$hallmarking_transport +
			$hallmarking +
			$polishing +
			$rhodium_good +
			$rhodium_work;

			$price = $price + ($otk_item*$sqlGoodRow['weight_ap']);
			$price = $price * (($profitability/100)+1);

			$userid = Yii::app()->user->id;


			//$user = mysql_result(mysql_query("select * from tbl_user where id = ".$userid), 0, v8name);
			$user = User::model()->cache(100000)->findByPk($userid)->v8name;

			$userdiscount = 0;
			if(Yii::app()->theme->name != 'roznica'){

				if($user != "")
				{
					if($sqlGoodRow['groupkod'] != "")
					{
						$userdiscount = UserGoodgroup::model()->cache(100000)->find(array('condition' => "userkod  = '".$user."' and groupkod = '".$sqlGoodRow['groupkod']."'"))->discount;
					}
				}
			}

				$price = $price - (($price/100)*$userdiscount);

				if($getMetalPrice == false && $getWorkPrice == false)
				{
					$price = $price;
				}elseif($getMetalPrice)
				{
					$price = $pricemetal;
				}elseif($getWorkPrice)
				{
					$price = $pricework;
				}

				$goodstorePrice = 0;
				if($serialkod)
				{
					$goodstorePrice = Goodstore::model()->cache(100000)->find(array('condition'=>"serialkod = '".$serialkod."'"))->price;;
					$price = $goodstorePrice - (($goodstorePrice/100)*$userdiscount);
				}


			//если нам необходимо вывести цену без слова р.
			if($withoutRub)
			{
				$return = number_format($price,0,',','');
			} else {
				$return = number_format($price,0,',',' ')." р.";
			}

			Yii::app()->cache->set($cache_id, $return, 100000);
		}

		if($this->groupkod == '000000006')
			$return = '0';


		if($api){
			return $return;
		}

		/*if(Yii::app()->user->isGuest && Yii::app()->controller->themeId != 1){
			return '';
		}*/
		return $return;
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
		return number_format($this->endprice,2,',',' ');
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kod, name, marking, hallmark, goodtype, measure, weight_avg, weight_wp, weight_wm, weight_ap, weight_bh, vellum1, vellum2, vellum3, usevellum, vellummaking_ag, moulding_ag, halmarking_ag, beforehallmarking_ag, polishing_ag, rhodiumplating_w_ag, vellummaking_au, vellumalloying_au, moulding_au, moulding_otk_au, beforehallmarking_au, hallmarkingtransport_au, rent_au, hallmarking_au, polishing_au, rhodiumplating_m_au, rhodiumplating_w_au, item_otk_au, waste_au', 'required'),
			array('vellum1, vellum2, vellum3, usevellum', 'numerical', 'integerOnly'=>true),
			array('weight_avg, weight_wp, weight_wm, weight_ap, weight_bh, vellummaking_ag, moulding_ag, halmarking_ag, beforehallmarking_ag, polishing_ag, rhodiumplating_w_ag, vellummaking_au, vellumalloying_au, moulding_au, moulding_otk_au, beforehallmarking_au, hallmarkingtransport_au, rent_au, hallmarking_au, polishing_au, rhodiumplating_m_au, rhodiumplating_w_au, item_otk_au, waste_au', 'numerical'),
			array('kod, hallmark, goodtype, stonekods', 'length', 'max'=>13),
			array('name, categoryId', 'length', 'max'=>250),
			array('marking', 'length', 'max'=>25),
			array('measure', 'length', 'max'=>10),
			array('categoryId','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kod, name, name_full, marking, hallmark, goodtype, measure, weight_avg, weight_wp, weight_wm, weight_ap, weight_bh, vellum1, vellum2, vellum3, usevellum, vellummaking_ag, moulding_ag, halmarking_ag, beforehallmarking_ag, polishing_ag, rhodiumplating_w_ag, vellummaking_au, vellumalloying_au, moulding_au, moulding_otk_au, beforehallmarking_au, hallmarkingtransport_au, rent_au, hallmarking_au, polishing_au, rhodiumplating_m_au, rhodiumplating_w_au, item_otk_au, waste_au', 'safe', 'on'=>'search'),
			array('name_full, main, description, description_main', 'safe'),
		);
	}

	public static function CategoryGoodsIDK($categoryId){
		$goods = Yii::app()->db->createCommand()
				->select('kod')
				//->from('goodstore t')
				->from('goods t')
				->rightjoin('tbl_category_item ci', 'ci.item_id=t.marking')
				->where('ci.category_id=:catid',array(':catid'=>$categoryId))
				->queryColumn();

		return $goods;
	}

	public static function CategoryGoods($categoryId){
		$ids = self::CategoryGoodsIDK($categoryId);

		$criteria = new CDbCriteria;
		$criteria->join = 'RIGHT JOIN goodstore gs ON gs.goodkod = t.kod ';
		$criteria->join .= 'JOIN goodimage gi ON gi.good = t.kod';
		$criteria->addCondition('gi.filename <> ""');
		$criteria->distinct = true;
		$criteria->addInCondition('kod',$ids);

		$goods = self::model()->findAll($criteria);

		return $goods;
	}

	/*public function getTableSchema()
	{
	  $table = parent::getTableSchema();

	  $table->columns['kod']->isForeignKey = true;
	  $table->foreignKeys['kod'] = array('Goodgroup', 'groupkod');

	  return $table;
	}*/

	public function getTableSchema()
	{
	  $table = parent::getTableSchema();

	  $table->columns['groupkod']->isForeignKey = true;
	  $table->foreignKeys['groupkod'] = array('Goods', 'kod');

	  $table->columns['kod']->isForeignKey = true;
	  $table->foreignKeys['kod'] = array('Goodgroup', 'groupkod');

	  return $table;
	}

	/*public function getTableSchema()
	{
	  $table = parent::getTableSchema();

	  $table->columns['kod']->isForeignKey = true;
	  $table->foreignKeys['kod'] = array('Goodimage', 'good');

	  return $table;
	}

	public function getTableSchema()
	{
	  $table = parent::getTableSchema();

	  $table->columns['good']->isForeignKey = true;
	  $table->foreignKeys['good'] = array('Goods', 'kod');

	  return $table;
	}*/

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catalog'=>array(self::BELONGS_TO, 'Goodtype', 'goodtype'),
			'goodgroup'=>array(self::BELONGS_TO, 'Goodgroup', 'groupkod'),
			'hm'=>array(self::BELONGS_TO, 'Hallmark', 'hallmark'),
			'images'=>array(self::HAS_MANY, 'Goodimage', 'good', 'order'=>'position'),
			'viewedGood'=>array(self::HAS_ONE, 'Viewed', 'product'),
			'goodstore'=>array(self::BELONGS_TO, 'Goodstore', 'goodkod'),
			'goodsiteminfo'=>array(self::HAS_ONE, 'ItemInfo', 'item_id'),
			//'group'=>array(self::BELONGS_TO, 'GroupItem', 'kod'),
			//'goodCategory'=>array(self::BELONGS_TO, 'Category', 'item_id'),
		);
	}

	public function getGroup(){
		$groupitem = GroupItem::model()->find('item_id=:kod', array(':kod'=>$this->kod));
		return $groupitem->parent;
	}

	public function getImage()
	{
		//$goodImages = Goodimage::model()->findAll('good=:kod',array(':kod'=>$this->kod));

		if($images = $this->cache(100000)->images) {
		//if($images = $goodImages) {

		$image = $images[0];
		if($image)
			return $image->filename;
		}
		else
			return "null.png";
	}


	public function getStoneKods()
	{
		$pks = Yii::app()->db->createCommand()->select('stonekod')->from('goodstone')->where('goodkod='.$this->kod)->queryColumn();
		return $pks;
	}

	public function getStones()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("goodkod = '".$this->kod."' AND can_choose=1");
		//$criteria->addInCondition('stonekod',$this->getStoneKods());
		$criteria->order = "numpos ASC";
		return Goodstone::model()->cache(100000)->findAll($criteria);
	}

	public function getDefaultStone()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("goodkod = '".$this->kod."' AND `default` = '1'");
		return Goodstone::model()->cache(100000)->find($criteria);
	}

	public function getDefaultSize()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("`goodkod` = '".$this->kod."' AND `default` = 1");
		$criteria->order = "numpos ASC";
		return Goodsize::model()->cache(100000)->find($criteria);
	}

	public function getSizes()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("goodkod = '".$this->kod."'");
		$criteria->order = "numpos ASC";
		return Goodsize::model()->cache(100000)->findAll($criteria);
	}


	public function attributeLabels()
	{
		return array(
			'kod' => 'Id',
			'name' => 'Name',
			'name_full' => 'Полное название',
			'marking' => 'Акртикул',
			'hallmark' => 'Hallmark',
			'goodtype' => 'Goodtype',
			'measure' => 'Measure',
			'weight_avg' => 'Weight Avg',
			'weight_wp' => 'Weight Wp',
			'weight_wm' => 'Weight Wm',
			'weight_ap' => 'Weight Ap',
			'weight_bh' => 'Weight Bh',
			'vellum1' => 'Vellum1',
			'vellum2' => 'Vellum2',
			'vellum3' => 'Vellum3',
			'usevellum' => 'Usevellum',
			'vellummaking_ag' => 'Vellummaking Ag',
			'moulding_ag' => 'Moulding Ag',
			'halmarking_ag' => 'Halmarking Ag',
			'beforehallmarking_ag' => 'Beforehallmarking Ag',
			'polishing_ag' => 'Polishing Ag',
			'rhodiumplating_w_ag' => 'Rhodiumplating W Ag',
			'vellummaking_au' => 'Vellummaking Au',
			'vellumalloying_au' => 'Vellumalloying Au',
			'moulding_au' => 'Moulding Au',
			'moulding_otk_au' => 'Moulding Otk Au',
			'beforehallmarking_au' => 'Beforehallmarking Au',
			'hallmarkingtransport_au' => 'Hallmarkingtransport Au',
			'rent_au' => 'Rent Au',
			'hallmarking_au' => 'Hallmarking Au',
			'polishing_au' => 'Polishing Au',
			'rhodiumplating_m_au' => 'Rhodiumplating M Au',
			'rhodiumplating_w_au' => 'Rhodiumplating W Au',
			'item_otk_au' => 'Item Otk Au',
			'waste_au' => 'Waste Au',
			'main' => 'На главную',
			'description_main' => 'Описание',
			'categoryId' => 'Категория',
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

		if(Yii::app()->controller->themeId == 1){
			$criteria->join  = 'INNER JOIN goodstore gs ON gs.goodkod = t.kod';
		}

		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_full',$this->name_full,true);
		$criteria->compare('marking',$this->marking,true);
		$criteria->compare('hallmark',$this->hallmark,true);
		$criteria->compare('goodtype',$this->goodtype,true);
		$criteria->compare('measure',$this->measure,true);
		$criteria->compare('weight_avg',$this->weight_avg);
		$criteria->compare('weight_wp',$this->weight_wp);
		$criteria->compare('weight_wm',$this->weight_wm);
		$criteria->compare('weight_ap',$this->weight_ap);
		$criteria->compare('weight_bh',$this->weight_bh);
		$criteria->compare('vellum1',$this->vellum1);
		$criteria->compare('vellum2',$this->vellum2);
		$criteria->compare('vellum3',$this->vellum3);
		$criteria->compare('usevellum',$this->usevellum);
		$criteria->compare('vellummaking_ag',$this->vellummaking_ag);
		$criteria->compare('moulding_ag',$this->moulding_ag);
		$criteria->compare('halmarking_ag',$this->halmarking_ag);
		$criteria->compare('beforehallmarking_ag',$this->beforehallmarking_ag);
		$criteria->compare('polishing_ag',$this->polishing_ag);
		$criteria->compare('rhodiumplating_w_ag',$this->rhodiumplating_w_ag);
		$criteria->compare('vellummaking_au',$this->vellummaking_au);
		$criteria->compare('vellumalloying_au',$this->vellumalloying_au);
		$criteria->compare('moulding_au',$this->moulding_au);
		$criteria->compare('moulding_otk_au',$this->moulding_otk_au);
		$criteria->compare('beforehallmarking_au',$this->beforehallmarking_au);
		$criteria->compare('hallmarkingtransport_au',$this->hallmarkingtransport_au);
		$criteria->compare('rent_au',$this->rent_au);
		$criteria->compare('hallmarking_au',$this->hallmarking_au);
		$criteria->compare('polishing_au',$this->polishing_au);
		$criteria->compare('rhodiumplating_m_au',$this->rhodiumplating_m_au);
		$criteria->compare('rhodiumplating_w_au',$this->rhodiumplating_w_au);
		$criteria->compare('item_otk_au',$this->item_otk_au);
		$criteria->compare('waste_au',$this->waste_au);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 100),
		));
	}

	public function searchMainItem()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		if(Yii::app()->controller->themeId == 1){
			$criteria->with = array('goodsiteminfo');
			$criteria->condition = 'goodsiteminfo.main=1';
		}else{
			$criteria->condition = 't.main=1';
		}

		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_full',$this->name_full,true);
		$criteria->compare('marking',$this->marking,true);
		$criteria->compare('hallmark',$this->hallmark,true);
		$criteria->compare('goodtype',$this->goodtype,true);
		$criteria->compare('measure',$this->measure,true);
		$criteria->compare('weight_avg',$this->weight_avg);
		$criteria->compare('weight_wp',$this->weight_wp);
		$criteria->compare('weight_wm',$this->weight_wm);
		$criteria->compare('weight_ap',$this->weight_ap);
		$criteria->compare('weight_bh',$this->weight_bh);
		$criteria->compare('vellum1',$this->vellum1);
		$criteria->compare('vellum2',$this->vellum2);
		$criteria->compare('vellum3',$this->vellum3);
		$criteria->compare('usevellum',$this->usevellum);
		$criteria->compare('vellummaking_ag',$this->vellummaking_ag);
		$criteria->compare('moulding_ag',$this->moulding_ag);
		$criteria->compare('halmarking_ag',$this->halmarking_ag);
		$criteria->compare('beforehallmarking_ag',$this->beforehallmarking_ag);
		$criteria->compare('polishing_ag',$this->polishing_ag);
		$criteria->compare('rhodiumplating_w_ag',$this->rhodiumplating_w_ag);
		$criteria->compare('vellummaking_au',$this->vellummaking_au);
		$criteria->compare('vellumalloying_au',$this->vellumalloying_au);
		$criteria->compare('moulding_au',$this->moulding_au);
		$criteria->compare('moulding_otk_au',$this->moulding_otk_au);
		$criteria->compare('beforehallmarking_au',$this->beforehallmarking_au);
		$criteria->compare('hallmarkingtransport_au',$this->hallmarkingtransport_au);
		$criteria->compare('rent_au',$this->rent_au);
		$criteria->compare('hallmarking_au',$this->hallmarking_au);
		$criteria->compare('polishing_au',$this->polishing_au);
		$criteria->compare('rhodiumplating_m_au',$this->rhodiumplating_m_au);
		$criteria->compare('rhodiumplating_w_au',$this->rhodiumplating_w_au);
		$criteria->compare('item_otk_au',$this->item_otk_au);
		$criteria->compare('waste_au',$this->waste_au);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 100),
		));
	}

	public function searchStore()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join  = 'INNER JOIN goodstore gs ON gs.goodkod = t.kod';
		$criteria->compare('kod',$this->kod,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_full',$this->name_full,true);
		$criteria->compare('marking',$this->marking,true);
		$criteria->compare('hallmark',$this->hallmark,true);
		$criteria->compare('goodtype',$this->goodtype,true);
		$criteria->compare('measure',$this->measure,true);
		$criteria->compare('weight_avg',$this->weight_avg);
		$criteria->compare('weight_wp',$this->weight_wp);
		$criteria->compare('weight_wm',$this->weight_wm);
		$criteria->compare('weight_ap',$this->weight_ap);
		$criteria->compare('weight_bh',$this->weight_bh);
		$criteria->compare('vellum1',$this->vellum1);
		$criteria->compare('vellum2',$this->vellum2);
		$criteria->compare('vellum3',$this->vellum3);
		$criteria->compare('usevellum',$this->usevellum);
		$criteria->compare('vellummaking_ag',$this->vellummaking_ag);
		$criteria->compare('moulding_ag',$this->moulding_ag);
		$criteria->compare('halmarking_ag',$this->halmarking_ag);
		$criteria->compare('beforehallmarking_ag',$this->beforehallmarking_ag);
		$criteria->compare('polishing_ag',$this->polishing_ag);
		$criteria->compare('rhodiumplating_w_ag',$this->rhodiumplating_w_ag);
		$criteria->compare('vellummaking_au',$this->vellummaking_au);
		$criteria->compare('vellumalloying_au',$this->vellumalloying_au);
		$criteria->compare('moulding_au',$this->moulding_au);
		$criteria->compare('moulding_otk_au',$this->moulding_otk_au);
		$criteria->compare('beforehallmarking_au',$this->beforehallmarking_au);
		$criteria->compare('hallmarkingtransport_au',$this->hallmarkingtransport_au);
		$criteria->compare('rent_au',$this->rent_au);
		$criteria->compare('hallmarking_au',$this->hallmarking_au);
		$criteria->compare('polishing_au',$this->polishing_au);
		$criteria->compare('rhodiumplating_m_au',$this->rhodiumplating_m_au);
		$criteria->compare('rhodiumplating_w_au',$this->rhodiumplating_w_au);
		$criteria->compare('item_otk_au',$this->item_otk_au);
		$criteria->compare('waste_au',$this->waste_au);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => 100),
		));
	}

	public static function getGroupItem($group = 0){
		// Золото с фианитами
		if($group==1){
			$criteria = new CDbCriteria;
			$match = '20';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

		// Золото с бриллиантами
		if($group==2){
			$criteria = new CDbCriteria;
			$match = '10';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

		// Золото с полудрагоценными камнями
		if($group==3){
			$criteria = new CDbCriteria;
			$match = '40';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

		// Серебро
		if($group==4){
			$criteria = new CDbCriteria;
			$match = '90';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

		// Серебро с желтым покрытием
		if($group==5){
			$criteria = new CDbCriteria;
			$match = '80';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

		// Серебро с красным покрытием
		if($group==6){
			$criteria = new CDbCriteria;
			$match = '70';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

		// Серебро с полудрагоценными камнями
		if($group==7){
			$criteria = new CDbCriteria;
			$match = '60';
			$match = addcslashes($match, '%_');
			$criteria->condition = 'replace(marking," ","") LIKE :match';
			$criteria->params = array(':match'=>"$match%");
			return Goods::model()->findAll($criteria);
		}

	}

	public static function getGroupDataProviderItem($groupId, $sort, $pagination)
	{
		/*if(Yii::app()->session->get("admin") == 1)
		{
			$id_cache = "getGroupDataProviderItem1".$groupId;

			$dataprovider = Yii::app()->cache->get($id_cache);

			print_r($dataprovider);

			if($dataprovider===false)
			{
				$criteria = new CDbCriteria;
				$criteria->join  = 'INNER JOIN tbl_group_item cp ON cp.item_id = t.kod AND cp.group_id = :id';
				$criteria->params = array(':id'=>$groupId);
				$dataprovider = new CActiveDataProvider("Goods",array(
									'criteria'=>$criteria,
									'sort'=>$sort,
									'pagination'=>$pagination
								));

				Yii::app()->cache->set($id_cache,$dataprovider);
			}

			return $dataprovider;
		} else {*/
			$criteria = new CDbCriteria;
			$criteria->join  = 'INNER JOIN tbl_group_item cp ON cp.item_id = t.kod AND cp.group_id = :id';
			$criteria->addCondition("publ = 0");
			//$criteria->addCondition("goodtype = 1");
			$criteria->params = array(':id'=>$groupId);
			$dataprovider = new CActiveDataProvider("Goods",array(
								'criteria'=>$criteria,
								'sort'=>$sort,
								'pagination'=>$pagination
							));
			return $dataprovider;
		/*}*/
	}

	public static function getGroupDataProviderItemInStock($groupId, $sort, $pagination, $priceFrom=false, $priceTo=false)
	{
			$criteria = new CDbCriteria;
			$criteria->select='t.*';
			$criteria->join  = 'INNER JOIN tbl_group_item cp ON cp.item_id = t.kod INNER JOIN goodstore gs ON gs.goodkod = t.kod';
			//$criteria->join  = 'INNER JOIN goodstore gs ON gs.goodkod = t.kod';
			$criteria->addCondition("publ = 0");
			$criteria->addCondition("cp.group_id = :id");

			if($priceFrom){
				$criteria->addCondition("gs.price > ".$priceFrom);
			}
			if($priceTo){
				$criteria->addCondition("gs.price < ".$priceTo);
			}
			$criteria->group='t.kod';
			$criteria->params = array(':id'=>$groupId);

			$dataprovider = new CActiveDataProvider("Goods",array(
								'criteria'=>$criteria,
								'sort'=>$sort,
								'pagination'=>$pagination
							));


			return $dataprovider;

	}

	public static function getGroupDataProviderItemByCat($groupId, $goodtype, $sort, $pagination)
	{
		/*$id_cache = "getGroupDataProviderItemByCat".$groupId.$goodtype.$sort.$pagination;

		$dataprovider = Yii::app()->cache->get($id_cache);

		if($dataprovider===false)
		{*/
			$criteria = new CDbCriteria;
			$criteria->join  = 'INNER JOIN tbl_group_item cp ON cp.item_id = t.kod AND cp.group_id = :id AND t.goodtype = :goodtype AND publ = 0';
			$criteria->params = array(':id'=>$groupId,':goodtype'=>$goodtype);
			$dataprovider = new CActiveDataProvider("Goods",array(
								'criteria'=>$criteria,
								'sort'=>$sort,
								'pagination'=>$pagination
							));

			/*Yii::app()->cache->set($id_cache,$dataprovider);
		}*/

		return $dataprovider;
	}

	public static function getGroupDataProviderItemByCatInStock($groupId, $goodtype, $sort, $pagination, $priceFrom=false, $priceTo=false)
	{
			$criteria = new CDbCriteria;
			$criteria->select='t.*';
			$criteria->join  = 'INNER JOIN tbl_group_item cp ON cp.item_id = t.kod INNER JOIN goodstore gs ON gs.goodkod = t.kod';
			//$criteria->join  = 'INNER JOIN goodstore gs ON gs.goodkod = t.kod';
			$criteria->condition = 'cp.group_id = :id AND t.goodtype = :goodtype AND publ = 0';
			$criteria->group='t.kod';

			if($priceFrom){
				$criteria->addCondition("gs.price >= ".$priceFrom);
			}
			if($priceTo){
				$criteria->addCondition("gs.price <= ".$priceTo);
			}

			$criteria->params = array(':id'=>$groupId,':goodtype'=>$goodtype);
			$dataprovider = new CActiveDataProvider("Goods",array(
								'criteria'=>$criteria,
								'sort'=>$sort,
								'pagination'=>$pagination
							));

		return $dataprovider;
	}

	public function stores($adminPrice=false)
	{
		$addCriteriaStart = "";
		$addCriteriaEnd = "";
		if(isset($_GET['filter-size-start']))
		{
			if($_GET['filter-size-start'])
				$addCriteriaStart = " AND goodsize >= '".$_GET['filter-size-start']."'";
		}
		if(isset($_GET['filter-size-end']))
		{
			if($_GET['filter-size-end'])
				$addCriteriaEnd = " AND goodsize <= '".$_GET['filter-size-end']."'";
		}


		$criteria = new CDbCriteria;
		$criteria->condition = 'goodkod=:kod'.$addCriteriaStart.$addCriteriaEnd;
		$criteria->order = 'goodsize ASC';
		$criteria->params = array(':kod'=>$this->kod);

		if($_GET['filter-stonekod']){
			$colorName = $_GET['filter-stonekod'];
			$colors = Yii::app()->db->createCommand()
						->select('kod')
						->from('stone')
						->where('color=:color', array(':color'=>$colorName))
						->order('kod DESC')
						->queryColumn();
			$criteria->addInCondition('stonekod',$colors);
		}


		$stores = Goodstore::model()->findAll($criteria);


		if($_GET['filterPriceToFrom']){
			$price = $_GET['filterPriceFrom'];
		}

		if((Yii::app()->session->get("admin") == 1)&&($price)){
			foreach ($stores as $data) {
				$item = Goods::model()->findByPk($data->goodkod);
				$pricegood = $item->getCalculatedPrice(array("serialkod"=>$data->serialkod, "withoutRub"=>true));

				if($pricegood<$price){
					$groupGoods[]=$data;
				}
			}
		}else{
			$groupGoods = $stores;
		}

		return $groupGoods;
	}

	public function getSizeInStock(){
		$sizes = Yii::app()->db->createCommand()
				->select('*')
				->from('goodstore gs')
				->where('gs.goodkod=:id', array(':id'=>$this->kod))
				->order('gs.stonekod DESC, gs.goodsize ASC, gs.weight DESC')
				->queryAll();

		return $sizes;
	}

	//выборка всех камней у данного товары в наличии
	public function getStoneInStock()
	{
		$count_msg = null;
		$stones = Yii::app()->db->createCommand()//делаем выборку всех камей данного товара в наличии
				->select('*')
				->from('goodstore gs')
				->leftJoin('tbl_stone_image si', 'si.stonekod=gs.stonekod')
				//->join('goods g', 't.item_id=g.kod')
				->where('gs.goodkod=:id', array(':id'=>$this->kod))
				->order('gs.stonekod DESC, gs.goodsize ASC, gs.weight DESC')
				->queryAll();

		foreach ($stones as $key => $data) { // проходимся по всем позициям

			if(!$data['stonekod']) // если поле камня пустое
			{
				$serialkod = $data['serialkod'];
				$stonekod = Yii::app()->db->createCommand() // проверяем его в еще одной таблице, не завалялся ли он там
				->select('stonekod')
				->from('tmp_serialkod_stonekod ts')
				->where('ts.serialkod=:id', array(':id'=>$serialkod))
				->queryScalar();

				if($stonekod){ // проверяем, нашли или нет
					//если нашли то добавляем информацию о нем
					$stones[$key]['stonekod'] = $stonekod;
					$stones[$key]['filename'] = $stonekod.'.jpg';
				} else {
					unset($stones[$key]); // иначе удаляем позицию, чтоб глаза не мазолила, так как камень не будет присутствовать, а надпись выберите камень будет
				}
			}
		}

		foreach ($stones as $key => $item) {
			$count_msg[$key] = $item['stonekod'];
		}

		array_multisort($count_msg, SORT_DESC, SORT_STRING, $stones);

		return $stones;
	}

	public static function getNewGoodStore(){
		$criteria = new CDbCriteria;
		$criteria->join  = 'INNER JOIN goodstore gs ON gs.goodkod = t.kod
							INNER JOIN tbl_item_info tii ON tii.item_id = t.kod';
		//$criteria->join  = ' tbl_item_info tii ON tii.kod = t.kod';
		$criteria->addCondition("publ = 0 AND tii.main=1");
		$criteria->group='t.kod';
		$criteria->order = 't.new DESC';
		// $criteria->limit = '5';
		$goods = Goods::model()->findAll($criteria);

		return $goods;
	}

	public function getStoreGoods(){
		$goods = Yii::app()->db->createCommand()
				->select('*')
				->from('goodstore gs')
				->where('gs.goodkod=:id', array(':id'=>$this->kod))
				->order('gs.stonekod ASC')
				->queryAll();

		return $goods;
	}

	public static function StoreGoodsAR(){
		$goods = Yii::app()->db->createCommand()
				->select('goodkod')
				->from('goodstore')
				->queryColumn();

		$criteria = new CDbCriteria;
		$criteria->addInCondition('kod',$goods);

		return self::model()->findAll($criteria);
	}

	public static function StoreGoodsDataProviderOther($priceFrom=0, $priceTo=false){
		if($priceTo){
			$goods = Yii::app()->db->createCommand()
					->select('t.goodkod')
					->from('goodstore t')
					->join('goodimage gi','t.kod=gi.good')
					->where('t.price >='.$priceFrom.' AND t.price <='.$priceTo)
					->queryColumn();
		}else{
			$priceFrom = $priceFrom ? $priceFrom : 0;
			$goods = Yii::app()->db->createCommand()
					->select('t.goodkod')
					->from('goodstore t')
					->join('goodimage gi','t.goodkod=gi.good')
					->where('t.price >='.$priceFrom)
					->queryColumn();
		}

		$marking = Yii::app()->db->createCommand()
				->select('item_id')
				->from('tbl_category_item')
				->queryColumn();

		$criteria = new CDbCriteria;
		$criteria->addInCondition('kod',$goods);
		$criteria->addNotInCondition('marking',$marking);
		/*$criteria->with = array('images', array('condition'=>'images.good=t.kod'));
		$criteria->addCondition('images.good=t.kod');*/


		$sort = new CSort();
		$sort->sortVar = 'sort';
		$sort->defaultOrder = 't.kod DESC';
		$sort->attributes = array(
			'kod'=>array(
				'label'=>'новизне',
				'asc'=>'kod ASC',
				'desc'=>'kod DESC',
				'default'=>'desc',
			),
			'marking'=>array(
				'asc'=>'marking ASC',
				'desc'=>'marking DESC',
				'default'=>'desc',
				'label'=>'артикулу',
			),
		);

		$dataProvider = new CActiveDataProvider('Goods',array(
			'criteria'=>$criteria,
			'sort' => $sort,
			'pagination'=>array(
					'pageSize'=> Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
				)
		));

		return $dataProvider;
	}


	public function getPricesInStock(){
		$prices = Yii::app()->db->createCommand()
				->select('serialkod')
				->from('goodstore gs')
				//->join('goods g', 't.item_id=g.kod')
				->where('gs.goodkod=:id', array(':id'=>$this->kod))
				->order('gs.price ASC')
				->queryColumn();

		return $prices;
	}



	public static function CategoryGoodsID($categoryId){
		$goods = Yii::app()->db->createCommand()
				->select('kod')
				//->from('goodstore t')
				->from('goods t')
				->join('tbl_category_item ci', 'ci.item_id=t.marking')
				->where('ci.category_id=:catid',array(':catid'=>$categoryId))
				->queryColumn();

		return $goods;
	}

	public static function CollectionGoodsID($collectionId){
		$goods = Yii::app()->db->createCommand()
				->select('kc.goods_kod')
				->from('tbl_kubachinka_collection_goods kc')
				//->from('goods t')
				//->join('tbl_kubachinka_collection_goods kc', 'kc.goods_kod=t.marking')
				->where('kc.collection_id=:catid',array(':catid'=>$collectionId))
				->queryColumn();

		return $goods;
	}

	public static function CategorysGoodsID($categoryIds){
		$goods = Yii::app()->db->createCommand()
				->select('kod')
				//->from('goodstore t')
				->from('goods t')
				->join('tbl_category_item ci', 'ci.item_id=t.marking')
				//->where('ci.category_id=:catid',array(':catid'=>$categoryIds[0]))
				->where(array('in', 'ci.category_id', implode(',', $categoryIds)))
				->queryColumn();


		return $goods;
	}

	public static function getCategoryGoodAR($categoryId){
		$categoryGoodsID = self::CategoryGoodsID($categoryId);

		if(!$categoryGoodsID){
			$categoryes = Category::model()->findAll('parent_id = :pid', array(':pid'=>$categoryId));
			foreach ($categoryes as $data) {
				$ids[] = $data->id;
			}


			$categoryGoodsID = self::CategorysGoodsID($ids);
		}


		$criteria = new CDbCriteria;
		$criteria->addInCondition('kod', $categoryGoodsID);
		$good = self::model()->findAll($criteria);


		foreach ($good as $data) {
			if($data->images){
				return $data;
			}
		}

		return $good[0];
	}

	/*id товаров в наличии конкртеной коллекции*/
	public static function getCollectionGoodStoreIDs($collectionId){ //echo $collectionId; die();
		$goods = Yii::app()->db->createCommand()
				->select('kod')
				->from('goods t')
				->join('goodstore gs', 'gs.goodkod=t.kod')
				->where('t.collection_id=:colid',array(':colid'=>$collectionId))
				->queryColumn(); //print_r($goods);
		return $goods;
	}

	private $_kubachiCollection;
	public function getKubachiCollection(){

		if(!$this->isNewRecord){
			if(empty($this->_kubachiCollection)){
				$this->_kubachiCollection = Yii::app()->db->createCommand()
													->select('collection_id')
													->from('tbl_kubachinka_collection_goods')
													->where('goods_kod = :kod', array(':kod'=>$this->id))
													->queryColumn();
			}
		}
		return $this->_kubachiCollection;
	}

	public function setKubachiCollection($value){
		$this->_kubachiCollection = $value;
	}

	protected function afterSave(){
		parent::afterSave();
		CategoryItem::model()->deleteAll('item_id=:id',array(':id'=>$this->article));

		if($this->categoryId){
			$categoryItem = new CategoryItem;
			$categoryItem->category_id = $this->categoryId;
			$categoryItem->item_id = $this->article;
			$categoryItem->save(safe);
		}

		// Добавление коллекции к товару

			KubachinkaCollectionGoods::model()->deleteAll('goods_kod = :kod', array(':kod'=>$this->id));
			foreach ($this->kubachiCollection as $data) {
				$kubachiCollection = new KubachinkaCollectionGoods;
				$kubachiCollection->goods_kod = $this->id;
				$kubachiCollection->collection_id = $data;
				$kubachiCollection->save();
			}


	}

	public function afterFind(){
		$this->categoryId = CategoryItem::model()->find('item_id=:id',array(':id'=>$this->article))->category_id;
	}

	public static function getMaxPrice($categoryId = false){

		if($categoryId){
			$maxPrice = Yii::app()->db->createCommand('
					SELECT MAX(gs.price) FROM goodstore AS gs
						LEFT JOIN goods g ON g.kod = gs.goodkod
						LEFT JOIN tbl_category_item ci ON ci.item_id = g.marking
						WHERE ci.category_id = :catId')
					->bindParam(":catId",$categoryId,PDO::PARAM_STR)
					->queryScalar();
		}else{
			$maxPrice = Yii::app()->db->createCommand('SELECT MAX(`price`) FROM `goodstore`')
															->queryScalar();
		}

		return (int)$maxPrice ? (int)$maxPrice+100 : 0;
	}

	public static function getMinPrice($categoryId = false){

		if($categoryId){
			$minPrice = Yii::app()->db->createCommand('
					SELECT MIN(gs.price) FROM goodstore AS gs
						LEFT JOIN goods g ON g.kod = gs.goodkod
						LEFT JOIN tbl_category_item ci ON ci.item_id = g.marking
						WHERE ci.category_id = :catId')
					->bindParam(":catId",$categoryId,PDO::PARAM_STR)
					->queryScalar();
		}else{
			$minPrice = Yii::app()->db->createCommand('SELECT MIN(`price`) FROM `goodstore`')
															->queryScalar();
		}

		return (int)$minPrice ? (int)$minPrice-100 : 0;
	}

	public $watermarkDir = 'uploads/watermark/';
	public $dir = 'uploads/';

	public function ImageUpdateInWatermark()
	{
		if($this->images){ // если есть картинки
			foreach ($this->images as $data) { // проходимся по ним циклом
				$time_create_main = filemtime($_SERVER['DOCUMENT_ROOT'].'/'.$this->dir.$data->filename);// сохраняем последнее изменение файла
				$time_create_wm = filemtime($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename);// сохраняем последнее изменение файла

				if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename) || $time_create_main > $time_create_wm){ // если в папке с наложенными вотермарками нет искомого файла
					Yii::app()->ih
						->load($_SERVER['DOCUMENT_ROOT'].'/uploads/'.$data->filename) // загружаем исходную картинку
						->resize(1200, 1200) // ресайзем её
						->watermark($_SERVER['DOCUMENT_ROOT'] . '/images/watermark.png', 40, 40, CImageHandler::CORNER_CENTER, 1) // накладываем вотермарк
						//->thumb(200, 200)
						->save($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename); // сохраняем в папку с вотермарками
					@unlink(Yii::app()->iwi->load($_SERVER['DOCUMENT_ROOT'].'/'.$watermarkDir.$image->filename)->resize(100,100)->cache());
					@unlink(Yii::app()->iwi->load($_SERVER['DOCUMENT_ROOT'].'/'.$watermarkDir.$image->filename)->resize(380,380)->cache());
					@unlink(Yii::app()->iwi->load($_SERVER['DOCUMENT_ROOT'].'/'.$watermarkDir.$image->filename)->resize(800,800)->cache());
				}
			}

			/*$time_create_main = filemtime($_SERVER['DOCUMENT_ROOT'].'/'.$dir.$data->filename);// сохраняем последнее изменение файла
			$time_create_wm = filemtime($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename);// сохраняем последнее изменение файла

			if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename) && $time_create_main > $time_create_wm) { // если в папке с наложенными вотермарками нет искомого файла
				@unlink($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename);
				Yii::app()->ih
					->load($_SERVER['DOCUMENT_ROOT'].'/'.$dir.$data->filename) // загружаем исходную картинку
					->resize(1200, 1200) // ресайзем её
					->watermark($_SERVER['DOCUMENT_ROOT'] . '/images/watermark.png', 40, 40, CImageHandler::CORNER_CENTER, 1) // накладываем вотермарк
					//->thumb(200, 200)
					//->save($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$time_create.'_'.$data->filename); // сохраняем в папку с вотермарками
					->save($_SERVER['DOCUMENT_ROOT'].'/'.$this->watermarkDir.$data->filename);
			}*/
		}
	}

	public function defaultPrice($api = false){
		$koof = Config::model()->findByPk(26)->value;

		if($api){
			$calculatePrice = $this->getCalculatedPrice(array('withoutRub'=>1), true);
		}else{
			$calculatePrice = $this->getCalculatedPrice();
		}

		$price = str_replace(' ','', $calculatePrice);
		$defPrice= $price + $price*$koof/100;
		return number_format((int)$defPrice,0,',','');
		//return number_format((int)$defPrice,0,',',' ').' руб';

	}

	/*protected function beforeSave(){

		if(parent::beforeSave() === false) {
			return false;
		}

		return true;
	}*/



	public function getNextItemUrl(){

        $sql = "SELECT item_id FROM {{category_item}} WHERE   category_id = {$this->categoryId} ORDER BY item_id DESC  ";
        $connection=Yii::app()->db;
        $arr = $connection->createCommand($sql)->queryColumn();
       	$key = array_search($this->marking, $arr);

       	// print_r($arr);
       	// die();

       //	return $key;



        if($arr[$key+1])
	        {
	            return  Goods::model()->find('marking=:marking',array(':marking'=>$arr[$key+1]))->id;
	        }
        else
            return '#';
    }

    public function getPrevItemUrl(){

       $sql = "SELECT item_id FROM {{category_item}} WHERE   category_id = {$this->categoryId} ORDER BY item_id DESC  ";
        $connection=Yii::app()->db;
        $arr = $connection->createCommand($sql)->queryColumn();
         $key = array_search($this->marking, $arr);
        if($arr[$key-1])
             {
	            return  Goods::model()->find('marking=:marking',array(':marking'=>$arr[$key-1]))->id;
	        }
        else
            return '#';
    }


    public static function isStore($goodkod)
    {
    	return Goodstore::model()->find('goodkod = :kod', array(':kod' => $goodkod));
    }

}