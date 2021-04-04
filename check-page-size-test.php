<?php 


    // $res = check_all_pages_size('Биофакер.pdf');
    // $res = check_all_pages_size('test-book.pdf');
    $res = check_all_pages_size('book.pdf');
    // $res = check_all_pages_size('combinepdf.pdf');
    echo (($res == false) ? 'FALSE' : ($res['width'] . "x" . $res['height']));

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
                    // echo $diff . "DIFF <br>";
                    $diff = ($diff < 0) ? ($diff * (-1)) : $diff; 
                    // echo $diff . "DIFF UNS <br>";
                    if ($diff > 1) return false;
                }
            }       
        }
        return $page_size;
    }


    function get_page_size_in_mm($size) {
        $size_orig = ($size / 72) * 25.4;
        // echo $size_orig;
        $size_discarded_fractional = number_format($size_orig, 2, '.', '');
        
        return round($size_discarded_fractional);
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

?>