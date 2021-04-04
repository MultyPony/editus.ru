<?php
    echo (image_check_DPI(__DIR__ . "/Биофакер.pdf") == false ? 'false' : 'true') . "<br>";
    echo (image_check_DPI(__DIR__ . "/sex-book.pdf") == false ? 'false' : 'true') . "<br>";
    echo (image_check_DPI(__DIR__ . "/zhir.pdf") == false ? 'false' : 'true') . "<br>";
    echo (image_check_DPI(__DIR__ . "/book.pdf") == false ? 'false' : 'true') . "<br>";
    echo (image_check_DPI(__DIR__ . "/test-book.pdf") == false ? 'false' : 'true') . "<br>";
    echo (image_check_DPI(__DIR__ . "/sample.pdf") == false ? 'false' : 'true') . "<br>";
    echo (image_check_DPI(__DIR__ . "/jpg2pdf.pdf") == false ? 'false' : 'true') . "<br>";

    /*
        Функция извлекает информация из всех изображений pdf файла.
        Затем проверяет DPI и если он < 200 возвращает false.
    */

    function image_check_DPI($pdf) {
        $result = true;
        $output = null;
        $ret_val = null;

        $command = "pdfimages -list " . $pdf;
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



?>