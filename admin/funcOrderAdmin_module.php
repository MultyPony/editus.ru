<?php

function listallorders(&$e,&$t) {
    $db = new Db();
    $sqlfilt = '';
    $sqlfiltid = '';
    $sqlfilt2 = '';
     if (!empty($_GET['cf'])&& !empty($_GET['ct'])){
        $sqlfiltcount = ' UsersOrders.orderCount > '.$_GET['cf'].' AND UsersOrders.orderCount < '.$_GET['ct'].' AND ';
    }
     if (!empty($_GET['pf']) && !empty($_GET['pt'])){
        $sqlfiltprice = ' ( CEILING(UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver) > '.$_GET['pf'].' AND  CEILING(UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver) < '.$_GET['pt'].' ) AND ';
    }
    if (!empty($_GET['orderid'])){
        $sqlfiltid = ' UsersOrders.orderId LIKE \'%%'.$db->mres($_GET['orderid']).'%%\' AND ';
    }
    if (!empty($_GET['filtstate'])){
        if ($_GET['filtstate']=='ncom'){
            $sqlfilt = ' UsersOrders.orderstep < 3 AND';
        }elseif($_GET['filtstate']=='all'){
            $sqlfilt = '';
        }else{
            $sqlfilt = ' UsersOrders.stateId = '.$_GET['filtstate'].' AND UsersOrders.orderstep > 2 AND ';
        }
    }
    if (!empty($_GET['userorder'])){
        $sqlfilt2 = ' Users.userEmail LIKE \'%%'.$db->mres($_GET['userorder']).'%%\' AND ';
    }
    $db->query("SELECT UsersOrders.orderId, Users.userId, Users.userEmail, UsersOrders.orderName, UsersOrders.orderAutor, UsersOrders.orderCount,UsersOrders.orderPages,
                       UsersOrders.orderSymb,CEILING(UsersOrders.orderPriceBlock) AS orderPriceBlock , CEILING(UsersOrders.orderPriceAdditService) AS orderPriceAdditService, CEILING(UsersOrders.orderPriceCover) AS orderPriceCover,
                       CEILING(UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver) AS orderPriceTotal,
                       Users.userId, UsersOrders.orderDate, UsersOrders.stateId, UsersOrders.orderstep
                FROM UsersOrders, Users
                WHERE ".$sqlfiltid.$sqlfilt.$sqlfiltcount.$sqlfiltprice.$sqlfilt2." Users.userId = UsersOrders.userId ORDER BY UsersOrders.orderId DESC ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $db->query("SELECT count(*)
                FROM UsersOrders, Users
                WHERE ".$sqlfiltid.$sqlfilt.$sqlfiltcount.$sqlfiltprice.$sqlfilt2." Users.userId=UsersOrders.userId");
    $count = $db->fetch_array();
    $db->query("SELECT stateId,	stateName
                FROM OrdersStates");
    while ($row = $db->fetch_array()) {
        $states[$row['stateId']] = $row['stateName'];
    }    
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('states'=>$states,'data' => $rows, 'pages'=> Engine::pagetpl($count['0'], 'index.php?do=listallorders&amp;filtstate='.$_GET['filtstate'].'&amp;orderid='.$_GET['orderid'].'&amp;cf='.$_GET['cf'].'&amp;ct='.$_GET['ct'].'&amp;pf='.$_GET['pf'].'&amp;pt='.$_GET['pt'], true)));
    $tpl->fetch('listallorders.tpl');
    return $tpl->get_tpl();
}
function vieworderadmin(){
    if (is_numeric($_GET['o'])){
        $db = new Db();
        $db->query("SELECT UsersOrders.orderId AS orderId, 
                           UsersOrders.orderName AS orderName, 
                           UsersOrders.orderAutor AS orderAutor, 
                           UsersOrders.orderCount AS orderCount, 
                           UsersOrders.orderPages AS orderPages, 
                           UsersOrders.orderSymb AS orderSymb, 
                           UsersOrders.orderCover AS orderCover,
                           UsersOrders.orderstep AS orderstep,
                           PaperFormat.formatName AS formatName,
                           PaperTypeCostsBlock.PaperTypeName AS PaperTypeName,
                           PaperTypeCostsBlock.PaperTypeWeight AS PaperTypeWeight,
                           BindingType.BindingName AS BindingName,
                           UsersOrders.orderAdditService AS orderAdditService,
                           CEILING(UsersOrders.orderPriceBlock) AS orderPriceBlock,
                           CEILING(UsersOrders.orderPriceAdditService) AS orderPriceAdditService,
                           CEILING(UsersOrders.orderPriceCover) AS orderPriceCover,
                           CEILING(UsersOrders.orderPriceBind) AS orderPriceBind,
                           PrintTypeCostsBlock.PrintTypeName AS PrintTypeName,
                           UsersOrders.DeliveryProviderId AS DeliveryProviderId,
                           UsersOrders.orderPriceDeliver AS orderPriceDeliver,
                           UsersOrders.addressId AS addressId,
                           UsersOrders.userId AS userId,
                           UsersOrders.formatUplBlock AS formatUplBlock
                    FROM UsersOrders, PaperFormat, PaperTypeCostsBlock, BindingType, PrintTypeCostsBlock
                    WHERE orderId = '".intval($_GET['o'])."' AND
                          PaperFormat.formatId = UsersOrders.orderSize AND
                          PaperTypeCostsBlock.PaperTypeId = UsersOrders.orderPaperBlock AND
                          BindingType.BindingId = UsersOrders.orderBinding AND
                          PrintTypeCostsBlock.PrintType = UsersOrders.orderColorBlock
                            LIMIT 1");
        $data = $db->fetch_array();
        $t = explode(',', $data['orderAdditService']);
        $db->query("SELECT AdditionalServiceId, AdditionalServiceName
                    FROM AdditionalServiceCosts 
                    WHERE AdditionalServiceEnable = '1' ");
        $addedads='';
        while ($row = $db->fetch_array()) {
            if (count($t)>0) {
                if (in_array($row['AdditionalServiceId'], $t)) {
                    $addedads.=', ' . $row['AdditionalServiceName'];
                }
            } 
        }
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
            if ($data['DeliveryProviderId']==18) {
                // $db->query("SELECT addressStr
                //         FROM UsersDeliveryAddreses
                //         WHERE addressId = '". $data['addressId'] ."'");
                
                $db->query("SELECT addressStr
                        FROM UsersDeliveryAddreses
                        WHERE addressIndex = '" . intval($_GET['o']) . "'");

                $dataadres = $db->fetch_array();
            }
        }
        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=cover';
        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=coverlayot';
        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=block'.$data['formatUplBlock'];
        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=blocklayot';
        
        
        $covers = array('soft'=>_VOA_SOFTCOVER,'hard'=>_VOA_HARDCOVER);
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('dhref'=>$dhref,'data'=>$data,'covers'=>$covers, 'addedads'=>substr($addedads,2),'namedeliv'=>$namedeliv, 'dataadres'=>$dataadres));
        $tpl->fetch('vieworderadmin.tpl');
        return $tpl->get_tpl();
    }
}
    
function ordersforpay(&$e,&$t) {
    $db = new Db();
    if (isset($_GET['ok'])) {
        $db->query("UPDATE UsersOrders 
                    SET stateId=2, 
                        orderstep = 4 
                    WHERE orderId='".intval($_GET['orderid'])."' ");
        $db->query("UPDATE ISBNnumbers 
                    SET isPaid = '1' 
                    WHERE orderId = '".intval($_GET['orderid'])."'");
        $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_GET['orderid']) . "',
                                curState = '2',
                                userId = '" . $_SESSION['userId'] . "' ");
        $db->query("SELECT bookstore 
                    FROM UsersOrders
                    WHERE orderId='".intval($_GET['orderid'])."'");
        $row=$db->fetch_array();
        if ($row['bookstore']==1){
            $db->query("SELECT userEmail
                            FROM Users
                            WHERE Users.userGroupId = '" .Settings::$v['managegroup'] . "' ");
            while ($row = $db->fetch_array()) {
                $mails[] = $row['userEmail'];
            }
            $e->mail($mails,'Добавление в интернет-магазин','Пользователь хотел бы выложить книгу в магазине, заказ №'.intval($_GET['orderid']));
        }
    }
    $db->query("SELECT Users.userEmail ,UsersOrders.orderId, CEILING((UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver)) AS orderPriceTotal, OrdersStates.stateName, UsersOrders.orderDate
                FROM UsersOrders, OrdersStates, Users
                WHERE UsersOrders.StateId = 1 AND 
                      Users.userId = UsersOrders.userId AND
                      UsersOrders.stateId = OrdersStates.stateId ORDER BY UsersOrders.orderDate DESC");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('ordersforpay.tpl');
    return $tpl->get_tpl();
}
function ordersformod(&$e,&$t) {
    $db = new Db();
    if (isset($_GET['deny'])) {
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('data' => $rows, 'mode'=>2));
        $tpl->fetch('ordersformod.tpl');
        return $tpl->get_tpl();
    }else{
        if (isset ($_POST['causedeny'])){
            $db->query("INSERT INTO OrdersDeny
                        SET orderId = '".intval($_POST['orderid'])."',
                            cause = '".$_POST['causedeny']."' ");
            $db->query("UPDATE UsersOrders 
                        SET stateId='5' 
                        WHERE orderId='".$_POST['orderid']."'");            
        }
        if (isset($_GET['ok'])) {
            $db->query("SELECT AdditionalServiceId 
                        FROM AdditionalServiceCosts 
                        WHERE label = 'makeup' OR 
                              label = 'covdesign' OR 
                              label = 'edit' ");
             while ($row = $db->fetch_array()) {
                 $rows[] = $row;
             }
             $sqlnext = "SELECT COUNT(*) 
                         FROM UsersOrders 
                         WHERE orderId = '".$_GET['orderid']."' AND ( ";
             $f= false;
             foreach ($rows as $cur){
                 if ($f){
                     $sqlnext.= " OR orderAdditService LIKE '%".$cur['0']."%' ";
                 }else{
                     $sqlnext.= " orderAdditService LIKE '%".$cur['0']."%' ";
                     $f=true;
                 }
             }
             $sqlnext.=" ) ";
             $db->query($sqlnext);
             $row=$db->fetch_array();
             if ($row[0]!=0) {
                $nextState = 4;
             }  else {
                $nextState = 3;
             }
             if (isset($_GET['edit'])){
                 $nextState = 4;
             }
             $db->query("UPDATE UsersOrders 
                         SET stateId='".$nextState."' 
                         WHERE orderId='".intval($_GET['orderid'])."'");
             
             $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_GET['orderid']) . "',
                                curState = '".$nextState."',
                                userId = '" . $_SESSION['userId'] . "' ");
             $db->query("SELECT UsersOrders.orderId AS orderId, 
                                UsersOrders.orderName AS orderName, 
                                UsersOrders.orderDate AS orderDate, 
                                UsersOrders.orderCount AS orderCount, 
                                UsersOrders.userId AS userId, 
                                UsersOrders.orderAdditService AS orderAdditService,
                                UsersOrders.orderPages AS orderPages, 
                                UsersOrders.orderCover AS orderCover,
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
                                BindingTypeCosts.BindingCosts AS BindingCosts,
                                SUM(AdditionalCoverCosts.AdditionalCoverCost) AS AdditionalCoverCost
                    FROM UsersOrders, PaperFormat, PaperTypeCostsBlock, BindingType, PrintTypeCostsBlock, PrintTypeCostsCover, PaperTypeCostsCover, BindingTypeCosts, AdditionalCoverCosts
                    WHERE orderId = '".intval($_GET['orderid'])."' AND
                          AdditionalCoverCosts.isDefault = '1' AND
                          BindingTypeCosts.BindingMin <= UsersOrders.orderPages AND BindingTypeCosts.BindingMax >= UsersOrders.orderPages AND 
                          BindingTypeCosts.BindingId = BindingType.BindingId AND
                          BindingTypeCosts.formatId = UsersOrders.orderSize AND
                          PrintTypeCostsCover.PrintType = '44' AND
                          PaperTypeCostsCover.CoverType = UsersOrders.orderCover AND
                          PaperTypeCostsCover.isDefault = '1' AND
                          PaperFormat.formatId = UsersOrders.orderSize AND
                          PaperTypeCostsBlock.PaperTypeId = UsersOrders.orderPaperBlock AND
                          BindingType.BindingId = UsersOrders.orderBinding AND
                          PrintTypeCostsBlock.PrintType = UsersOrders.orderColorBlock
                            LIMIT 1");
             $dataorder = $db->fetch_array();
             require_once '../include/ext_libs/PHPExcel/PHPExcel.php';
             require_once '../include/ext_libs/PHPExcel/PHPExcel/Writer/Excel5.php';
             require_once '../include/ext_libs/PHPExcel/PHPExcel/Writer/PDF.php';
             $reader = PHPExcel_IOFactory::createReader('Excel5');
             $excel = $reader->load('../include/zayavka.xls');
             $excel->setActiveSheetIndex(0);
             $aSheet = $excel->getActiveSheet();
             $aSheet->SetCellValue('E3',$dataorder['orderId']);
             $aSheet->SetCellValue('F3',date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))));
             $aSheet->SetCellValue('C8',$dataorder['orderName']);
             $aSheet->SetCellValue('D8',$dataorder['formatName'].'-'.$dataorder['formatWidth'].'x'.$dataorder['formatHeight']);
             $aSheet->SetCellValue('E8',$dataorder['orderPages']);
             
//             if (!empty($dataorder['orderAdditService'])){
//                $addservice = explode(',',$dataorder['orderAdditService']);
//                $db->query("SELECT AdditionalServiceId
//                            FROM AdditionalServiceCosts
//                            WHERE label = 'addtoisdpack' LIMIT 1");
//                $addtoisdpack = $db->fetch_array();
//                $addtoisdpack = $addtoisdpack['AdditionalServiceId'];
//                if (in_array($addtoisdpack, $addservice)){
//                    $dataorder['orderCount'] = $dataorder['orderCount'] + 16;
//                }
//             }
                          
             $aSheet->SetCellValue('F8',$dataorder['orderCount']);
             $aSheet->SetCellValue('G8',$dataorder['BindingName']);
             $aSheet->SetCellValue('C11',$dataorder['PaperTypeName'].' '.$dataorder['PaperTypeWeight']);
             $aSheet->SetCellValue('D11',$dataorder['orderId'].'_block.pdf');
             $aSheet->SetCellValue('E11',$dataorder['PrintTypeName']);
             if ($dataorder['orderCover'] == 'hard'){
                 $aSheet->SetCellValue('C14','самоклеящаяся (твердая обложка)');
                 $aSheet->SetCellValue('C17', date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+8, date("Y"))));
             }else{
                 $aSheet->SetCellValue('C14','250 мелованная (мягкая обложка)');
                 $aSheet->SetCellValue('C17', date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y"))));
             }
             $aSheet->SetCellValue('D14',$dataorder['orderId'].'_cover.pdf');
             $allblock = ceil((($dataorder['BlockPrintCost'] + $dataorder['BlockPaperTypeCost']) * $dataorder['orderPages'] / $dataorder['formatInA3']) * $dataorder['orderCount']);
             $allcover = ceil((($dataorder['CoverPrintCost']/2 + $dataorder['CoverPaperTypeCost']+$dataorder['AdditionalCoverCost']) / $dataorder['formatInA3'] * 4) * $dataorder['orderCount']);
             $allbind = ceil($dataorder['BindingCosts'] * $dataorder['orderCount']);
             $total = ($allblock+$allcover+$allbind);
             $aSheet->SetCellValue('D17',$total);
             $writer = new PHPExcel_Writer_Excel5($excel);
             $pathdir = './../uploads/'.$dataorder['userId'].'/'.$dataorder['orderId'];
             $fullpath = $pathdir.'/'.$dataorder['orderId'].'_zayavka.xls';
             $writer->save($fullpath);  
        }
        unset($rows);
        $rows = array();
        $db->query("SELECT Users.userEmail, UsersOrders.orderAdditService, UsersOrders.formatUplBlock, 
                           UsersOrders.orderId, UsersOrders.orderName, UsersOrders.orderAutor,
                           UsersOrders.orderCount, UsersOrders.orderPages, UsersOrders.userId,
                           UsersOrders.orderDate AS orderDate
                    FROM UsersOrders, Users
                    WHERE StateId=2 AND 
                          Users.userId = UsersOrders.userId ORDER BY UsersOrders.orderDate DESC");
        while ($row = $db->fetch_array()) {
            $rows[] = $row;
        }
        $t->addjs('jquery.tablesorter.min');
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('data' => $rows, 'mode'=>1));
        $tpl->fetch('ordersformod.tpl');
        return $tpl->get_tpl();
    }
}

function ordersformanualedit(&$e,&$t) {
    if (!isset($_GET['a'])){
        $db = new Db();
        if (isset($_GET['ok'])) {
             $db->query("UPDATE UsersOrders 
                         SET stateId = '3' 
                         WHERE orderId='".intval($_GET['orderid'])."'");
             $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_GET['orderid']) . "',
                                curState = '3',
                                userId = '" . $_SESSION['userId'] . "' ");
        }
        $db->query("SELECT Users.userEmail, UsersOrders.formatUplBlock, UsersOrders.formatUplImg, UsersOrders.userId,  UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
                           UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
                    FROM UsersOrders, Users
                    WHERE StateId = '4' AND
                          Users.userId = UsersOrders.userId ORDER BY UsersOrders.orderDate DESC");
        while ($row = $db->fetch_array()) {
            $rows[] = $row;
        }
        $t->addjs('jquery.tablesorter.min');
        $t->addjs('ajaxupload');
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('data' => $rows));
        $tpl->fetch('ordersformanualedit.tpl');
        return $tpl->get_tpl();
    }else{
        if ($_POST['do']=='replaceblock'){
            if($_FILES['myfile']['error'] === 0){
                if (isset($_FILES["myfile"]) && (end(explode(".", $_FILES['myfile']['name']))=='pdf')){
                    $pathblockpdf = './../uploads/'.$_POST['userid'].'/'.$_POST['orderid'].'/'.$_POST['orderid'].'_block_converted.pdf';
                    if (file_exists($pathblockpdf)){
                        unlink($pathblockpdf);
                    }
                    if (move_uploaded_file($_FILES['myfile']['tmp_name'], $pathblockpdf)){
                        echo _OFME_FILEREPLACED;
                    }else{
                        echo 'ERROR';
                    }
                }else{
                    echo 'ERROR FORMAT';
                }
            }else{
                echo $_FILES['myfile']['error'];
            }
        }
        if ($_POST['do']=='replacecover'){
            if($_FILES['myfile']['error'] === 0){
                if (isset($_FILES["myfile"]) && (end(explode(".", $_FILES['myfile']['name']))=='pdf')){
                    $pathcoverpdf = './../uploads/'.$_POST['userid'].'/'.$_POST['orderid'].'/'.$_POST['orderid'].'_cover.pdf';
                    if (file_exists($pathcoverpdf)){
                        unlink($pathcoverpdf);
                    }
                    if (move_uploaded_file($_FILES['myfile']['tmp_name'], $pathcoverpdf)){
                        echo _OFME_FILEREPLACED;
                    }else{
                        echo 'ERROR';
                    }
                }else{
                    echo 'ERROR FORMAT';
                }
            }else{
                echo $_FILES['myfile']['error'];
            }
        }
    }
}
function editstatus(){
    if(isset($_GET['id'])){
        $db = new Db();
        if (isset($_POST['idstatus'])){
            $db->query("UPDATE UsersOrders
                        SET stateId = '".  intval($_POST['status'])."'
                        WHERE orderId = '".  intval($_POST['idstatus'])."' ");
            $db->query("INSERT INTO OrderStateChanges 
                            SET orderId = '" . intval($_POST['idstatus']) . "',
                                curState = '".intval($_POST['status'])."',
                                userId = '" . $_SESSION['userId'] . "' ");
        }
        if (isset($_POST['idstatusfulldelete'])){
            $pathdir = './../uploads/'.intval($_POST['userstatusfulldelete']).'/'.intval($_POST['idstatusfulldelete']).'/';
            $op_dir=opendir($pathdir);
            while (false !== ($file = readdir($op_dir))){
                if($file != "." && $file != ".." ){
                    unlink ($pathdir.$file);
                }
            }
            closedir($op_dir);
            rmdir($pathdir);
            $db->query("DELETE 
                        FROM UsersOrders
                        WHERE orderId = '".  intval($_POST['idstatusfulldelete'])."' ");
            header("Location: //".$_SERVER['HTTP_HOST'].'/admin/index.php?do=listallorders');
        }
        if (isset($_POST['idstep'])){
            $db->query("UPDATE UsersOrders
                        SET orderstep = '".  intval($_POST['step'])."'
                        WHERE orderId = '".  intval($_POST['idstep'])."' ");
        }        
        $db->query("SELECT stateId, stateName
                    FROM OrdersStates");
        while ($row = $db->fetch_array()) {
            $statuses[] = $row;
        }
        $statuses[] = array('stateId'=>'0','stateName'=>_ES_NOTSET);
        $db->query("SELECT stateId, orderstep, userId
                    FROM UsersOrders
                    WHERE orderId = '".  intval($_GET['id'])."' LIMIT 1 ");
        $row = $db->fetch_array();
        $curstate = array($row['stateId'], $row['orderstep'], $row['userId']);
        
        $oform = array('1'=>_ES_NOTCOMPCOVER,'2'=>_ES_NOTCOMPDELIV,'3'=>_ES_NOTCOMPPAY,'4'=>_ES_COMPL);
        
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('statuses' => $statuses, 'oform'=>$oform, 'curstate'=>$curstate));
        $tpl->fetch('editstatus.tpl');
        return $tpl->get_tpl();
    }
}
function editisbn() {
    $db = new Db();
    
    $activtab= 'freenum';
    if (isset($_GET['p'])){
        $activtab= 'usednum';
    }
    
    if (isset($_POST['newisbn']) && intval($_POST['newisbn'])!=0) {
        $db1 = new Db();
        $db1->query("INSERT INTO ISBNnumbers 
                     SET isbn = '".intval($_POST['newisbn'])."' ");
    }
    if (isset($_POST['isbndel'])) {
        $db->query("DELETE 
                    FROM ISBNnumbers 
                    WHERE isbn = '".intval($_POST['isbndel'])."'");
    }
    if (isset($_POST['isbnfree'])){
        $db->query("UPDATE ISBNnumbers 
                    SET orderId = '0'
                    WHERE isbn = '".intval($_POST['isbnfree'])."'");
        $activtab= 'usednotpaynum';
    }
    if (isset($_POST['isbnpay'])){
        $db->query("UPDATE ISBNnumbers
                    SET isPaid = '1'
                    WHERE isbn = '".intval($_POST['isbnpay'])."'");
        $activtab= 'usednotpaynum';
    }
    $db->query("SELECT isbn, isbnAddDate, orderId, isPaid, orderDate
                FROM ISBNnumbers
                WHERE isPaid = '0'");
    while ($row = $db->fetch_array()) {
        if ($row['orderId']==0){
            $isbnsfree[] = $row;
        }else{
            $isbnnotpayused[] = $row;
        }
    }
    
    $db->query("SELECT isbn, isbnAddDate, orderId, isPaid, orderDate
                FROM ISBNnumbers
                WHERE isPaid = '1' 
                ORDER BY orderDate DESC ".Engine::pagesql()."");
    while ($row = $db->fetch_array()) {
        $isbnused[] = $row;
    }
    $db->query("SELECT count(*)
                FROM ISBNnumbers
                WHERE isPaid = '1' ");
    $count = $db->fetch_array();

    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('action'=>'index.php?do=editisbn','isbnsfree' => $isbnsfree,'isbnnotpayused'=>$isbnnotpayused,'activtab'=>$activtab,'count'=>$count[0],'isbnused'=>$isbnused,'pages'=> Engine::pagetpl($count['0'], 'index.php?do=editisbn', true)));
    $tpl->fetch('editisbn.tpl');
    return $tpl->get_tpl();
}
function ordersmakeup(&$m) {
    $db = new Db();
    $orderid = '';
    if (isset($_POST['orderid']) || isset($_GET['orderid'])){
        $orderid = isset($_POST['orderid'])? intval($_POST['orderid']):intval($_GET['orderid']);
        if (substr($orderid,0,3)=='978'){
            $db->query("SELECT orderId
                        FROM ISBNnumbers
                        WHERE isbn = '".$orderid."'");
            $row = $db->fetch_array();
            $orderid = $row['orderId'];
        }
        if ($orderid==0){
            $orderid='';
        }
        $db->query("SELECT UsersOrders.orderId AS orderId, 
                           UsersOrders.orderName AS orderName, 
                           UsersOrders.orderCount AS orderCount, 
                           UsersOrders.orderPages AS orderPages, 
                           UsersOrders.orderSymb AS orderSymb, 
                           UsersOrders.orderCover AS orderCover,
                           PaperFormat.formatName AS formatName,
                           PaperTypeCostsBlock.PaperTypeName AS PaperTypeName,
                           PaperTypeCostsBlock.PaperTypeWeight AS PaperTypeWeight,
                           BindingType.BindingName AS BindingName,
                           UsersOrders.orderAdditService AS orderAdditService,
                           PrintTypeCostsBlock.PrintTypeName AS PrintTypeName,
                           UsersOrders.stateId AS stateId
                    FROM UsersOrders, PaperFormat, PaperTypeCostsBlock, BindingType, PrintTypeCostsBlock
                    WHERE orderId = '".$orderid."' AND
                          PaperFormat.formatId = UsersOrders.orderSize AND
                          PaperTypeCostsBlock.PaperTypeId = UsersOrders.orderPaperBlock AND
                          BindingType.BindingId = UsersOrders.orderBinding AND
                          PrintTypeCostsBlock.PrintType = UsersOrders.orderColorBlock AND
                          (UsersOrders.stateId = 6 OR UsersOrders.stateId = 7)
                          LIMIT 1");
        $data = $db->fetch_array();
        $chang = false;
        if (!empty($data) && $data['stateId']!=7){
            $db->query("UPDATE UsersOrders
                        SET UsersOrders.stateId = 7
                        WHERE orderId = '".$orderid."'");
            $db->query("INSERT INTO OrderStateChanges 
                        SET orderId = '" . $orderid . "',
                            curState = '7',
                            userId = '" . $_SESSION['userId'] . "' ");
            $chang = true;
        }
        $t = explode(',', $data['orderAdditService']);
        $db->query("SELECT AdditionalServiceId, AdditionalServiceName
                    FROM AdditionalServiceCosts 
                    WHERE AdditionalServiceEnable = '1' ");
        $addedads='';
        while ($row = $db->fetch_array()) {
            if (count($t)>0) {
                if (in_array($row['AdditionalServiceId'], $t)) {
                    $addedads.=', ' . $row['AdditionalServiceName'];
                }
            } 
        }
    }
    $db->query("SELECT UsersOrders.orderId, UsersOrders.orderName, UsersOrders.orderAutor,
                       UsersOrders.orderCount, UsersOrders.orderPages, UsersOrders.userId,
                       UsersOrders.orderUploadDate
                FROM UsersOrders 
                WHERE UsersOrders.stateId = '7' ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $covers = array('soft'=>_OMU_SOFTCOVER,'hard'=>_OMU_HARDCOVER);
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('addedads'=>substr($addedads,2),'orders' => $rows,'data'=>$data,'covers'=>$covers,'orderid'=>$orderid,'chang'=>$chang));
    $tpl->fetch('ordersmakeup.tpl');
    return $tpl->get_tpl();
}    

function ordersdelivery(&$m) {
    $db = new Db();
    $activtab = 'createdeliver';
    if (isset($_POST['orderid'])){
        $orderid = intval($_POST['orderid']);
    }else{
        $orderid = intval($_GET['orderid']);
    }
    if (substr($orderid,0,3)=='978'){
        $db->query("SELECT orderId
                    FROM ISBNnumbers
                    WHERE isbn = '".$orderid."'");
        $row = $db->fetch_array();
        $orderid = $row['orderId'];
    }
    if ($orderid==0){
        $orderid='';
    }
    if (isset($_POST['createdeliver'])){
        $db->query("SELECT UsersOrders.orderId, UsersOrders.stateId 
                    FROM UsersOrders
                    WHERE UsersOrders.orderId = '".$orderid."'  AND
                          UsersOrders.stateId = '7' LIMIT 1");
        if ($db->num_rows()==1){
            $db->query("UPDATE UsersOrders
                        SET UsersOrders.stateId = '8'
                        WHERE UsersOrders.orderId = '".$orderid."' ");
            $db->query("INSERT INTO OrderStateChanges 
                        SET orderId = '" . $orderid . "',
                            curState = '8',
                            userId = '" . $_SESSION['userId'] . "' ");            
            $chang[0] = true;
        }
    }
    if (isset($_POST['dispatch'])){
        $db->query("SELECT UsersOrders.orderId, UsersOrders.stateId 
                    FROM UsersOrders
                    WHERE UsersOrders.orderId = '".$orderid."'  AND
                          UsersOrders.stateId = '8' LIMIT 1");
        if ($db->num_rows()==1){
            $db->query("UPDATE UsersOrders
                        SET UsersOrders.stateId = '9'
                        WHERE UsersOrders.orderId = '".$orderid."' ");
            $db->query("INSERT INTO OrderStateChanges 
                        SET orderId = '" . $orderid . "',
                            curState = '9',
                            userId = '" . $_SESSION['userId'] . "' ");
            $chang[1] = true;
            $activtab = 'dispatch';
        }
    }
    $db->query("SELECT UsersOrders.orderId
                FROM UsersOrders
                WHERE UsersOrders.DeliveryProviderId = '0' AND 
                      UsersOrders.stateId = '8' ");
    while ($row = $db->fetch_array()) {
        $pickup[] = $row;
    }  
    $db->query("SELECT DeliveryProviders.DeliveryProviderName AS DeliveryProviderName,
                       DeliveryProviders.DeliveryProviderId AS DeliveryProviderId,
                       UsersOrders.orderId AS orderId,
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
                FROM UsersDeliveryAddreses, DeliveryCountries, DeliveryRegions, UsersOrders, DeliveryProviders
                WHERE UsersDeliveryAddreses.addressId = UsersOrders.addressId AND
                      DeliveryProviders.DeliveryProviderId = UsersOrders.DeliveryProviderId AND
                      DeliveryCountries.CountryId = UsersDeliveryAddreses.addressCountry AND 
                      DeliveryRegions.RegionId = UsersDeliveryAddreses.addressRegion AND 
                      UsersOrders.stateId = '8' ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'chang'=>$chang,'orderid'=>$orderid, 'activtab'=>$activtab, 'pickup'=>$pickup));
    $tpl->fetch('ordersdelivery.tpl');
    return $tpl->get_tpl();
}
function zayavkaprint(){
    $db = new Db();
    $db->query("SELECT orderId, userId 
                FROM UsersOrders
                WHERE stateId > 2 AND
                      stateId < 7 ORDER BY orderId DESC");
    while ($row = $db->fetch_array()) {
        $pathdir = './../uploads/'.$row['userId'].'/'.$row['orderId'];
        $fullpath = $pathdir.'/'.$row['orderId'].'_zayavka.xls';
        $row['link'] = $fullpath;
        $data[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('zayavkaprint.tpl');
    return $tpl->get_tpl();
}
function orderswaitupload(){
    if (isset($_POST['uplcur'])){
        exec("/usr/bin/php5 /home/httpd/editus.ru/www/include/uploadtoftp.php");
    }
    $db = new Db();
    $db->query("SELECT UsersOrders.orderId, UsersOrders.orderDate
                FROM UsersOrders 
                WHERE stateId = '3'");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('orderswaitupload.tpl');
    return $tpl->get_tpl();
}
function orderstatechanges(){
    $db = new Db();
    $sql = " ORDER BY OrderStateChanges.dateChange DESC LIMIT 15";
    if (!empty($_POST['searchorder'])){
        $sql = " AND OrderStateChanges.orderId = '".intval($_POST['searchorder'])."' ORDER BY OrderStateChanges.dateChange DESC ";
    }
    $db->query("SELECT OrderStateChanges.orderId, OrderStateChanges.dateChange, OrderStateChanges.curState, 
                       Users.userEmail, Users.userId
                FROM OrderStateChanges, Users  
                WHERE Users.userId = OrderStateChanges.userId ".$sql." ");
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
    $tpl->fetch('orderstatechanges.tpl');
    return $tpl->get_tpl();
}
function ordersonprint(&$m) {
    $db = new Db();
//if (isset($_GET['ok'])) {
//     $db->query("UPDATE UsersOrders SET stateId='7' WHERE orderId='{$_GET['orderid']}'");
//}
   $db->query("SELECT UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
                      UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
               FROM UsersOrders 
               WHERE StateId = '6' ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('ordersonprint.tpl');
    return $tpl->get_tpl();
}
?>
