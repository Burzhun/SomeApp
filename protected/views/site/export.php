<? echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
	<v8msg:Message xmlns:v8msg="http://v8.1c.ru/messages">
	<v8msg:Header>
		<v8msg:ExchangePlan>бс_ОбменСДистрибьюторами</v8msg:ExchangePlan>
		<v8msg:To>01</v8msg:To>
		<v8msg:From>003</v8msg:From>
		<v8msg:MessageNo>8517</v8msg:MessageNo>
		<v8msg:ReceivedNo>8059</v8msg:ReceivedNo>
	</v8msg:Header>
	<v8msg:Body>
		<d3p1:Таблица xmlns:d3p1="Таблица">
			<d4p1:СтруктураКолонок xmlns:d4p1="СтруктураКолонок">
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Код</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Название</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Цена</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Количество</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Артикул</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Вес</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Проба</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Размер</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Скидка</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Пол</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">ВидИзделия</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Цвет</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Раздел</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Вставка</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">ВставкаОписание</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Картинка1</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Картинка2</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Картинка3</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Картинка4</Колонка>
				<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">Картинка5</Колонка>
			</d4p1:СтруктураКолонок>
			<d4p1:Данные xmlns:d4p1="Данные">

			<? 	$whatname = array(
				'000000001'=>'Белый',
				'000000002'=>'Желтый',
				'000000003'=>'Белый',
				'000000004'=>'Красный',
				'000000005'=>'Белый',
				'000000006'=>'Желтый',
				'000000007'=>'Желтый',
				'000000008'=>'Желтый',
				'000000009'=>'Желтый',
				); 
			?>

			<? foreach($model as $item) { 
				if(!empty($item->stonekod)) $stonekod = $item->stonekod; else $stonekod = "Без ставок"; 

				$stoneDescription = Stone::model()->cache(40000)->find(array("condition"=>"kod='".$item->stonekod."'")); ?>

					<d5p1:СтрокаТаблицы xmlns:d5p1='СтрокаТаблицы'>
					<Код xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$item->goodkod;?></Код>
					<Название xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$item->goods->name;?></Название>
					<Цена xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:decimal'><?=$item->price;?></Цена>
					<Количество xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:decimal'><?=$item->kolvo;?></Количество>
					<Артикул xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$item->goods->marking;?></Артикул>
					<Вес xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:decimal'><?=$item->weight;?></Вес>
					<Проба xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$item->goods->hm->name;?></Проба>
					<Размер xmlns:v8='http://v8.1c.ru/data' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='v8:Null'/><?=$item->goodsize;?></Размер>
					<Скидка xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:decimal'><?=$item->goods->discount;?></Скидка>
					<Пол xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'>Жен</Пол>
					<ВидИзделия xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'>Новый</ВидИзделия>
					<Цвет xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$whatname[$item->goods->groupkod];?></Цвет>
					<Раздел xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$item->goods->catalog->name;?></Раздел>
					<Вставка xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$stonekod;?></Вставка>
					<ВставкаОписание xmlns:v8='http://v8.1c.ru/data' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='v8:Null'/><?=$stoneDescription->name;?></ВставкаОписание>
					<Картинка1 xmlns:xs='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:type='xs:string'><?=$item->goods->image;?></Картинка1>
					<Картинка2 xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:nil='true'/>
					<Картинка3 xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:nil='true'/>
					<Картинка4 xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:nil='true'/>
					<Картинка5 xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:nil='true'/>
				</d5p1:СтрокаТаблицы>
			 <? } ?>

			</d4p1:Данные>
			</d3p1:Таблица>
			<d3p1:Таблица xmlns:d3p1="Таблица">
				<d4p1:СтруктураКолонок xmlns:d4p1="СтруктураКолонок">
					<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">НоменклатураКод</Колонка>
					<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">ДатаЗаказа</Колонка>
					<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">НомерЗаказа</Колонка>
					<Колонка xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="xs:string">ДатаОтгрузки</Колонка>
				</d4p1:СтруктураКолонок>
				<d4p1:Данные xmlns:d4p1="Данные"/>
			</d3p1:Таблица>
		</v8msg:Body>
	</v8msg:Message>


