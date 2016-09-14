<h1>Новый заказ</h1>

Товары: <br>

<? foreach ($items as $item) {
$data = $item->item; ?>

<?=CHtml::link($data->name, $data->CreateAbsoluteUrl);?><br>

<? }?>

<h2>Сведения о заказчике</h2>

Имя: <?=$order->name;?><br>
Тел: <?=$order->phone;?><br>
Email: <?=$order->email;?><br>
Адрес: <?=$order->address;?><br>