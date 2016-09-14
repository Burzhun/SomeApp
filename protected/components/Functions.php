<?

Class Functions {

public static function YesNo($value)
{
return $value = ($value==1) ? "Да" : "Нет" ;
}

public static function makeUrl($string)
{
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "",  'ы' => 'y',   'ъ' => "",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => "",  'Ы' => 'Y',   'Ъ' => "",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        
        ' ' => '-',
        '?' => '',
        '"' => '',
        ',' => '',
        '.' => '-',
        '(' => '',
        ')' => '',
    );
    $str =  strtr($string, $converter);
    return $str;
}

 public static function BotDetect() { 
    $engines = array( 
        array('Google', 'Google Bot'), 
        array('Gsa-crawler', 'Google Bot'), 
        array('Yandex', 'Yandex Bot'), 
        array('YaDirectBot', 'Yandex Direct Bot'), 
        array('Yahoo', 'Yahoo Bot'), 
        array('Rambler', 'Rambler Bot'), 
        array('msn', 'MSN Bot'), 
        array('Gigabot', 'Giga Bot'), 
        array('Aport', 'Aport Bot'), 
        array('Lycos', 'Lycos Bot'), 
        array('FAST-WebCrawler', 'WebCrawler Bot'), 
        array('Mail.Ru', 'Mail.Ru Bot'), 
        array('IDBot', 'ID-Search Bot'), 
        array('eStyle', 'eStyle Bot'), 
        array('AbachoBOT', 'Abacho Bot'), 
        array('accoona', 'Accoona Bot'), 
        array('AcoiRobot', 'Acoi Bot'), 
        array('ASPSeek', 'ASPSeek Bot'), 
        array('CrocCrawler', 'CrocCrawler Bot'), 
        array('Dumbot', 'Dumbot Bot'), 
        array('GeonaBot', 'Geona Bot'), 
        array('MSRBOT', 'MSR Bot'), 
        array('Scooter', 'Altavista Bot'), 
        array('AltaVista', 'Altavista Bot'), 
        array('WebAlta', 'WebAlta Bot'), 
        array('Scrubby', 'Scrubby Bot'), 
        array('Slurp', 'Slurp Bot'), 
        array('ia_archiver', 'IA.Archiver Bot'), 
        array('Baiduspider', 'Baidu.com'), 
        array('oBot', 'oBot'), 
        array('Speedy Spider', 'EntireWeb Bot'), 
        array('Speedy_Spider', 'EntireWeb Bot'), 
        array('Teoma', 'Ask Bot'), 
        array('Binky', 'libwww.Binky Bot'), 
        array('amaya', 'libwww.amaya Bot'), 
        array('Webgate', 'libwww.Webgate Bot'), 
        array('W3C_Validator', 'libwww.W3C Validator Bot'), 
        array('libwww', 'libwww.nothing Bot'), 
        array('What You Seek', 'WhatYouSeek Bot'), 
        //////////////////////////////////////////////////////// 
        array('Offline Explorer', 'Offline Explorer Bot'), 
        array('Teleport', 'Teleport Bot'), 
    ); 

    foreach ($engines as $engine) { 
        if (stristr($_SERVER['HTTP_USER_AGENT'], $engine[0])) { 
            return($engine[1]); 
        } 
    } 

    return false; 
}  

public static function human ($number, $titles=array('коробка','коробки','коробок'))  {
    $cases = array (2, 0, 1, 1, 1, 2);
return $titles[ ($number%100 >4 && $number%100< 20)? 2 : $cases[min($number%10, 5)] ];

}



public static function getIp()
{
 if (!empty($_SERVER['HTTP_CLIENT_IP']))
 {
   $ip=$_SERVER['HTTP_CLIENT_IP'];
 }
 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
 {
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
 }
 else
 {
   $ip=$_SERVER['REMOTE_ADDR'];
 }
 
 ///еще проверочки
 $ip = ip2long($ip);
 $ip = long2ip($ip);

 return $ip;
}



public static function numberformat ($number,$decmals =0) {

return number_format($number,$decmals, $dec_point = '.' , $thousands_sep = ' ' );

}


public static function incart($id) {

$session=new CHttpSession;
$session->open();
$sess = $session->getsessionID();
$all = Cart::model()->findAll("session_id = '$sess' AND item_id = '$id'");
if(count($all)>0) 
return true;
else
return false;
}




public static function dbupdate() {
/*
 //категории
    $catalog = Catalog::model()->findAll('parent_id !=0');

    foreach ($catalog as $item) {
        if (Catalog::model()->findByPk($item->parent_id) === null) {
            $item->delete();
            Item::model()->deleteAll('catalog_id = '.$item->id);    
        }

        Item::model()->deleteAll('catalog_id = '.$item->parent_id);
}
        $items = Item::model()->with('catalog')->findAll();
        foreach ($items as $item) {
            if(empty($item->catalog->name)) 
                $item->delete();
        }


     $itemmain = ItemMain::model()->findAll();
     foreach ($itemmain as $main) {
              if (Item::model()->findByPk($main->item_id) === null) 
            $item->delete();
        }

    $images = ItemImage::model()->findAll();

    foreach ($images as $item) {
        
        if (Item::model()->findByPk($item->item->id) === null) {
            ImageFuck::delete($item->filename);
            $item->delete();
}


*/
    }


public static function rusMonth($month){
  if($month > 12 || $month < 1) return FALSE;
  $aMonth = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
  return $aMonth[$month - 1];
}



}




?>