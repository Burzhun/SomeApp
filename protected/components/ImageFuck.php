<?
Class ImageFuck {

	public static function save ($tmp_name, $banner = false)
	{
		if($tmp_name == "")
			return false;
		//папка для сохранения
		$dir = "uploads";
		$watermark = 'images/watermark.png';
		//нужные размеры
		// оригинал тоже сохраняем)
		//73x72   - small
		//181x131   - medium
		//489x403   - large

		//имя файла
		$name = md5(mt_rand()+time()).".jpg";

		// будущий путь оригинала 
		$origpath = $dir."/".$name;
		//сохранили оригинал
		copy($tmp_name,$origpath);

		if(!$banner) 
		{//но с размером - 1000px
			$img = Yii::app()->simpleImage->load($origpath);
			$h = getimagesize($origpath);
			
			if($h[0]>1000)
				$img->resizeToHeight(1000);
			
			$img->save($dir."/".$name);
		}


		//делаем 73 x 72 из оригинала
		$img = Yii::app()->simpleImage->load($origpath);
		$img->resizeToHeight(73);
		$img->save($dir."/small_".$name);

		//делаем 181 150 
		$img = Yii::app()->simpleImage->load($origpath);
		$img->resizeToHeight(155);
		$img->save($dir."/medium_".$name);

		//делаем 181 131 
		$img = Yii::app()->simpleImage->load($origpath);
		$img->resizeToHeight(201);
		$img->save($dir."/201_".$name);

		$img = Yii::app()->simpleImage->load($origpath);
		$h = getimagesize($origpath);
		if($h[1]>489)
		$img->resizeToWidth(489);
		//$img->resizeToHeight(403);
		$img->save($dir."/large_".$name);



		// // Загрузка штампа и фото, для которого применяется водяной знак (называется штамп или печать)
		// $stamp = imagecreatefrompng($watermark);
		// $im = imagecreatefromjpeg($dir."/large_".$name);

		// // Установка полей для штампа и получение высоты/ширины штампа
		// $marge_right = 10;
		// $marge_bottom = 10;
		// $sx = imagesx($stamp);
		// $sy = imagesy($stamp);

		// // Копирование изображения штампа на фотографию с помощью смещения края
		// // и ширины фотографии для расчета позиционирования штампа. 
		// imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		// // Вывод и освобождение памяти
		// imagepng($im, $dir."/wm_large_".$name);
		// imagedestroy($im);
		return $name;
	}

	public static function delete($name)
	{
		$dir = "uploads";
		@unlink($dir."/".$name);
		@unlink($dir."/watermark/".$name);
		@unlink($dir."/small_".$name);
		@unlink($dir."/medium_".$name);
		@unlink($dir."/wm_large_".$name);
		@unlink($dir."/large_".$name);
		@unlink($dir."/201_".$name);
	
	}
}