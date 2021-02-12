<?php

function shopaddItem(&$e,&$t) {
    $db = new Db();
    $res = '';
    if (isset($_POST['newItemName'])){
        if (!empty($_POST['newItemName']) && !empty($_POST['newItemAuthor']) &&
            !empty($_POST['newItemPrice']) && !empty($_FILES['newItemCoverImg']['name'])){
            $db->query("INSERT INTO ShopItems 
                        SET itemName = '".$db->mres($_POST['newItemName'])."',
                            itemAuthor = '".$db->mres($_POST['newItemAuthor'])."',
                            itemAnnotation = '".$db->mres($_POST['newItemAnnotation'])."',
                            classificateId = '".intval($_POST['newItemClassificate'])."',
                            itemISBN = '".intval($_POST['newItemNumISBN'])."',
                            itemPublish = '".$db->mres($_POST['newItemPublish'])."',
                            itemPages = '".intval($_POST['newItemPages'])."',
                            itemTypeCover = '".$db->mres($_POST['newItemTypeCover'])."',
                            PrintTypeId = '".intval($_POST['newItemTypePrint'])."',
                            formatId = '".intval($_POST['newItemPageFormat'])."',
                            papertTypeId = '".intval($_POST['newItemPaperType'])."',
                            bindingId = '".intval($_POST['newItemBindingType'])."',
                            itemPrice = '".floatval($_POST['newItemPrice'])."',
                            itemAuthorUrl = '".$db->mres($_POST['itemAuthorUrl'])."',
                            isEnable = '1'
                        ");
            $db->query("SELECT LAST_INSERT_ID()");
            $row = $db->fetch_array();
            if (!empty($row[0])){
                $f = 0;
                $path = '../items/'.$row[0];
                if (!file_exists($path)){
                    if (mkdir($path,0777,true)){
                        $image = new Imagick($_FILES['newItemCoverImg']['tmp_name']);
                        if (($image->getImageFormat () == 'JPEG') || ($image->getImageFormat () == 'PNG')){
                            $thumb = $image->clone();
                            $thumb2 = $image->clone();
                            $image->thumbnailImage(200, 0); 
                            $image->writeImage($path.'/'.$row[0].'_cover.png');
                            $thumb->thumbnailImage(100, 0); 
                            $thumb2->thumbnailImage(40, 0); 
                            $thumb2->writeImage($path.'/'.$row[0].'_thumbmini_cover.png');
                            if ($thumb->writeImage($path.'/'.$row[0].'_thumb_cover.png')){
                                $f += 1;
                            }
                        }else{
                            $res = _SAI_INCORECTFORMAT; 
                        }
                        if (!empty ($_FILES['newItemFileBook']['name'])){
                            if (end(explode(".", $_FILES['newItemFileBook']['name'])) == 'pdf' ){
                                if (move_uploaded_file($_FILES['newItemFileBook']['tmp_name'], $path.'/'.$row[0].'_block.pdf')){
                                    $f += 1;
                                }
                            }else{
                                $res = _SAI_INCORECTFORMAT;
                            }
                        }else{
                            $f += 1;
                        }
                        if (!empty ($_FILES['newItemFileCover']['name'])){
                            if (end(explode(".", $_FILES['newItemFileCover']['name'])) == 'pdf' ){
                                if (move_uploaded_file($_FILES['newItemFileCover']['tmp_name'], $path.'/'.$row[0].'_cover.pdf')){
                                    $f += 1;
                                }
                            }else{
                                $res = _SAI_INCORECTFORMAT;
                            }
                        }else{
                            $f += 1;
                        }
                        if (!empty ($_FILES['newItemFilePreview']['name'])){
                            if (end(explode(".", $_FILES['newItemFilePreview']['name'])) == 'pdf' ){
                                if (move_uploaded_file($_FILES['newItemFilePreview']['tmp_name'], $path.'/'.$row[0].'_preview.pdf')){
                                    $f += 1;
                                }
                            }else{
                                $res = _SAI_INCORECTFORMAT;
                            }
                        }else{
                            $f += 1;
                        }
                    }
                }
            }
            if ($f == 4 ){
                $res = _SAI_RESOK;
            }
        }else{
            $res = _SAI_FILLFIELD;
        }
    }
    $db->query("SELECT PrintTypeId, PrintTypeName
                FROM PrintTypeCostsBlock");
    while ($row = $db->fetch_array()) {
        $typeprint[$row['PrintTypeId']] = $row['PrintTypeName'];
    }
    $db->query("SELECT formatId, formatName, formatWidth, formatHeight
                FROM PaperFormat");
    while ($row = $db->fetch_array()) {
        $formats[$row['formatId']] = $row['formatName'].' ('.$row['formatWidth'].'x'.$row['formatHeight'].')';
    }   
    $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight
                FROM PaperTypeCostsBlock");
    while ($row = $db->fetch_array()) {
        $papertype[$row['PaperTypeId']] = $row['PaperTypeName'].' '.$row['PaperTypeWeight'];
    } 
    $db->query("SELECT BindingId, BindingName
                FROM BindingType");
    while ($row = $db->fetch_array()) {
        $binding[$row['BindingId']] = $row['BindingName'];
    } 
    $cover['soft']=_SAI_SOFTCOVER;
    $cover['hard']=_SAI_HARDCOVER;
    $db->query("SELECT classificateId, classificateName
                FROM ShopItemClassificate");
    while ($row = $db->fetch_array()) {
        $classificate[$row['classificateId']] = $row['classificateName'];
    } 
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('binding'=>$binding,'formats'=>$formats, 'typeprint'=>$typeprint, 'cover'=>$cover,'classificate'=>$classificate, 'res'=>$res, 'papertype'=>$papertype));
    $tpl->fetch('shopAddItem.tpl');
    return $tpl->get_tpl();
}
function editclassificate(){
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM ShopItemClassificate 
                    WHERE classificateId = '".intval($_POST['id'])."' ");
    }
    if (isset($_POST['newclassificate'])) {
        $db->query("INSERT INTO ShopItemClassificate 
                     SET classificateName = '".$db->mres($_POST['newclassificate'])."' ");
    }
    if (isset($_POST['classificate']) ) {
        $db->query("UPDATE ShopItemClassificate 
                    SET classificateName = '".$db->mres($_POST['classificate'])."'
                    WHERE classificateId = '".intval($_POST['id'])."' ");
    }    
        
    $db->query("SELECT classificateId, classificateName
                FROM ShopItemClassificate");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    } 
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data'=>$data));
    $tpl->fetch('editClassificate.tpl');
    return $tpl->get_tpl();
}
function listitems(){
    $db = new Db();
    $cover['soft']=_LI_SOFTCOVER;
    $cover['hard']=_LI_HARDCOVER;
    $sqls='';
    if (isset($_GET['searchline']) && !empty($_GET['searchline'])){
        $searchline = str_replace(' ', '%' , trim($_GET['searchline']));
        $sqls= " AND ( ShopItems.itemName LIKE '%".$searchline."%' OR ShopItems.itemAuthor LIKE '%".$searchline."%' OR ShopItems.itemISBN LIKE '%".$searchline."%' ) ";
    }
    $db->query("SELECT ShopItems.itemId, ShopItems.itemName, ShopItems.itemAuthor, ShopItems.itemAnnotation, ShopItemClassificate.classificateName, 
                       ShopItems.itemISBN, ShopItems.itemPublish, ShopItems.itemPages, ShopItems.itemTypeCover, PrintTypeCostsBlock.PrintTypeName,
                       PaperFormat.formatName, ShopItems.itemPrice, ShopItems.itemAuthorUrl
                FROM ShopItems, ShopItemClassificate, PaperFormat, PrintTypeCostsBlock
                WHERE ShopItems.classificateId = ShopItemClassificate.classificateId AND
                      ShopItems.PrintTypeId = PrintTypeCostsBlock.PrintTypeId AND
                      ShopItems.isEnable = '1' AND
                      ShopItems.formatId = PaperFormat.formatId ".$sqls." ORDER BY ShopItems.itemId DESC ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()) {
        $row['itemTypeCover'] = $cover[$row['itemTypeCover']];
        $data[] = $row;
    } 
    $db->query("SELECT count(*)
                FROM ShopItems, ShopItemClassificate, PaperFormat, PrintTypeCostsBlock
                WHERE ShopItems.classificateId = ShopItemClassificate.classificateId AND
                      ShopItems.PrintTypeId = PrintTypeCostsBlock.PrintTypeId AND
                      ShopItems.isEnable = 1 AND 
                      ShopItems.formatId = PaperFormat.formatId ".$sqls." ");
    $count = $db->fetch_array();
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data'=>$data,'count'=>$count,'pages'=> Engine::pagetpl($count[0], 'index.php?do=listitems&amp;searchline='.$_GET['searchline'], true)));
    $tpl->fetch('listitems.tpl');
    return $tpl->get_tpl();
}
function listshopallorders(&$e,&$t) {
    $db = new Db();
    $sqlfilt = '';
    $sqlfiltid = '';
    if (!empty($_GET['pf']) && !empty($_GET['pt'])){
        $sqlfiltprice = ' ( CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) > '.$_GET['pf'].' AND  
                            CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) < '.$_GET['pt'].' ) AND ';
    }
    if (!empty($_GET['orderid'])){
        $sqlfiltid = ' ShopOrders.orderId = '.intval($_GET['orderid']).' AND ';
    }
    if (!empty($_GET['filtstate'])){
        if($_GET['filtstate']=='all'){
            $sqlfilt = '';
        }else{
            $sqlfilt = ' ShopOrders.stateId = '.$_GET['filtstate'].' AND ShopOrders.orderstep > 0 AND ';
        }
    }
    $db->query("SELECT ShopOrders.orderId, 
                       ShopOrders.orderCost,
                       ShopOrders.orderDate,
                       ShopOrders.stateId, 
                       ShopOrders.orderstep,
                       Users.userId, 
                       Users.userEmail, 
                       CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal
                FROM ShopOrders, Users
                WHERE ".$sqlfiltid.$sqlfilt.$sqlfiltcount.$sqlfiltprice." 
                      Users.userId = ShopOrders.userId ORDER BY ShopOrders.orderDate DESC ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $db->query("SELECT count(*)
                FROM ShopOrders, Users
                WHERE ".$sqlfiltid.$sqlfilt.$sqlfiltcount.$sqlfiltprice." Users.userId=ShopOrders.userId");
    $count = $db->fetch_array();
    $db->query("SELECT stateId,	stateName
                FROM OrdersStates");
    while ($row = $db->fetch_array()) {
        $states[$row['stateId']] = $row['stateName'];
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('states'=>$states,'data' => $rows, 'pages'=> Engine::pagetpl($count['0'], 'index.php?do=listshopallorders&amp;filtstate='.$_GET['filtstate'].'&amp;orderid='.$_GET['orderid'].'&amp;cf='.$_GET['cf'].'&amp;ct='.$_GET['ct'].'&amp;pf='.$_GET['pf'].'&amp;pt='.$_GET['pt'], true)));
    $tpl->fetch('listshopallorders.tpl');
    return $tpl->get_tpl();
}
function editshopstatus(){
    if(isset($_GET['id'])){
        $db = new Db();
        if (isset($_POST['idstatus'])){
            $db->query("UPDATE ShopOrders
                        SET stateId = '".  intval($_POST['status'])."'
                        WHERE orderId = '".  intval($_POST['idstatus'])."' ");
            $db->query("INSERT INTO ShopOrderStateChanges 
                        SET orderId = '" . intval($_POST['idstatus']) . "',
                            curState = '".intval($_POST['status'])."',
                            userId = '" . $_SESSION['userId'] . "' ");
        }
        if (isset($_POST['idstep'])){
            $db->query("UPDATE ShopOrders
                        SET orderstep = '".  intval($_POST['step'])."'
                        WHERE orderId = '".  intval($_POST['idstep'])."' ");
        }  
        if (isset($_POST['idstatusfulldelete'])){
            $db->query("DELETE 
                        FROM ShopOrders
                        WHERE orderId = '".  intval($_POST['idstatusfulldelete'])."' ");
            header("Location: //".$_SERVER['HTTP_HOST'].'/admin/index.php?do=listshopallorders');
        }
        $db->query("SELECT stateId, stateName
                    FROM OrdersStates");
        while ($row = $db->fetch_array()) {
            $statuses[] = $row;
        }
        $statuses[] = array('stateId'=>'0','stateName'=>_ESS_NOTSET);
        $db->query("SELECT stateId, orderstep
                    FROM ShopOrders
                    WHERE orderId = '".  intval($_GET['id'])."' LIMIT 1 ");
        $row = $db->fetch_array();
        $curstate = array($row['stateId'], $row['orderstep']);
        $oform = array('1'=>_ESS_NOTCOMPPAY,'2'=>_ESS_COMPL);
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('statuses' => $statuses, 'curstate'=>$curstate,'oform'=>$oform));
        $tpl->fetch('editshopstatus.tpl');
        return $tpl->get_tpl();
    }
}
function viewshoporderadmin(){
    if (is_numeric($_GET['o'])){
        $db = new Db();
        $db->query("SELECT ShopOrders.orderId AS orderId, 
                           ShopOrders.itemsId AS itemsId, 
                           ShopOrders.orderCost AS orderCost, 
                           ShopOrders.orderDate AS orderDate, 
                           ShopOrders.orderstep AS orderstep, 
                           ShopOrders.stateId AS stateId,
                           ShopOrders.orderPriceDeliver AS orderPriceDeliver,
                           CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal,
                           ShopOrders.DeliveryProviderId AS DeliveryProviderId,
                           ShopOrders.addressId AS addressId
                    FROM ShopOrders
                    WHERE orderId = '".intval($_GET['o'])."' LIMIT 1");
        $data = $db->fetch_array();
        $t = unserialize($data['itemsId']);
        $sqlcomporder = 'SELECT itemId, itemName 
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
            $comp .= ', <a href="./index.php?do=shopviewitem&itemid='.$row['itemId'].'">'.$row['itemName'].'</a> x'.$t[$row['itemId']];
        }
        $comp[0]='';
        if ($data['DeliveryProviderId']!=0){
            $db->query("SELECT DeliveryProviderName
                        FROM DeliveryProviders 
                        WHERE DeliveryProviderId = '". $data['DeliveryProviderId'] ."' ");
            $row = $db->fetch_array();
            $namedeliv = $row[0];
            $db->query("SELECT DeliveryCountries.CountryName AS CountryName,
                               DeliveryRegions.RegionName AS RegionName,
                               UsersDeliveryAddreses.addressIndex AS addressIndex,
                               UsersDeliveryAddreses.addressCity AS addressCity,
                               UsersDeliveryAddreses.addressStr AS addressStr,
                               UsersDeliveryAddreses.addressHouse AS addressHouse,
                               UsersDeliveryAddreses.addressBuild AS addressBuild,
                               UsersDeliveryAddreses.addressApt AS addressApt,
                               UsersDeliveryAddreses.addressContact AS addressContact,
                               UsersDeliveryAddreses.addressTelephone AS addressTelephone
                        FROM UsersDeliveryAddreses, DeliveryCountries, DeliveryRegions
                        WHERE UsersDeliveryAddreses.addressId = '". $data['addressId'] ."' AND
                              DeliveryCountries.CountryId = UsersDeliveryAddreses.addressCountry AND 
                              DeliveryRegions.RegionId = UsersDeliveryAddreses.addressRegion ");
            $dataadres = $db->fetch_array();
        }
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('data'=>$data,'namedeliv'=>$namedeliv, 'dataadres'=>$dataadres,'comp'=>$comp));
        $tpl->fetch('viewshoporderadmin.tpl');
        return $tpl->get_tpl();
    }
}
function shopedititem(&$e,&$t) {
    $db = new Db();
    $res = '';
    if (isset($_POST['delete'])){
        $id = intval($_POST['itemid']);
//        $db->query("DELETE
//                    FROM ShopItems 
//                    WHERE itemId = '".$id."' ");
//        $path = '../items/'.$id;
//        unlink($path.'/'.$id.'_cover.png');
//        unlink($path.'/'.$id.'_thumbmini_cover.png');
//        unlink($path.'/'.$id.'_thumb_cover.png');
//        if (file_exists($path.'/'.$id.'_book.pdf')){
//            unlink($path.'/'.$id.'_book.pdf');
//        }
//        rmdir($path);
        $db->query("UPDATE ShopItems 
                    SET isEnable = '0' 
                    WHERE itemId = '".$id."' ");
        header("Location: //".$_SERVER['HTTP_HOST'].'/admin/index.php?do=listitems');
    }
    if (isset($_POST['newItemName'])){
        if (!empty($_POST['newItemName']) && !empty($_POST['newItemAuthor']) &&
            !empty($_POST['newItemPrice']) ){
            $id = intval($_POST['itemid']);
            $db->query("UPDATE ShopItems 
                        SET itemName = '".$db->mres($_POST['newItemName'])."',
                            itemAuthor = '".$db->mres($_POST['newItemAuthor'])."',
                            itemAnnotation = '".$db->mres($_POST['newItemAnnotation'])."',
                            classificateId = '".intval($_POST['newItemClassificate'])."',
                            itemISBN = '".intval($_POST['newItemNumISBN'])."',
                            itemPublish = '".$db->mres($_POST['newItemPublish'])."',
                            itemPages = '".intval($_POST['newItemPages'])."',
                            itemTypeCover = '".$db->mres($_POST['newItemTypeCover'])."',
                            PrintTypeId = '".intval($_POST['newItemTypePrint'])."',
                            formatId = '".intval($_POST['newItemPageFormat'])."',
                            papertTypeId = '".intval($_POST['newItemPaperType'])."',
                            bindingId = '".intval($_POST['newItemBindingType'])."',
                            itemPrice = '".floatval($_POST['newItemPrice'])."',
                            itemAuthorUrl = '".$db->mres($_POST['newItemAuthorUrl'])."'
                        WHERE itemId = '".$id."' ");
            $row[0]=$id;
            if (!empty($row[0])){
                $f = 0;
                $path = '../items/'.$row[0];
                if (!empty($_FILES['newItemCoverImg']['name'])){
                    $image = new Imagick($_FILES['newItemCoverImg']['tmp_name']);
                    if (($image->getImageFormat () == 'JPEG') || ($image->getImageFormat () == 'PNG')){
                        $thumb = $image->clone();
                        $thumb2 = $image->clone();
                        unlink($path.'/'.$row[0].'_cover.png');
                        $image->thumbnailImage(200, 0); 
                        $image->writeImage($path.'/'.$row[0].'_cover.png');
                        $thumb->thumbnailImage(100, 0); 
                        $thumb2->thumbnailImage(40, 0); 
                        unlink($path.'/'.$row[0].'_thumbmini_cover.png');
                        unlink($path.'/'.$row[0].'_thumb_cover.png');
                        $thumb2->writeImage($path.'/'.$row[0].'_thumbmini_cover.png');
                        if ($thumb->writeImage($path.'/'.$row[0].'_thumb_cover.png')){
                            $f += 1;
                        }
                    }else{
                        $res = _SEI_INCORECTFORMAT; 
                    }
                }else{
                        $f += 1;
                }
                if (!empty ($_FILES['newItemFileBook']['name'])){
                    if (end(explode(".", $_FILES['newItemFileBook']['name'])) == 'pdf' ){
                        if (move_uploaded_file($_FILES['newItemFileBook']['tmp_name'], $path.'/'.$row[0].'_block.pdf')){
                            $f += 1;
                        }
                    }else{
                        $res = _SEI_INCORECTFORMAT;
                    }
                }else{
                    $f += 1;
                }
                if (!empty ($_FILES['newItemFileCover']['name'])){
                    if (end(explode(".", $_FILES['newItemFileCover']['name'])) == 'pdf' ){
                        if (move_uploaded_file($_FILES['newItemFileCover']['tmp_name'], $path.'/'.$row[0].'_cover.pdf')){
                            $f += 1;
                        }
                    }else{
                        $res = _SAI_INCORECTFORMAT;
                    }
                }else{
                    $f += 1;
                }
                if (!empty ($_FILES['newItemFilePreview']['name'])){
                    if (end(explode(".", $_FILES['newItemFilePreview']['name'])) == 'pdf' ){
                        if (move_uploaded_file($_FILES['newItemFilePreview']['tmp_name'], $path.'/'.$row[0].'_preview.pdf')){
                            $f += 1;
                        }
                    }else{
                        $res = _SAI_INCORECTFORMAT;
                    }
                }else{
                    $f += 1;
                }                    
            }
            if ($f == 4 ){
                $res = _SEI_RESOK;
            }
        }else{
            $res = _SEI_FILLFIELD;
        }
    }
    if (isset($_GET['iditem'])){
        $id = intval($_GET['iditem']);
    }else{
        $id = intval($_POST['itemid']);
    }
    $db->query("SELECT ShopItems.itemId, ShopItems.itemName, 
                       ShopItems.itemAuthor, ShopItems.itemCoverImgUrl,
                       ShopItems.itemAnnotation, ShopItems.classificateId,
                       ShopItems.itemISBN, ShopItems.itemPublish,
                       ShopItems.itemPages, ShopItems.itemTypeCover,
                       ShopItems.PrintTypeId, ShopItems.formatId,
                       ShopItems.papertTypeId, ShopItems.itemPrice,
                       ShopItems.itemAuthorUrl, ShopItems.bindingId
                FROM ShopItems
                WHERE ShopItems.itemId = '".$id."' LIMIT 1");
    $data = $db->fetch_array();
    $db->query("SELECT PrintTypeId, PrintTypeName
                FROM PrintTypeCostsBlock");
    while ($row = $db->fetch_array()) {
        $typeprint[$row['PrintTypeId']] = $row['PrintTypeName'];
    }
    $db->query("SELECT formatId, formatName, formatWidth, formatHeight
                FROM PaperFormat");
    while ($row = $db->fetch_array()) {
        $formats[$row['formatId']] = $row['formatName'].' ('.$row['formatWidth'].'x'.$row['formatHeight'].')';
    }   
    $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight
                FROM PaperTypeCostsBlock");
    while ($row = $db->fetch_array()) {
        $papertype[$row['PaperTypeId']] = $row['PaperTypeName'].' '.$row['PaperTypeWeight'];
    } 
    $cover['soft']=_SAI_SOFTCOVER;
    $cover['hard']=_SAI_HARDCOVER;
    $db->query("SELECT classificateId, classificateName
                FROM ShopItemClassificate");
    while ($row = $db->fetch_array()) {
        $classificate[$row['classificateId']] = $row['classificateName'];
    } 
    $db->query("SELECT BindingId, BindingName
                FROM BindingType");
    while ($row = $db->fetch_array()) {
        $binding[$row['BindingId']] = $row['BindingName'];
    } 
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('binding'=>$binding,'data'=>$data, 'formats'=>$formats, 'typeprint'=>$typeprint, 'cover'=>$cover,'classificate'=>$classificate, 'res'=>$res, 'papertype'=>$papertype));
    $tpl->fetch('shopedititem.tpl');
    return $tpl->get_tpl();
}
function ordersshopforpay(&$e,&$t) {
    $db = new Db();
    if (isset($_GET['ok'])) {
        $db->query("UPDATE ShopOrders 
                    SET stateId = '3', 
                        orderstep = '2' 
                    WHERE orderId='".$_GET['orderid']."' ");
        $db->query("INSERT INTO ShopOrderStateChanges 
                    SET orderId = '".$_GET['orderid']."',
                        curState = '3',
                        userId = '" . $_SESSION['userId'] . "' ");
        $db->query("SELECT itemsId, orderId, orderDate
                   FROM ShopOrders
                   WHERE orderId = '".$_GET['orderid']."' LIMIT 1");
        $dataorder = $db->fetch_array();
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
    $db->query("SELECT Users.userEmail, ShopOrders.orderId, ShopOrders.itemsId,
                       CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal, 
                       OrdersStates.stateName, ShopOrders.orderDate
                FROM ShopOrders, OrdersStates, Users
                WHERE ShopOrders.StateId = 1 AND 
                      Users.userId = ShopOrders.userId AND
                      ShopOrders.stateId = OrdersStates.stateId ORDER BY ShopOrders.orderDate DESC");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('ordersshopforpay.tpl');
    return $tpl->get_tpl();
}
function ordersshopdelivery(&$m) {
    $db = new Db();
    $activtab = 'createdeliver';
    if (isset($_POST['orderid'])){
        $orderid = intval($_POST['orderid']);
    }else{
        $orderid = intval($_GET['orderid']);
    }
    if ($orderid==0){
        $orderid='';
    }
    if (isset($_POST['createdeliver'])){
        $db->query("SELECT ShopOrders.orderId, ShopOrders.stateId 
                    FROM ShopOrders
                    WHERE ShopOrders.orderId = '".$orderid."'  AND
                          ShopOrders.stateId = '7' LIMIT 1");
        if ($db->num_rows()==1){
            $db->query("UPDATE ShopOrders
                        SET ShopOrders.stateId = '8'
                        WHERE ShopOrders.orderId = '".$orderid."' ");
            $chang[0] = true;
        }
    }
    if (isset($_POST['dispatch'])){
        $db->query("SELECT ShopOrders.orderId, ShopOrders.stateId 
                    FROM ShopOrders
                    WHERE ShopOrders.orderId = '".$orderid."'  AND
                          ShopOrders.stateId = '8' LIMIT 1");
        if ($db->num_rows()==1){
            $db->query("UPDATE ShopOrders
                        SET ShopOrders.stateId = '9'
                        WHERE ShopOrders.orderId = '".$orderid."' ");
            $chang[1] = true;
            $activtab = 'dispatch';
        }
    }
    $db->query("SELECT ShopOrders.orderId
                FROM ShopOrders
                WHERE ShopOrders.DeliveryProviderId = '0' AND 
                      ShopOrders.stateId = '8' ");
    while ($row = $db->fetch_array()) {
        $pickup[] = $row;
    }  
    $db->query("SELECT DeliveryProviders.DeliveryProviderName AS DeliveryProviderName,
                       DeliveryProviders.DeliveryProviderId AS DeliveryProviderId,
                       ShopOrders.orderId AS orderId,
                       DeliveryCountries.CountryName AS CountryName,
                       DeliveryRegions.RegionName AS RegionName,
                       UsersDeliveryAddreses.addressIndex AS addressIndex,
                       UsersDeliveryAddreses.addressCity AS addressCity,
                       UsersDeliveryAddreses.addressStr AS addressStr,
                       UsersDeliveryAddreses.addressHouse AS addressHouse,
                       UsersDeliveryAddreses.addressBuild AS addressBuild,
                       UsersDeliveryAddreses.addressApt AS addressApt,
                       UsersDeliveryAddreses.addressContact AS addressContact,
                       UsersDeliveryAddreses.addressTelephone AS addressTelephone
                FROM UsersDeliveryAddreses, DeliveryCountries, DeliveryRegions, ShopOrders, DeliveryProviders
                WHERE UsersDeliveryAddreses.addressId = ShopOrders.addressId AND
                      DeliveryProviders.DeliveryProviderId = ShopOrders.DeliveryProviderId AND
                      DeliveryCountries.CountryId = UsersDeliveryAddreses.addressCountry AND 
                      DeliveryRegions.RegionId = UsersDeliveryAddreses.addressRegion AND 
                      ShopOrders.stateId = '8' ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'chang'=>$chang,'orderid'=>$orderid, 'activtab'=>$activtab, 'pickup'=>$pickup));
    $tpl->fetch('ordersshopdelivery.tpl');
    return $tpl->get_tpl();
}
function shoporderstatechanges(){
    $db = new Db();
    $sql = " ORDER BY ShopOrderStateChanges.dateChange DESC LIMIT 30";
    if (!empty($_POST['searchorder'])){
        $sql = " AND ShopOrderStateChanges.orderId = '".intval($_POST['searchorder'])."' ORDER BY ShopOrderStateChanges.dateChange DESC ";
    }
    $db->query("SELECT ShopOrderStateChanges.orderId, ShopOrderStateChanges.dateChange, ShopOrderStateChanges.curState, 
                       Users.userEmail, Users.userId
                FROM ShopOrderStateChanges, Users  
                WHERE Users.userId = ShopOrderStateChanges.userId ".$sql." ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $db->query("SELECT OrdersStates.stateId, OrdersStates.stateName
                FROM OrdersStates");
    $states = array('new'=>_OSC_NEWPROJ,'cover'=>_OSC_NEWCOVER,'deliv'=>_OSC_DELIV);
    while ($row = $db->fetch_array()) {
        $states[$row['stateId']] = $row['stateName'];
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows, 'states'=>$states));
    $tpl->fetch('shoporderstatechanges.tpl');
    return $tpl->get_tpl();
}

function shoporderswaitupload(){
    if (isset($_POST['uplcur'])){
        exec("/usr/bin/php5 /home/httpd/editus.ru/www/include/shopuploadtoftp.php");
    }
    $db = new Db();
    $db->query("SELECT ShopOrders.orderId, ShopOrders.orderDate
                FROM ShopOrders 
                WHERE stateId = '3'");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('shoporderswaitupload.tpl');
    return $tpl->get_tpl();
}
function shopordersonprint(&$m) {
    $db = new Db();
    $db->query("SELECT ShopOrders.orderId, ShopOrders.userId, ShopOrders.itemsId
               FROM ShopOrders 
               WHERE StateId = '6' ");
    $z = array();
    if ($db->num_rows()!=0){
        while ($row = $db->fetch_array()) {
            $te = unserialize($row['itemsId']);
            $row['itemsId'] = array_keys($te);
            $rows[] = $row;
            $z = array_merge($z, $row['itemsId']);
        }
        $z = array_unique($z);
        $sqlcomporder = 'SELECT itemId, itemName 
                         FROM ShopItems
                         WHERE ';
        foreach ($z as $key){
            if (!isset($f)){
                $sqlcomporder .=" itemId = '".$key."' ";
                $f = 1;
            }else if ($f == 1){
                $sqlcomporder .=" OR itemId = '".$key."' ";
            } 
        }
        $db->query($sqlcomporder);
        while ($row = $db->fetch_array()) {
            $items[$row['itemId']] = $row['itemName'];
        }
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows,'items'=>$items));
    $tpl->fetch('shopordersonprint.tpl');
    return $tpl->get_tpl();
}
function shopviewitem() {
    $id = intval($_GET['itemid']);
    $db = new Db();
    $db->query("SELECT ShopItems.itemId, ShopItems.itemName, ShopItems.itemAuthor, ShopItems.itemAnnotation, ShopItemClassificate.classificateName, 
                       ShopItems.itemISBN, ShopItems.itemPublish, ShopItems.itemPages, ShopItems.itemTypeCover, PrintTypeCostsBlock.PrintTypeName,
                       PaperFormat.formatName, ShopItems.itemPrice, ShopItems.itemAuthorUrl, BindingType.BindingName, PaperTypeCostsBlock.PaperTypeName,
                       PaperTypeCostsBlock.PaperTypeWeight
                FROM ShopItems, ShopItemClassificate, PaperFormat, PrintTypeCostsBlock, BindingType, PaperTypeCostsBlock
                WHERE ShopItems.itemId = '".$id."' AND
                      PaperTypeCostsBlock.PaperTypeId = ShopItems.papertTypeId AND
                      BindingType.BindingId = ShopItems.bindingId AND
                      ShopItems.classificateId = ShopItemClassificate.classificateId AND
                      ShopItems.PrintTypeId = PrintTypeCostsBlock.PrintTypeId AND
                      ShopItems.isEnable = 1 AND
                      ShopItems.formatId = PaperFormat.formatId LIMIT 1");
    $dataitem = $db->fetch_array();
    $cover['soft']= _SVI_SOFT;
    $cover['hard']= _SVI_HARD;
    $dataitem['itemTypeCover'] = $cover[$dataitem['itemTypeCover']];
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('dataitem' => $dataitem));
    $tpl->fetch('shopviewitem.tpl');
    return $tpl->get_tpl();
}
function shopordersmakeup(&$m) {
    $db = new Db();
    if (isset($_POST['orderid']) || isset($_GET['orderid'])){
        $orderid = isset($_POST['orderid'])? intval($_POST['orderid']):intval($_GET['orderid']);
        if ($orderid==0){
            $orderid='';
        }
        $db->query("SELECT ShopOrders.orderId AS orderId, ShopOrders.itemsId,
                           ShopOrders.stateId AS stateId
                    FROM ShopOrders
                    WHERE orderId = '".$orderid."' AND
                          (ShopOrders.stateId = '6' OR ShopOrders.stateId = '7')
                          LIMIT 1");
        $data = $db->fetch_array();
        if ($db->num_rows()!=0){
            $te = unserialize($data['itemsId']);
            $z = array_keys($te);
            $data['itemsId'] = $z;
            $sqlcomporder = 'SELECT itemId, itemName 
                             FROM ShopItems
                             WHERE ';
            foreach ($z as $key){
                if (!isset($f)){
                    $sqlcomporder .=" itemId = '".$key."' ";
                    $f = 1;
                }else if ($f == 1){
                    $sqlcomporder .=" OR itemId = '".$key."' ";
                } 
            }
            $db->query($sqlcomporder);
            while ($row = $db->fetch_array()) {
                $items[$row['itemId']] = $row['itemName'];
            }
        }
        $chang = false;
        if (!empty($data) && $data['stateId']!=7){
            $db->query("UPDATE ShopOrders
                        SET ShopOrders.stateId = 7
                        WHERE orderId = '".$orderid."'");
            $db->query("INSERT INTO ShopOrderStateChanges 
                        SET orderId = '" . $orderid . "',
                            curState = '7',
                            userId = '" . $_SESSION['userId'] . "' ");
            $chang = true;
        }
    }
    $db->query("SELECT ShopOrders.orderId, ShopOrders.orderUploadDate
                FROM ShopOrders 
                WHERE ShopOrders.stateId = '7' ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('orders' => $rows,'data'=>$data,'items'=>$items,'orderid'=>$orderid,'chang'=>$chang));
    $tpl->fetch('shopordersmakeup.tpl');
    return $tpl->get_tpl();
}  
function shopordersformanualedit(&$m) {
    $db = new Db();
    if (isset($_GET['ok'])) {
     $db->query("UPDATE ShopOrders 
                 SET stateId = '3' 
                 WHERE orderId='".intval($_GET['orderid'])."'");
     $db->query("INSERT INTO ShopOrderStateChanges 
                    SET orderId = '" . intval($_GET['orderid']) . "',
                        curState = '3',
                        userId = '" . $_SESSION['userId'] . "' ");
    }
    $db->query("SELECT ShopOrders.orderId, ShopOrders.userId, ShopOrders.itemsId
               FROM ShopOrders 
               WHERE StateId = '4' ");
    if ($db->num_rows()!=0){
        $z = array();
        while ($row = $db->fetch_array()) {
            $te = unserialize($row['itemsId']);
            $row['itemsId'] = array_keys($te);
            $rows[] = $row;
            $z = array_merge($z, $row['itemsId']);
        }
        $z = array_unique($z);
        $sqlcomporder = 'SELECT itemId, itemName 
                         FROM ShopItems
                         WHERE ';
        foreach ($z as $key){
            if (!isset($f)){
                $sqlcomporder .=" itemId = '".$key."' ";
                $f = 1;
            }else if ($f == 1){
                $sqlcomporder .=" OR itemId = '".$key."' ";
            } 
        }
        $db->query($sqlcomporder);
        while ($row = $db->fetch_array()) {
            $items[$row['itemId']] = $row['itemName'];
        }
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows,'items'=>$items));
    $tpl->fetch('shopordersformanualedit.tpl');
    return $tpl->get_tpl();
}
function shopzayavkaprint(){
    $db = new Db();
    $db->query("SELECT orderId, userId, itemsId
                FROM ShopOrders
                WHERE stateId > 1 AND
                      stateId < 7 ORDER BY orderId DESC");
    if ($db->num_rows()!=0){
        $z = array();
        while ($row = $db->fetch_array()) {
            $te = unserialize($row['itemsId']);
            $row['itemsId'] = array_keys($te);
            $rows[] = $row;
            $z = array_merge($z, $row['itemsId']);
        }
        $z = array_unique($z);
        $sqlcomporder = 'SELECT itemId, itemName 
                         FROM ShopItems
                         WHERE ';
        foreach ($z as $key){
            if (!isset($f)){
                $sqlcomporder .=" itemId = '".$key."' ";
                $f = 1;
            }else if ($f == 1){
                $sqlcomporder .=" OR itemId = '".$key."' ";
            } 
        }
        $db->query($sqlcomporder);
        while ($row = $db->fetch_array()) {
            $items[$row['itemId']] = $row['itemName'];
        }
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows,'items'=>$items));
    $tpl->fetch('shopzayavkaprint.tpl');
    return $tpl->get_tpl();
}
?>
