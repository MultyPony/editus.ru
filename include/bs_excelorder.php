<?php
session_start();
if (is_numeric($_GET['o'])){
    require_once 'ext_libs/PHPExcel/PHPExcel.php';
    //include './ext_libs/PHPExcel/PHPExcel/IOFactory.php';
    require_once 'ext_libs/PHPExcel/PHPExcel/Writer/Excel5.php';
    require_once 'ext_libs/PHPExcel/PHPExcel/Writer/PDF.php';
    require_once './../config.inc.php';
    require_once 'db_class.php';
    $pathdir = './bookstore/tmpgen';

    $db = new Db();
    $db->query("SELECT Users.userFirstName AS userFirstName,
                       Users.userLastName AS userLastName,
                       Users.userAdditionalName AS userAdditionalName,
                       Users.orgName AS orgName, 
                       Users.orgINN AS orgINN, 
                       Users.orgKPP AS orgKPP, 
                       ShopOrders.orderId AS orderId, 
                       ShopOrders.itemsId AS itemsId, 
                       ShopOrders.orderCost AS orderCost,
                       ShopOrders.orderPriceDeliver AS orderPriceDeliver,
                       ShopOrders.addressId AS addressId,
                       ShopOrders.DeliveryProviderId AS DeliveryProviderId,
                       ShopOrders.isOrg AS isOrg
                FROM ShopOrders, Users
                WHERE Users.userId = '".$_SESSION['userId']."' AND
                      ShopOrders.userId = '".$_SESSION['userId']."' AND
                      ShopOrders.orderId = '".intval($_GET['o'])."' 
                      LIMIT 1");
    $data = $db->fetch_array();
    $db->query("SELECT DeliveryCountries.CountryName AS CountryName,
                       DeliveryRegions.RegionName AS RegionName,
                       UsersDeliveryAddreses.addressIndex AS addressIndex,
                       UsersDeliveryAddreses.addressCity AS addressCity,
                       UsersDeliveryAddreses.addressStr AS addressStr,
                       UsersDeliveryAddreses.addressHouse AS addressHouse,
                       UsersDeliveryAddreses.addressBuild AS addressBuild,
                       UsersDeliveryAddreses.addressApt AS addressApt
                FROM UsersDeliveryAddreses, DeliveryCountries, DeliveryRegions
                WHERE UsersDeliveryAddreses.addressId = '". $data['addressId'] ."' AND
                      DeliveryCountries.CountryId = UsersDeliveryAddreses.addressCountry AND 
                      DeliveryRegions.RegionId = UsersDeliveryAddreses.addressRegion ");
    $dataadres = $db->fetch_array();
   
    $rumonth = array('1'=> 'января', 
                     '2'=> 'февраля',
                     '3'=> 'марта',
                     '4'=> 'апреля',
                     '5'=> 'мая',
                     '6'=> 'июня',
                     '7'=> 'июля',
                     '8'=> 'августа',
                     '9'=> 'сентября',
                     '10'=> 'октября',
                     '11'=> 'ноября',
                     '12'=> 'декабря' );
    
    if ($data['isOrg']==1){
        
        $t = unserialize($data['itemsId']);
        $sqlcomporder = 'SELECT itemId, itemName, itemPrice
                         FROM ShopItems
                         WHERE ';
        foreach ($t as $key=>$val){
            if (!isset($f)){
                $sqlcomporder .=" itemId = '".$key."' ";
                $f = 1;
            }else if ($f == 1){
                $sqlcomporder .=" OR itemId = '".$key."' ";
            } 
        }
        $db->query($sqlcomporder);
        while ($row = $db->fetch_array()) {
            $prods[] = array('name'=>$row['itemName'], 'amount'=>$t[$row['itemId']],'priceone'=>$row['itemPrice'],'totalcost'=>ceil($row['itemPrice']*$t[$row['itemId']]));
        }
        
        
        $text_schet_na_oplatu = 'Счет на оплату № K'.$data['orderId'].' от '.date("j").' '.$rumonth[date("n")].' '.date("Y").' г.';
//        if ($data['isOrg']==1){
            $text_pokupatel = $data['orgName'].', ИНН '.$data['orgINN'].', КПП '.$data['orgKPP'].', ';
//        }else{
//            $text_pokupatel = $data['userLastName'].' '.$data['userFirstName'].' '.$data['userAdditionalName'].', ';
//        }
    //    var_dump($data);
        $text_pokupatel .=$dataadres['CountryName'].', '.$dataadres['addressIndex'].', ';
        if ($dataadres['RegionName'] != $dataadres['addressCity']){
            $text_pokupatel .= $dataadres['RegionName'].', ';
        }
        $text_pokupatel .= 'г. '.$dataadres['addressCity'].', ул. '.$dataadres['addressStr'].', д. '.$dataadres['addressHouse'].', ';
        if (!empty($dataadres['addressBuild'])){
            $text_pokupatel .= 'стр./корп. '.$dataadres['addressBuild'].', ';
        }
        $text_pokupatel .= 'кв./оф. '.$dataadres['addressApt'];

        $summa_tovara = (ceil($data['orderCost']));
        $cena_tovara = ceil($summa_tovara/$kol_tovara);
        $cena_summa_dostavka = ceil($data['orderPriceDeliver']);

        $itogo_vsego_k_olpate = $summa_tovara+$cena_summa_dostavka;

        $vsego_naimenovan = 'Всего наименований '.  count($prods).', на сумму '.$itogo_vsego_k_olpate.' руб.';
        
        
        
        $summa_propis = num2str($itogo_vsego_k_olpate);


        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $excel = $reader->load('example.xls');

        //$excel->setActiveSheetIndex(0);
        //$excel->getActiveSheet()->SetCellValue('B13', 'Счет на оплату № 215 от 17 февраля 2011 г.');

        $excel->setActiveSheetIndex(0);
        $aSheet = $excel->getActiveSheet();
        $aSheet->mergeCells('B1:AL3');
        $aSheet->mergeCells('B5:T6');
        $aSheet->mergeCells('U5:X5');
        $aSheet->mergeCells('Y5:AL5');
        $aSheet->mergeCells('B7:T7');
        $aSheet->mergeCells('U6:X7');
        $aSheet->mergeCells('Y6:AL7');
        $aSheet->mergeCells('B8:C8');
        $aSheet->mergeCells('D8:J8');
        $aSheet->mergeCells('K8:L8');
        $aSheet->mergeCells('M8:T8');
        $aSheet->mergeCells('U8:X11');
        $aSheet->mergeCells('Y8:AL11');
        $aSheet->mergeCells('B9:T10');
        $aSheet->mergeCells('B11:T11');
        $aSheet->mergeCells('B13:AL14');
        $aSheet->mergeCells('B15:AL15');
        $aSheet->mergeCells('B17:E17');
        $aSheet->mergeCells('F17:AL17');
        $aSheet->mergeCells('B19:E19');
        $aSheet->mergeCells('F19:AL19');
        $aSheet->mergeCells('B21:C21');
        $aSheet->mergeCells('D21:R21');
        $aSheet->mergeCells('S21:V21');
        $aSheet->mergeCells('W21:Y21');
        $aSheet->mergeCells('Z21:AE21');
        $aSheet->mergeCells('AF21:AK21');
        $aSheet->mergeCells('B22:C22');
        $aSheet->mergeCells('D22:R22');
        $aSheet->mergeCells('S22:V22');
        $aSheet->mergeCells('W22:Y22');
        $aSheet->mergeCells('Z22:AE22');
        $aSheet->mergeCells('AF22:AK22');
        $aSheet->mergeCells('B23:C23');
        $aSheet->mergeCells('D23:R23');
        $aSheet->mergeCells('S23:V23');
        $aSheet->mergeCells('W23:Y23');
        $aSheet->mergeCells('Z23:AE23');
        $aSheet->mergeCells('AF23:AK23');
        $aSheet->mergeCells('AF25:AK25');
        $aSheet->mergeCells('AF27:AK27');
        $aSheet->mergeCells('B28:AL28');
        $aSheet->mergeCells('B29:AJ29');

        ###Добавил 25.02.2011###

        $aSheet->mergeCells('B32:E36');
        $aSheet->mergeCells('F32:L36');

        //
        $aSheet->mergeCells('M32:S36');
        //$aSheet->mergeCells('T32:AC43');
        $aSheet->mergeCells('B37:E41');
        $aSheet->mergeCells('F37:L41');
        $aSheet->mergeCells('M37:S41');
        //
        $aSheet->mergeCells('B37:E41');
        $aSheet->mergeCells('F37:L41');
        $aSheet->mergeCells('M37:S41');

        $aSheet->mergeCells('T32:AC47');
        $aSheet->SetCellValue('B32','Руководитель');
        $aSheet->SetCellValue('B37','Бухгалтер');
        $aSheet->SetCellValue('M32','Воронов В.В.');
        $aSheet->SetCellValue('M37','Баютова Е.В.');
        $boldFont = array(
                'font'=>array(
                        'name'=>'Arial Cyr',
                        'size'=>'8',
                        'bold'=>true
                )
            );
        $left = array(
                'alignment'=>array(
                        'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                        //'vertical'=>PHPExcel_Style_Alignment::VERTICAL_TOP
                )
        );
        $aSheet->getStyle('B32')->applyFromArray($boldFont);
        $aSheet->getStyle('B37')->applyFromArray($boldFont);

        $aSheet->getStyle('M32')->applyFromArray($left);
        $aSheet->getStyle('M37')->applyFromArray($left);

        $iDrowing = new PHPExcel_Worksheet_Drawing();
        //берем рисунок
        $iDrowing->setPath('bill_images/img1.jpg');

        //устанавливаем ячейку
        $iDrowing->setCoordinates('F32');

        //устанавливаем смещение X и Y
        $iDrowing->setResizeProportional(false);
        $iDrowing->setHeight(60);
        $iDrowing->setWidth(140);
        $iDrowing->setOffsetX(50);
        $iDrowing->setOffsetY(50);

        $iDrowing2 = new PHPExcel_Worksheet_Drawing();
        //берем рисунок
        $iDrowing2->setPath('bill_images/img2.jpg');

        //устанавливаем ячейку
        $iDrowing2->setCoordinates('F37');

        //устанавливаем смещение X и Y
        $iDrowing2->setResizeProportional(false);
        $iDrowing2->setHeight(60);
        $iDrowing2->setWidth(140);
        $iDrowing2->setOffsetX(50);
        $iDrowing2->setOffsetY(50);

        $iDrowing3 = new PHPExcel_Worksheet_Drawing();
        //берем рисунок
        $iDrowing3->setPath('bill_images/img3.jpg');

        //устанавливаем ячейку
        $iDrowing3->setCoordinates('T32');

        //устанавливаем смещение X и Y
        $iDrowing3->setResizeProportional(false);
        //$iDrowing3->setHeight(70);
        //$iDrowing3->setWidth(140);
        $iDrowing3->setOffsetX(50);
        $iDrowing3->setOffsetY(50);

        //помещаем на лист
        $iDrowing->setWorksheet($aSheet);
        $iDrowing2->setWorksheet($aSheet);
        $iDrowing3->setWorksheet($aSheet);

        $aSheet->SetCellValue('B13', $text_schet_na_oplatu);
        $aSheet->SetCellValue('F19', $text_pokupatel);
//        $aSheet->SetCellValue('Z23', $cena_summa_redaktizd);
//        $aSheet->SetCellValue('AF23', $cena_summa_redaktizd);
        $aSheet->SetCellValue('AF25', $itogo_vsego_k_olpate);
        $aSheet->SetCellValue('AF27', $itogo_vsego_k_olpate);
        $aSheet->SetCellValue('B29', $summa_propis);
        $aSheet->SetCellValue('B28', $vsego_naimenovan);
        
        if (count($prods)<2){
            $aSheet->SetCellValue('D22', $prods[0]['name']);
            $aSheet->SetCellValue('S22', $prods[0]['amount']);
            $aSheet->SetCellValue('Z22', $prods[0]['priceone']);
            $aSheet->SetCellValue('AF22', $prods[0]['totalcost']);
            if ($data['DeliveryProviderId']!=0){
                $db->query("SELECT DeliveryProviderName
                            FROM DeliveryProviders
                            WHERE DeliveryProviderId = '".$data['DeliveryProviderId']."' ");
                $row = $db->fetch_array();

                $dostavka = 'Доставка, '.$row['DeliveryProviderName'];
                $vsego_naimenovan = 'Всего наименований '.  (count($prods)+1).', на сумму '.$itogo_vsego_k_olpate.' руб.';
                $aSheet->SetCellValue('B28', $vsego_naimenovan);
                $aSheet->mergeCells('B23:C23');
                $aSheet->mergeCells('D23:R23');
                $aSheet->mergeCells('S23:V23');
                $aSheet->mergeCells('W23:Y23');
                $aSheet->mergeCells('Z23:AE23');
                $aSheet->mergeCells('AF23:AK23');
                $aSheet->SetCellValue('B23', '2');
                $aSheet->SetCellValue('D23', $dostavka);
                $aSheet->SetCellValue('S23', '1');
                $aSheet->SetCellValue('Z23', $cena_summa_dostavka);
                $aSheet->SetCellValue('AF23', $cena_summa_dostavka);
            }
        }else {
            $vsego_naimenovan = 'Всего наименований '.  (count($prods)+1).', на сумму '.$itogo_vsego_k_olpate.' руб.';
            $aSheet->SetCellValue('B28', $vsego_naimenovan);
            $z = 24;
            $aSheet->insertNewRowBefore($z, count($prods)-1);
            for ($i=0;$i<(count($prods)-1);$i++){
                $aSheet->mergeCells('B'.($z+$i).':C'.($z+$i).'');
                $aSheet->mergeCells('D'.($z+$i).':R'.($z+$i).'');
                $aSheet->mergeCells('S'.($z+$i).':V'.($z+$i).'');
                $aSheet->mergeCells('W'.($z+$i).':Y'.($z+$i).'');
                $aSheet->mergeCells('Z'.($z+$i).':AE'.($z+$i).'');
                $aSheet->mergeCells('AF'.($z+$i).':AK'.($z+$i).'');
                
            }
            $z=$z-2;
            $i=0;
            for ($i;$i<(count($prods));$i++){
                $aSheet->SetCellValue('B'.($z+$i), $i+1);
                $aSheet->SetCellValue('D'.($z+$i), $prods[$i]['name']);
                $aSheet->SetCellValue('S'.($z+$i), $prods[$i]['amount']);
                $aSheet->SetCellValue('W'.($z+$i), 'шт.');
                $aSheet->SetCellValue('Z'.($z+$i), $prods[$i]['priceone']);
                $aSheet->SetCellValue('AF'.($z+$i),$prods[$i]['totalcost']);
            }
            if ($data['DeliveryProviderId']!=0){
                $db->query("SELECT DeliveryProviderName
                            FROM DeliveryProviders
                            WHERE DeliveryProviderId = '".$data['DeliveryProviderId']."' ");
                $row = $db->fetch_array();
                $dostavka = 'Доставка, '.$row['DeliveryProviderName'];
                $aSheet->SetCellValue('B'.($z+$i), ($i+1));
                $aSheet->SetCellValue('D'.($z+$i), $dostavka);
                $aSheet->SetCellValue('S'.($z+$i), '1');
                $aSheet->SetCellValue('Z'.($z+$i), $cena_summa_dostavka);
                $aSheet->SetCellValue('AF'.($z+$i), $cena_summa_dostavka);
            }
        }


//        $aSheet->SetCellValue('B28', $vsego_naimenovan);

        //$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $writer = new PHPExcel_Writer_Excel5($excel);

        //$objWriter = new PHPExcel_Writer_PDF($excel);
        //$objWriter->setSheetIndex(0);
        //$objWriter->save('write.pdf');

        //$writer->save('write.xls');
        //$objWriter = PHPExcel_IOFactory::createWriter($excel, 'PDF');
        //
        //
        //$objWriter->writeAllSheets();
        //
        //
        //$objWriter->save('write.pdf');
        $fullpath = $pathdir.'/'.intval($_GET['o']).'_write.xls';
        $fullpathpdf = $pathdir.'/'.intval($_GET['o']).'_write.pdf';

        if (file_exists($fullpath)){
            unlink($fullpath);
            if (file_exists($fullpath)){

                unlink($fullpathpdf);
            }
        }
        $writer->save($fullpath);  
        exec("/usr/bin/python3 ./uploadblockconv.py --xls  ".$fullpath, $res);
        $filename = $fullpathpdf;
        if(file_exists($filename)){
           $fp = @fopen($filename, "rb");
           if ($fp)
           {
              header("Content-type: application/pdf");
              header("Content-Length: " . filesize($filename));
              header("Content-Disposition: attachment; filename=editus_bill_number_".intval($_GET['o']).".pdf");
              header('Content-Transfer-Encoding: binary');
              header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
              fpassthru($fp);
              exit;
           }
        }
    }elseif ($data['isOrg']==0){
        $text_schet_dogovor = 'Заказ № K'.$data['orderId'].' от '.date("j").' '.$rumonth[date("n")].' '.date("Y").' г.';
        $text_platelshik = $data['userLastName'].' '.$data['userFirstName'].' '.$data['userAdditionalName'];
        $text_adres =$dataadres['CountryName'].', '.$dataadres['addressIndex'].', ';
        if ($dataadres['RegionName'] != $dataadres['addressCity']){
            $text_adres .= $dataadres['RegionName'].', ';
        }
        $text_adres .= 'г. '.$dataadres['addressCity'].', ул. '.$dataadres['addressStr'].', д. '.$dataadres['addressHouse'].', ';
        if (!empty($dataadres['addressBuild'])){
            $text_adres .= 'стр./корп. '.$dataadres['addressBuild'].', ';
        }
        $text_adres .= 'кв./оф. '.$dataadres['addressApt'];
        
        $summa_platega = (ceil($data['orderCost'])+ceil($data['orderPriceDeliver']));
        $summa_platega2 = 'Сумма платежа за услуги '.$summa_platega.' руб.00 коп.';
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $excel = $reader->load('kvitanexp.xls');

        //$excel->setActiveSheetIndex(0);
        //$excel->getActiveSheet()->SetCellValue('B13', 'Счет на оплату № 215 от 17 февраля 2011 г.');

        $excel->setActiveSheetIndex(0);
        $aSheet = $excel->getActiveSheet();
        
        $aSheet->mergeCells('O1:CJ2');
        $aSheet->mergeCells('O3:X3');
        $aSheet->mergeCells('Y3:AY3');
        $aSheet->mergeCells('AZ3:CI3');
        $aSheet->mergeCells('O4:AH4');
        $aSheet->mergeCells('AI4:CC4');
        $aSheet->mergeCells('O5:CI5');
        $aSheet->mergeCells('O6:AY6');
        $aSheet->mergeCells('AZ6:BI6');
        $aSheet->mergeCells('BJ6:BP6');
        $aSheet->mergeCells('BQ6:BT6');
        $aSheet->mergeCells('BU6:CI6');
        $aSheet->mergeCells('O7:CI7');
        $aSheet->mergeCells('O8:AY8');
        $aSheet->mergeCells('AZ8:CI8');
        $aSheet->mergeCells('O9:CI9');
        $aSheet->mergeCells('O10:AR10');
        $aSheet->mergeCells('AS10:AV10');
        $aSheet->mergeCells('AW10:CI10');
        $aSheet->mergeCells('O11:AR11');
        $aSheet->mergeCells('AS11:AV11');
        $aSheet->mergeCells('AW11:CI11');
        $aSheet->mergeCells('O12:AB12');
        $aSheet->mergeCells('AC12:CI12');
        $aSheet->mergeCells('O13:AB13');
        $aSheet->mergeCells('AC13:CI13');
        $aSheet->mergeCells('O14:X14');
        $aSheet->mergeCells('Y14:AD14');
        $aSheet->mergeCells('AE14:AL14');
        $aSheet->mergeCells('AM14:AR14');
        $aSheet->mergeCells('AS14:AY14');
        $aSheet->mergeCells('AZ14:CI14');
        $aSheet->mergeCells('O15:T15');
        $aSheet->mergeCells('U15:Z15');
        $aSheet->mergeCells('AA15:AD15');
        $aSheet->mergeCells('AE15:AL15');
        $aSheet->mergeCells('AM15:AR15');
        $aSheet->mergeCells('AS15:AV15');
        $aSheet->mergeCells('AW15:BC15');
        $aSheet->mergeCells('BD15:BY15');
        $aSheet->mergeCells('BZ15:CI15');
        $aSheet->mergeCells('O16:CI16');
        $aSheet->mergeCells('O17:CI17');
        $aSheet->mergeCells('O18:AR18');
        $aSheet->mergeCells('AS18:CI18');
        
        $aSheet->mergeCells('O19:CJ20');
        $aSheet->mergeCells('O21:X21');
        $aSheet->mergeCells('Y21:AY21');
        $aSheet->mergeCells('AZ21:CI21');
        $aSheet->mergeCells('O22:AH22');
        $aSheet->mergeCells('AI22:CC22');
        $aSheet->mergeCells('O23:CI23');
        $aSheet->mergeCells('O24:AY24');
        $aSheet->mergeCells('AZ24:BI24');
        $aSheet->mergeCells('BJ24:BP24');
        $aSheet->mergeCells('BQ24:BT24');
        $aSheet->mergeCells('BU24:CI24');
        $aSheet->mergeCells('O25:CI25');
        $aSheet->mergeCells('O26:AY26');
        $aSheet->mergeCells('AZ26:CI26');
        $aSheet->mergeCells('O27:CI27');
        $aSheet->mergeCells('O28:AR28');
        $aSheet->mergeCells('AS28:AV28');
        $aSheet->mergeCells('AW28:CI28');
        $aSheet->mergeCells('O29:AR29');
        $aSheet->mergeCells('AS29:AV29');
        $aSheet->mergeCells('AW29:CI29');
        $aSheet->mergeCells('O30:AB30');
        $aSheet->mergeCells('AC30:CI30');
        $aSheet->mergeCells('O31:AB31');
        $aSheet->mergeCells('AC31:CI31');
        $aSheet->mergeCells('O32:X32');
        $aSheet->mergeCells('Y32:AD32');
        $aSheet->mergeCells('AE32:AL32');
        $aSheet->mergeCells('AM32:AR32');
        $aSheet->mergeCells('AS32:AY32');
        $aSheet->mergeCells('AZ32:CI32');
        $aSheet->mergeCells('O33:T33');
        $aSheet->mergeCells('U33:Z33');
        $aSheet->mergeCells('AA33:AD33');
        $aSheet->mergeCells('AE33:AL33');
        $aSheet->mergeCells('AM33:AR33');
        $aSheet->mergeCells('AS33:AV33');
        $aSheet->mergeCells('AW33:BC33');
        $aSheet->mergeCells('BD33:BY33');
        $aSheet->mergeCells('BZ33:CI33');
        $aSheet->mergeCells('O34:CI34');
        $aSheet->mergeCells('O35:CI35');
        $aSheet->mergeCells('O36:AR36');
        $aSheet->mergeCells('AS36:CI36');
        
        if (isset($_GET['clean'])){
            $text_platelshik = ' ';
            $text_adres= ' ';
        }
        $aSheet->SetCellValue('AC12', $text_platelshik);
        $aSheet->SetCellValue('AC13', $text_adres);
        $aSheet->SetCellValue('O10', $text_schet_dogovor);

        $aSheet->SetCellValue('Y14', $summa_platega);
        
        
        $aSheet->SetCellValue('AC30', $text_platelshik);
        $aSheet->SetCellValue('O28', $text_schet_dogovor);
        $aSheet->SetCellValue('Y32', $summa_platega);
        
        $writer = new PHPExcel_Writer_Excel5($excel);
        
              
        $fullpath = $pathdir.'/'.intval($_GET['o']).'_write.xls';
        $fullpathpdf = $pathdir.'/'.intval($_GET['o']).'_write.pdf';

        if (file_exists($fullpath)){
            unlink($fullpath);
            if (file_exists($fullpath)){

                unlink($fullpathpdf);
            }
        }
        $writer->save($fullpath);  
        exec("/usr/bin/python3 ./uploadblockconv.py --xls  ".$fullpath, $res);
        $filename = $fullpathpdf;
        if(file_exists($filename)){
           $fp = @fopen($filename, "rb");
           if ($fp)
           {
              header("Content-type: application/pdf");
              header("Content-Length: " . filesize($filename));
              header("Content-Disposition: attachment; filename=editus_bill_number_".intval($_GET['o']).".pdf");
              header('Content-Transfer-Encoding: binary');
              header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
              fpassthru($fp);
              exit;
           }
        }
    }  
//    header('Content-Type: application/vnd.ms-excel');
//
//    header('Content-Disposition: attachment;filename="print.xls"');
//    header('Cache-Control: max-age=0');
    //выводим в браузер таблицу с бланком
//    $writer->save('php://output');
    //$objWriter->save('php://output');
    //$objReader = PHPExcel_IOFactory::createReader($inputFileType);
}
function num2str($inn, $stripkop=false) {
	$nol = 'ноль';
	$str[100]= array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот', 'восемьсот','девятьсот');
	$str[11] = array('','десять','одиннадцать','двенадцать','тринадцать', 'четырнадцать','пятнадцать','шестнадцать','семнадцать', 'восемнадцать','девятнадцать','двадцать');
	$str[10] = array('','десять','двадцать','тридцать','сорок','пятьдесят', 'шестьдесят','семьдесят','восемьдесят','девяносто');
	$sex = array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),// m
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять') // f
	);
	$forms = array(
		array('копейка',  'копейки',   'копеек',     1), // 10^-2
		array('рубль',    'рубля',     'рублей',     0), // 10^ 0
		array('тысяча',   'тысячи',    'тысяч',      1), // 10^ 3
		array('миллион',  'миллиона',  'миллионов',  0), // 10^ 6
		array('миллиард', 'миллиарда', 'миллиардов', 0), // 10^ 9
		array('триллион', 'триллиона', 'триллионов', 0), // 10^12
	);
	$out = $tmp = array();
	// Поехали!
	$tmp = explode('.', str_replace(',','.', $inn));
	$rub = number_format($tmp[0],0,'','-');
	if ($rub==0) $out[] = $nol;
	// нормализация копеек
	$kop = isset($tmp[1]) ? substr(str_pad($tmp[1], 2, '0', STR_PAD_RIGHT),0,2) : '00';
	$segments = explode('-', $rub);
	$offset = sizeof($segments);
	if ((int)$rub==0) { // если 0 рублей
		$o[] = $nol;
		$o[] = morph(0, $forms[1][0],$forms[1][1],$forms[1][2]);
	}
	else {
		foreach ($segments as $k=>$lev) {
			$sexi= (int) $forms[$offset][3]; // определяем род
			$ri  = (int) $lev; // текущий сегмент
			if ($ri==0 && $offset>1) {// если сегмент==0 & не последний уровень(там Units)
				$offset--;
				continue;
			}
			$ri = str_pad($ri, 3, '0', STR_PAD_LEFT);
			$r1 = (int)substr($ri,0,1); //первая цифра
			$r2 = (int)substr($ri,1,1); //вторая
			$r3 = (int)substr($ri,2,1); //третья
			$r22= (int)$r2.$r3; //вторая и третья
			if ($ri>99) $o[] = $str[100][$r1]; // Сотни
			if ($r22>20) {// >20
				$o[] = $str[10][$r2];
				$o[] = $sex[ $sexi ][$r3];
			}
			else { // <=20
				if ($r22>9) $o[] = $str[11][$r22-9]; // 10-20
				elseif($r22>0)  $o[] = $sex[ $sexi ][$r3]; // 1-9
			}
			// Рубли
			$o[] = morph($ri, $forms[$offset][0],$forms[$offset][1],$forms[$offset][2]);
			$offset--;
		}
	}
	// Копейки
	if (!$stripkop) {
		$o[] = $kop;
		$o[] = morph($kop,$forms[0][0],$forms[0][1],$forms[0][2]);
	}
	return preg_replace("/\s{2,}/",' ',implode(' ',$o));
}
function morph($n, $f1, $f2, $f5) {
	$n = abs($n) % 100;
	$n1= $n % 10;
	if ($n>10 && $n<20)	return $f5;
	if ($n1>1 && $n1<5)	return $f2;
	if ($n1==1)		return $f1;
	return $f5;
}
?>
