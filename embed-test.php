<?php 
    /*
        Проверяет pdf файл на наличие встроенных шрифтов.
        Если хотя бы 1 шрифт не встроен - проверка не пройдена.
        Стандартные шрифты не проверяются.
    */

    function check_fonts_embedded($pdf_file) {
        $default_fonts = ['Helvetica']; // Список стандартных шрифтов
        $output=null;
        $retval=null;
        
        exec($_SERVER['DOCUMENT_ROOT'] . "pdffonts $pdf_file", $output, $retval);

        $length = count($output);
        
        for ($i=2; $i < $length; $i++) { 
            $haystack = substr($output[$i], 65);
            if (strpos($haystack, 'no') !== false) {  // Если шрифт не встроен
                $fontName = explode(' ',trim($output[$i]));
                if(!in_array($fontName[0], $default_fonts)) {
                    return false;   // Шрифт не встроен!
                }
            }
        }
        return true; // Все ок! Шрифты встроены
    }

    echo check_fonts_embedded('book.pdf') == false ? 'Шрифт не встроен!' : 'Все ок!';
?>