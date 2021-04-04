<?php 

    require_once 'config.inc.php';
    require_once 'include/db_class.php';

    if (isset($_FILES['file']['tmp_name'])) {
        // Здесь проверка pdf
        $name = $_FILES['file']['name'];
        $name = "test-image.jpg";
        $new_path_file = __DIR__ . "/uploads/$name";
        $res = move_uploaded_file($_FILES['file']['tmp_name'], $new_path_file);


        $res = main_check_pdf($new_path_file);

        // Успешная проверка
        if ($res[0]) {
            echo json_encode(array(
                'success' => $res[0],
                'formatId' => $res[1]['formatId'],
                'bookWidth' => $res[1]['formatWidth'],
                'bookHeight' => $res[1]['formatHeight'],
                'bookSize' => $res[1]['formatName'],
                'pageCount' => get_pdf_page_count($new_path_file),
            ));
        } else {
            // echo json_encode(array('error' => 'File not accepted'));
            echo json_encode(array('error' => $res[1]), JSON_UNESCAPED_UNICODE);
        }

    } else {
        echo 'Ничего не пришло';
    }


    function main_check_pdf($path_file) {
        // $result = check_fonts_embedded($_SERVER['DOCUMENT_ROOT'] . "./uploads/$name");
        $result = check_fonts_embedded($path_file);
        if (!$result) return [false, "Шрифты не встроены"];
        
        $result = image_check_DPI($path_file);
        if (!$result) return [false, "Разрешение изображений < 200 DPI"];
        
        $result = check_all_pages_size($path_file);
        if (!$result) return [false, "Размеры страниц отличаются внутри документа"];

        $result = DBREQ($result);
        if(!$result) return [false, "Размер страниц отличается от стандартных"];

        return [true, $result];
    }

    /* 
        Запрос в БД 
    */

    function DBREQ($page_size) {
        $db = new Db();
        
        $db->query("SELECT * FROM paperformat");
        while ($row = $db->fetch_array()) {
            if( $row['formatWidth'] == $page_size['width'] ||
                $row['formatWidth'] == ($page_size['width'] - 1) ||
                $row['formatWidth'] == ($page_size['width'] + 1)) {
                    return array(
                            'formatId' => $row['formatId'], 
                            'formatName' => $row['formatName'], 
                            'formatWidth' => $row['formatWidth'], 
                            'formatHeight' => $row['formatHeight'], 
                    );
            }
        }
        return false;
    }



    /*
        Проверяет pdf файл на наличие встроенных шрифтов.
        Если хотя бы 1 шрифт не встроен - проверка не пройдена.
        Стандартные шрифты не проверяются.
    */

    function check_fonts_embedded($pdf_file) {
        $default_fonts = ['Helvetica']; // Список стандартных шрифтов
        $output=null;
        $retval=null;
        
        // Переписать для unix
        exec("pdffonts \"$pdf_file\"", $output, $retval);

        $length = count($output);
        
        for ($i=2; $i < $length; $i++) {
            $haystack = substr($output[$i], 65);
            $words_array = str_word_count($haystack, 1, '0..9');
            // if (strpos($haystack, 'no') !== false) {  // Если шрифт не встроен
            if ($words_array[0] == 'no') {  // Если шрифт не встроен
                $fontName = explode(' ',trim($output[$i]));
                if(!in_array($fontName[0], $default_fonts)) {
                    return false;   // Шрифт не встроен!
                }
            }
        }
        return true; // Все ок! Шрифты встроены
    }

    /*
        Функция извлекает информация из всех изображений pdf файла.
        Затем проверяет DPI и если он < 200 возвращает false.
    */

    function image_check_DPI($pdf) {
        $output = null;
        $ret_val = null;

        $command = "pdfimages -list " . "\"$pdf\"";
        exec($command, $output, $ret_val);
        $length = count($output);
        for ($i=2; $i < $length; $i++) { 
            $words_array = str_word_count($output[$i], 1, '0..9');
            if (intval($words_array[12]) < 200) {
                return false;   // DPI < 200
            }
        }
        return true; // DPI >= 200
    }

    /*
        Функция возвращает колиство страниц pdf файла.
    */

    function get_pdf_page_count($pdf) {
        $output = null;
        $ret_val = null;

        $command = "pdfinfo " . "\"$pdf\"";
        exec($command, $output, $ret_val);
        $length = count($output);

        for ($i=0; $i < $length; $i++) {
            if (strpos($output[$i], 'Pages') !== false) {
                $pages_arr = explode(':', $output[$i]);
                return intval($pages_arr[1]);
            }
        }
        return false;
    }

    /*
        Функция проверяте размер всех страниц pdf файла.
        Если размеры внутри файла отличается возвращает false,
        иначе возвращает размер страницы (массив 2-х значений).
        Зависит от:
            - get_page_size_in_mm
            - get_pdf_page_count
    */

    function check_all_pages_size($pdf) {
        $page_count = get_pdf_page_count($pdf);
        if ($page_count == false) return false;

        $output = null;
        $ret_val = null;
        $page_size = null;

        $command = "pdfinfo -f 1 -l $page_count " . "\"$pdf\"";
        exec($command, $output, $ret_val);
        $length = count($output);

        for ($i=0; $i < $length; $i++) {
            if (strpos($output[$i], 'Page') !== false and strpos($output[$i], 'size') !== false) {
                $words_array = str_word_count($output[$i], 1, '0..9.');
                $size_index = array_search('size', $words_array);
                
                $width = get_page_size_in_mm($words_array[$size_index + 1]);
                $height = get_page_size_in_mm($words_array[$size_index + 3]);
                
                if (!isset($page_size)) {
                    $page_size['width'] = $width;
                    $page_size['height'] = $height;
                } else if ($page_size['width'] != $width || $page_size['height'] != $height) {
                    $diff = $page_size['width'] - $width;
                    $diff = ($diff < 0) ? ($diff * (-1)) : $diff; 
                    if ($diff > 1) return false;
                }
            }       
        }
        return $page_size;
    }


    function get_page_size_in_mm($size) {
        $size_orig = ($size / 72) * 25.4;
        $size_discarded_fractional = number_format($size_orig, 2, '.', '');
        
        return round($size_discarded_fractional);
    }
    
?>