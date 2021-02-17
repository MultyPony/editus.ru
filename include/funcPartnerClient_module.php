<?php

function partnerslistorders(&$e,&$t) {
    $db = new Db();
    $db->query("SELECT UsersOrders.orderId, Users.userId, Users.userEmail, UsersOrders.orderName, UsersOrders.orderAutor, UsersOrders.orderCount,UsersOrders.orderPages,
                       UsersOrders.orderSymb,CEILING(UsersOrders.orderPriceBlock) AS orderPriceBlock , CEILING(UsersOrders.orderPriceAdditService) AS orderPriceAdditService, CEILING(UsersOrders.orderPriceCover) AS orderPriceCover,
                       CEILING(UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver) AS orderPriceTotal,
                       Users.userId, UsersOrders.orderDate, UsersOrders.stateId, UsersOrders.orderstep
                FROM UsersOrders, Users
                WHERE Users.userId = UsersOrders.userId AND Users.partnerId = '".$_SESSION['myPartnerId']."' ORDER BY UsersOrders.orderId DESC ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()){
        $rows[] = $row;
    }
    $db->query("SELECT count(*)
                FROM UsersOrders, Users
                WHERE Users.userId = UsersOrders.userId AND Users.partnerId = '".$_SESSION['myPartnerId']."' ");
    $count = $db->fetch_array();
    $db->query("SELECT stateId,	stateName
                FROM OrdersStates");
    while ($row = $db->fetch_array()){
        $states[$row['stateId']] = $row['stateName'];
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_vars(array('states'=>$states,'data' => $rows, 'pages'=> Engine::pagetpl($count['0'], Main_config::$main_file_name.'?do=partnerslistorders&amp;p='.$_GET['p'])));
    $tpl->fetch('partnerslistorders.tpl');
    return $tpl->get_tpl();
}

function editpartnerdata(&$e) {
    if (!isset($_GET['a'])) {
        $db = new Db();
        if (isset($_POST['epd_key'])) {
            $key = $db->mres($_POST['epd_key']);
            $page = $db->mres($_POST['epd_page']);
            $title = $db->mres($_POST['epd_title']);
            $mainpage = $db->mres($_POST['epd_mainpage']);
            $format = end(explode(".", $_FILES['epd_logo']['name']));
            if (!isset($_FILES["epd_logo"])){
                if ((isset($_FILES["epd_logo"]) && ($format == 'jpg' || $format=='png'))){
                    $image = new Imagick($_FILES['epd_logo']['tmp_name']);
                    $pathdir = './partner_logo/logo_'.intval($_SESSION['userId']);
                    if (($image->getImageFormat () == 'JPEG') || ($image->getImageFormat () == 'PNG')){
                        $image->adaptiveResizeImage(250,0);
                        $image->writeImage($pathdir.'.jpg');
                    }else{
                        $e->messuser(_EPD_EXTERROR, 0);
                    }
                }else{
                    $e->messuser(_EPD_EXTERROR, 0);
                }
            }
            $sql = "UPDATE PartnersData
                    SET partnerPage = '".$page."',
                        partnerName = '".$title."',
                        partnerKey = '".$key."',
                        partnerMainPage = '".$mainpage."'
                    WHERE userId = '".$_SESSION['userId']."';";
            $db->query($sql);
            $e->messuser(_EPD_SAVEOK, 1);
        }
        $db->query("SELECT partnerName, partnerKey, status, partnerPage, percent, partnerMainPage
                    FROM PartnersData
                    WHERE userId = '".$_SESSION['userId']."' LIMIT 1");
        $data = $db->fetch_array();
        $tpl = new Template();
        $tpl->set_vars(array('mode'=>1,'data' => $data, 'action' => Main_config::$main_file_name . '?do=editpartnerdata'));
        $tpl->fetch('editpartnerdata.tpl');
        return $tpl->get_tpl();
        
    }else{
        if ($_POST['do']=='getregion'){
            $db = new Db();
            $db->query("SELECT RegionId, RegionName, iscity
                        FROM DeliveryRegions
                        WHERE CountryId = '".  intval($_POST['countryid'])."' AND
                              RegionParentId ='0' ");
            while ($row = $db->fetch_array()) {
                $regions[] = $row;
            }
            $sel = 0;
            if ($_POST['edit']!=0){
                $db->query("SELECT addressRegion
                            FROM UsersDeliveryAddreses
                            WHERE addressId = '".  intval($_POST['edit'])."' ");
                $row = $db->fetch_array();
            }
            
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('mode'=>2,'regions'=>$regions,'sel'=>$row[0]));
            $tpl->fetch('editclientdata.tpl');
            $tpl->display();
        }
    }
}
function partnervieworder($e){
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
        }
//        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=cover';
//        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=coverlayot';
//        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=block'.$data['formatUplBlock'];
//        $dhref[]='../include/get.php?uid='.$data['userId'].'&amp;oid='.$data['orderId'].'&amp;o=blocklayot';

        $e->do = 'partnerslistorders';
        $covers = array('soft'=>_PVO_SOFTCOVER,'hard'=>_PVO_HARDCOVER);
        $tpl = new Template();
        $tpl->set_vars(array('data'=>$data,'covers'=>$covers, 'addedads'=>substr($addedads,2),'namedeliv'=>$namedeliv, 'dataadres'=>$dataadres));
        $tpl->fetch('partnervieworder.tpl');
        return $tpl->get_tpl();
    }
}
function partnerviewuser($e){
    if (is_numeric($_GET['id'])){
        $db = new Db();

        $db->query("SELECT * FROM Users WHERE userId = '" . intval($_GET['id']) . "' AND partnerId = '" . $_SESSION['partnerId'] . "' LIMIT 1");
        $data = $db->fetch_array();
        $db->query("SELECT * FROM Groups");
        while ($row = $db->fetch_array()) {
            $groups[] = $row;
        }
        $e->do = 'partnerslistorders';
        $tpl = new Template();
        $tpl->set_vars(array('data' => $data, 'groups' => $groups));
        $tpl->fetch('partnerviewuser.tpl');
        return $tpl->get_tpl();
    }
}
function partnerstatistics($e){
    $data = array();
    $db = new Db();
    $datefrom = $db->mres($_POST['ps_datefrom']);
    $dateto = $db->mres($_POST['ps_dateto']);
    if (isset($_POST['ps_datefrom'])){
        $sql = "SELECT userId FROM Users WHERE partnerId = '".$_SESSION['myPartnerId']."' AND
                userRegistrationDate > '".$datefrom."' AND userRegistrationDate < '".$dateto."' ";
        $db->query($sql);
        $data['countnewusers'] = $db->num_rows();
        $sqloreders = "SELECT SUM(orderPriceBind+orderPriceCover+orderPriceAdditService+orderPriceBlock+orderPriceDeliver) AS TOTAL
                       FROM UsersOrders, Users WHERE Users.partnerId = '".$_SESSION['myPartnerId']."' AND
                            UsersOrders.userId = Users.userId AND
                            orderDate >= '".$datefrom."' AND orderDate <= '".$dateto."' ";
        $db->query($sqloreders);
        $data['countorders'] = $db->num_rows();
        $t = $db->fetch_array();
        $data['totalcoast'] = round($t['TOTAL'],2);
    }
    $tpl = new Template();
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('partnerstatistics.tpl');
    return $tpl->get_tpl();
}
?>
