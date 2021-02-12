<?php
require_once '../include/lang/errors_lang.php';
require_once '../config.inc.php';
require_once '../include/db_class.php';
require_once '../include/engine_class.php';
require_once '../include/lang/funcOrderClient_lang.php';
if (isset($_POST['shpt']) && $_POST['shpt']=='bs'){
    if (isset($_POST['InvId'])){
        $id = intval($_POST['InvId']);
        $pwd2 = "gpvqmlu12456";
        $db = new Db();
        $db->query("SELECT userId, CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal, itemsId, orderId, orderDate
                    FROM ShopOrders
                    WHERE orderId = '".$id."' LIMIT 1 ");
        if ($db->num_rows()==1){
            $row = $db->fetch_array();
            $dataorder = $row;
            $sum = $row['orderPriceTotal'];
            $user = $row['userId'];
            if ( $sum == intval($_POST['OutSum'])){
                if (strtolower($_POST['SignatureValue']) == strtolower(md5($_POST['OutSum'] . ":" . $id . ":" . $pwd2.":shpt=".$_POST['shpt']))){
                    $db->query("INSERT INTO OrderBills
                                       SET orderId = 'bs".$id."',
                                           userId = '".$user."',
                                           paysys = 'robokassa',
                                           paysysId = '".$id."',
                                           paybill = '".date("Y-m-d H:i:s")."' ");
                    $db->query("UPDATE ShopOrders
                                SET orderstep = 2,
                                    stateId = 3
                                WHERE orderId = '".$id."' ");
                    $db->query("INSERT INTO ShopOrderStateChanges 
                                SET orderId = '" . $id . "',
                                    curState = '3',
                                    userId = '".$user."' ");
                    echo "OK" . $id;
                     
                    $items = unserialize($dataorder['itemsId']);
                    require_once '../include/ext_libs/PHPExcel/PHPExcel.php';
                    require_once '../include/ext_libs/PHPExcel/PHPExcel/Writer/Excel5.php';
                    require_once '../include/ext_libs/PHPExcel/PHPExcel/Writer/PDF.php';
                    foreach ($items as $key=>$val){
                        $db->query("SELECT ShopItems.itemName AS itemName,
                                           ShopItems.itemPages AS orderPages, 
                                           ShopItems.itemTypeCover AS orderCover,
                                           PaperFormat.formatName AS formatName,
                                           PaperFormat.formatWidth AS formatWidth,
                                           PaperFormat.formatHeight AS formatHeight,
                                           PaperFormat.formatInA3 AS formatInA3,
                                           PaperTypeCostsBlock.PaperTypeName AS PaperTypeName,
                                           PaperTypeCostsBlock.PaperTypeWeight AS PaperTypeWeight,
                                           PaperTypeCostsBlock.PaperTypeCost AS BlockPaperTypeCost,
                                           BindingType.BindingName AS BindingName,
                                           PrintTypeCostsBlock.PrintTypeName AS PrintTypeName,
                                           PrintTypeCostsBlock.PrintCost AS BlockPrintCost,
                                           PaperTypeCostsCover.PaperTypeCost AS CoverPaperTypeCost,
                                           PrintTypeCostsCover.PrintCost AS CoverPrintCost,
                                           BindingTypeCosts.BindingCosts AS BindingCosts
                                FROM ShopItems, PaperFormat, PaperTypeCostsBlock, BindingType, PrintTypeCostsBlock, PrintTypeCostsCover, PaperTypeCostsCover, BindingTypeCosts
                                WHERE ShopItems.itemId = '".$key."' AND
                                      BindingTypeCosts.BindingMin <= ShopItems.itemPages AND BindingTypeCosts.BindingMax >= ShopItems.itemPages AND 
                                      BindingTypeCosts.BindingId = BindingType.BindingId AND
                                      BindingTypeCosts.formatId = ShopItems.formatId AND
                                      PrintTypeCostsCover.PrintType = '44' AND
                                      PaperTypeCostsCover.CoverType = ShopItems.itemTypeCover AND
                                      PaperTypeCostsCover.isDefault = '1' AND
                                      PaperFormat.formatId = ShopItems.formatId AND
                                      PaperTypeCostsBlock.PaperTypeId = ShopItems.papertTypeId AND
                                      BindingType.BindingId = ShopItems.bindingId AND
                                      PrintTypeCostsBlock.PrintTypeId = ShopItems.PrintTypeId
                                        LIMIT 1");
                        $dataitem = $db->fetch_array();
                        $reader = PHPExcel_IOFactory::createReader('Excel5');
                        $excel = $reader->load('../include/zayavka.xls');
                        $excel->setActiveSheetIndex(0);
                        $aSheet = $excel->getActiveSheet();
                        $aSheet->SetCellValue('E3','K'.$dataorder['orderId']);
                        $aSheet->SetCellValue('F3',date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+2, date("Y"))));
                        $aSheet->SetCellValue('C8',$dataitem['itemName']);
                        $aSheet->SetCellValue('D8',$dataitem['formatName'].'-'.$dataitem['formatWidth'].'x'.$dataitem['formatHeight']);
                        $aSheet->SetCellValue('E8',$dataitem['orderPages']);
                        $aSheet->SetCellValue('F8',$val);
                        $aSheet->SetCellValue('G8',$dataitem['BindingName']);
                        $aSheet->SetCellValue('C11',$dataitem['PaperTypeName'].' '.$dataitem['PaperTypeWeight']);
                        $aSheet->SetCellValue('D11',$key.'_block.pdf');
                        $aSheet->SetCellValue('E11',$dataitem['PrintTypeName']);
                        if ($dataitem['orderCover'] == 'hard'){
                            $aSheet->SetCellValue('C14','самоклеящаяся (твердая обложка)');
                            $aSheet->SetCellValue('C17', date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+8, date("Y"))));
                        }else{
                            $aSheet->SetCellValue('C14','250 мелованная (мягкая обложка)');
                            $aSheet->SetCellValue('C17', date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y"))));
                        }
                        $aSheet->SetCellValue('D14',$key.'_cover.pdf');
                        $allblock = ceil((($dataitem['BlockPrintCost'] + $dataitem['BlockPaperTypeCost']) * $dataitem['orderPages'] / $dataitem['formatInA3']) * $val);
                        $allcover = ceil((($dataitem['CoverPrintCost'] + $dataitem['CoverPaperTypeCost'] ) / $dataitem['formatInA3'] * 4) * $val);
                        $allbind = ceil($dataitem['BindingCosts'] * $val);
                        $total = ($allblock+$allcover+$allbind);
                        $aSheet->SetCellValue('D17',$total);
                        $writer = new PHPExcel_Writer_Excel5($excel);
                        $pathdir = './../include/bookstore/K'.$dataorder['orderId'];
                        if (!file_exists($pathdir)){
                            mkdir($pathdir);
                        }
                        $fullpath = $pathdir.'/'.$key.'_zayavka.xls';
                        $writer->save($fullpath);  
                    }
                    $z = new Engine();
                    $z->set_path_to_root('../');
                    $z->load_class('settings');
                    new Settings();
                    $z->mail(array('debug-editus@banuchka.ru','support@editus.ru'), 'Оплата - Robokassa', 'Заказ № K'.$id.' на сумму '.$sum.' оплачен.');

                }
            }
        }
    }
}else{
    if (isset($_POST['InvId'])){
        $id = intval($_POST['InvId']);
        $pwd2 = "gpvqmlu12456";
        $db = new Db();
        $db->query("SELECT userId, CEILING(UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver) AS orderPriceTotal, bookstore
                    FROM UsersOrders
                    WHERE orderId = '".$id."' LIMIT 1 ");
        if ($db->num_rows()==1){
            $row = $db->fetch_array();
            $sum = $row['orderPriceTotal'];
            $user = $row['userId'];
            if ( $sum == intval($_POST['OutSum'])){
                if (strtolower($_POST['SignatureValue']) == strtolower(md5($_POST['OutSum'] . ":" . $id . ":" . $pwd2))){
                    $db->query("INSERT INTO OrderBills
                                       SET orderId = '".$id."',
                                           userId = '".$user."',
                                           paysys = 'robokassa',
                                           paysysId = '".$id."',
                                           paybill = '".date("Y-m-d H:i:s")."' ");
                    $db->query("UPDATE UsersOrders
                                SET orderstep = 4,
                                    stateId = 2
                                WHERE orderId = '".$id."' ");
                    $db->query("UPDATE ISBNnumbers 
                                SET isPaid = '1' 
                                WHERE orderId = '".$id."'");
                    $db->query("INSERT INTO OrderStateChanges 
                                SET orderId = '" . $id . "',
                                    curState = '2',
                                    userId = '".$user."' ");
                    $z = new Engine();
                    $z->set_path_to_root('../');
                    $z->load_class('settings');
                    new Settings();
                    if ($row['bookstore']==1){
                        $db->query("SELECT userEmail
                                        FROM Users
                                        WHERE Users.userGroupId = '" .Settings::$v['managegroup'] . "' ");
                        while ($row = $db->fetch_array()) {
                            $mails[] = $row['userEmail'];
                        }
                        $z->mail($mails,'Добавление в интернет-магазин','Пользователь хотел бы выложить книгу в магазине, заказ №'.$id);
                    }
                    echo "OK" . $id;
                    $z->mail(array('debug-editus@banuchka.ru','support@editus.ru'), 'Оплата - Robokassa', 'Заказ № '.$id.' на сумму '.$sum.' оплачен.');

                }
            }
        }
    }
}
?>
