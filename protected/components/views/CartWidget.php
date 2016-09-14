<? $sum = 0;
$price = 0;
/*$session=new CHttpSession;
$session->open();
$sess = $session->getsessionID();

$all = Cart::model()->findAll("session_id = '$sess'");*/
$all = Cart::getOrderItems(); 
foreach ($all as $good)
{
	$sum+= $good->num;
	$price+=$good->num*$good->item->getCalculatedPrice(array("serialkod"=>$good->serialkod, "withoutRub"=>true,"stone"=>$good->stonekod,'size'=>$good->size, 'checkStone'=>1));
} ?>	

<?
if(Yii::app()->theme->name == 'roznica'){?>
	<a href="/cart">В корзине<span> <?=($sum==0) ? '0' : $sum;?></span> <?=Functions::human($sum, array('товар','товара','товаров'))?> </a> 
	 <a href="/cart"> На сумму <span><?=$price?></span> Руб. </a> 
<?}else{?>
	<a href="/cart" rel="nofollow"><?=($sum==0) ? 'Нет' : $sum;?></span> <span><?=Functions::human($sum, array('товар','товара','товаров'))?> в корзине</a><br>
	<? if($price) {?>
		Сумма: <?=$price;?> руб
	<? } ?>
<?}?>