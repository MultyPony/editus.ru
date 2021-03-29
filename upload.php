<?php 

    if (isset($_FILES['file']['tmp_name'])) {
        // echo 'Файл ' . $_FILES['file']['name'] . ' получен';
        // Здесь проверка pdf
        $name = $_FILES['file']['name'];
        $res = move_uploaded_file($_FILES['file']['tmp_name'], "./uploads/$name");
        // Успешная проверка
        if ($res) {
            echo json_encode(array(
                'success' => $res,
                'bookSize' => 'A5',
                'pageNumber' => '101',
            ));
        } else {
            echo json_encode(array('error' => 'File not accepted'));
        }

    } else {
        echo 'Ничего не пришло';
    }

?>