<?php

// перевод цвета из HEX в RGB
function hexToRgb($color) {
    // проверяем наличие # в начале, если есть, то отрезаем ее
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }
   
    // разбираем строку на массив
    if (strlen($color) == 6) { // если hex цвет в полной форме - 6 символов
        list($red, $green, $blue) = array(
            $color[0] . $color[1],
            $color[2] . $color[3],
            $color[4] . $color[5]
        );
    } elseif (strlen($color) == 3) { // если hex цвет в сокращенной форме - 3 символа
        list($red, $green, $blue) = array(
            $color[0]. $color[0],
            $color[1]. $color[1],
            $color[2]. $color[2]
        );
    }else{
        return false; 
    }
 
    // переводим шестнадцатиричные числа в десятичные
    $red = hexdec($red); 
    $green = hexdec($green);
    $blue = hexdec($blue);
     
    // вернем результат
    return array(
        'red' => $red, 
        'green' => $green, 
        'blue' => $blue
    );
}


// получаем рандомное значение цвета для RGB в небольших пределах
function getRandColor($number, $mutation) {

	if ( is_int((int)$mutation) && (int)$mutation > 0 && (int)$mutation <= 100) {
		$mut_num = floor(255 * $mutation / 100);
	} else {
		return (string)$number;
	}

		// $invert
	// echo $number;
	// echo "<br>";
	// $number = 255 - (int)$number;
	// if ($invert)
	$rand = rand($number-$mut_num, $number+$mut_num);
	if ($rand < 0) {
		$rand = $rand * -1;
	}
	else if ($rand > 255) {
		$rand = 255 - ($rand - 255);
	}
	return (string)$rand;
}

function renamePictures($folder){
    // получили массив со списком всех картинок
    $picForRename = rglob ($folder."*.{jpg,png,jpeg,gif,svg}",GLOB_BRACE); //эта маска - не регулярка!

    $namesArr = [];

    foreach($picForRename as $path) {
        $name = pathinfo($path, PATHINFO_BASENAME); // hero.jpg
        $extension = pathinfo($path, PATHINFO_EXTENSION); // jpg
        // echo "<div>name: " . $name ."</div>";
        $namesArr[] = $name;
    }

    //сортируем с использованием функции sort_func, описанной выше
    usort($namesArr, "sort_func");

    // создаём замену имени
    // preg_split — Разбивает строку по регулярному выражению
    $words = preg_split('//', 'abcdefghijklmnopqrstuvwxyz0123456789', -1);
    // перемешиваем массив
    shuffle($words);

    foreach($words as $word) {
            $mask .= $word;
    }

    $counter=1; // счетчик - начинаем с 1

    //создаём ассоциативный массив с уникальными именами
    $unicNamesArr = array();
    foreach($namesArr as $name) {
        // $unicNamesArr[$name] = 
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        // echo "<div>extension: " . $extension ."</div>";
        // преобразуем переменные в строки
        $newname=(string)$mask.(string)$counter.'.'.(string)$extension;
        $counter++;
        // записываем новое имя как значение для старого
        $unicNamesArr[$name] = $newname;
    }

    // переименовываем картинки в папках
    // обходим массив с путями к картинкам
    foreach($picForRename as $path) {
        $nameInFolder = pathinfo($path, PATHINFO_BASENAME); // hero.jpg
        $directory = pathinfo($path, PATHINFO_DIRNAME); // 

        // обходим массив с новыми именами, и если старое имя в этом массиве совпало с
        // именем картинки из массива с путями, то переименовываем картинку в папке используя путь
        foreach($unicNamesArr as $oldname=>$newname) {
            if ($oldname == $nameInFolder) {
                // переименовываем файлы в папке (старое имя, новое имя)
                rename($directory . DIRECTORY_SEPARATOR . $nameInFolder,$directory . DIRECTORY_SEPARATOR .  $newname);
            }
        }

    }

    // переименовывание изображений в текстовых файлах
    // получили массив со списком всех текстовых файлов
    $textFiles = rglob ($folder."*.{html,HTML,htm,HTM,css,CSS,php,PHP,js,JS}",GLOB_BRACE); //эта маска - не регулярка!

    // echo "<pre>";
    // print_r($textFiles);
    // echo "</pre>";
    
    foreach ($textFiles as $htmlFile) {
        
        // получаем текстовый файл в виде строки
        $fileString = file_get_contents($htmlFile);
        
        // обходим массив с уникальными именами и в строке файла ищем совпадения
        foreach($unicNamesArr as $oldname=>$newname) {

            // ставим скобки или кавычки вокруг имени файла
            $changes=array(['/','"'],['/',"'"],['"','"'],["'","'"],['(',')'],['/',')']);
            foreach ($changes as $change)
                {
                    $old1=$change[0].$oldname.$change[1]; 
                    $new1=$change[0].$newname.$change[1];
                    // if ($old1 == '/buyer-bg.png"') {

                    // 	echo $old1;
                    // 	echo "<br>";
                    // 	echo $new1;
                    // 	echo "<br>";
                    // 	echo "<br>";
                    // }
                    // str_replace — Заменяет все вхождения строки поиска на строку замены (что ищем, чем заменяем, где ищем)
                    // перезаписываем в эту же строку, не в другую
                    $fileString = str_replace($old1, $new1, $fileString);
                }
        }
        $resultRewrite = file_put_contents($htmlFile, $fileString);
    }
}

?>