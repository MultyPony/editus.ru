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
    
    $z = new Engine();
    $z->set_path_to_root('/home/httpd/editus.ru/www/');
    $z->load_class('settings');
    new Settings();
    
    $ftp_server=Settings::$v['ftp']['serv'];
    $ftp_user_name=Settings::$v['ftp']['user'];
    $ftp_user_pass=Settings::$v['ftp']['pass'];
    $mailGoodStr = 'Заказы загруженные на ftp: ';
    $mailBadStr = "\n\n".'Заказы возвращенные на ручную верстку: ';
    $array_orders =array();
    $db = new Db();
    $db->query("SELECT ShopOrders.orderId, ShopOrders.userId, ShopOrders.itemsId
                FROM ShopOrders
                WHERE ShopOrders.stateId = '3' ");
    while ($row = $db->fetch_array()) {
        $array_orders[] = $row;
    }
    $fr = false;
    $frb = false;
    $sql_res_ok = "UPDATE ShopOrders
                   SET ShopOrders.stateId = '6',
                       ShopOrders.orderUploadDate = '".date("Y-m-d G:H:i", mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."'
                   WHERE ";
    $sql_res_ok_log = "INSERT INTO ShopOrderStateChanges (orderId, curState, userId) 
                       VALUES ";
    $sql_res_back = "UPDATE ShopOrders
                     SET ShopOrders.stateId = '4'
                     WHERE ";
    $sql_res_back_log = "INSERT INTO ShopOrderStateChanges (orderId, curState, userId) 
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
                $flag =0;
                $f2 = 0;
                $items = unserialize($cur['itemsId'] );
//                $pathdirsourse = '/home/httpd/editus.banuchka.ru/www/uploads/'.$cur[1].'/'.$cur[0];
                $pathdirsourse = '/home/httpd/editus.ru/www/items/';
                $pathdirsourse2 = '/home/httpd/editus.ru/www/include/bookstore/K'.$cur['orderId'].'/';
                foreach ($items as $key=>$value) {
                    if (file_exists($pathdirsourse.'/'.$key.'/'.$key.'_block.pdf') && file_exists($pathdirsourse.'/'.$key.'/'.$key.'_cover.pdf') ){
                        $flag++;
                    }
                }
                $count = count($items);
                if ($flag==$count){
                    foreach ($items as $key=>$value) {
                        @ftp_delete($conn_id, $curdaydirname.'/K'.$cur['orderId'].'/'.$key.'_block.pdf');
                        @ftp_delete($conn_id, $curdaydirname.'/K'.$cur['orderId'].'/'.$key.'_cover.pdf');
                        @ftp_delete($conn_id, $curdaydirname.'/K'.$cur['orderId'].'/'.$key.'_zayavka.xls');
                    }
                    @ftp_rmdir($conn_id, $curdaydirname.'/K'.$cur['orderId']);

                    if (@ftp_mkdir($conn_id, $curdaydirname.'/K'.$cur['orderId'])){
                        foreach ($items as $key=>$value) {
                            if (@ftp_put($conn_id, $curdaydirname.'/K'.$cur['orderId'].'/'.$key.'_block.pdf', $pathdirsourse.'/'.$key.'/'.$key.'_block.pdf', FTP_BINARY)){
                                $f2++;
                            }if (@ftp_put($conn_id, $curdaydirname.'/K'.$cur['orderId'].'/'.$key.'_cover.pdf', $pathdirsourse.'/'.$key.'/'.$key.'_cover.pdf', FTP_BINARY)){
                                $f2++;
                            }if (@ftp_put($conn_id, $curdaydirname.'/K'.$cur['orderId'].'/'.$key.'_zayavka.xls', $pathdirsourse2.$key.'_zayavka.xls', FTP_BINARY)){
//                                $f2++;
                            }
                        }
                    }
                    if ($f2 == (2*$count)){
                        $mailGoodStr .= 'K'.$cur['orderId'].' ';
                        if ($fr == false){
                            $sql_res_ok .= " ShopOrders.orderId = '".$cur['orderId']."' ";
                            $sql_res_ok_log = " ('".$cur['orderId']."', '6', '".$cur['userId']."') ";
                            $fr = true;
                        }else{
                            $sql_res_ok .= " OR ShopOrders.orderId = '".$cur[0]."' ";
                            $sql_res_ok_log = ", ('".$cur['orderId']."', '6', '".$cur['userId']."') ";
                        }
                    } 
                }else{
                    if ($frb == false){
                        $mailBadStr .= 'K'.$cur[0].' ';
                        $sql_res_back .= " ShopOrders.orderId = '".$cur[0]."' ";
                        $sql_res_back_log = " ('".$cur[0]."', '4', '".$cur[1]."') ";
                        $frb = true;
                    }else{
                        $sql_res_back .= " OR ShopOrders.orderId = '".$cur[0]."' ";
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

        $z->mail(array('debug-editus@banuchka.ru','support@editus.ru'), 'Загрузка на FTP', $mailGoodStr.$mailBadStr);
    }
}
?>
