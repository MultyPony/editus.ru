<?php
require_once 'lang/errors_lang.php';
require_once './../config.inc.php';
require_once 'db_class.php';
require_once 'lang/funcOrderClient_lang.php';

$userid=intval($_POST['userid']);
$orderid=intval($_POST['orderid']);

$pathdir = './../uploads/'.$userid.'/'.$orderid;
$data['error']=false;
$data['errortext']='';
$data['skiptest']=false;

if (isset($_FILES["myfile"])){
    $db = new Db();
    $db->query("SELECT orderAdditService, formatUplImg
                FROM UsersOrders 
                WHERE orderId = '" . $orderid . "' AND
                      userId = '" . $userid . "' LIMIT 1");
    $dataorder = $db->fetch_array();
    $t = explode(',', $dataorder['orderAdditService']);
    $db->query("SELECT AdditionalServiceId, label
                FROM AdditionalServiceCosts 
                WHERE AdditionalServiceEnable = '1' ");
    $ftemplate=array();
    $addtoisdpack = false;
    while ($row = $db->fetch_array()) {
        if (count($t)>0) {
            if (in_array($row['AdditionalServiceId'], $t)) {
                if ($row['label'] == 'covdesign') {
                    $ftemplate['covdesign'] = 1;
                }    
                if ($row['label'] == 'addtoisdpack') {
                    $addtoisdpack = true;
                }
            }
        } 
    }
    $data['format'] = end(explode(".", $_FILES['myfile']['name']));
    
    $pathdesignDB = $pathdir.'/'.$orderid.'_design.'.$dataorder['formatUplImg'];
    $pathcoverDB = $pathdir.'/'.$orderid.'_cover.'.$dataorder['formatUplImg'];
    
    if (file_exists($pathdesignDB)){
        unlink($pathdesignDB);
    }
    if (file_exists($pathcoverDB)){
        unlink($pathcoverDB);
    }
    
    $pathdesign = $pathdir.'/'.$orderid.'_design.'.$data['format'];
    $pathcover = $pathdir.'/'.$orderid.'_cover.'.$data['format'];
    $pathcoverpdf = $pathdir.'/'.$orderid.'_cover.pdf';
    
    if ($ftemplate['covdesign'] == 1){
        if(move_uploaded_file($_FILES['myfile']['tmp_name'], $pathdesign)){
            $data['skiptest']=true;
            $data['messgood'].=_OS2_FILEUPLOADED;
        }
    }else{
        $pathtemplatecover = $pathdir.'/'.$orderid.'_template_cover.png';
        $_5mm = 59;
        if (file_exists($pathcover)){
            unlink($pathcover);
        }
        if (file_exists($filename)){
            unlink($pathcoverpdf);
        }
        if(move_uploaded_file($_FILES['myfile']['tmp_name'], $pathcover)){
            $image = new Imagick($pathcover);
            if (($image->getImageFormat () == 'JPEG') || ($image->getImageFormat () == 'PNG')){
                if(get_dpi($pathcover)){
                   $templatecover = new Imagick($pathtemplatecover);
                   $templatecoversize = $templatecover->getImageGeometry();
                   $imagesize = $image->getImageGeometry();
                   if (abs($templatecoversize['width']-$imagesize['width'])>=$_5mm || abs($templatecoversize['height']-$imagesize['height'])>=$_5mm){
                       $data['error']=true;
                       $data['errortext'].=_OS2_INCORECTSIZE;
                   }else{
                       $res=array();
//                       exec("/usr/bin/convert ".$pathcover." ".$pathcoverpdf, $res);
                       if ($addtoisdpack){
                           $db->query("SELECT isbn
                                       FROM ISBNnumbers
                                       WHERE (orderId = '0' OR orderId = '".$orderid."') AND 
                                             isPaid = '0' 
                                       LIMIT 1 ");
                           $isbnqu = $db->fetch_array();
                           $isbnnumber = $isbnqu['isbn'];
                           $db->query("UPDATE ISBNnumbers 
                                       SET orderId = '".$orderid."',
                                           orderDate = '".date("Y-m-d H:i:s")."'
                                       WHERE isbn = '".$isbnnumber."'");
//                           echo "/usr/bin/perl ./createcoverpdf.pl ".$pathcover." ".$orderid." ".$isbnnumber;
                           exec("/usr/bin/perl ./createcoverpdf.pl ".$pathcover." ".$isbnnumber, $res);
                           
                       }else{
                           exec("/usr/bin/perl ./createcoverpdf.pl ".$pathcover, $res);
                       }
                       if (count($res)>0){
                           $data['error']=true;
                           $data['errortext'].=_OS2_CANTCREATEPDF;
                       }else{
                           $data['messgood']=_OS2_COVERUPLOADED;
                       }
                   }
                }else{
                    $data['error']=true;
                    $data['errortext'].=_OS2_INCORECTDPI;
                }
            }else{
                $data['error']=true;
                $data['errortext'].=_OS2_INCORECTFORMAT;
            }
        }
    }
    $db->query("UPDATE UsersOrders
                SET formatUplImg = '". $data['format'] ."'
                WHERE orderId = '". $orderid ."' AND
                      userId = '" . $userid . "'");
    echo json_encode($data);
}

 function get_dpi($filename){ 
//    $a = fopen($filename,'r'); 
//    $string = fread($a,20); 
//    fclose($a); 
//
//    $data = bin2hex(substr($string,14,4)); 
//    $x = substr($data,0,4); 
//    $y = substr($data,4,4); 
//    $m = 5;
//    if (abs(300-hexdec($x))<$m && abs(300-hexdec($y))<$m){
        return true;
//    }else{
//        return false;
//    }

} 

?>
