<?php
require_once 'lang/errors_lang.php';
require_once './../config.inc.php';
require_once 'db_class.php';
$userid=intval($_GET['uid']);
$orderid=intval($_GET['oid']);
$object = $_GET['o'];
$pathdir = './../uploads/'.$userid.'/'.$orderid;

if ($object=='covertemplate'){
    $filename = $pathdir.'/'.$orderid.'_template_cover.png';
    if(file_exists($filename))
    {
       $filename2 = basename($_GET['img']); // don't accept other directories
       $size = @getimagesize($filename);
       $fp = @fopen($filename, "rb");
       if ($size && $fp)
       {
          header("Content-type: {$size['mime']}");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid."_template_cover.png");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='cover'){
    $db = new Db();
    $db->query("SELECT formatUplImg
                FROM UsersOrders 
                WHERE orderId = '" . $orderid . "' AND
                      userId = '" . $userid . "' LIMIT 1");
    $row = $db->fetch_array();
    $type = $row[0];
    $filename = $pathdir.'/'.$orderid.'_cover.'.$type;
    if(file_exists($filename))
    {
       if ($type == 'pdf'){
           $size['mime'] = 'application/pdf';
       }else{
           $filename2 = basename($_GET['img']); // don't accept other directories
           $size = @getimagesize($filename);
       }
       $fp = @fopen($filename, "rb");
       if ($size && $fp)
       {
          header("Content-type: {$size['mime']}");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid.'_cover.'.$type);
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='coverdesign'){
    $db = new Db();
    $db->query("SELECT formatUplImg
                FROM UsersOrders 
                WHERE orderId = '" . $orderid . "' AND
                      userId = '" . $userid . "' LIMIT 1");
    $row = $db->fetch_array();
    $type = $row[0];
    $filename = $pathdir.'/'.$orderid.'_design.'.$type;
    if(file_exists($filename))
    {
       if ($type == 'pdf'){
           $size['mime'] = 'application/pdf';
       }else{
           $filename2 = basename($_GET['img']); // don't accept other directories
           $size = @getimagesize($filename);
       }
       $fp = @fopen($filename, "rb");
       if ($size && $fp)
       {
          header("Content-type: {$size['mime']}");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid.'_design.'.$type);
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='blocklayot'){
    $filename = $pathdir.'/'.$orderid.'_block_converted.pdf';
if ($_GET['d']==1)
{
	$pathXAccel = '/uploads/'.$userid . '/' . $orderid . '/' . $orderid.'_block_converted.pdf';	
	header("X-Accel-Redirect: " . $pathXAccel);
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=".$orderid."_block_converted.pdf");
        exit;
}
if ($_GET['d']==2){
	var_dump($pathXAccel = '/uploads/'.$userid . '/' . $orderid . '/' . $orderid.'_block_converted.pdf');
	exit;
}
    if(file_exists($filename))
    {
//       $fp = @fopen($filename, "rb");
//       if ($fp)
//       {
//          header("Content-type: application/pdf");
//          header("Content-Length: " . filesize($filename));
//          header("Content-Disposition: attachment; filename=".$orderid."_block_converted.pdf");
//          header('Content-Transfer-Encoding: binary');
//          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//          fpassthru($fp);
//          exit;
//       }
	$pathXAccel = '/uploads/'.$userid . '/' . $orderid . '/' . $orderid.'_block_converted.pdf';
        header("X-Accel-Redirect: " . $pathXAccel);
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=".$orderid."_block_converted.pdf");
        exit;
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='blockdoc'){
    $filename = $pathdir.'/'.$orderid.'_block.doc';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/msword");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid."_block.doc");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='blockdocx'){
    $filename = $pathdir.'/'.$orderid.'_block.docx';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document ");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid."_block.docx");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='coverlayot'){
    $filename = $pathdir.'/'.$orderid.'_cover.pdf';
    if(file_exists($filename)) {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/pdf");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid."_cover.pdf");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='zayavka'){
    $filename = $pathdir.'/'.$orderid.'_zayavka.xls';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/vnd.ms-excel ");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$orderid."_zayavka.xls");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
?> 
