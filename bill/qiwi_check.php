<?php

$s = new SoapServer('IShopClientWS.wsdl', array('classmap' => array('tns:updateBill' => 'Param', 'tns:updateBillResponse' => 'Response')));
$s->setClass('QiwiServ');
$s->handle();

class Response {

    public $updateBillResult;

}

class Param {

    public $login;
    public $password;
    public $txn;
    public $status;

}

class QiwiServ {

    function updateBill($param) {
        require_once '../include/lang/errors_lang.php';
        require_once '../config.inc.php';
        require_once '../include/db_class.php';
        require_once '../include/engine_class.php';
        $db = new Db();
        $db->query("INSERT INTO QiwiLog 
                           SET QiwiLogin = '".$param->login."',
                               QiwiPass = '".$param->password."',
                               QiwiTxn = '".$param->txn."',
                               BillStatus = '".$param->status."' ");

        $f = fopen('./qiwi_log.php', 'a');
        fwrite($f, 'order #' . $param->txn . ' - status #' . $param->status."\n");
        fclose($f);
        
        if (($param->login == '12456') && ($param->password == strtoupper(md5(($param->txn) . (strtoupper(md5("gpvqmlu"))))))) {
            require_once '../include/lang/funcOrderClient_lang.php';
           
            if ($param->status == 60) {
                $z = new Engine();
                $z->set_path_to_root('../');
                $z->load_class('settings');
                new Settings();
                
                $db->query("UPDATE OrderBills 
                            SET paybill = '" . date("Y-m-d H:i:s") . "', 
                                ispay = '1' 
                            WHERE orderId = '" . substr($param->txn, 0, strrpos($param->txn, "-")) . "' AND 
                                  paysysId = '" . $param->txn . "' AND 
                                  paysys = 'qiwi'");
                if (substr($param->txn, 0,2)!='bs'){
                    $db->query("UPDATE UsersOrders 
                                SET orderstep = 4, 
                                    stateId = 2 
                                WHERE orderId = '" . substr($param->txn, 0, strrpos($param->txn, "-")) . "' ");
                    $db->query("UPDATE ISBNnumbers 
                                SET isPaid = '1' 
                                WHERE orderId = '".substr($param->txn, 0, strrpos($param->txn, "-"))."'");

                    $db->query("SELECT userId, bookstore
                                FROM UsersOrders
                                WHERE orderId = '" . substr($param->txn, 0, strrpos($param->txn, "-")) . "' LIMIT 1");
                    $row = $db->fetch_array();
                    $db->query("INSERT INTO OrderStateChanges 
                                    SET orderId = '" . substr($param->txn, 0, strrpos($param->txn, "-")) . "',
                                        curState = '2',
                                        userId = '".$row['userId']."' ");

                    if ($row['bookstore']==1){
                        $db->query("SELECT userEmail
                                        FROM Users
                                        WHERE Users.userGroupId = '" .Settings::$v['managegroup'] . "' ");
                        while ($row = $db->fetch_array()) {
                            $mails[] = $row['userEmail'];
                        }
                        $z->mail($mails,'Добавление в интернет-магазин','Пользователь хотел бы выложить книгу в магазине, заказ №'.substr($param->txn, 0, strrpos($param->txn, "-")));
                    }
                    $z->mail(array('debug-editus@banuchka.ru','support@editus.ru'), 'Оплата - Qiwi', 'Заказ № '.$param->txn.' оплачен.');
                }else{
                    $id = substr($param->txn, 2, (strrpos($param->txn, "-")-2));
                    $db->query("UPDATE ShopOrders 
                                SET stateId = '3', 
                                    orderstep = '2' 
                                WHERE orderId='".$id."' ");
                    $db->query("SELECT itemsId, orderId, orderDate
                                FROM ShopOrders
                                WHERE orderId = '" . $id. "' LIMIT 1");
                    $row = $db->fetch_array();
                    $dataorder = $row;
                    $db->query("INSERT INTO ShopOrderStateChanges 
                                SET orderId = '".$id."',
                                    curState = '3',
                                    userId = '" .$row['userId']. "' ");
                    $z->mail(array('debug-editus@banuchka.ru','support@editus.ru'), 'Оплата - Qiwi', 'Заказ №K'.$id.' оплачен.');
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

                }
                $temp = new Response();
                $temp->updateBillResult = 0;
                return $temp;
            } else {
                $db->query("UPDATE OrderBills 
                            SET cancelbill = '" . date("Y-m-d H:i:s") . "' 
                            WHERE orderId = '" . substr($param->txn, 0, strrpos($param->txn, "-")) . "' AND 
                                  paysysId = '" . $param->txn . "' AND 
                                  paysys = 'qiwi'");
                $temp = new Response();
                $temp->updateBillResult = 0;
                return $temp;
            }
        }
    }

}

?>
