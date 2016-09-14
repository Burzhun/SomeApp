<?php

class NewItemWidget extends CWidget {

	public function run() {

		$dependecy = new CDbCacheDependency('SELECT MAX(kod) FROM goods');
		$month = date('Y-m-d H:m:s', time() - Goods::$noveltiLeftTime);

		$noveltyDataProvider = new CActiveDataProvider(Goods::model()->cache(10000, $dependecy),
															array(
																'criteria'=>array(
																	'condition'=>'publ = 0 AND new > :month',
																	'order'=>'RAND()',
																	'params' => array(':month' => $month),
																	//'limit'=>1,
																),
																'pagination'=>array(
																	'pageSize'=> 8,
																),
																'totalItemCount'=>8,
															));

        $this->render('NewItemWidget', array(
       		'noveltyDataProvider' => $noveltyDataProvider,
		));
    }
}