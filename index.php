<?php
if (isset($_GET['debug'])) {
	 error_reporting(E_ALL);
	 ini_set('display_errors', 1); 
}

// подключаем источник данных
require_once('data.php');
// подключаем функции
require_once('functions.php');


// class Uniq
// {
// 	static public function image($source, $dest)
// 	{
// 		$image = file_get_contents($source);
// 		$im    = new Imagick();
// 		$im->readimageblob($image);

// 		$width  = $im->getImageWidth();
// 		$height = $im->getImageHeight();

// 		do {
// 			$ratio      = rand(0, 1000) / 100;
// 			$new_width  = floor($width * $ratio);
// 			$new_height = floor($height * $ratio);
// 		} while (
// 			($new_width < 700 || $new_width > 1000)
// 			&& ($new_height < 700 || $new_height > 1000));

// 		$im->scaleImage($new_width, $new_height);
// 		$im->rotateImage('#00000000', rand(-30, 30) / 100);
// 		$crop_pixels = rand(0, 5);
// 		$im->cropImage(
// 			$new_width - abs($crop_pixels), $new_height - abs($crop_pixels),
// 			0, 0
// 		);

// 		$color       = new ImagickPixel();
// 		$rand_color1 = rand(0, 255);
// 		$rand_color2 = rand(0, 255);
// 		$rand_color3 = rand(0, 255);
// 		$color->setColor("rgb($rand_color1,$rand_color2,$rand_color3)");
// 		$im->borderImage($color, rand(0, 1), rand(0, 1));

// 		$im->brightnessContrastImage(rand(-5, 5), rand(-5, 5));

// 		$image = $im->getimageblob();
// 		file_put_contents($dest, $image);
// 	}

// 	static public function video($source, $dest)
// 	{
// 		$noise_types = ['all', 'c0', 'c1', 'c2', 'c3'];
// 		$noise_flags = ['a', 'p', 't', 'u'];
// 		$noise       = $noise_types[array_rand($noise_types)];
// 		$noise_flag  = $noise_flags[array_rand($noise_flags)];
// 		$noise_value = rand(0, 10);
// 		$bitrate     = rand(750, 1250);
// 		$command
// 					 = "ffmpeg -i {$source} -vf noise={$noise}s={$noise_value}:{$noise}f={$noise_flag} -b:v {$bitrate}K {$dest} >/dev/null";
// 		shell_exec($command);
// 	}
// }

// // если уникализируем креативы
// if ($_FILES && $_POST['data-type'] == 'creative') {
// 	$uniq_files = [];
// 	$file       = [
// 		'name'     => $_FILES['file']['name'],
// 		'type'     => $_FILES['file']['type'],
// 		'tmp_name' => $_FILES['file']['tmp_name'],
// 	];

// 	$file_parts        = explode('.', $file['name']);
// 	$file['extension'] = end($file_parts);
// 	$file['basename']  = str_replace(
// 		".{$file['extension']}", '', $file['name']
// 	);
// 	// echo '<pre>';
// 	// print_r($file);
// 	// echo '</pre>';
	
// 	$file['source'] = $_SERVER['DOCUMENT_ROOT']."/tmp/source.{$file['extension']}";
// 	move_uploaded_file($file['tmp_name'], $file['source']);

// 	// $copies = isset($_POST['copies']) ? $_POST['copies'] : 1;
// 	$copies = $_POST['copies'] ? $_POST['copies'] : 1;

// 	// echo $copies;
	
// 	for ($i = 1; $i <= $copies; $i++) {
// 		if (strpos($file['type'], 'image') !== false) {
// 			$copy_filename
// 				= $_SERVER['DOCUMENT_ROOT']."/tmp/{$file['basename']}_uniq_{$i}.{$file['extension']}";
// 			Uniq::image($file['source'], $copy_filename);
// 			$uniq_files[] = $copy_filename;
// 		}

// 		if (strpos($file['type'], 'video') !== false) {
// 			$copy_filename
// 				= $_SERVER['DOCUMENT_ROOT']."/tmp/{$file['basename']}_uniq_{$i}.{$file['extension']}";
// 			Uniq::video($file['source'], $copy_filename);
// 			$uniq_files[] = $copy_filename;
// 		}
// 	}
	
// 	// если копия тотлько 1, то в архив не запихиваем
// 	if ($copies == 1) {
		
// 		$result_file = $uniq_files[0];
		
// 		if (is_file($result_file) && is_readable($result_file)) {
// 			header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
// 			header("Content-Type: application/zip");
// 			header("Content-Transfer-Encoding: Binary");
// 			header("Content-Length: " . filesize($result_file));
// 			header(
// 				"Content-Disposition: attachment; filename=\"" . basename(
// 					$result_file
// 				)
// 				. "\""
// 			);
// 			while (ob_get_level()) {
// 				ob_end_clean();
// 			}
// 			readfile($result_file);
// 		}
// 	} 

// 	$zip          = new ZipArchive();
// 	$zip_filename = $_SERVER['DOCUMENT_ROOT']."/tmp/uniq_result.zip";
// 	@unlink($zip_filename);
// 	$zip->open($zip_filename, ZipArchive::CREATE);

// 	foreach ($uniq_files as $uniq_file) {
// 		if (@file_exists($uniq_file)) {
// 			$zip->addFile($uniq_file, pathinfo($uniq_file)['basename']);
// 		}
// 	}
// 	$zip->close();

// 	foreach ($uniq_files as $uniq_file) {
// 		@unlink($uniq_file);
// 	}

// 	if (is_file($zip_filename) && is_readable($zip_filename)) {
// 		header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
// 		header("Content-Type: application/zip");
// 		header("Content-Transfer-Encoding: Binary");
// 		header("Content-Length: " . filesize($zip_filename));
// 		header(
// 			"Content-Disposition: attachment; filename=\"" . basename(
// 				$zip_filename
// 			)
// 			. "\""
// 		);
// 		while (ob_get_level()) {
// 			ob_end_clean();
// 		}
// 		readfile($zip_filename);
// 	}
// }




// уникализация картинок для ленда
// function image($source){
// 	// получаем картинку по указанному адресу
// 	$image = file_get_contents($source);
// 	$im    = new Imagick();
// 	//Imagick::readImageBlob — Reads image from a binary string
// 	$im->readimageblob($image);

// 	$width  = $im->getImageWidth();
// 	$height = $im->getImageHeight();

// 	// определяем какая из сторон больше
// 	if ($height < $width) {
// 		$biggest_side = $width;
// 		$smaller_side = $height;
// 	}
// 	else {
// 		$biggest_side = $height;
// 		$smaller_side = $width;
// 	}
// 	if ($biggest_side / $smaller_side <3) {

// 		// задаём угол поворота
// 		$angle = rand(0, 1)?.2:-.2;

// 		$im->rotateImage('#ffffff', $angle);
// 		// вычисляем составные части наименьшей стороны 
// 		$smaller_side_x1 = $biggest_side*sin(deg2rad(abs($angle)));
// 		$smaller_side_x2 = $smaller_side*cos(deg2rad(abs($angle)));

// 		// фактические размеры после поворота
// 		$fact_new_width =  $im->getImageWidth();
// 		$fact_new_height =  $im->getImageHeight();

// 		if ($height < $width) {
// 				$fact_new_biggest_side = $fact_new_width;
// 				$fact_new_smaller_side = $fact_new_height;
// 		}
// 		else {
// 				$fact_new_biggest_side = $fact_new_height;
// 				$fact_new_smaller_side = $fact_new_width;
// 		}

// 		// вычисляемый размер после поворота
// 		$calc_new_smaller_side = $smaller_side_x1 + $smaller_side_x2;
		
// 		// отношение высоты полезной части картинки к высоте с незаполненными областями
// 		$ratio = ( $calc_new_smaller_side - 2 * $smaller_side_x1  ) / $fact_new_smaller_side ;

// 		// увеличаваем картинку
// 		if ($height < $width) {
// 				$im->scaleImage(floor($fact_new_biggest_side / $ratio), floor($fact_new_smaller_side / $ratio));
// 		} else {
// 				$im->scaleImage(floor($fact_new_smaller_side / $ratio), floor($fact_new_biggest_side / $ratio));
// 		}

// 		$width_arter_scale =  $im->getImageWidth();
// 		$height_arter_scale =  $im->getImageHeight();

// 		// обрезаем от картинки части, которые указывали на поворот
// 		// получаем итоговое изображение равное по размерам изначальному
// 		$im->cropImage($width, $height, floor(($width_arter_scale - $width)/2-1), floor(($height_arter_scale - $height)/2-1) );
// 	}

// 	// меняем яркость и контрастность
// 	$im->brightnessContrastImage(rand(-5, 5), rand(-5, 5));

// 	$image = $im->getimageblob();

// 	// Пишет данные в файл (куда, что)
// 	$result = file_put_contents($source, $image); 

// 	$im -> clear();

// 	return $result;
// }

// найти все файлы в папке и во вложенных папках
function rglob($pattern, $flags = 0) {
	$files = glob($pattern, $flags); 
	foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
	 $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
	}
	return $files;
}



// удаление папки
function RDir( $path ) {
	// если путь существует и это папка
	if ( file_exists( $path ) AND is_dir( $path ) ) {
		// открываем папку
		 $dir = opendir($path);
		 while ( false !== ( $element = readdir( $dir ) ) ) {
			 // удаляем только содержимое папки
			 if ( $element != '.' AND $element != '..' )  {
				 $tmp = $path . DIRECTORY_SEPARATOR . $element;
				 chmod( $tmp, 0777 );
				// если элемент является папкой, то
				// удаляем его используя нашу функцию RDir
				 if ( is_dir( $tmp ) ) {
					RDir( $tmp );
				// если элемент является файлом, то удаляем файл
				 } else {
					 unlink( $tmp );
				}
			}
		}
		// закрываем папку
		 closedir($dir);
		 // удаляем саму папку
		if ( file_exists( $path ) ) {
			rmdir( $path );
		}
	}
 }

 // архивация содержимого папки
function zip($source, $destination)
{
	if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
	}

	$zip = new ZipArchive();
	if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
	}

	$source = str_replace('\\', DIRECTORY_SEPARATOR, realpath($source));
	$source = str_replace('/', DIRECTORY_SEPARATOR, $source);

	if (is_dir($source) === true) {
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source),
				RecursiveIteratorIterator::SELF_FIRST);

		foreach ($files as $file) {
			$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
			$file = str_replace('/', DIRECTORY_SEPARATOR, $file);

			if ($file == '.' || $file == '..' || empty($file) || $file == DIRECTORY_SEPARATOR) {
					continue;
			}
			// Ignore "." and ".." folders
			if (in_array(substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1), array('.', '..'))) {
					continue;
			}

			$file = realpath($file);
			$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
			$file = str_replace('/', DIRECTORY_SEPARATOR, $file);

			if (is_dir($file) === true) {
					$d = str_replace($source . DIRECTORY_SEPARATOR, '', $file);
					if (empty($d)) {
							continue;
					}
					$zip->addEmptyDir($d);
			} elseif (is_file($file) === true) {
					$zip->addFromString(str_replace($source . DIRECTORY_SEPARATOR, '', $file),
							file_get_contents($file));
			} else {
					// do nothing
			}
		}
	} elseif (is_file($source) === true) {
			$zip->addFromString(basename($source), file_get_contents($source));
	}

	return $zip->close();
}

// функция сортировки по днине (сначала длинные)
function sort_func($a,$b) //объявляем функцию
{
if (strlen($a) == strlen($b)) //если длины значений в переменных $a и $b равны возвращаем 0 (закомментировано)
{
			//  return 0;
}
//если длина значения в переменной $a меньше длины значения в переменной $b, то возвращаем -1, иначе возвращаем 1
		return (strlen($a) >strlen( $b)) ? -1 : 1; 
}


//========================== WHITE ========================

// копируем картинки из запасников в рабочий ленд	
function picReplace($from, $to) {
	
	// $pic_url = $from;
	// echo $from;
	// echo "<br>";
	// echo $to;
	// echo "<br>";
	// получаем список запасных картинок
	// $imgFiles = rglob($pic_url."*.{jpg}",GLOB_BRACE);
	$imgFiles = rglob($from."*.{jpg,png}",GLOB_BRACE);

	// перемешиваем список запасных картинок
	shuffle($imgFiles);

	// путь к рабочим картинкам
	// $land_url = $temp ."assets". DIRECTORY_SEPARATOR ."img". DIRECTORY_SEPARATOR ."bg". DIRECTORY_SEPARATOR .$size;
	// получаем список рабочих картинок
	// $landImgFiles = rglob($land_url."*.{jpg}",GLOB_BRACE);
	$landImgFiles = rglob($to."*.{jpg,png}",GLOB_BRACE);
	// echo "<pre>";
	// print_r($landImgFiles);
	// echo "</pre>";
	// echo "<pre>";
	// print_r($imgFiles);
	// echo "</pre>";
	// die;
	// заменяем картинки в ленде на случайные
	$i = 0;
	foreach($landImgFiles as $path)  {
		// если запасные картинки в массиве кончились, то начинаем массив с начала
		if (!$imgFiles[$i]) $i = 0;
		copy($imgFiles[$i], $path );
		$i++;
	}
}

// копируем логотип
function logoReplace($logo_storage_url, $logo_site_url) {
	// получаем список запасных картинок
	$imgFiles = rglob($logo_storage_url."*.{png}",GLOB_BRACE);

	// перемешиваем список запасных картинок
	shuffle($imgFiles);

	// копируем первый попавшийся логотип на место логотипа сайта
	copy($imgFiles[0], $logo_site_url );
}


//========================== /WHITE ========================

//========================== WHITE ========================
if ($_POST['data-type'] == 'white') {
	// echo "<pre>";
	// print_r($_SERVER);
	// echo "</pre>";
	 //die;
	$root = '';
	if ($_SERVER[REMOTE_ADDR] && $_SERVER[REMOTE_ADDR] === "127.0.0.1") {
		$root = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR;
	} 
	// какая страна выбрана
	$country = $_POST['country'];
	// какая тема выбрана
	$theme = $_POST['theme'];
	// массив с размерами изображений
	$sizeArr = array('1290', '740', '448');

	// путь к директории вайта
	$white_ulr = $root."mywhite".DIRECTORY_SEPARATOR;

	// путь к ленду
	$land_zip_url = $white_ulr."land".DIRECTORY_SEPARATOR.$country.DIRECTORY_SEPARATOR."dist".DIRECTORY_SEPARATOR;
	// путь к запасным картинкам
	$pic_all_url = $white_ulr."pic".DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR;

	
	
	// временные файлы
	$temp = $white_ulr."temp";
	// $temp = $white_ulr."temp";
	// путь для преобразуемого ленда
	$temp_folder = $temp. DIRECTORY_SEPARATOR . "folder".DIRECTORY_SEPARATOR;

	// путь для готового архива
	$temp_zip = $temp. DIRECTORY_SEPARATOR . "zip".DIRECTORY_SEPARATOR;

	// создаём папку temp
	@mkdir($temp. DIRECTORY_SEPARATOR, 0777, true);

	// создаём папку folder
	@mkdir($temp_folder, 0777, true);

	// создаём папку zip
	@mkdir($temp_zip, 0777, true);

	// извлекаем ленд в папку темп
	$zip = new ZipArchive;

	if ($zip->open($land_zip_url ."source_".$country.".zip") === TRUE) {
		$zip->extractTo($temp_folder);
		$zip->close();
	} 
	// ============================ COLOR SCHEME ==============================
	

		

		$search_color_arr = array(
			'#96cd00',
			'#003046',
			'#fff',
			'#0579fc',
			'#ffb400',
			'#11bd11',
			'#ff4a4a',
			'#ffbebe',
			'#c7d2d6',
			'#f2f5f5',
			'#282828',
			'#e5e5e5',
			'#8b8b8b'
		);

		// получаемцвету RGB цвета
		foreach($search_color_arr as $color) {
			$search_color_rgb_arr[] = hexToRgb($color);
		}

		// если меняем цветовую схему на случайную
		if ($_POST['scheme'] === 'true') {
			// поучаем случайную схему из заранее приготовленных
			$rand_sceme = getColorScheme();

			$search_color_rgb_arr[0] = hexToRgb($rand_sceme[0]);
			$search_color_rgb_arr[1] = hexToRgb($rand_sceme[1]);
		}
		// устанавливаем уровень мутации цвета, если он выбран
		if ($_POST['mutation'] ) {
			$mutation = (int)$_POST['mutation'];
		} else {
			$mutation = 0;
		}
		
		// создаём целевые цвета с мутацией
		foreach($search_color_rgb_arr as $color) {
			$target_color_arr[] = "rgb("
				.getRandColor($color['red'],$mutation).","
				.getRandColor($color['green'],$mutation).","
				.getRandColor($color['blue'],$mutation).")";
		}
		
		// путь к папке со стилями
		$css_url = $temp_folder."assets".DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR;
		// список css файлов
		$css_arr = rglob ($css_url."*.{css}",GLOB_BRACE);

		// проходим по каждому css файлу (должен быть 1)
		foreach ($css_arr as $css) {
			// получаем текстовый файл в виде строки
			$css_string = file_get_contents($css);

			// str_replace — Заменяет все вхождения строки поиска на строку замены (что ищем, чем заменяем, где ищем)
			// перезаписываем в эту же строку, не в другую
			$css_string = str_replace($search_color_arr, $target_color_arr, $css_string);
			// добавляем белую тень буквам, чтобы они были видны на тёмном фоне
			// $css_string = $css_string."*{text-shadow:0px 0px 2px #FFFFFF;}";
			// записываем строку обратно в файл стилей
			$result_css_rewrite = file_put_contents($css, $css_string);
		}
		
		
	// ============================ / COLOR SCHEME ==============================


	// путь к рабочим картинкам
	$pic_site_url = $temp_folder ."assets". DIRECTORY_SEPARATOR ."img". DIRECTORY_SEPARATOR ."bg". DIRECTORY_SEPARATOR;

	// проходим по каждому размеру
	foreach($sizeArr as $size) {
		// echo $size;
		// echo "<br>";
		// echo $pic_all_url;
		// echo "<br>";
		// echo $temp_folder;
		// die;
		$size = $size . DIRECTORY_SEPARATOR;
		// заменить картинки новыми (высота (1290, 740, 448), путь к запасным картинкам, путь к папке темп)
		picReplace($pic_all_url . $size, $pic_site_url . $size);
	}


	//============================= LOGO CHANGE ===================================
	// путь к хранилищу логотипов
	$logo_storage_url = $pic_all_url."logo".DIRECTORY_SEPARATOR;

	// путь к логотипу на сайте
	$logo_site_url = $temp_folder . "assets". DIRECTORY_SEPARATOR ."img". DIRECTORY_SEPARATOR ."logo".DIRECTORY_SEPARATOR;
	// echo $logo_site_url;
	// die;
	picReplace($logo_storage_url, $logo_site_url);

	// удаляем favicon
	//unlink($temp_folder . "favicon.ico");

	//============================= / LOGO CHANGE ===================================
	//============================= SET CONTACTS =======================================


	// получили массив со списком всех текстовых файлов
		$textFiles = rglob ($temp_folder."*.{html,HTML,php,PHP}",GLOB_BRACE); //эта маска - не регулярка!

		// echo "<pre>";
		// print_r($textFiles);
		// echo "</pre>";
		
		// имя компании и email
		$company = getCompanyName();

		// адрес и телефон компании
		$contacts = getContacts($country);
		// $company_name = $company['name'];
		// $company_email = $company['email'];

		// echo $company_name;
		// echo "<br>";
		// echo $company_email;
		// echo "<br>";
		// die;

		// массив искомых значений
		$search_values = array(
			"PUT_COMPANY_NAME_HERE",
			"PUT_COMPANY_ADDRESS_HERE",
			"PUT_COMPANY_PHONE_HERE",
			"PUT_COMPANY_EMAIL_HERE"
		);
		// массив целевых значений
		$replase_values = array(
			$company['name'],
			$contacts['address'],
			$contacts['phone'],
			$company['email']
		);
		// echo "<pre>";
		// print_r($search_values);
		// echo "</pre>";
		// echo "<pre>";
		// print_r($replase_values);
		// echo "</pre>";
		// die;
		foreach ($textFiles as $htmlFile) {
			
			// получаем текстовый файл в виде строки
			$fileString = file_get_contents($htmlFile);
			// str_replace — Заменяет все вхождения строки поиска на строку замены (что ищем, чем заменяем, где ищем)
			// перезаписываем в эту же строку, не в другую
			$fileString = str_replace($search_values, $replase_values, $fileString);
			
			$resultRewrite = file_put_contents($htmlFile, $fileString);
		}

	//============================= / SET CONTACTS =======================================

	renamePictures($temp_folder);
	
	//=========================== архивация =====================================
	$result_zip = $temp_zip. "white_" .$country. ".zip";
	// архивируем папку
	zip($temp_folder, $result_zip);
	// die;
	if (is_file($result_zip) && is_readable($result_zip)) { 
		header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
		header("Content-Type: application/zip");
		header("Content-Transfer-Encoding: Binary");
		header("Content-Length: " . filesize($result_zip));
		header(
			"Content-Disposition: attachment; filename=\"" . basename(
				$result_zip
			)
			. "\""
		);
		while (ob_get_level()) {
			ob_end_clean();
		}
		readfile($result_zip);
	}

	// очищаем папку temp
	RDir( $temp );
	//=========================== /архивация =====================================
	
	
	
}
//========================== /WHITE ========================

















// if ($_FILES && $_POST['data-type'] == 'land') {
	
// 	$file = [
// 		'name'     => $_FILES['file']['name'],
// 		'type'     => $_FILES['file']['type'],
// 		'tmp_name' => $_FILES['file']['tmp_name'],
// 	];

// 	// если не zip-архив , то прерываем выполнение
// 	if ( $file['type'] != 'application/x-zip-compressed') {
// 		echo "<h1>Выберите ZIP-архив</h1>";
// 		die;
// 	}
// 	// если скобки квадратные, то ничего работать не будет, поэтому заменяем на круглые
// 	$nameBrackets=array(['[','('],[']',')']);
// 	foreach ($nameBrackets as $change) {
// 		$file['name'] = str_replace($change[0], $change[1], $file['name']);
// 	}
	

// 	$file_parts = explode('.', $file['name']);
// 	// получаем расширение файла
// 	$file['extension'] = end($file_parts);
// 	// имя файла без расширения
// 	$file['basename'] = str_replace(".{$file['extension']}", '', $file['name']);

// 	// куда сохраняем архив
// 	$temp = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
// 	$url = $temp . $file['basename'];
// 	$folder = $url.DIRECTORY_SEPARATOR."folder".DIRECTORY_SEPARATOR;

// 	// создаём папку temp
// 	@mkdir($temp, 0777, true);
// 	// создаём папку для загружаемого архива
// 	@mkdir($url, 0777, true);

// 	// $file['source'] = $_SERVER['DOCUMENT_ROOT']."/temp/source.{$file['extension']}";
// 	$file['source'] = $url.DIRECTORY_SEPARATOR. "source.zip";
// 	move_uploaded_file($file['tmp_name'], $file['source']);// архив в папке temp
// 	// создаём директорию folder
// 	@mkdir($folder, 0777, true);

// 	$zip = new ZipArchive;
// 	if ($zip->open($url . DIRECTORY_SEPARATOR."source.zip") === TRUE) {
// 		$zip->extractTo($folder);
// 		$zip->close();
// 	} 
	
	
	
// 	if ($_POST['select'] == 'all' || $_POST['select'] == 'rename') {
	
	//============================ переименовывание картинок ================================
	// function renamePictures($folder){
	// 	// получили массив со списком всех картинок
	// 	$picForRename = rglob ($folder."*.{jpg,png,jpeg,gif,svg}",GLOB_BRACE); //эта маска - не регулярка!

	// 	$namesArr = [];

	// 	foreach($picForRename as $path) {
	// 		$name = pathinfo($path, PATHINFO_BASENAME); // hero.jpg
	// 		$extension = pathinfo($path, PATHINFO_EXTENSION); // jpg
	// 		// echo "<div>name: " . $name ."</div>";
	// 		$namesArr[] = $name;
	// 	}

	// 	//сортируем с использованием функции sort_func, описанной выше
	// 	usort($namesArr, "sort_func");

	// 	// создаём замену имени
	// 	// preg_split — Разбивает строку по регулярному выражению
	// 	$words = preg_split('//', 'abcdefghijklmnopqrstuvwxyz0123456789', -1);
	// 	// перемешиваем массив
	// 	shuffle($words);

	// 	foreach($words as $word) {
	// 			$mask .= $word;
	// 	}

	// 	$counter=1; // счетчик - начинаем с 1

	// 	//создаём ассоциативный массив с уникальными именами
	// 	$unicNamesArr = array();
	// 	foreach($namesArr as $name) {
	// 		// $unicNamesArr[$name] = 
	// 		$extension = pathinfo($name, PATHINFO_EXTENSION);
	// 		// echo "<div>extension: " . $extension ."</div>";
	// 		// преобразуем переменные в строки
	// 		$newname=(string)$mask.(string)$counter.'.'.(string)$extension;
	// 		$counter++;
	// 		// записываем новое имя как значение для старого
	// 		$unicNamesArr[$name] = $newname;
	// 	}

	// 	// переименовываем картинки в папках
	// 	// обходим массив с путями к картинкам
	// 	foreach($picForRename as $path) {
	// 		$nameInFolder = pathinfo($path, PATHINFO_BASENAME); // hero.jpg
	// 		$directory = pathinfo($path, PATHINFO_DIRNAME); // 

	// 		// обходим массив с новыми именами, и если старое имя в этом массиве совпало с
	// 		// именем картинки из массива с путями, то переименовываем картинку в папке используя путь
	// 		foreach($unicNamesArr as $oldname=>$newname) {
	// 			if ($oldname == $nameInFolder) {
	// 				// переименовываем файлы в папке (старое имя, новое имя)
	// 				rename($directory . DIRECTORY_SEPARATOR . $nameInFolder,$directory . DIRECTORY_SEPARATOR .  $newname);
	// 			}
	// 		}

	// 	}

	// 	// переименовывание изображений в текстовых файлах
	// 	// получили массив со списком всех текстовых файлов
	// 	$textFiles = rglob ($folder."*.{html,HTML,htm,HTM,css,CSS,php,PHP}",GLOB_BRACE); //эта маска - не регулярка!

	// 	// echo "<pre>";
	// 	// print_r($textFiles);
	// 	// echo "</pre>";
		
	// 	foreach ($textFiles as $htmlFile) {
			
	// 		// получаем текстовый файл в виде строки
	// 		$fileString = file_get_contents($htmlFile);
			
	// 		// обходим массив с уникальными именами и в строке файла ищем совпадения
	// 		foreach($unicNamesArr as $oldname=>$newname) {

	// 			// ставим скобки или кавычки вокруг имени файла
	// 			$changes=array(['/','"'],['/',"'"],['"','"'],["'","'"],['(',')'],['/',')']);
	// 			foreach ($changes as $change)
	// 				{
	// 					$old1=$change[0].$oldname.$change[1]; 
	// 					$new1=$change[0].$newname.$change[1];
	// 					// if ($old1 == '/buyer-bg.png"') {

	// 					// 	echo $old1;
	// 					// 	echo "<br>";
	// 					// 	echo $new1;
	// 					// 	echo "<br>";
	// 					// 	echo "<br>";
	// 					// }
	// 					// str_replace — Заменяет все вхождения строки поиска на строку замены (что ищем, чем заменяем, где ищем)
	// 					// перезаписываем в эту же строку, не в другую
	// 					$fileString = str_replace($old1, $new1, $fileString);
	// 				}
	// 		}
	// 		$resultRewrite = file_put_contents($htmlFile, $fileString);
	// 	}
	// }
		// / renamePictures end

// 	}
// 	//============================ /переименовывание картинок ================================
// 	//=========================== обработка изображений =====================================
// 	if ($_POST['select'] == 'all' || $_POST['select'] == 'unic') {

// 		// получили массив со списком всех картинок
// 		$cdir = rglob ($folder."*.{jpg,png}",GLOB_BRACE); //эта маска - не регулярка!
// 		// обходим массив и получаем имена файлов
// 		$i = 0;
// 		foreach( $cdir as $path) {
				
// 			// echo "<div class='error".$i."'>".$path ." ...error</div>";
				
// 			try {
// 				$result = image($path);
	
// 				// если функция вернула true, то файл перезаписан
// 				if ($result) {
// 					// echo "<div>".$path . "  - success</div>";
// 					// echo "<style>.error".$i."{display:none;}</style>";
// 				} else {
// 					throw new Exception();
// 				}
// 			}
// 			catch (Exception $ex) {
// 				//Выводим сообщение об исключении.
// 				// а лучше не выводим, тогда если появится ошибка,
// 				// она не застопорит весь остальной процес
// 				// echo $ex->getMessage();
// 			}
	
// 			$i++;
// 		}
// 	}
// 	//=========================== /обработка изображений =====================================


// 	//=========================== архивация =====================================
// 	$result_zip = $url.DIRECTORY_SEPARATOR. $file['name'];
// 	// архивируем папку
// 	zip($folder, $result_zip);

// 	if (is_file($result_zip) && is_readable($result_zip)) { 
// 		header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
// 		header("Content-Type: application/zip");
// 		header("Content-Transfer-Encoding: Binary");
// 		header("Content-Length: " . filesize($result_zip));
// 		header(
// 			"Content-Disposition: attachment; filename=\"" . basename(
// 				$result_zip
// 			)
// 			. "\""
// 		);
// 		while (ob_get_level()) {
// 			ob_end_clean();
// 		}
// 		readfile($result_zip);
// 	}

// 	// очищаем папку temp
// 	RDir( $temp );
// 	//=========================== /архивация =====================================

// }
?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport"
				content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet"
				href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
				integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
				crossorigin="anonymous">
	<title>White page</title>
</head>
<body>
<div class="container" style="display: flex; flex-direction:column; margin-top: 100px;">
	<!-- <div class="row">
		<div class="col-12 col-lg-6 offset-lg-3 form-wrapper">
			<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="data-type" value="creative">
				<div class="custom-file">
					<input type="file" class="custom-file-input form-control-lg"
						id="customFile" name="file">
					<label class="custom-file-label" for="customFile">Выбери креатив</label>
				</div>
				<div class="my-3 col-12 col-lg-6 offset-lg-3">
					<input type="number" class="form-control"
						placeholder="Количество копий" name="copies">
				</div>
				<div class="my-3 text-center">
					<button type="submit" class="btn btn-lg btn-primary">
					Уникализировать креатив
					</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-lg-6 offset-lg-3 form-wrapper">
			<form method="post" enctype="multipart/form-data" action="index.php">
				<input type="hidden" name="data-type" value="land">
				<div class="custom-file">
					<input type="file" class="custom-file-input form-control-lg"
								id="customFile" name="file">
					<label class="custom-file-label" for="customFile">Выбери zip-архив лендинга</label>
				</div>
				<div class="form-group my-3">
					<select class="form-control" name="select">
					<option value="all">переименование + уникализация</option>
						<option value="rename">только переименование</option>
						<option value="unic">только уникализация</option>
					</select>
				</div>
				<div class="my-3 text-center">
					<button type="submit" class="btn btn-lg btn-primary">
						Уникализировать ленд
					</button>
				</div>
			</form>
		</div>
	</div> -->
	<div class="row">
		<div class="col-12 col-lg-6 offset-lg-3 form-wrapper">
			<form method="post" enctype="multipart/form-data" action="index.php">
				<input type="hidden" name="data-type" value="white">
				<!-- <input type="hidden" name="scheme" value="true"> -->
				<div class="form-group my-3">
					<label for="theme">Тема:</label>
					<select class="form-control" name="theme" data-theme>
						<!-- <option id="theme" value="cosmetics">выбери тематику</option> -->
						<option value="cosmetics">Красота</option>
					</select>
				</div>
				<div class="form-group my-3">
					<label for="language">Язык:</label>
					<select id="language" class="form-control" name="country" data-language>
						<option value="es">ES - испанский</option>
						<option value="hu">HU - венгерский</option>
						<option value="it">IT - итальянский</option>
						<option value="pl">PL - польский</option>
						<option value="ro">RO - румынский</option>
						<option value="en">EN - английский</option>
						<!-- <option value="ru">RU - русский</option> -->
						<!-- <option value="bg">BG - болгарский</option> -->
						<option value="vi">VI - вьетнамский</option>
						<!-- <option value="nl">NL - голландский</option> -->
						<option value="el">EL - греческий</option>
						<!-- <option value="da">DA - датский</option> -->
						<!-- <option value="ms">MS - малайский</option> -->
						<!-- <option value="de">DE - немецкий</option> -->
						<option value="pt">PT - португальский</option>
						<!-- <option value="sk">SK - словацкий</option> -->
						<!-- <option value="th">TH - тайский</option> -->
						<!-- <option value="fr">FR - французский</option> -->
						<!-- <option value="hr">HR - хорватский</option> -->
						<!-- <option value="cs">CS - чешский</option> -->
					</select>
				</div>
				<div class="form-check">
					<input type="checkbox" class="form-check-input" id="check1" name="scheme" value="true" checked data-scheme>
					<label class="form-check-label" for="check1">Изменить цветовую схему</label>
				</div>

				<div class="form-group my-3">
				<div class="form-group">
				<label for="formControlRange">Максимальная мутация цвета: <span class="percent" data-percent>10</span><span class="percent">%</span> </label>
					<input type="range" class="form-control-range" name="mutation" id="formControlRange" min="0" max="100" value="10" step="1" data-range>
				</div>
				</div>

				<div class="my-3 text-center">
					<button type="submit" class="btn btn-lg btn-primary">
						Скачать вайт
					</button>
				</div>
			</form>
		</div>
			<div class="col-12 button-wrapper">
				<a class="button btn btn-lg btn-secondary" href="http://109.68.214.169/">К уникализатору</a>
			</div>
	</div>
</div>


<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
				integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
				crossorigin="anonymous"></script> -->
<script src="js/jquery-3.5.0.min.js"></script>
<!-- <script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
	crossorigin="anonymous"></script> -->
<script
	src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
	integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
	crossorigin="anonymous"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.2/bootstrap-slider.min.js"></script> -->
<script>
	// $("#ex2").slider({});
	// $("#ex12b").slider({ id: "slider12b", min: 0, max: 10, range: true, value: [3, 7] });
	// var sliderB = new Slider("#ex12b", { id: "slider12b", min: 0, max: 10, range: true, value: [3, 7] });
	// var slider = new Slider('#ex2', {});
</script>
<style>
	body {
		background-color: #DBFFEF;
	}
	form {
		padding: 20px;
		border: 1px solid black;
		border-radius: 5px;
		background-color: aliceblue;
	}
	.form-wrapper {
		width: 100%;
		margin-top: 20px;
		margin-bottom: 20px;
	}
	.button-wrapper {
		display: flex;
		justify-content: center;
		margin-top: 20px;
	}
	.button {
		background-image: radial-gradient(circle farthest-corner at 50.1% 52.3%, rgba(255, 231, 98, 1) 58.2%, rgba(251, 212, 0, 1) 90.1%);
		color: #222;
	}
	.percent {
		font-weight: bold;
		font-size: 20px;
	}
</style>
<script src=js/script.js></script>
</body>
</html>