<?

class PageController extends Controller
{
	public $layout='//layouts/column2';

	public function actionIndex()
	{
		$page = $this->loadModel($_GET['id']);
		$this->render('index',array(
			'page'=>$page,
		));
	}
	
	public function actionViewbyurl()
	{
		$criteria=new CDbCriteria;
		$criteria->condition='url=:url AND theme=:theme';
		$criteria->params=array(':url'=>"/".$_GET['url'], ':theme'=>$this->themeId);


		$page = Page::model()->find($criteria);
		if($page === null)
					throw new CHttpException(404,'The requested page does not exist.');
		$this->render('index',array(
			'page'=>$page,
		));
	}

	public function loadModel($id)
	{
		$model=Page::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelUrl($url)
	{
		$model=Page::model()->findAll(array('criteria' => array('condition' => "url = $url", 'limit' => 1)));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
