<?php

include 'ext_libs/PHPExcel/PHPExcel.php';
//include './ext_libs/PHPExcel/PHPExcel/IOFactory.php';
include 'ext_libs/PHPExcel/PHPExcel/Writer/Excel5.php';
include 'ext_libs/PHPExcel/PHPExcel/Writer/PDF.php';


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
if (1) 
    {
    $aSheet->insertNewRowBefore(24, 1);
    $aSheet->mergeCells('B24:C24');
    $aSheet->mergeCells('D24:R24');
    $aSheet->mergeCells('S24:V24');
    $aSheet->mergeCells('W24:Y24');
    $aSheet->mergeCells('Z24:AE24');
    $aSheet->mergeCells('AF24:AK24');
    
    }
$aSheet->SetCellValue('B13', 'Счет на оплату № 215 от 17 февраля 2011 г.');


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


header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="print.xls"');
header('Cache-Control: max-age=0');
//выводим в браузер таблицу с бланком
$writer->save('php://output');
//$objWriter->save('php://output');
//$objReader = PHPExcel_IOFactory::createReader($inputFileType);

?>
