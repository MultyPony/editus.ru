<?php
require_once 'lang/errors_lang.php';
require_once './../config.inc.php';
require_once 'db_class.php';
$userid=intval($_GET['uid']);
$orderid=intval($_GET['oid']);
$itemid = intval($_GET['itemid']);
$object = $_GET['o'];
$pathitem = './../items/'.$itemid;
$pathitemgen = './../include/bookstore/K'.$orderid;

if ($object=='block'){
    $filename = $pathitem.'/'.$itemid.'_block.pdf';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/pdf");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$itemid."_block.pdf");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='cover'){
    $filename = $pathitem.'/'.$itemid.'_cover.pdf';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/pdf");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$itemid."_cover.pdf");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='preview'){
    $filename = $pathitem.'/'.$itemid.'_preview.pdf';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/pdf");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=preview.pdf");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
if ($object=='zayavka'){
    $filename = $pathitemgen.'/'.$itemid.'_zayavka.xls';
    if(file_exists($filename))
    {
       $fp = @fopen($filename, "rb");
       if ($fp)
       {
          header("Content-type: application/vnd.ms-excel ");
          header("Content-Length: " . filesize($filename));
          header("Content-Disposition: attachment; filename=".$itemid."_zayavka.xls");
          header('Content-Transfer-Encoding: binary');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          fpassthru($fp);
          exit;
       }
    }
    header("HTTP/1.0 404 Not Found");
}
?> 