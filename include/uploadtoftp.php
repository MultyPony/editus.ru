<?php
//    require_once '/home/httpd/editus.banuchka.ru/www/include/lang/errors_lang.php';
//    require_once '/home/httpd/editus.banuchka.ru/www/config.inc.php';
//    require_once '/home/httpd/editus.banuchka.ru/www/include/db_class.php';   
//    require_once '/home/httpd/editus.banuchka.ru/www/include/engine_class.php';
//    
//    $z = new Engine();
//    $z->set_path_to_root('/home/httpd/editus.banuchka.ru/www/');
//    $z->load_class('settings');
//    new Settings();
    
if(defined('STDIN')){

    require_once '/home/httpd/editus.ru/www/config.inc.php';
    require_once '/home/httpd/editus.ru/www/include/db_class.php';   
    require_once '/home/httpd/editus.ru/www/include/engine_class.php';
    
    require_once '/home/httpd/editus.ru/www/include/ext_libs/PHPExcel/PHPExcel.php';
    require_once '/home/httpd/editus.ru/www/include/ext_libs/PHPExcel/PHPExcel/Writer/Excel5.php';
    require_once '/home/httpd/editus.ru/www/include/ext_libs/PHPExcel/PHPExcel/Writer/PDF.php';
    
    $z = new Engine();
    $z->set_path_to_root('/home/httpd/editus.ru/www/');
    $z->load_class('settings');
    new Settings();
    
    $ftp_server=Settings::$v['ftp']['serv'];
    $ftp_user_name=Settings::$v['ftp']['user'];
    $ftp_user_pass=Settings::$v['ftp']['pass'];
    $mailGoodStr = 'Заказ от '.date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))." счет на ООО «Эдитус» \n\n\n";
    $mailBadStr = "\n\n".'Заказы возвращенные на ручную верстку: ';
    $array_orders = array();
    $db = new Db();
    $db->query("SELECT UsersOrders.orderId, UsersOrders.userId, UsersOrders.orderCover
                FROM UsersOrders
                WHERE UsersOrders.stateId = '3' ");
    while ($row = $db->fetch_array()) {
        $array_orders[] = $row;
    }
    $fr = false;
    $frb = false;
    $sql_res_ok = "UPDATE UsersOrders
                   SET UsersOrders.stateId = '6',
                       orderUploadDate = '".date("Y-m-d G:H:i", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."'
                   WHERE ";
    $sql_res_ok_log = "INSERT INTO OrderStateChanges (orderId, curState, userId) 
                       VALUES ";
    $sql_res_back = "UPDATE UsersOrders
                     SET UsersOrders.stateId = '4'
                     WHERE ";
    $sql_res_back_log = "INSERT INTO OrderStateChanges (orderId, curState, userId) 
                         VALUES ";
    if (count($array_orders)>0){
        $conn_id = ftp_connect($ftp_server); 
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
        if ((!$conn_id) || (!$login_result)) { 
            exit; 
        } else {
            $curdaydirname = date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
            
            @ftp_mkdir($conn_id, $curdaydirname);

            foreach ($array_orders as $cur){
//                $pathdirsourse = '/home/httpd/editus.banuchka.ru/www/uploads/'.$cur[1].'/'.$cur[0];
                $pathdirsourse = '/home/httpd/editus.ru/www/uploads/'.$cur[1].'/'.$cur[0];
                if (file_exists($pathdirsourse.'/'.$cur[0].'_block_converted.pdf') && file_exists($pathdirsourse.'/'.$cur[0].'_cover.pdf')){
                    if (@ftp_mkdir($conn_id, $curdaydirname.'/'.$cur[0])){
                        @ftp_delete($conn_id, $curdaydirname.'/'.$cur[0].'/'.$cur[0].'_block.pdf');
                        @ftp_delete($conn_id, $curdaydirname.'/'.$cur[0].'/'.$cur[0].'_cover.pdf');
                        @ftp_delete($conn_id, $curdaydirname.'/'.$cur[0].'/'.$cur[0].'_zayavka.xls');
                    }
                    $uploadblock = @ftp_put($conn_id, $curdaydirname.'/'.$cur[0].'/'.$cur[0].'_block.pdf', $pathdirsourse.'/'.$cur[0].'_block_converted.pdf', FTP_BINARY);
                    $uploadcover = @ftp_put($conn_id, $curdaydirname.'/'.$cur[0].'/'.$cur[0].'_cover.pdf', $pathdirsourse.'/'.$cur[0].'_cover.pdf', FTP_BINARY);
                    //set upload date, edited 13.11.2011
                    $reader = PHPExcel_IOFactory::createReader('Excel5');
                    $excel = $reader->load($pathdirsourse.'/'.$cur[0].'_zayavka.xls');
                    $excel->setActiveSheetIndex(0);
                    $aSheet = $excel->getActiveSheet();
                    $aSheet->SetCellValue('F3',date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))));
                    if ($cur[2] == 'hard'){
                         $aSheet->SetCellValue('C17', date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+8, date("Y"))));
                    }else{
                         $aSheet->SetCellValue('C17', date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y"))));
                    }
                    $writer = new PHPExcel_Writer_Excel5($excel);
                    $writer->save($pathdirsourse.'/'.$cur[0].'_zayavka.xls');
                    //
                    $uploadzayavka = @ftp_put($conn_id, $curdaydirname.'/'.$cur[0].'/'.$cur[0].'_zayavka.xls', $pathdirsourse.'/'.$cur[0].'_zayavka.xls', FTP_BINARY);
                    if ($uploadblock && $uploadcover){
                        $mailGoodStr .= 'Заказ №'.$cur[0]."\n".
                                        'Заявка: ftp://www.pcentre.net/'.$curdaydirname.'/'.$cur[0].'/'.$cur[0].'_zayavka.xls'."\n".
                                        'Файлы: ftp://www.pcentre.net/'.$curdaydirname.'/'.$cur[0].'/'."\n\n";
                        if ($fr == false){
                            $sql_res_ok .= " UsersOrders.orderId = '".$cur[0]."' ";
                            $sql_res_ok_log = " ('".$cur[0]."', '6', '".$cur[1]."') ";
                            $fr = true;
                        }else{
                            $sql_res_ok .= " OR UsersOrders.orderId = '".$cur[0]."' ";
                            $sql_res_ok_log = ", ('".$cur[0]."', '6', '".$cur[1]."') ";
                        }
                    }
                }else{
                    if ($frb == false){
                        $mailBadStr .= $cur[0].' ';
                        $sql_res_back .= " UsersOrders.orderId = '".$cur[0]."' ";
                        $sql_res_back_log = " ('".$cur[0]."', '4', '".$cur[1]."') ";
                        $frb = true;
                    }else{
                        $sql_res_back .= " OR UsersOrders.orderId = '".$cur[0]."' ";
                        $sql_res_back_log = ", ('".$cur[0]."', '4', '".$cur[1]."') ";
                    }
                }
            }
        }
        ftp_close($conn_id);
        if ($fr){
            $db->query($sql_res_ok);
            $db->query($sql_res_ok_log);
        }
        if ($frb){
            $db->query($sql_res_back);
            $db->query($sql_res_back_log);
        }
        $mails = array('debug-editus@banuchka.ru','support@editus.ru');
        $db->query("SELECT userEmail
                    FROM Users
                    WHERE Users.userGroupId = '" .Settings::$v['managegroup'] . "' OR
                          Users.userGroupId = '" .Settings::$v['typograthgroup'] . "' ");
        while ($row = $db->fetch_array()) {
            $mails[] = $row['userEmail'];
        }
        if (!$frb){
            $mailBadStr = '';
        }
        $z->mail($mails, 'Заказ от ООО "Эдитус" '.$curdaydirname, $mailGoodStr.$mailBadStr);
    }
}
?>
