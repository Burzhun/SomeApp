<?
/*
Класс Транслитерации
Перевод текста в транслит
echo Translit::text('Хорошая погода сегодня! + 25 на улице! Влажность 99%');
Horoshaya pogoda segodnya! + 25 na ulitse! Vlajnost 99%
            ******
Translit::url('Хорошая погода сегодня!');
horoshaya-pogoda-segodnya-25-na-ulitse-vlajnost-99
*/
Class Translit {
	public static function text($string) 
{
    $replace = array(
        "А"=>"A",
        "Б"=>"B",
        "В"=>"V",
        "Г"=>"G",        
        "Д"=>"D",
        "Е"=>"E",
        "Ж"=>"J",
        "З"=>"Z",
        "И"=>"I",
        "Й"=>"Y",
        "К"=>"K",
        "Л"=>"L",
        "М"=>"M",
        "Н"=>"N",
        "О"=>"O",
        "П"=>"P",
        "Р"=>"R",
        "С"=>"S",
        "Т"=>"T",
        "У"=>"U",
        "Ф"=>"F",
        "Х"=>"H",
        "Ц"=>"TS",
        "Ч"=>"CH",
        "Ш"=>"SH",
        "Щ"=>"SCH",
        "Ъ"=>"",
        "Ы"=>"YI",
        "Ь"=>"",
        "Э"=>"E",
        "Ю"=>"YU",
        "Я"=>"YA",
        "а"=>"a",
        "б"=>"b",
        "в"=>"v",
        "г"=>"g",
        "д"=>"d",
        "е"=>"e",
        "ж"=>"j",
        "з"=>"z",
        "и"=>"i",
        "й"=>"y",
        "к"=>"k",
        "л"=>"l",
        "м"=>"m",
        "н"=>"n",
        "о"=>"o",
        "п"=>"p",
        "р"=>"r",
        "с"=>"s",
        "т"=>"t",
        "у"=>"u",
        "ф"=>"f",
        "х"=>"h",
        "ц"=>"ts",
        "ч"=>"ch",
        "ш"=>"sh",
        "щ"=>"sch",
        "ъ"=>"y",
        "ы"=>"yi",
        "ь"=>"",
        "э"=>"e",
        "ю"=>"yu",
        "я"=>"ya", 
    );
    return strtr($string,$replace);
}
public static function url($string, $len = 50)
	{
//преобразовываем строку в транслит
$string = self::text($string);		
//заменяем пробелы на тире
$string = str_replace(" ", "-", $string);
$string = str_replace(",", "-", $string);
//тоже самое с переносом строки
$string = str_replace("\n", "-", $string);
//переводим строку в нижний регистр
$string = strtolower($string);
//вырезаем все остальное
$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
//небольшой костыль чтобы в конце не оставалось "-"
$string = trim($string, "-");
//костыль чтобы не было --
$string = preg_replace('/-++/', '-', $string);

$string = substr($string, 0, $len);

	return $string;		
	}
}
