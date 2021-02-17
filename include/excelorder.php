<?php
session_start();
if (is_numeric($_GET['o'])){
    require_once 'ext_libs/PHPExcel/PHPExcel.php';
    //include 'ext_libs/PHPExcel/PHPExcel/IOFactory.php';
    require_once 'ext_libs/PHPExcel/PHPExcel/Writer/Excel5.php';
    require_once 'ext_libs/PHPExcel/PHPExcel/Writer/PDF.php';
    require_once './../config.inc.php';
    require_once 'db_class.php';
    
    $pathdir = './../uploads/'.$_SESSION['userId'].'/'.intval($_GET['o']);

    $db = new Db();
    $db->query("SELECT Users.userFirstName AS userFirstName,
                       Users.userLastName AS userLastName,
                       Users.userAdditionalName AS userAdditionalName,
                       Users.orgName AS orgName, 
                       Users.orgINN AS orgINN, 
                       Users.orgKPP AS orgKPP, 
                       UsersOrders.orderId AS orderId, 
                       UsersOrders.orderCount AS orderCount, 
                       UsersOrders.orderPages AS orderPages, 
                       PaperFormat.formatName AS formatName,
                       PaperTypeCostsBlock.PaperTypeName AS PaperTypeName,
                       PaperTypeCostsBlock.PaperTypeWeight AS PaperTypeWeight,
                       BindingType.BindingName AS BindingName,
                       UsersOrders.orderPriceBlock AS orderPriceBlock,
                       UsersOrders.orderPriceAdditService AS orderPriceAdditService,
                       UsersOrders.orderPriceCover AS orderPriceCover,
                       UsersOrders.orderPriceBind AS orderPriceBind,
                       PrintTypeCostsBlock.PrintTypeName AS PrintTypeName,
                       UsersOrders.orderPriceDeliver AS orderPriceDeliver,
                       UsersOrders.addressId AS addressId,
                       UsersOrders.DeliveryProviderId AS DeliveryProviderId,
                       UsersOrders.isOrg AS isOrg
                FROM UsersOrders, PaperFormat, PaperTypeCostsBlock, BindingType, PrintTypeCostsBlock, Users
                WHERE Users.userId = '".$_SESSION['userId']."' AND
                      UsersOrders.userId = '".$_SESSION['userId']."' AND
                      UsersOrders.orderId = '".intval($_GET['o'])."' AND
                      PaperFormat.formatId = UsersOrders.orderSize AND
                      PaperTypeCostsBlock.PaperTypeId = UsersOrders.orderPaperBlock AND
                      BindingType.BindingId = UsersOrders.orderBinding AND
                      PrintTypeCostsBlock.PrintType = UsersOrders.orderColorBlock
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
        $text_schet_na_oplatu = 'Счет на оплату № '.$data['orderId'].' от '.date("j").' '.$rumonth[date("n")].' '.date("Y").' г.';
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

        $text_tovar = 'Книга '.$data['formatName'].', '.$data['orderPages'].', '.$data['PrintTypeName'].', '.$data['PaperTypeName'].' '.$data['PaperTypeWeight'].', '.$data['BindingName'];
        $kol_tovara = $data['orderCount'];
        if ($kol_tovara==0){$kol_tovara=1;}
        $summa_tovara = (ceil($data['orderPriceBlock'])+ceil($data['orderPriceCover'])+ceil($data['orderPriceBind']));
        $cena_tovara = ceil($summa_tovara/$kol_tovara);
        $cena_summa_redaktizd = ceil($data['orderPriceAdditService']);
        $cena_summa_dostavka = ceil($data['orderPriceDeliver']);

        $itogo_vsego_k_olpate = $summa_tovara+$cena_summa_redaktizd+$cena_summa_dostavka;

        $vsego_naimenovan = 'Всего наименований 2, на сумму '.$itogo_vsego_k_olpate.' руб.';
        $summa_propis = num2str($itogo_vsego_k_olpate);


        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $excel = $reader->load('invoice.xlsx');

        //$excel->setActiveSheetIndex(0);
        //$excel->getActiveSheet()->SetCellValue('B13', 'Счет на оплату № 215 от 17 февраля 2011 г.');

        $excel->setActiveSheetIndex(0);
        $aSheet = $excel->getActiveSheet();
       

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
        $aSheet->SetCellValue('D22', $text_tovar);
        $aSheet->SetCellValue('S22', $kol_tovara);
        $aSheet->SetCellValue('AF22', $summa_tovara);
        $aSheet->SetCellValue('Z22', $cena_tovara);
        $aSheet->SetCellValue('Z23', $cena_summa_redaktizd);
        $aSheet->SetCellValue('AF23', $cena_summa_redaktizd);
        $aSheet->SetCellValue('AF25', $itogo_vsego_k_olpate);
        $aSheet->SetCellValue('AF27', $itogo_vsego_k_olpate);
        $aSheet->SetCellValue('B29', $summa_propis);
        $aSheet->SetCellValue('B28', $vsego_naimenovan);

        if ($data['DeliveryProviderId']!=0){
            $db->query("SELECT DeliveryProviderName
                        FROM DeliveryProviders
                        WHERE DeliveryProviderId = '".$data['DeliveryProviderId']."' ");
            $row = $db->fetch_array();

            $dostavka = 'Доставка, '.$row['DeliveryProviderName'];
            $vsego_naimenovan = 'Всего наименований 3, на сумму '.$itogo_vsego_k_olpate.' руб.';
            $aSheet->SetCellValue('B28', $vsego_naimenovan);
            $aSheet->insertNewRowBefore(24, 1);
            $aSheet->mergeCells('B24:C24');
            $aSheet->mergeCells('D24:R24');
            $aSheet->mergeCells('S24:V24');
            $aSheet->mergeCells('W24:Y24');
            $aSheet->mergeCells('Z24:AE24');
            $aSheet->mergeCells('AF24:AK24');
            $aSheet->SetCellValue('B24', '3');
            $aSheet->SetCellValue('D24', $dostavka);
            $aSheet->SetCellValue('S24', '1');
            $aSheet->SetCellValue('Z24', $cena_summa_dostavka);
            $aSheet->SetCellValue('AF24', $cena_summa_dostavka);
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
//        exec("/usr/bin/python3 ./uploadblockconv.py --xls  ".$fullpath, $res);
//        $filename = $fullpathpdf;
	$filename = $fullpath;
        if(file_exists($filename)){
           $fp = @fopen($filename, "rb");
           if ($fp)
           {
              header("Content-type: application/vnd.ms-excel");
              header("Content-Length: " . filesize($filename));
              header("Content-Disposition: attachment; filename=editus_bill_number_".intval($_GET['o']).".xls");
              header('Content-Transfer-Encoding: binary');
              header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
              fpassthru($fp);
              exit;
           }
        }
    }elseif ($data['isOrg']==0){
        $text_schet_dogovor = 'СЧЕТ-ДОГОВОР № '.$data['orderId'].' от '.date("j").' '.$rumonth[date("n")].' '.date("Y").' г.';
        $text_zakaz = 'Издание книги по заказу №'.$data['orderId'].'';
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
        
        $summa_platega = (ceil($data['orderPriceBlock'])+ceil($data['orderPriceCover'])+ceil($data['orderPriceBind'])+ceil($data['orderPriceAdditService'])+ceil($data['orderPriceDeliver']));
        $summa_platega2 = 'Сумма платежа за услуги '.$summa_platega.' руб.00 коп.';
        $reader = PHPExcel_IOFactory::createReader('Excel5');
        $excel = $reader->load('invoice.xls');

        //$excel->setActiveSheetIndex(0);
        //$excel->getActiveSheet()->SetCellValue('B13', 'Счет на оплату № 215 от 17 февраля 2011 г.');

        $excel->setActiveSheetIndex(0);
        $aSheet = $excel->getActiveSheet();
        
       
        
        if (isset($_GET['clean'])){
            $text_platelshik = ' ';
            $text_adres= ' ';
        }
        $aSheet->SetCellValue('B16', $text_platelshik);
        $aSheet->SetCellValue('B17', $text_adres);
        $aSheet->SetCellValue('A13', $text_schet_dogovor);
		$aSheet->SetCellValue('B21', $text_zakaz);

        $aSheet->SetCellValue('E21', $summa_platega);
         $aSheet->SetCellValue('F21', $summa_platega);
		 $aSheet->SetCellValue('F22', $summa_platega);
		 $aSheet->SetCellValue('F24', $summa_platega);
        
        
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
        //exec("/usr/bin/python3 ./uploadblockconv.py --xls  ".$fullpath, $res);
//        $filename = $fullpathpdf;
	$filename = $fullpath;
        if(file_exists($filename)){
           $fp = @fopen($filename, "rb");
           if ($fp)
           {
              header("Content-type: application/vnd.ms-excel");
              header("Content-Length: " . filesize($filename));
//              header("Content-Disposition: attachment; filename=editus_bill_number_".intval($_GET['o']).".pdf");
              header("Content-Disposition: attachment; filename=editus_bill_number_".intval($_GET['o']).".xls");
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
    //$writer->save('php://output');
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
