<?
class TempGoods extends CActiveRecord
{
 
	public $primaryKey = array('kod');

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getId()
	{
		return $this->kod;
	}	
 
	public function tableName()
	{
		return 'temp_goods';
	}
 
	public function rules()
	{
 
		return array(
			//array('name, orderdate, goodcount, weight, sum, agentkod', 'safe'   ),
		);
	}


	public function relations()
	{
		return array(
		);
	}
 
 
}