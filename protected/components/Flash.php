<? 

Class Flash

{

public static function success($msg)
{
	return	Yii::app()->user->setFlash('success', "$msg");

}
public static function error($msg)
{
	Yii::app()->user->setFlash('error', "$msg");
}


}