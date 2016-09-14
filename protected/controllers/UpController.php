<?php
class UpController extends Controller
{

	public makePrice($weight)
	{
		$sum = $weight*220;	
		$avg = floor($sum/50);
		return $avg*50;
	}

	public function actionIndex()
	{
		echo $this->makePrice(1243.45);
	}
}