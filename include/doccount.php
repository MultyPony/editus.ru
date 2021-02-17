<?php

require_once 'lang/errors_lang.php';
require_once 'lang/funcOrderClient_lang.php';
require_once './../config.inc.php';
require_once 'db_class.php';


$data = array();
$userid = intval($_POST['userid']);
$orderid = intval($_POST['orderid']);

$pathdir = './../uploads/' . $userid . '/' . $orderid;
$path = $pathdir . '/' . $orderid . '_block.doc';
$pathpdf = $pathdir . '/' . $orderid . '_block.pdf';
$pathpdf_c = $pathdir . '/' . $orderid . '_block_converted.pdf';
$pathdocx = $pathdir . '/' . $orderid . '_block.docx';
$db = new Db();
$db->query("SELECT projectData, projectCount, uplFormat
            FROM UsersProjects 
            WHERE projectId = '" . $orderid . "' AND
                  userId = '".$userid."' ");
$row = $db->fetch_array();
$gdata = unserialize($row['projectData']);
$gdata['projectCount']=$row['projectCount'];
$gdata['uplFormat']=$row['uplFormat'];

$curformat = end(explode(".", $_FILES['myfile']['name']));

//$flagedit = false;
if ($gdata['additionalservice']!= NULL){
    $sql = implode("' OR AdditionalServiceId = '", $gdata['additionalservice']);
    $db->query("SELECT label 
                FROM AdditionalServiceCosts 
                WHERE AdditionalServiceId = '" . $sql . "' ");
    while($row = $db->fetch_array()){
        if ($row['label']=='edit'){
            if ($curformat != 'doc' && $curformat != 'docx'){
                echo json_encode(array('error' => _OS1_INCORECTFORMATFILEFORSERVICE));
                return;
            }
        }
    }
} 
//
//if ($flagedit){
//    if ($curformat != 'doc' && $curformat != 'docx'){
//        echo json_encode(array('error' => _OS1_INCORECTFORMATFILEFORSERVICE));
//        return;
//    }
//}

if (isset($_POST['do'])=='newstestbind'){
    $gdata['binding'] = intval($_POST['newbind']);
    
    $db->query("UPDATE UsersProjects 
                SET projectData = '" . serialize($gdata) . "' 
                WHERE projectId = '" . $orderid . "' AND
                      userId = '".$userid."' ");
    doctopdf();
}
function clearfiles(){
    global $path, $pathpdf, $pathdocx, $pathpdf_c;
    if (file_exists($pathpdf)){
        unlink($pathpdf);
    }
    if (file_exists($path)){
        unlink($path);
    }
    if (file_exists($pathpdf_c)){
        unlink($pathpdf_c);
    }
    if (file_exists($pathdocx)){
        unlink($pathdocx);
    }
}

if (isset($_FILES["myfile"])) {
    if ($curformat == 'doc') {
        if (file_exists($pathdir)) {
//            if (file_exists($path)) {
//                rename($path, $path . '_' . date("Y-m-d_G-i-s"));
//            }
            clearfiles();
            if (move_uploaded_file($_FILES['myfile']['tmp_name'], $path)) {
                doctopdf('doc');
            }
        } else {
            if (mkdir($pathdir, 0777, true)) {
                chmod($pathdir, 0777);
                if (move_uploaded_file($_FILES['myfile']['tmp_name'], $path)) {
                    doctopdf('doc');
                }
            } else {
                echo json_encode(array('error' => _CANTCREATEDIR));
                return;
            }
        }
    } else if ($curformat == 'pdf') {
        if (file_exists($pathdir)) {
//            if (file_exists($path)) {
//                rename($path, $path . '_' . date("Y-m-d_G-i-s"));
//            }
            clearfiles();
            if (move_uploaded_file($_FILES['myfile']['tmp_name'], $pathpdf)) {
                doctopdf('pdf');
            }
        } else {
            if (mkdir($pathdir, 0777, true)) {
                chmod($pathdir, 0777);
                if (move_uploaded_file($_FILES['myfile']['tmp_name'], $pathpdf)) {
                    doctopdf('pdf');
                }
            } else {
                echo json_encode(array('error' => _CANTCREATEDIR));
                return;
            }
        }
    }else if ($curformat == 'docx') {
        if (file_exists($pathdir)) {
//            if (file_exists($path)) {
//                rename($path, $path . '_' . date("Y-m-d_G-i-s"));
//            }
            clearfiles();
            if (move_uploaded_file($_FILES['myfile']['tmp_name'], $pathdocx)) {
                doctopdf('docx');
            }
        } else {
            if (mkdir($pathdir, 0777, true)) {
                chmod($pathdir, 0777);
                if (move_uploaded_file($_FILES['myfile']['tmp_name'], $pathdocx)) {
                    doctopdf('docx');
                }
            } else {
                echo json_encode(array('error' => _CANTCREATEDIR));
                return;
            }
        }
    } else{
        echo json_encode(array('error' => _INCORECTFORMATFILE));
        return;
    }
}


function doctopdf($format='') {
    global $path, $ptoadd, $orderid, $userid, $gdata, $pathpdf, $pathdocx, $data;
    if ($format==''){
//        if (file_exists($path)){
        $format = $gdata['uplFormat'];
//        }else if(file_exists($pathdocx)){
//            $format = 'docx';
//        }else{
//            $format='pdf';
//        }
    }else{
        $db = new Db();
        $db->query("UPDATE UsersProjects 
                    SET uplFormat = '" . $format . "' 
                    WHERE projectId = '" . $orderid . "' AND
                          userId = '".$userid."' ");
    }
    $db = new Db();
    $db->query("SELECT BindingMultiplicity 
                FROM BindingType 
                WHERE BindingId = '".$gdata['binding']."' ");
    $bm = $db->fetch_array();
    $db->query("SELECT formatInA3, formatName
                FROM PaperFormat 
                WHERE formatId = '" . $gdata['size'] . "' ");
    $row = $db->fetch_array();
    $pr_pagesona3 = $row['formatInA3'];
    $pageformatname = $row['formatName'];
    $f = 0;
    $try = 5;
    $good = 5;
    $data['pathblock'] = false;
    $res=array();
    if ($format == 'doc'){
        do {
            $f++;
	    //fastcgi_finish_request();
	    //sleep(10);
            exec("/usr/bin/python3 ./uploadblockconv.py -f ".$pageformatname." -k ".$bm['BindingMultiplicity']." -p ".$gdata['volume']."  --pdf " . $path, $res);
            foreach ($res as $cur) {
                $t = explode(': ', $cur);
                $data[$t[0]] = $t[1];
            }
        } while (count($res) != $good && $f < $try);
        $data['format'] = 'doc';
        $data['pathblock'] = 'include/get.php?uid='.$userid.'%26oid='.$orderid.'%26o=blockdoc';
    }
    if ($format == 'pdf'){
        do {
            $f++;
	    //fastcgi_finish_request();
            exec("/usr/bin/python3 ./uploadblockconv.py -f ".$pageformatname." -k ".$bm['BindingMultiplicity']." -p ".$gdata['volume']."  --ispdf " . $pathpdf, $res);
            foreach ($res as $cur) {
                $t = explode(': ', $cur);
                $data[$t[0]] = $t[1];
            }
        } while ((count($res) != $good) && (count($res) != ($good+1)) && $f < $try); 
        $data['format'] = 'pdf';
    }
    if ($format == 'docx'){
        do {
            $f++;
	    //fastcgi_finish_request();
            exec("/usr/bin/python3 ./uploadblockconv.py -f ".$pageformatname." -k ".$bm['BindingMultiplicity']." -p ".$gdata['volume']."  --pdf " . $pathdocx, $res);
            foreach ($res as $cur) {
                $t = explode(': ', $cur);
                $data[$t[0]] = $t[1];
            }
        } while (count($res) != $good && $f < $try); 
        $data['format'] = 'docx';
        $data['pathblock'] = 'include/get.php?uid='.$userid.'%26oid='.$orderid.'%26o=blockdocx';
    }
    $data['debug']=$gdata['uplFormat'].' '.$pageformatname;

    if (count($res) == $good) {
        $db = new Db();
        $db->query("UPDATE UsersProjects 
                    SET uplFormat = '" . $data['format'] . "' 
                    WHERE projectId = '" . $orderid . "' AND
                          userId = '".$userid."' ");
        $data['pathpdf'] = 'include/get.php?uid='.$userid.'%26oid='.$orderid.'%26o=blocklayot';
        $data['error'] = false;

        
//        $db->query("SELECT PrintCost 
//                    FROM PrintTypeCostsBlock 
//                    WHERE PrintType = '" . $gdata['colorblock'] . "' ");
//        $row = $db->fetch_array();
//        $pr_printtypeblock = $row[0];
//        $db->query("SELECT PaperTypeCost 
//                    FROM PaperTypeCostsBlock 
//                    WHERE PaperTypeId = '" . $gdata['paper'] . "' ");
//        $row = $db->fetch_array();
//        $pr_papertypeblock = $row[0];
//        $db->query("SELECT OrderRate 
//                    FROM OrdersRates 
//                    WHERE OrderRateMin <= '" . $gdata['projectCount'] . "' AND 
//                          OrderRateMax >= '" . $gdata['projectCount'] . "' ");
//        $row = $db->fetch_array();
//        $koef = $row[0];
//        $data['totalblock'] = 0 ;
//        $data['totalblock'] = ((($pr_printtypeblock + $pr_papertypeblock) * $data['PageCount'] / $pr_pagesona3) * $gdata['projectCount'] * $koef);
//        if ($gdata['additionalservice']!= NULL){
//            $sql = implode("' OR AdditionalServiceId = '", $gdata['additionalservice']);
//            $db->query("SELECT AdditionalServiceCost, MetricType, MetricVal 
//                        FROM AdditionalServiceCosts 
//                        WHERE AdditionalServiceId = '" . $sql . "' ");
//            $pr = 0;
//            while ($row = $db->fetch_array()){
//                if ($row['MetricType']=='char'){
//                    $pr += ((floor($data['CharacterCount']/$row['MetricVal'])+1)*$row['AdditionalServiceCost']);
//                }else if($row['MetricType']=='pub'){
//                    $pr +=$row['AdditionalServiceCost'];
//                }else if($row['MetricType'] == 'list'){
//                    $pr += ($data['PageCount']*$row['AdditionalServiceCost']);
//                }
//            }
//            $data['totaladds'] = $pr;
//        }else{
//            $data['totaladds'] = 0;
//        }
        if ($data['PageCount']!= $gdata['volume']){
            $data['pf'] =true;
            $newbind=array();
            $db->query("SELECT BindingId 
                        FROM BindingType 
                        WHERE CoverType = '".$db->mres($gdata['cover'])."' AND 
                              BindingMin <= '".intval($data['PageCount'])."' AND 
                              BindingMax >= '".intval($data['PageCount'])."' ");
            while ($row = $db->fetch_array()){
                $newbind[] = $row['BindingId'];
            }
            if (in_array($gdata['binding'],$newbind)){
                $data['newbind'] = false;
            }else{
                $data['newbind'] = $data['PageCount'];
            }
        }
        echo json_encode($data);
    } else {
        if ($data['format'] == 'pdf' && isset($data['error'])){
            echo json_encode(array('error' => _OS1_ERRUPLFORMAT.' '.$pageformatname.'.'));
        }else{
            echo json_encode(array('error' => _OS1_ERRORCONVERT));
        }
        return;
    }
    
}

?>
