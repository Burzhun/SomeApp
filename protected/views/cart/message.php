<h1>Новый заказ</h1>

Товары: <br>
<?$totalPrice = 0;?>
<? foreach ($items as $item){
	$data = $item->item; ?>
	<?=CHtml::link($data->name, "http://".$_SERVER['SERVER_NAME'].$data->CreateAbsoluteUrl);?>&nbsp;&nbsp;
	<?php if($item->size) { ?>Размер: <?php echo $item->size; } ?>&nbsp;&nbsp;
	<?php if($item->stonekod) { ?>Вставка: <?php echo Stone::model()->findByAttributes(array('kod'=>$item->stonekod))->name; } ?><br>
	<?php if($item->stonekod) { ?><img src="http://agra-gold.ru/uploads/<?=Stone::model()->find(array('condition'=>"kod='".$item->stonekod."'"))->imageStone->filename;?>" width="80px;"><?}?>
	<?/* if($item->item->StoneImage){?><img src='http://agra-gold.ru/uploads/<?=$item->item->StoneImage->filename?>' width="100px"><?} */?>
	<br>
	<?$totalItemPrice=$item->price*$item->num;?>
	<?$totalPrice+=$totalItemPrice;?>
<? } ?>

<p><span>Итого: </span><?=$totalPrice?> руб. </p>

<h2>Сведения о заказчике</h2>

Имя: <?=$order->name;?><br>
Тел: <?=$order->phone;?><br>
Email: <?=$order->email;?><br>
Адрес: <?=$order->address;?><br>

Индекс: <?=$order->index;?><br>
Регион: <?=$order->region;?><br>
Способ доставки: <?=$order->transport;?><br>
Комментарии: <?=$order->info;?><br>
